<?php

namespace App\Providers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        //
        Validator::extend('phone', function($attribute, $value, $parameters, $validator) {
            return preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$%i', $value) ;
        });
    
        Validator::replacer('phone', function($message, $attribute, $rule, $parameters) {
                return str_replace(':attribute',$attribute, 'valor inserido no campo :attribute é um número de telefone inválido');
            });

        Validator::extend('bi', function($attribute, $value, $parameters, $validator) {
            return preg_match("/^[0-9]{9}[A-Z]{2}[0-9]{3}$/m", $value) ;
        });
    
        Validator::replacer('bi', function($message, $attribute, $rule, $parameters) {
                return str_replace(':attribute',$attribute, 'valor inserido no campo :attribute é um número de bilhete ou contribuinte inválido');
        });
        Validator::extend('passport', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[A-PR-WY][1-9]\d\s?\d{4}[1-9]$/', $value) ;
        });
    
        Validator::replacer('passport', function($message, $attribute, $rule, $parameters) {
                return str_replace(':attribute',$attribute, 'valor inserido no campo :attribute é um número de passaporte inválido');
        });
        Validator::extend('residence_card', function($attribute, $value, $parameters, $validator) {
            return preg_match("/^[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{5}$/m", $value) ;
        });
    
        Validator::replacer('residence_card', function($message, $attribute, $rule, $parameters) {
                return str_replace(':attribute',$attribute, 'valor inserido no campo :attribute é um número de cartão de residência inválido');
        });
    }
        
}
