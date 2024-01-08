<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException; 

class BtxController extends Controller{
    private $wh; public $bx24;    
public function __construct(){
    $bxkeys = include(resource_path('arrays/bxkeys.php')); 
    $this->setWh(($key = (is_array($bxkeys)) ? $bxkeys[array_rand($bxkeys)] : 'https://musclass.bitrix24.ru/rest/3/j50n6tryd4yxv5j8/'));
    //pa($wh);pa($this->wh);pa($key); exit;
}

public function addDiel(array $opt):bool{//$opt = ['TITLE' => 'Тестовая сделка №1', 'COMPANY_ID' => 6, 'CONTACT_ID' => 312]
    if(empty($opt)){return false;}
return ($this->bx24->addDeal($opt)) ? true : false;}

public function getDielAll():?array{$ret=[];
    foreach($this->bx24->fetchDealList() as $gen){$ret += $gen;} 
return (empty($ret)) ? null : $ret;}

public function setWh(string $wh):void{$this->wh = $wh; $this->bx24 = new Bitrix24API($this->wh);}

public function getWh():string{return $this->wh;}

public function getContactsByPhone($phone){
    try{
        return $this->bx24->getContactsByPhone($phone);
    }catch(\Exception $e){ pa($e); exit;
        sleep(1); $this->getContactsByPhone($phone);
}}

}