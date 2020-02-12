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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'birth_date' => 'required|date',
            'doc_type' => 'required',
            'doc_no' => 'required',
            'operator_id' => 'required',
            'gender' => 'required|string',
            'name' => 'required',
            'number' => 'required',
        ]);

        if($validator->fails()){
            return Redirect::back()->with('errors',  $validator->errors());
        }
        $phone = Phone::whereNumber($request->phone)->first();
        if (!$phone){
            DB::beginTransaction();
            try{  
                $customer = Customer::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'gender' => $request->gender,
                    'birth_date' => $request->birth_date,
                    'bi'=> $this->doc($request->doc_type, $request->doc_no),
                    'nif'=> $this->doc($request->doc_type, $request->doc_no),
                    'passport'=> $this->doc($request->doc_type, $request->doc_no),
                    'residence_card'=> $this->doc($request->doc_type, $request->doc_no),
                ]);
            
                Phone::create([
                    'number'=> $request->number,
                    'operator_id'=> $request->operator_id,
                    'customer_id'=> $customer->id,
                ]);
                DB::commit();
                return redirect('/')->with('message', 'Telefone cadastrado feito com sucesso.');
            }
            catch(\Throwable $th){
                DB::rollback();
                return redirect('/')->with('error', 'Falha ao cadastrar telefone.');   
            }
        }
        
        try{ 
            Mail::send('email',
            array(
                'name' => $request->name,
                'message_to_send' => 'Você usou APNA para insirir ou actualizar suas informações relativamente com o número de telefone: '.$request->number.'.'
            ), function($message) use ($request)
            {
                $message->from('Angola Phone Numbers Api');
                $message->to($request->email, $request->name)->subject('Informações insiridas com sucesso');
            });
           
        }
        catch(\Throwable $th){
         
        }
        
    }
}