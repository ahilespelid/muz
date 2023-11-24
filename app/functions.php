<?php
if(!function_exists('pa')){
    function pa($a,$br=0,$mes='',$t='pre'):bool{$backtrace = debug_backtrace(); $fileinfo = '';$sbr='';
        if(!empty($backtrace[0]) && is_array($backtrace[0])){$fileinfo = $backtrace[0]['file'] . ":" . $backtrace[0]['line'];}
        while($br){$sbr.=(empty($t) ? PHP_EOL : '<br>');$br--;}
        echo $fileinfo.$sbr.$mes.(empty($t) ? '' : '<'.$t.'>'); print_r($a=(!empty($a)?$a:[])); echo(empty($t) ? '' : '</'.$t.'>').PHP_EOL;
        return true;
}}
if(!function_exists('is_date')){
function is_date($value){ // */  проверка строки на дату  // */
    if(!$value){return null;}
    try{return $d = (new \DateTime($value));}catch(\Exception $e){return null;}
    return null;}
}
if(!function_exists('is_json')){
function is_json($string){
    json_decode($string);
return (json_last_error() == JSON_ERROR_NONE);}    
}
if(!function_exists('is_phone')){
function is_phone(string $phone):string{
        $phone = preg_replace('/\D/', '', $phone);          // Удаляем все не символы кроме цифр
        if(substr($phone, 0, 1) !== '9'){return false;}     // Номер должен начинается на цифру 9
        if(strlen($phone) !== 10){return false;}            // Длиной 10 символов
return '+7'.$phone;}
}
if(!function_exists('is_email')){
function is_email(string $email):string{
        return (false === filter_var($email, FILTER_VALIDATE_EMAIL)) ? false : $email;
    }
}

?>