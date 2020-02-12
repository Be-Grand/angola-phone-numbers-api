<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;

use Illuminate\Auth\Events\Registered;
use App\Events\DisableUserEventPrivate;



class UserController extends Controller
{
   
    use SendsPasswordResetEmails, ResetsPasswords {
        SendsPasswordResetEmails::broker insteadof ResetsPasswords;
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
    }

    public function sendPasswordResetLink(Request $request)
    {
        return $this->sendResetLinkEmail($request);
    }
   
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json([
            'message' => 'Password reset email sent.',
            'data' => $response
        ]);
    }
    
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Email could not be sent to this email address.']);
    }

    public function callResetPassword(Request $request)
    {
        return $this->reset($request);
    }
 
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
    }
    
    protected function sendResetResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Password reset successfully.']);
    }
   
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Failed, Invalid Token.']);
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
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|numeric|phone',
            'password' => 'required|min:6'

        ]);
        if($validator->fails()){
            return response()->json([$validator->errors(), 'success' => false], 400);
        }
        $email='';
        $user='';
        if ($request->phone){
            $user = User::where('phone', $this->validatePhone($request->phone, false))->first();
            $email= $user? $user->email : null;
        }
        else {
            $user = User::where('email', $request->email)->first();
            $email= $request->email;
        }
        if ($email){
            $credentials =['email'=>$email, 'password'=>  $request->password];
        }
        else{
            return response()->json([Validator::make(['email'=>null, 'phone'=>null], [
                'email' => 'required',
                'phone' => 'required',
    
            ])->errors(), 'success' => false], 400);
        }
        try {
            if ( $user && ! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Senha errada.', 'success'=>false], 400);
            }
            else if ( !$user && ! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'E-mail ou número de telefone errado.', 'success'=>false], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Não foi possivel criar um token', 'success'=>false], 400);
        }
        if ($user->status == '1' || $user->status==null){
            return response()->json(['message' => 'A sua conta está desactivada, não tens o devido acesso.', 'success'=>false], 401);
        }
        else {
            return response()->json(['message'=> 'Login efectuado com sucesso', 'success'=> true, 'token'=>$token, 'user'=>$user]);
        }
    }

    public function logout(Request $request) {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message'=> "Você foi deslogado com sucesso!", 'success' => true]);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Falha ao fazer ao terminar a sessão.', 'success' => false], 500);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'nullable|numeric|phone|unique:users',

        ]);

        if($validator->fails()){
            return response()->json([$validator->errors(), 'success' => false], 400);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type'=> $request->type,
            'status'=> '1',
            'municipality_id'=> '1',
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'password' => Hash::make('123456'),
        ]);
        event(new Registered($user));
        $token = JWTAuth::fromUser($user);
        return response()->json(['message'=> 'Conta criada com sucesso.', 'success'=> true, /*'token'=>$token, 'user'=>$user*/], 201);
    }

    public function recover(Request $request){
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => "E-mail não encontrado."], 401);
        }
        try {
            Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject('Foi enviado o link de recuperação');
            });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'message' => $error_message], 401);
        }
        return response()->json([
            'success' => true, 'message'=> 'Foi enviado um link de recuperação de conta no seu e-mail.'
        ]);
    }
    public function update(Request $request){
        $user = JWTAuth::parseToken()->authenticate();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->birth_date = $request->birth_date;
        if ( $user->email != $request->email){
            $user->email == $request->email;
            $user->verified_at = null;
        }

        $name =null;
        $allowedExtensions = ['png', 'jpg', 'jpeg'];
        if (!empty($request->imageToUpload)) {
           
            $explode = explode(',', $request->imageToUpload);
            if(count($explode) == 2){
                
                $format = str_replace(
                    ['data:image/', ';', 'base64'], 
                    ['', '', '',], 
                    $explode[0]
                );
                if (in_array($format, $allowedExtensions)) {
                    $decoded = base64_decode($explode[1]);
                    if (str_contains($explode[0], 'jpeg')){
                        $extension ='jpg';
                    }
                    else{
                        $extension ='png';
                    }
                    if ($user->image){
                        $expl= explode('.', $user->image);
                        $name = $expl[0];
                    }
                    else {
                        $name = $user->id.kebab_case($user->first_name);
                    }
                    $fileName ="{$name}.{$extension}";
                    $path= public_path().'/storage/users/'. $fileName;
                    file_put_contents($path, $decoded);
                    $user->image = $fileName;
                }
            }
        }
        if ($user->save()){
            return response()->json(['success' => true, 'message' => "Dados actualizados com sucesso.", 'data' => $user]);
        }
        return response()->json(['success' => false, 'message' => "Dados não actualizados", 'data' => $user]);
    }
 
 
    public function updatePassword(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
     
        if(password_verify($request->old_password, $user->password)){
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json(['message' => 'Senha actualizada com sucesso!', 'success' => true]); 
        }
       
        return response()->json(['message' => 'Erro ao actualizar a senha!', 'success' => false]); 
    }
  
    public function get(Request $request){
        return response()->json(['success' => true, 'message' => "Operação realizada com sucesso.",'data' =>$request->user()]);
    }
    public function list(){
        $users = User::leftjoin('municipalities', 'municipalities.id', 'users.municipality_id')->select('users.*', 'municipalities.municipality')->paginate(20);
        return response()->json(['message' => "Operação realizada com sucesso.", 'users' => $users,'success' => true]);
    }

    public function disable(Request $request){
        $admins_count = User::whereStatus('0')->whereType('0')->get()->count();
        $use = User::findOrFail($request->id);
        if ($admins_count<=1){
            return response()->json(['success' => false, 'message' => "Este é o único administrador com todos com todos privilégios, adicione outro e tenta mais tarde.", ]);
        }
        else {
            $user->status = $request->status;
            $user->save();

            try {
                JWTAuth::invalidate(JWTAuth::fromUser($user));
            } catch (JWTException $e) {
            }
            event(new DisableUserEventPrivate($user, $disabled=$user->status==0?false:true));
            return response()->json(['success' => true, 'message' => "Conta desactivada com sucesso.", 'data' => $user]);
        }  
    }
    public function destroy(Request $request){
        $admins_count = User::whereStatus('0')->whereType('0')->get()->count();
        $user = User::findOrFail($request->id);
        if ($admins_count<=1){
            return response()->json(['success' => false, 'message' => "Este é o único administrador com todos com todos privilégios, adicione outro e tenta mais tarde.", ]);
        }
        else {
            if ($user->delete())
            return response()->json(['success' => true, 'message' => "Conta eliminada com sucesso.", ]);
            else
            return response()->json(['message' => 'Falha ao apagar!', 'success' => false]);
        }  
    }
    
}
