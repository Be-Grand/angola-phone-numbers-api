<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Operator;
use App\Models\Customer;
use App\Models\Phone;
use DB;
use Carbon\Carbon;

use Redirect;
use Mail;

 
class LandingController extends Controller
{
    
    public function index(){

        $operators = Operator::get();
        return view('landing', compact('operators',));
    }
    public function doc($type, $no){
        if ($type == 'bi'){
            return $no;
        }
        else if ($type == 'nif'){
            return $no;
        }
        else if ($type == 'passport'){
            return $no;
        }
        else if ($type == 'residence_card'){
            return $no;
        }
        else {
            return null;
        }
    }
    public function  validatePhone($phone, $indicative){
        if ($indicative && strlen($phone) ==9){
            return '244'.$phone;
        }
        else if ($indicative==false) {
            return substr($phone, -9);
        }
        else if ($indicative && strlen($phone) >9){
            return $phone;
        }
    }  
    public function store(Request $request)
    {
        $validator = Validator::make(array_merge($request->all(),[
            'bi'  =>  $request->doc_type=='bi'? $request->doc_no:null,
            'nif'  =>  $request->doc_type=='nif'? $request->doc_no:null,
            'passport'  =>  $request->doc_type=='passport'? $request->doc_no:null,
            'residence_card'  =>   $request->doc_type=='residence_card'? $request->doc_no:null,
        ]), [
            'passport'  => 'nullable|passport',
            'bi'  => 'nullable|bi',
            'nif'  => 'nullable|bi',
            'residence_card'  => 'nullable|residence_card',
            'birth_date' => 'required|date',
            'doc_type' => 'required',
            'doc_no' => 'required',
            'operator_id' => 'required',
            'gender' => 'required|string',
            'name' => 'required|min:6',
            'email'  => 'nullable|email',
            'number' => 'required|phone',
            'address' => 'required|min:6',
        ]);

        if($validator->fails()){
            return Redirect::back()->with('errors',  $validator->errors());
        }
        $customer = Customer::whereEmail($request->email)->orWhere('bi', $request->doc_no)
        ->orWhere('bi', $request->doc_no)
        ->orWhere('nif', $request->doc_no)
        ->orWhere('passport', $request->doc_no)
        ->orWhere('residence_card', $request->doc_no)
        ->first();
        $phone = Phone::whereNumber($this->validatePhone($request->number, false))->first();
        if (!$phone && $customer){
            Phone::create([
                'number'=> $request->number,
                'operator_id'=> $request->operator_id,
                'customer_id'=> $customer->id,
            ]);
            try{ 
                Mail::send('email',
                array(
                    'name' => $request->name,
                    'message_to_send' => 'Você usou APNA e acabou de associar mais um número de telefone: '.$request->number.'.'
                ), function($message) use ($request)
                {
                    
                    $message->to($request->email, $request->name)->subject('Associação de novo número');
                });
               
            }
            catch(\Throwable $th){
             
            }
            return redirect('/')->with('message', 'Telefone associado a um cliente já existente.');
        }
        else if ($phone && !$customer){
            return redirect('/')->with('error', 'Este número de telefone já se encontra associado.');
        }
        else if ($phone && $customer && $customer->id == $phone->customer_id  
        && $customer->name == $request->name
        && $customer->gender == $request->gender
        && $customer->birth_date == $request->birth_date
        && $phone->operator_id == $request->operator_id
        ){
            $request->bi?  $customer->bi =  $request->bi : '';
            $request->nif?  $customer->nif =  $request->nif : '';
            $request->passport?  $customer->passport =  $request->passport : '';
            $request->residence_card?  $customer->residence_card =  $request->residence_card : '';
            $customer->address =  $request->address;
            $customer->email =  $request->email;
            $customer->save();
            try{ 
                Mail::send('email',
                array(
                    'name' => $customer->name,
                    'message_to_send' => 'Você APNA para actualizar as suas informações relativamente associados ao  número de telefone: '.$request->number.'.'
                ), function($message) use ($request)
                {
                    
                    $message->to($request->email, $request->name)->subject('Informações actualizadas com sucesso');
                });
               
            }
            catch(\Throwable $th){
             
            }
            return redirect('/')->with('message', 'Informações actualizadas.');
        }
        else if ($phone && $customer && $customer->id != $phone->customer_id){
            return redirect('/')->with('error', 'Este número de telefone já se encontra associado.');
        }
        else if (!$phone && !$customer){
            DB::beginTransaction();
            try{  
                $customer = Customer::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'gender' => $request->gender,
                    'birth_date' => $request->birth_date,
                    'bi'  =>  $request->doc_type=='bi'? $request->doc_no:null,
                    'nif'  =>  $request->doc_type=='nif'? $request->doc_no:null,
                    'passport'  =>  $request->doc_type=='passport'? $request->doc_no:null,
                    'residence_card'  =>   $request->doc_type=='residence_card'? $request->doc_no:null,
                ]);
            
                Phone::create([
                    'number'=> $this->validatePhone($request->number, false),
                    'operator_id'=> $request->operator_id,
                    'customer_id'=> $customer->id,
                ]);
                DB::commit();
                try{ 
                    Mail::send('email',
                    array(
                        'name' => $request->name,
                        'message_to_send' => 'Você usou APNA para insirir suas informações relativamente com o número de telefone: '.$request->number.'.'
                    ), function($message) use ($request)
                    {
                        
                        $message->to($request->email, $request->name)->subject('Informações insiridas com sucesso');
                    });
                   
                }
                catch(\Throwable $th){
                 
                }
                return redirect('/')->with('message', 'Telefone cadastrado com sucesso.');
            }
            catch(\Throwable $th){
                DB::rollback();
                return redirect('/')->with('error', 'Falha ao cadastrar telefone.');   
            }
        }
        
     
        
    }
}
