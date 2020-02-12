<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Operator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;


    class OperatorController extends Controller
    {
        public function get(){
            $operators = Operator::paginate(20);
            return response()->json(['message' => "Operação realizada com sucesso.", 'operators' => $operators,'success' => true]);
        }
        public function add(Request $request) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|',
                'type' => 'required',
            ]);
            if($validator->fails()){
                return response()->json([$validator->errors(), 'success' => false], 400);
            }
            $operator = Operator::create([
                'name'=> $request->name,
                'type'=> $request->type,
            ]);
            if($operator)
            return response()->json(['message' => 'Operadora cadastrada com sucesso!', 'success' => true]);
        }
        public function update(Request $request){
            $operator = Operator::findOrFail($request->id);
            $operator->name = $request->name;
            $operator->type = $request->type;
            $operator->save();
            return response()->json(['message' => 'Operadora actualizada com sucesso!', 'success' => true]); 
        }
        public function destroy(Request $request){
            if (Operator::findOrFail($request->id)->delete())
            return response()->json(['message' => 'Operadora apagada com sucesso!', 'success' => true]);
            else
            return response()->json(['message' => 'Falha ao apagar!', 'success' => false]);
        }
        
    }