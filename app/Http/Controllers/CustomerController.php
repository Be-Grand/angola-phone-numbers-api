<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Customer;
    use App\Models\Municipality;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;


    class CustomerController extends Controller
    {
        public function get(){
            $customers = Customer::paginate(20);
            return response()->json(['message' => "Operação realizada com sucesso.",
            'customers' => $customers,'success' => true]);
        }
        public function add(Request $request) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|',
            ]);
            if($validator->fails()){
                return response()->json([$validator->errors(), 'success' => false], 400);
            }
           
            $customer = Customer::create([
                'name'=> $request->name,
                'birth_date'=> $request->birth_date,
                'gender'=> $request->gender,
                'email'=> $request->email,
                'address'=> $request->address,
            ]);
            if($customer)
            return response()->json(['message' => 'Cliente cadastrado com sucesso!', 'success' => true]);
        }
        public function update(Request $request){
            $customer = Customer::findOrFail($request->id);
            $customer->name = $request->name;
            $customer->birth_date = $request->birth_date;
            $customer->gender = $request->gender;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->save();
            return response()->json(['message' => 'Cliente actualizado com sucesso!', 'success' => true]); 
        }
        public function destroy(Request $request){
            if (Customer::findOrFail($request->id)->delete())
            return response()->json(['message' => 'Cliente apagado com sucesso!', 'success' => true]);
            else
            return response()->json(['message' => 'Falha ao apagar!', 'success' => false]);
        }
        
    }