<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use App\Models\Message;
use Carbon\Carbon;
use DateTime;
use Mail;
use DB;

class SendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:minute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar as mensagens';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
            /**
         * Messages type:
         * 0 == cobrança
         * 1 == aniversário cliente
         * 2 == restam x dias
         * 3 == aniversário casamento
         * 4 == aniversário da actividade
         * 5 == outras datas
         * 
         * Activity type:
         * 0 == casamento
         * 1 == aniversário de empresa/organização
         * 2 == aniversário de uma pessoa
         * 3 == festas no geral
         *
         */
        $activities = Activity::leftjoin('customers', 'customers.id', 'activities.customer_id')
        ->leftjoin('users', 'users.id', 'activities.user_id')
        ->select('activities.*',
        'users.first_name as admin_first_name','users.last_name as admin_last_name',
        'customers.first_name','customers.last_name','customers.birth_date',
        'customers.phone', 'customers.email'
        )
        ->where('activities.status',2)
        ->orWhere('activities.status',1)
        ->get();
        $templates = Template::get();
        $messages_to_send  = array();
        foreach ( $activities as  $activity){
            $today = Carbon:: now();
            $years = (new DateTime(Carbon::parse($activity->date)->format('Y-m-d')))->diff((new DateTime($today->format('Y-m-d'))))->y;
            $messages = Message::whereCustomerId($activity->customer_id)->whereDate('created_at', Carbon::today())->get();
            $debt = $activity->total - $activity->paid;
            $birth_activity =   $years > 0 && ($today->format('m-d') == Carbon::parse($activity->date)->format('m-d'));
            $birth_customer =   $today->format('m-d') == Carbon::parse($activity->birth_date)->format('m-d');


            if ($debt > 0  &&  $template = Template::whereType('0')->inRandomOrder()->limit('1')->first()){ //Mensagem caso haja dívida
                $send = true;
                foreach ($messages as $message){ 

                    if ($message->type == '0' ||  $message->created_at->diffInMinutes($today, false) < 10){
                        $send = false;
                    }
                }
                if ($send && $today->format('Y-m-d') != Carbon::parse($activity->created_at)->format('Y-m-d')){
                    array_push($messages_to_send, array(
                        'topic' => 'Cobrança de dívida',
                        'body' => str_replace(['{{nome}}', '{{data}}', '{{divida}}'],[ $activity->first_name, Carbon::parse($activity->created_at)->format('d-m-Y'), $debt], $template->body), 
                        'phone'  =>  $activity->phone,
                        'email' => $activity->email,
                        'customer_id' => $activity->customer_id,
                        'activity_id' => $activity->id,
                        'type' => '0',
                        'sms_api'=>env('SMS_API'),
                    ));
                }
            }
            if ($birth_customer &&  $template = Template::whereType('1')->inRandomOrder()->limit('1')->first()){ //Mensagem de aniversário do cliente
                $send = true;
                foreach ($messages as $message){ 
                    if ($message->type == '1'||  $message->created_at->diffInMinutes($today, false) < 10){
                        $send = false;
                    }
                }
                if ($send){
                    array_push($messages_to_send, array(
                        'topic' => 'Aniversário do cliente',
                        'body' => str_replace(['{{nome}}'],[ $activity->first_name], $template->body), 
                        'phone'  =>  $activity->phone,
                        'email' => $activity->email,
                        'customer_id' => $activity->customer_id,
                        'activity_id' => $activity->id,
                        'type' => '1',
                        'sms_api'=>env('SMS_API'),
                    ));
                }
            }
            if ($today->format('Y-m-d') != Carbon::parse($activity->date)->format('Y-m-d')  &&  $template = Template::whereType('2')->inRandomOrder()->limit('1')->first()){ //Mensagem caso restam dias até a actividade
                $send = true;
                foreach ($messages as $message){ 
                    if ($message->type == '2'||  $message->created_at->diffInMinutes($today, false) < 10){
                        $send = false;
                    }
                }
                if ($send){
                    for ($x = 1; $x <= 5; $x++) {
                        if ($today->format('Y-m-d') == Carbon::parse($activity->date)->addDays(-$x)->format('Y-m-d') ){
                            $body_complement ="";
                            if ($x > 1){
                                $body_complement = 'faltam '.$x.' dias';
                            }else {
                                $body_complement = 'falta '.$x.' dia';
                            }
                            array_push($messages_to_send, array(
                                'topic' => 'Dias restantes',
                                'body' => str_replace(['{{nome}}', '{{faltamXdias}}', '{{descricao}}'],[ $activity->first_name, $body_complement, $activity->description], $template->body),
                                'phone'  =>  $activity->phone,
                                'email' => $activity->email,
                                'customer_id' => $activity->customer_id,
                                'activity_id' => $activity->id,
                                'type' => '2',
                                'sms_api'=>env('SMS_API'),
                            ));
                        }
                    }
                }
            
            }
            if ($activity->type == 0 &&  $birth_activity  &&  $template = Template::whereType('3')->inRandomOrder()->limit('1')->first()){  //Mensagem de aniversário de casamento
                $send = true;
                foreach ($messages as $message){ 
                    if ($message->type == '3'||  $message->created_at->diffInMinutes($today, false) < 10){
                        $send = false;
                    }
                }
                if ($send){
                    $body_complement ="";
                    if ($years = 1){
                        $body_complement = 'pelo '.$years.'  ano de casamento';
                    }else {
                        $body_complement = 'pelos '.$years.'  anos de casamento';
                    }
                    array_push($messages_to_send, array(
                        'topic' => 'Aniversário de casamento',
                        'body' =>  str_replace(['{{pelosAnos}}'],[ $body_complement], $template->body),
                        'phone_husband'  =>  $activity->phone_husband,
                        'email_husband' => $activity->email_husband,
                        'phone_wife'  =>  $activity->phone_wife,
                        'email_wife' => $activity->email_wife,
                        'customer_id' => $activity->customer_id,
                        'activity_id' => $activity->id,
                        'type' => '3',
                        'sms_api'=>env('SMS_API'),
                    ));
                }
            }
            if ($activity->type != 0 &&  $birth_activity &&   $template = Template::whereType('4')->inRandomOrder()->limit('1')->first()){  //Mensagem de aniversário da actividade
                $send = true;
                foreach ($messages as $message){ 
                    if ($message->type == '4'||  $message->created_at->diffInMinutes($today, false) < 10){
                        $send = false;
                    }
                }
                if ($send){
                    $body_complement ="";
                    if ($years = 1){
                        $body_complement =$years.'  ano';
                    }else {
                        $body_complement =$years.'  anos';
                    }
                    array_push($messages_to_send, array(
                        'topic' => 'Aniversário de actividade',
                        'body' =>  str_replace(['{{nome}}', '{{anos}}', '{{descricao}}'], [$activity->first_name, $body_complement, $activity->description], $template->body),
                        'phone'  =>  $activity->phone,
                        'email' => $activity->email,
                        'customer_id' => $activity->customer_id,
                        'activity_id' => $activity->id,
                        'type' => '4',
                        'sms_api'=>env('SMS_API'),
                    ));
                }
            }
            foreach ($templates as  $template){
                if ($today->format('m-d') == Carbon::parse($template->date)->format('m-d') && $template->type == '5'){ //Outras mensagens do template
                    $send = true;
                    foreach ($messages as $message){ 
                        if ($message->topic == $template->title ||  $message->created_at->diffInMinutes($today, false) < 10){
                            $send = false;
                        }
                    }
                    if ($send){
                        array_push($messages_to_send, array(
                            'topic' => $template->title,
                            'body' => str_replace(['{{nome}}'], [$activity->first_name], $template->body),
                            'phone'  =>  $activity->phone,
                            'email' => $activity->email,
                            'customer_id' => $activity->customer_id,
                            'activity_id' => $activity->id,
                            'type' => '5',
                            'sms_api'=>env('SMS_API'),
                        ));
                    }
                }
            }   
        }
        $succes=0;
        foreach ($messages_to_send as $message){
            DB::beginTransaction();
            try{ 

                $messages_sent = Message::whereCustomerId($message['customer_id'])->whereDate('created_at', Carbon::today())->get();
                $send = true;
                foreach ($messages_sent as $item_sent){ 
                    if ($item_sent->created_at->diffInMinutes(Carbon:: now(), false) <= 10){
                        $send = false;
                    }
                }
                $via= 0;
                if (($message['email'] || $message['email_husband'] || $message['email_wife']) && (new SendMessageController)->email($message)){
                    $via= $via +1;
                }
                if (($message['phone'] || $message['phone_husband'] || $message['phone_wife']) && (new SendMessageController)->sms($message)){
                    $via= $via+ 2;
                }

                if ($send && $via> 0){
                    Message::create([
                    'topic'=> $message['topic'],
                    'body'=> $message['body'],
                    'type'=> $message['type'],
                    'via' =>strval($via),
                    'customer_id'=> $message['customer_id'],
                    'activity_id'=> $message['activity_id'],
                    ]);

                    DB::commit();
                    $succes = $succes +1;

                }
            }
            catch(\Throwable $th){
                DB::rollback();  
            }
        }
        $today_sent = Message::whereDate('created_at', Carbon::today())->get()->count();
        $undread = Contact::whereStatus('1')->get()->count();
        event(new MessageEvent($today_sent, $undread));
        //return response()->json(['count'=>sizeof($messages_to_send), 'sent'=> $succes, 'message' => 'Mensagens geradas com sucesso!', 'messages'=>$messages_to_send ,'success' => true]);
        
    }
        
   
}
