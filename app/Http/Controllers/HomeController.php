<?php namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
setlocale(LC_ALL, 'ru_RU.utf8');
date_default_timezone_set( 'Europe/Moscow' );

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MuzController;
use App\Http\Controllers\BtxController;
use App\Models\Classes;
use App\Models\Corpuses;
use App\Models\Orders;
use App\Models\Users;
use \Crest;

class HomeController extends Controller{    
public function index(Request $request){
    $mb = new MuzController; //$api->setLogin(); 
    $bx = new BtxController; 

    if('stoimost' == $request->api){$mb->stoimost($request);exit;}
        
    $dealId = empty($request->dealId) ? (
            (!empty($request->PLACEMENT_OPTIONS) && !empty($dealJson = json_decode($request->PLACEMENT_OPTIONS, true))) ? 
                (empty($dealJson['ID']) ? null : $dealJson['ID']) : null
        ) : $request->dealId;

    if($bases = (is_array($bases = $mb->listBases())) ? $bases : null){
        ///*/ Синхранизация корпусов pa($bases); exit; ///*/
        foreach($bases as $base){
            $newBase = Corpuses::firstOrCreate(['muzid' => $base['id']]);
            $newBase->muzid = $base['id'];
            $newBase->name = $base['value'];
            $newBase->type = $base['sphere'];
            $newBase->save();
        }
        
        $week = ['пн','вт','ср','чт','пт','сб','вс'];
        $month = ['Январь', 'Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь', 'Ноябрь','Декабрь'];
        $monthShort = ['Янв', 'Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт', 'Ноя','Дек'];
        $curBaseImg = ['https://partner.musbooking.com/res/bases/220315-1650-2.jpeg','https://partner.musbooking.com/res/bases/220314-2123-5.jpeg',];
        
        $curTimestamp           = (empty($_GET['dateIn'])) ? time() : strtotime($_GET['dateIn']); 
        $curDate['day']         = date('d', $curTimestamp);
        $curDate['month']       = date('m', $curTimestamp);
        $curDate['monthRus']    = $month[$curDate['month']-1];
        $curDate['year']        = date('Y', $curTimestamp);
        $curDate['week']        = $week[date('N', $curTimestamp)-1];
        $curDate['calendar']    = $curDate['week'].', '.$monthShort[$curDate['month']-1].' '.$curDate['day'];
        $curDate['rus']         = $curDate['day'].' '.$curDate['monthRus'].' '.$curDate['year'];
        $curDate['timestamp']   = strtotime($curDate['year'].'-'.$curDate['month'].'-'.$curDate['day']);
        
        $curBaseKey = (!empty($request->baseId) && !empty($bases)) ? array_search($request->baseId, array_column($bases, 'id')) : null;
        $curBase = (empty($curBaseKey)) ? ((!empty($bases[0]['value']) && !empty($bases[0]['sphere'])) ? $bases[0] : null) : $bases[$curBaseKey]; 
        $curBase['workHours'][0]['from'] = (0 === $curBase['workHours'][0]['from']) ? 1 : $curBase['workHours'][0]['from'];
        //pa($curBase['id']); //exit;
        $clases = (!empty($curBase['id'])) ? array_filter($mb->listClases(), function($el) use($curBase){return $el['baseId'] === $curBase['id'];}) : null;
        usort($clases, function($a, $b){return $a['order'] <=> $b['order'];});
        //pa($clases); exit;
        if(!empty($curBase['workHours'][0]['from']) && !empty($curBase['workHours'][0]['to'])){
            $period = new \DatePeriod(new \DateTime(gmdate('H:i', $curBase['workHours'][0]['from']*3600)), new \DateInterval('PT1H'), new \DateTime(gmdate('H:i', $curBase['workHours'][0]['to']*3600-61)));
            $curTimes = []; foreach($period as $value){$curTimes[] = $value->format('H:i');} $curTimes[] =  $curBase['workHours'][0]['to'].':00';
        }else{
            $curTimes = ['01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00', '24:00'];            
        }
        ///*/ Синхранизация классов pa($bases); exit; ///*/
        foreach($clases as $clase){
            $orders[$clase['id']] = $mb->listOrders($clase['id'], date('Y-m-d', $curDate['timestamp']));
            $newClass = Classes::firstOrCreate(['muzid' => $clase['id']]);
            $newClass->name = $clase['value'];
            $newClass->muzid = $clase['id'];
            $newClass->corpusesid = $clase['baseId'];
            $newClass->orders = $clase['order'];
            $newClass->save();
        } $rooms = array_fill_keys(array_keys($orders), '');
        //pa($orders['a9b09c01-0057-41dd-a66b-a8c4ec5e4097']); exit; 
        //pa($orders); exit;
        $curOrders = array_fill_keys($curTimes, $rooms);
        
        foreach($orders as $id => $ordersList){
///*/ ВЫБИРАЕМ ID КЛАССА ИЗ НАШЕЙ БД ///*/
            $classMuzid = (0 <= $key = array_search($id, array_column($clases, 'id'))) ? $clases[$key]['id'] : null;
            $classId = ($classMuzid) ? Classes::where('muzid', '=', $classMuzid)->get('id')->toArray()[0]['id'] : null;
            
            if(!empty($ordersList)){ //$cl = Classes::where('muzid', '=', $id); pa($cl, 5); exit;//pa($classId); exit; //pa($ordersList[$i]); exit;
 ///*/ ПЕРЕБИРАЕМ ЗАКАЗЫ ИЗ МУЗБУКИНГА ///*/
                for($i=0,$c=count($ordersList); $i<$c; $i++){
///*/ ЕСЛИ В ЗАКАЗЕ ЕСТЬ ИМЯ И ТЕЛЕФОН ///*/
                    if(!empty($phone = $ordersList[$i]['phone']) && !empty($fio = $ordersList[$i]['fio'])){
                        $email = (empty($ordersList[$i]['email'])) ? '' : $ordersList[$i]['email'];
///*/ ПРОВЕРЯЕМ ЕСТЬ ЛИ ПОЛЬЗОВАТЕЛЬ В БИТРИКС ПО ТЕЛЕФОНУ, ЕСЛИ НЕТ ///*/
                        if(empty($bxContactIdCheck = $bx->bx24->getContactsByPhone($phone))){
                            list($lastname, $firstname) = explode(' ', trim($fio));
///*/ СОЗДАЁМ ПОЛЬЗОВАТЕЛЯ В БИТРИКС ///*/                            
                            $bxContactId = $bx->bx24->addContact([
                                'NAME'      => $firstname,
                                'LAST_NAME' => $lastname,
                                'PHONE'     => array((object)['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']),
                                'EMAIL'     => array((object)['VALUE' => $email]),
                                //'COMPANY_ID'  => 332,
                                //'SECOND_NAME' => 'Васильевич',
                            ]);
///*/ ЕСЛИ ПОЛЬЗОВАТЕЛЬ БИТРИКС СУЩЕСТВУЕТ БЕРЁМ ЕГО ID ///*/                            
                        }else{$bxContactId = $bxContactIdCheck[0]['ID'];}
///*/ ВЫБИРАЕМ ИЛИ СОЗДАЁМ ЕСЛИ НЕТ ПОЛЬЗОВАТЕЛЯ С ТАКИМ ТЕЛЕФОНО И ИМЕНЕМ В НАШЕЙ БАЗЕ ///*/
                        $newUser = Users::firstOrCreate(['phone' => $phone, 'fio' => $fio]);
                        $newUser->phone = $phone;
                        $newUser->fio = $fio;
                        $newUser->email = $email;
                        $newUser->bitrixid = $bxContactId;
                        $newUser->save();
                    }else{
///*/ ЕСЛИ В ЗАКАЗЕ НЕТ ИМЯ И ТЕЛЕФОН ///*/
                        $createUser = Users::create([
                            'fio' => '',
                            'key2' => 'val2',
                        ]);
                        $userId = (empty($newUser->id)) ? '' : $newUser->id;
                    }
                    pa($newUser->id);exit;
                    
                    $newOrder = Orders::firstOrCreate(['muzid' => $base['id']]);
                    $newOrder->muzid = $ordersList[$i]['id'];
                    $newOrder->usersid = $newUser->id;
                    $newOrder->name = $base['value'];
                    $newOrder->type = $base['sphere'];
                    $newOrder->save();

                $periodsOrder = new \DatePeriod(new \DateTime(date('H:i', strtotime($ordersList[$i]['dateFrom']))), new \DateInterval('PT1H'), new \DateTime(date('H:i', strtotime($ordersList[$i]['dateTo'])))); 
                foreach($periodsOrder as $periodOrder){
                    //$curOrders[$periodOrder->format('H:00')][$id] = $ordersList[$i];
                    //unset(); 
                    $curOrders[$periodOrder->format('H:00')][$id] = $ordersList[$i]; //array_merge($rooms, [$id => $ordersList[$i]]);
                }
    }}}
    //pa($curOrders);
    //$curOrders = (empty($curOrders)) ? array_fill_keys($curTimes, $rooms) : array_merge(array_fill_keys($curTimes, $rooms),$curOrders);
    //pa($curOrders); exit;
    //
    /*/
    $deal = (!empty($deal_id) && $deal = CRest::call('crm.deal.get', ['ID' => $deal_id])) ? 
        (isset($deal['result']) ? $deal['result'] : ['ID' => $deal['error_description']]) : $deal;
    $deal_into_id = (empty($deal['UF_CRM_1683462809'])) ? null : $deal['UF_CRM_1683462809'];
///*/
 
///*/ Вывод ///*/
    $data = get_defined_vars(); unset($data['request'], $data['mb'], $data['bx']); $data = array_keys($data);
return view('front.home', compact($data));}else{
pa($bases = $mb->listBases());}}             

}