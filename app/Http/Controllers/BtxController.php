<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException; 

class BtxController extends Controller{
    private $wh; public $bx24;    
public function __construct(){
    $this->setWh('https://b24-9948j5.bitrix24.ru/rest/13/wgo3pwvp35lyec0g/');   
}

public function addDiel(array $opt):bool{//$opt = ['TITLE' => 'Тестовая сделка №1', 'COMPANY_ID' => 6, 'CONTACT_ID' => 312]
    if(empty($opt)){return false;}
return ($this->bx24->addDeal($opt)) ? true : false;}

public function getDielAll():?array{$ret=[];
    foreach($this->bx24->fetchDealList() as $gen){$ret += $gen;} 
return (empty($ret)) ? null : $ret;}

public function setWh(string $wh):void{
    $this->wh = $wh; $this->bx24 = new Bitrix24API($this->wh);
}public function getWh():string{return $this->wh;}

}