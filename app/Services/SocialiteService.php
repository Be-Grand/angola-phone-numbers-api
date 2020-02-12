<?php


namespace App\Services;


use App\Helpers\SocialiteHelper;
use App\Services\Contracts\SocialiteServiceInterface;
use App\User;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class SocialiteService implements SocialiteServiceInterface
{
    public function getRedirectUrlByProvider($provider): array
    {
        if ($provider=='twitter'){
            return [
                'redirectUrl' => Socialite::driver($provider)
                    ->redirect()
                    ->getTargetUrl()
            ];
        }
        else if ($provider=='facebook'){
            return [
                'redirectUrl' => Socialite::driver($provider)
                    ->fields([
                        'name', 'first_name', 'last_name', 'email', 'gender', 'birthday',  'address'
                    ])
                    ->stateless()
                    ->redirect()
                    ->getTargetUrl()
            ];
        }
        

        else{
            return [
                'redirectUrl' => Socialite::driver($provider)
                    ->stateless()
                    ->redirect()
                    ->getTargetUrl()
            ];

        }
       
    }

    public function loginWithSocialite($provider): array
    {
        $userSocial = null;
        if ($provider=='twitter'){
            $userSocial =  Socialite::driver($provider)->user() ;
        }else if ($provider=='facebook'){
            $userSocial =  Socialite::driver($provider)->stateless()->fields(['name', 'first_name', 'last_name', 'email', 'gender', 'birthday', 'address'])->user();
        }else{
            $userSocial =  Socialite::driver($provider)->stateless()->user();
        }
        if (SocialiteHelper::isSocialPresent($userSocial)) {
            $user = $this->searchUserByEmail($userSocial->email);
            if ($user) {
                return  $user->provider == $provider ? $this->prepareSuccessResult($user) : $this->prepareErrorResult();
            } else {
           
                //$user = New User([], $userSocial);
              
                $user = User::create([
                    'first_name' =>$this->formatName($userSocial->getName())['first_name'],
                    'last_name' =>  $this->formatName($userSocial->getName())['last_name']  ,
                    'email' =>  $userSocial->getEmail(),
                    'image'  =>  $userSocial->getAvatar(),
                    'address'=> $this->formatAddress($userSocial,  $provider),
                    'type'=> '2',
                    'gender' => $this->formatGender($userSocial, $provider),
                    'provider' => $provider,
                    'birth_date'=> $this->formatDate($userSocial,  $provider),
                ]);
            
                return $user->save()
                    ? $this->prepareSuccessResult($user)
                    : $this->prepareErrorResult();
            
               
            }
        } else {
            return $this->prepareErrorResult();
        }
    }
    private function formatAddress($user,  $provider)
    {
        $address =null;
        if ($provider== 'twitter' && $user->location){
            $address = $user->location;
        }
        else if ('u'=='e'){//$provider== 'facebook' && $user->address ) {
           // $address = $user->address;
        }
        return $address;
    }
    private function formatDate($user,  $provider)
    {
        if ('u'=='e'){//$provider== 'facebook' && $user->birth_date
           // $birth_date = date('Y-m-d',strtotime($user->birth_date));
        }
        else {
            $birth_date = Carbon:: now()-> format('Y-m-d');
        }
        return $birth_date ;
    }
    private function formatGender($user,  $provider)
    {
        if ('u'=='e'){//$provider== 'facebook' && $user->gender
           // $gender = $user->gender == 'male'? '1' : '0';
        }
        else {
            $gender = '1';
        }
        return $gender ;
    }
    private function formatName($name)
    {
        $parts = explode(" ", $name);
        if(count($parts) > 1) {
            $last_name = array_pop($parts);
            $first_name = implode(" ", $parts);
        }
        else
        {
            $first_name = $name;
            $last_name = " ";
        }
        return[
            'first_name' =>$first_name,
            'last_name' =>  $last_name ,
        ];
    }
    private function makeAuthenticationCookie($result)
    {
        $result['cookie'] = cookie('authentication',
            json_encode($result),
            8000,
            null,
            null,
            false,
            false
        );
        return $result;
    }

    private function searchUserByEmail($email): ?User
    {
        return User::where('email', $email)->first();
    }

    private function prepareErrorResult(): array
    {
        return $this->makeAuthenticationCookie([
            'error' => 'Não foi possivel usar está rede social. Tente com uma outra',
            'redirect' => '/login',
            'redirect_url' => '/#/',
        ]);
    }

    private function prepareSuccessResult(User $user): array
    {
        return $this->makeAuthenticationCookie([
            'error' => null,
            //'api_token' => $user->api_token,
            'user_id' => $user->id,
            'redirect_url' => '/#/'
        ]);
    }
}