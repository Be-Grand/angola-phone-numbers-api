<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Phone;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;


    class PhoneController extends Controller
    {
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
        public function info($phone, Request $request){
            $phone = Phone::whereNumber($this->validatePhone($phone, false))->first();
            return response()->json(['message' => "Operação realizada com sucesso.", 'phone' => $phone,'success' => true]);
        }
        public function get(Request $request){
            if ($request->key=="123ao"){
                $phones = Phone::paginate(20);
                return response()->json(['message' => "Operação realizada com sucesso.", 'phones' => $phones,'success' => true]);
            }
            else{
                return response()->json(['message' => "Falha ao realizar a operação.",'success' => false]);
            }
           
        }
        public function add(Request $request) {
            $validator = Validator::make($request->all(), [
                'number' => 'required|numeric|phone|unique',
                'operator_id' => 'required',
                'customer_id' => 'required',
                
            ]);
            if($validator->fails()){
                return response()->json([$validator->errors(), 'success' => false], 400);
            }
            $phone = Phone::create([
                'number'=> $request->number,
            ]);
            if($phone)
            return response()->json(['message' => 'Telefone cadastrado com sucesso!', 'success' => true]);
        }
        public function update(Request $request){
            $phone = Phone::findOrFail($request->id);
            $phone->number = $request->number;
            $phone->status = $request->status;
            $phone->operator_id = $request->operator_id;
            $phone->customer_id = $request->customer_id;
            $phone->save();
            return response()->json(['message' => 'Telefone actualizado com sucesso!', 'success' => true]); 
        }
        public function destroy(Request $request){
            if (Phone::findOrFail($request->id)->delete())
            return response()->json(['message' => 'Telefone apagado com sucesso!', 'success' => true]);
            else
            return response()->json(['message' => 'Falha ao apagar!', 'success' => false]);
        }
        
    }
