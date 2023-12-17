<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;
//use \Crest;

class MuzController extends Controller{
    public $login, $pass, $key, $curl, $url, $token;

public function __construct(){
    $this->curl = curl_init();
    $this->setLogin(); 
}    

public function setLogin(string $login = 'musicclasses24', string $pass = 'Lg5BJ8', string $url = 'https://partner.musbooking.com'){
    if(empty($login) && empty($pass) && empty($url)){return null;}
    $this->login = $login; $this->pass = $pass; $this->url = $url;
    
    $this->curl = curl_init();
    curl_setopt_array($this->curl, [
        CURLOPT_URL => $this->url.'/api/auth/login', 
        CURLOPT_RETURNTRANSFER => 1, CURLOPT_POST => 1, 
        CURLOPT_POSTFIELDS => http_build_query(['login' => $login, 'password' => $pass])
        ]);
    $token = (is_json($tokenJson = curl_exec($this->curl))) ? json_decode($tokenJson, true) : null;
    if(!empty($token['token']) && !empty($token['key'])){$this->key = $token['key']; $this->token = $token['token'];}
}

public function listSpheres():?array{
    if(empty($this->token)){return null;}
    $url = $this->url.'/api/spheres/search?'.http_build_query(['token' => $this->token]);
return (is_json($json = file_get_contents($url))) ? json_decode($json, true) : null;}

public function listBases(){//*/ pa($this->url.'/api/bases/names?token='.$this->token); //*/
    if(empty($this->token)){return null;}        
    curl_setopt($this->curl, CURLOPT_URL, $this->url.'/api/bases/names'); 
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($this->curl, CURLOPT_POST, 0);
    curl_setopt($this->curl, CURLOPT_HEADER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.$this->token]);
return (is_json($json = curl_exec($this->curl))) ? json_decode($json, true) : $json;}

public function listClases(){//*/ pa($this->url.'/api/rooms/names?token='.$this->token); //*/
    if(empty($this->token)){return null;}
    curl_setopt($this->curl, CURLOPT_URL, $this->url.'/api/rooms/names');
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($this->curl, CURLOPT_POST, 0);
    curl_setopt($this->curl, CURLOPT_HEADER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.$this->token]);
return (is_json($json = curl_exec($this->curl))) ? json_decode($json, true) : $json;}

public function listOrders(string $room, string $dfrom = '', string $dto = ''){
    if(empty($this->token) && empty($room)){return null;}
    $dfrom = (empty($dfrom)) ? date('Y-m-d') : $dfrom;
    $dto = (empty($dto)) ? date('Y-m-d', strtotime($dfrom)) : $dto;
    //$date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -'.$agoMonth.' month'));

    curl_setopt($this->curl, CURLOPT_URL, $url = $this->url.'/api/orders/wgcalendar?' . http_build_query(['room' => $room, 'dfrom' => $dfrom, 'dto' => $dto])); //pa($url);
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($this->curl, CURLOPT_POST, 0);
    curl_setopt($this->curl, CURLOPT_HEADER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
    //curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.$this->token]);
return (is_json($json = curl_exec($this->curl))) ? json_decode($json, true) : $json;}

public function syncUpdate(string $muzid, int $act = 11){
    $this->setLogin();
    if(empty($this->token) && empty($muzid)&& empty($status)){return null;}
    $d = ['id' => $muzid, 'act' => $act, 'token' => $this->token]; //pa($d);
    
    curl_setopt($this->curl, CURLOPT_URL, $url = $this->url.'/api/orders/status?' . http_build_query($d)); //pa($url);
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($this->curl, CURLOPT_POST, 1);
    curl_setopt($this->curl, CURLOPT_HEADER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.$this->token]);
return (is_json($json = curl_exec($this->curl))) ? json_decode($json, true) : $json;}

public function syncAdd(string $room, string $dateTime, string $firstName, string $lastName, string $phone, ?string $email = '', int $hours = 1){
    $this->setLogin();
    if(empty($this->token) && empty($room)&& empty($dateTime)&& empty($firstName)&& empty($lastName)&& empty($phone)){return null;}
    $d = ['room' => $room, 'date' => $dateTime, 'hours' => $hours, 'firstName' => $firstName, 'lastName' => $lastName, 'phone' => $phone, 'email' => $email];
    if(empty($email)){unset($d['email']);}
    
    curl_setopt($this->curl, CURLOPT_URL, $url = $this->url.'/api/orders/sync-add?' . http_build_query($d)); //pa($url); exit;
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($this->curl, CURLOPT_POST, 1);
    curl_setopt($this->curl, CURLOPT_HEADER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.$this->token]);
    //pa(curl_exec($this->curl));exit;
return (is_json($json = curl_exec($this->curl))) ? json_decode($json, true) : $json;}

public function listSyncOrders(int $agoMonth = 1){
    if(empty($this->token)){return null;}
    $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -'.$agoMonth.' month'));
    curl_setopt($this->curl, CURLOPT_URL, $this->url.'/api/orders/sync-list');
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($this->curl, CURLOPT_POST, 1);
    curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query(['date' => $date]));     
    curl_setopt($this->curl, CURLOPT_HEADER, true);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
     
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer' . $this->token, 'User-Agent: HendrixApp']);
///*/ pa($this->login.PHP_EOL.$this->pass.PHP_EOL.$this->url.PHP_EOL.PHP_EOL.PHP_EOL); pa($date); ///*/        
return (is_json($json = curl_exec($this->curl))) ? json_decode($json, true) : $json;}


public function __destruct(){curl_close($this->curl);}}