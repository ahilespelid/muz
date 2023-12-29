<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController{
use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
const PHONE_CODE = '+7', 
      DEFAULT_CONTACT = 199,
      //DOMAIN = 'b24-9948j5.bitrix24.ru',
      DOMAIN = 'musclass.bitrix24.ru',
      AMOUT_PEOPLE_ID = 'fe7f09ae-14ac-4071-9d99-e278cef61ea5',
      MUZ_ID_BX = 'UF_CRM_1697011461644',    
      DATE_FROM_BX = 'UF_CRM_1697156890471',    
      DATE_TO_BX = 'UF_CRM_1697156942243';    
    
    public function is_phone(string $phone):string{
        $phone = preg_replace('/\D/', '', $phone);          // Удаляем все не символы кроме цифр
        if(substr($phone, 0, 1) !== '9'){return false;}     // Номер должен начинается на цифру 9
        if(strlen($phone) !== 10){return false;}            // Длиной 10 символов
    return self::PHONE_CODE.$phone;}
    
    public function is_email(string $email):string{
        return (false === filter_var($email, FILTER_VALIDATE_EMAIL)) ? false : $email;
    }

}