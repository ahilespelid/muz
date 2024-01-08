<?php namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
set_time_limit(0);
setlocale(LC_ALL, 'ru_RU.utf8');
date_default_timezone_set( 'Europe/Moscow' );

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\MuzController;
use App\Http\Controllers\BtxController;

use App\Http\Controllers\SyncController;

use App\Models\Classes;
use App\Models\Corpuses;
use App\Models\Orders;
use App\Models\Users;
use Validator;

class HomeController extends Controller{

 public function index(Request $request){
    if($request->DOMAIN != self::DOMAIN){
        //pa($request->toArray());exit;
        $redirectWidget = (empty($request->addOrderNotification)) ? '/widget' : 
                          (empty($request->classId) ? '/widget?addOrderNotification='.$request->addOrderNotification : '/widget?classId='.$request->classId.'&addOrderNotification='.$request->addOrderNotification);
        //pa($redirectWidget); exit;
        header('Location: '.$redirectWidget); exit;}
    $data = $this->in($request);
    //pa(); exit;
    return (empty($data)) ? abort(404) : view('front.home', $data);
}
public function widget(Request $request){
    $data = $this->in($request);
    $data['periodWidget'] = [];
    $period = new \DatePeriod(new \DateTime(date("Y-m-d H:i:s", $data['curTimestamp'])), new \DateInterval('P1D'), new \DateTime(date("Y-m-d H:i:s", $data['curTimestamp']+(86400*14))));
    foreach($period as $per){
        $data['periodWidget'][] = ['date' => $per, 'weekday' => $data['week'][$per->format('N')-1], 'day' => $per->format('d').' '.$data['monthShort'][$per->format('m')-1]];
    }
    //pa($data); //exit;if(!empty($request->addOrderNotification)){pa($request->addOrderNotification);exit;}
    return (!empty($data)) ? view('front.widget', $data) : abort(404);
}

public static function getOrdersFromMuzOneDay(string $classid, string $date, array $curTimes):array{
    $mb = new MuzController; $orders = array_fill_keys($curTimes,''); $ordersList = '';
    if($ordersList = (empty($classid) && empty($date)) ? null : (!empty($order = $mb->listOrders($classid, date('Y-m-d', strtotime($date)))) ? $order : null) && is_array($ordersList)){
        for($i=0,$c=count($ordersList); $i<$c; $i++){
            $periodsOrder = new \DatePeriod(new \DateTime(date('H:i', strtotime($ordersList[$i]['dateFrom']))), new \DateInterval('PT1H'), new \DateTime(date('H:i', strtotime($ordersList[$i]['dateTo'])))); 
            foreach($periodsOrder as $periodOrder){
                $orders[$periodOrder->format('H:00')] = $ordersList[$i];
            }
    }}ksort($orders);
return $orders;}    
    
public static function getOrdersFromOurOneDay(string $classesid, string $date, array $curTimes):?array{
    $orders = $timeJob = array_fill_keys($curTimes,''); //pa($orders);
    if(!empty($classesid) && !empty($date) && is_array($ordersList = Orders::where('classesid', $classesid)->whereDate('datefrom', $date)->get()->toArray()) && !empty($ordersList)){
            for($i=0,$c=count($ordersList); $i<$c; $i++){
                $periodsOrder = new \DatePeriod(new \DateTime(date('H:i', strtotime($ordersList[$i]['datefrom']))), new \DateInterval('PT1H'), new \DateTime(date('H:i', strtotime($ordersList[$i]['dateto'])))); 
                foreach($periodsOrder as $periodOrder){
                    $orders[$periodOrder->format('H:00')] = $ordersList[$i];
                }
    }}ksort($orders);//pa($orders);
    
    if(!empty($keyUnsetList = array_keys(array_diff_ukey($orders, $timeJob, function($a, $b){return ($a === $b) ? 0 : (($a > $b)? 1: -1);})))){
        foreach($keyUnsetList as $thisKey){unset($orders[$thisKey]);}
    }//pa($orders);
return $orders;}    
    
    
public function in(Request $request){
    $mb = new MuzController;
    $bx = new BtxController('https://b24-9948j5.bitrix24.ru/rest/3/1x1wha5pdsw7e3xi/');
//pa($request->toArray());    
///* / БЕРЁМ ДОМЕН ЧЕРЕЗ КОТОРЫЙ ЗАПРАШИВАЕТСЯ, ЧТОБЫ ОГРАНИЧИТЬ ВИДИМОСТЬ ВНЕ БИТРИКС ПРИЛОЖЕНИЯ ///* /
    $domain = ($request->DOMAIN ?? self::DOMAIN);
///* / ЕСЛИ ПРИЛОЖЕНИЕ ОТКРЫТО ИЗ СДЕЛКИ БЕРЁМ ID СДЕЛКИ ///* /
    $OpenDealId = empty($request->dealId) ? (
            (!empty($request->PLACEMENT_OPTIONS) && !empty($dealJson = json_decode($request->PLACEMENT_OPTIONS, true))) ? 
                (empty($dealJson['ID']) ? null : $dealJson['ID']) : null
        ) : $request->dealId;
///* / БЕРЁМ КОРПУСА ИЗ БАЗЫ ///* /
    if($Corpuses = (!empty($Corpuses = Corpuses::all()->toArray())) ? $Corpuses : null){
        $week = ['пн','вт','ср','чт','пт','сб','вс'];
        $month = ['Января', 'Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября', 'Ноября','Декабря'];
        $monthShort = ['Янв', 'Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт', 'Ноя','Дек'];
        $curBaseImg = ['https://partner.musbooking.com/res/bases/220315-1650-2.jpeg','https://partner.musbooking.com/res/bases/220314-2123-5.jpeg',];
///* / БЕРЁМ ИЗ ПАРАМЕТРОВ ВРЕМЕННУЮ МЕТКУ ЛИБО ФОРМИРУЕМ ЕЁ ИЗ ТЕКУЩЕГО ВРЕМЕНИ ///* /        
        $curTimestamp           = (empty($request->dateIn)) ? time() : strtotime($request->dateIn); 
///* / ФОРМИРУЕМ ДАТ ИЗ ВРЕМЕННОЙ МЕТКИ ///* /        
        $curDate['day']         = date('d', $curTimestamp);
        $curDate['month']       = date('m', $curTimestamp);
        $curDate['monthRus']    = $month[$curDate['month']-1];
        $curDate['year']        = date('Y', $curTimestamp);
        $curDate['week']        = $week[date('N', $curTimestamp)-1];
        $curDate['calendar']    = $curDate['week'].', '.$monthShort[$curDate['month']-1].' '.$curDate['day'];
        $curDate['rus']         = $curDate['day'].' '.$curDate['monthRus'].' '.$curDate['year'];
        $curDate['datestamp']   = $curDate['year'].'-'.$curDate['month'].'-'.$curDate['day'];//strtotime($curDate['year'].'-'.$curDate['month'].'-'.$curDate['day']);
///* / БЕРЁМ ТЕКУЩИЙ КОРПУС ИЗ МАССИВА КОРПУСОВ УЧИТЫВАЯ ПАРАМЕТР ЗАПРОСА КОРПУСА ///* /
        if(!empty($request->classId)){
            $curCorpuses = $Corpuses[(!empty($corpId = Classes::where('id', $request->classId)->first('corpusesid')->toArray())) ? array_search($corpId['corpusesid'], array_column($Corpuses, 'muzid')) : 0];
        }else{
            $curCorpuses = $Corpuses[(!empty($request->baseId)) ? array_search($request->baseId, array_column($Corpuses, 'muzid')) : 0];
        } 
        
///* / ГЕНЕРИРУЕМ МАССИВ С РАБОЧИМ ВРЕМЕНЕМ КОРПУСА ///* /                
        if(!empty($curCorpuses['workfrom']) && !empty($curCorpuses['workto'])){
            $curCorpuses['workfrom'] = (0 === $curCorpuses['workfrom']) ? 1 : $curCorpuses['workfrom'];
            $curCorpusesPeriod = new \DatePeriod(new \DateTime(gmdate('H:i', $curCorpuses['workfrom']*3600)), new \DateInterval('PT1H'), new \DateTime(gmdate('H:i', $curCorpuses['workto']*3600-60)));
            //pa($curCorpuses);
            //pa($curCorpusesPeriod);
            $curTimes = []; foreach($curCorpusesPeriod as $period){$curTimes[] = $period->format('H:i');} //$curTimes[] =  $curCorpuses['workto'].':00';
        }else{
            $curTimes = ['01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00', '24:00'];            
        }
///* / БЕРЁМ КЛАССЫ ДЛЯ КОРПУСА ИЗ БАЗЗЫ ///* /               
        if($Classes = (!empty($curCorpuses['muzid']) && !empty($Classes = Classes::where('corpusesid', $curCorpuses['muzid'])->get()->toArray())) ?  $Classes : null){
        $curClass = (!empty($request->classId)) ? $Classes[(0 < $key = array_search($request->classId, array_column($Classes, 'id'))) ? $key : 0] : $Classes[0];
        //usort($clases, function($a, $b){return $a['order'] <=> $b['order'];});//pa($Corpuses); exit; pa($curCorpuses);
///* / ПЕРЕБИРАЕМ МАССИВ КЛАСОВ ИЗ БАЗЫ ///* /
            foreach($Classes as $Class){
 //* / ФОРМИРУЕМ МАССИВ ЗАКАЗОВ В КЛАССЕ ///* /
                $orders[$Class['muzid']] = (is_array($Orders = Orders::where('classesid', $Class['id'])->whereDate('datefrom', $curDate['datestamp'])->get()->toArray()) && !empty($Orders)) ? $Orders : null;
                //pa($clase); exit; $dayAfter = (new DateTime('2014-07-10'))->modify('+1 day')->format('Y-m-d'); //pa($orders);exit; //pa($curDate['datestamp']); pa($Class); exit;
//
/* / ВЫБИРАЕМ ТОВАР ИЗ БИТРИКСА ЕСЛИ ЕСТЬ ///* /         
            try{$bxProductId = $bx->bx24->getProduct($Class['product'])['ID'];}catch(\Exception $e){
                $bxProductId = (str_replace(['"', '}','{', '.', ','], '', explode(':', $e->getMessage())[6]));
            }
///*/// ВЫБИРАЕМ МАССИВ ЦЕННИКОВ ИЗ РЕСУРСОВ ///* /
                $prices = include(resource_path('arrays/prices.php'));
                $curPrice = $prices[(0 < $key = array_search($Class['muzid'], array_column($prices, 'muzid'))) ? $key : 0]['price'];            
//
/* / ЕСЛИ НЕТ ТОВАРА В БИТРИКСЕ, СОЗДАЁМ ТОВАР С ЦЕНОЙ КЛАССА ///* / 
            if('Product is not found' == $bxProductId || 'ID is not defined or invalid' == $bxProductId){
                $bxProductId = $bx->bx24->addProduct([
                    'NAME' => $Class['name'], 
                    'CURRENCY_ID' => 'RUB', 
                    'PRICE' => $curPrice,
                ]);
            }
 */           
        } 
///*/// СОЗДАЁМ МАССИВ ЗАГЛУШКУ С КЛАССАМИ И ВРЕМЕНЕМ РАБОТЫ ДЛЯ ЗАКАЗОВ ///* /        
            $curOrders = array_fill_keys($curTimes, $rooms = array_fill_keys(array_keys($orders), ''));
        //pa($curOrders); exit;

///* / ПЕРЕБИРАЕМ МАССИВ ЗАКАЗОВ И РАСКЛАДЫВАЕМ В МАССИВ СО ВРЕМЕНЕМ ///* /        
            foreach($orders as $classId => $ordersList){
///* / ВЫБИРАЕМ ID КЛАССА ИЗ НАШЕЙ БД ///* /
                if(!empty($ordersList)){ //$cl = Classes::where('muzid', '=', $id); pa($cl, 5); exit;//pa($classId); exit; //pa($ordersList); exit;
///* / ВЫБИРАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ ИЗ КЛАССА СДЕЛАВШИХ ЗАКАЗ В ТЕКУЩЕЙ ДАТЕ ///* /                
                    $users = Users::whereIn('id', array_values(array_unique(array_column($ordersList, 'usersid'), SORT_NUMERIC)))->get()->toArray();
 ///* / ПЕРЕБИРАЕМ ЗАКАЗЫ ИЗ БАЗЫ ///* /
                    for($i=0,$c=count($ordersList); $i<$c; $i++){
///* / ЦЕПЛЯЕМ К ЗАКАЗУ ПОЛЬЗОВАТЕЛЯ ///* /
                        $ordersList[$i]['users'] = (0 === $keyUser = array_search($ordersList[$i]['usersid'], array_column($users, 'id'))) ? $users[0] : 
                                                   ((is_numeric($keyUser) && $keyUser > 0) ? $users[$keyUser] : []);
                        //pa($ordersList[$i]);exit;
///* / ЕСЛИ В ЗАКАЗЕ ЕСТЬ ИМЯ И ТЕЛЕФОН ///* /
                        if(!empty($phone = $ordersList[$i]['users']['phone']) && !empty($fio = $ordersList[$i]['users']['fio'])){
//
/* / ПРОВЕРЯЕМ ЕСТЬ ЛИ ПОЛЬЗОВАТЕЛЬ В БИТРИКС ПО ТЕЛЕФОНУ, ЕСЛИ НЕТ ///* /
                            if(empty($bxContactIdCheck = $bx->bx24->getContactsByPhone($phone))){
                                list($lastname, $firstname) = explode(' ', trim($fio));
///* / СОЗДАЁМ ПОЛЬЗОВАТЕЛЯ В БИТРИКС ///* /                            
                                $bxContactId = $bx->bx24->addContact([
                                    'NAME'      => $firstname,
                                    'LAST_NAME' => $lastname,
                                    'PHONE'     => array((object)['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']),
                                    'EMAIL'     => array((object)['VALUE' => $email]),
                                    //'COMPANY_ID'  => 332,
                                    //'SECOND_NAME' => 'Васильевич',
                                ]);
///* / ЕСЛИ ПОЛЬЗОВАТЕЛЬ БИТРИКС СУЩЕСТВУЕТ БЕРЁМ ЕГО ID ///* /                            
                            }else{$bxContactId = $bxContactIdCheck[0]['ID'];}
 */
                        }else{
///* / ЕСЛИ В ЗАКАЗЕ НЕТ ИМЯ И ТЕЛЕФОН ///* /
                            $importContact = $bx->bx24->getContact(SyncController::DEFAULT_CONTACT);
                            $phone = (empty($importContact['PHONE'][0]['VALUE'])) ? null : $importContact['PHONE'][0]['VALUE'];
                            $email = (empty($importContact['EMAIL'][0]['VALUE'])) ? null : $importContact['EMAIL'][0]['VALUE'];
                            $fio = $importContact['NAME'];
                            $bxContactId = $importContact['ID'];                        

                            $ordersList[$i]['users'][id] = 0;
                            $ordersList[$i]['users'][bitrixid] = $bxContactId;
                            $ordersList[$i]['users'][fio] = $fio;
                            $ordersList[$i]['users'][phone] = $phone;
                            $ordersList[$i]['users'][email] = $email;
                        }                    
//
/* / ВЫБИРАЕМ СДЕЛКУ ИЗ БИТРИКСА ЕСЛИ ЕСТЬ ///* /
                    try{$dealId = $bx->bx24->getDeal($ordersList[$i]['deal'], [\App\Bitrix24\Bitrix24API::$WITH_PRODUCTS, \App\Bitrix24\Bitrix24API::$WITH_CONTACTS]);}catch(\Exception $e){
                        $dealId = str_replace(['"', '}','{', '.', ','], '', (explode('.', explode(':', $e->getMessage())[11])[0]));
                    }
///*/// ФОРМИРУЕМ ВРЕМЕННОЙ ПЕРИОД ЗАКАЗА И КОЛИЧЕСТВО ТОВАРОВ ДЛЯ БИТРИКС СДЕЛКИ ///*/                       
                            $periodsOrder = new \DatePeriod(new \DateTime(date('H:i', strtotime($ordersList[$i]['datefrom']))), new \DateInterval('PT1H'), new \DateTime(date('H:i', strtotime($ordersList[$i]['dateto'])))); 
                            $quantity = 0;
                            foreach($periodsOrder as $periodOrder){$quantity++;
                                $curOrders[$periodOrder->format('H:00')][$classId] = $ordersList[$i];
                            }
//
/* / ЕСЛИ НЕТ СДЕЛКИ В БИТРИКСЕ, СОЗДАЁМ СДЕЛКУ ///* /
                        if('ID is not defined or invalid' == $dealId){
                            $title = ((!empty($Classes[$classId]['name'])) ? '('.$Classes[$classId]['name'].') ' : '').
                                     ((!empty($ordersList[$i]['users'][fio])) ? $ordersList[$i]['users'][fio].' ' : '').
                                     ((!empty($ordersList[$i]['comment'])) ? $ordersList[$i]['comment'] : '');
                            $title = (!empty($title)) ? $title : 'Безымянная - '.time();
                            
                            $bx->bx24->setDealProductRows($dealId = $bx->bx24->addDeal([
                                'TITLE' => $title, 
                                'CONTACT_ID' => $bxContactId, 
                                SyncController::MUZ_ID_BX => $ordersList[$i]['muzid'], 
                                SyncController::DATE_FROM_BX => $ordersList[$i]['datefrom'], 
                                SyncController::DATE_TO_BX => $ordersList[$i]['dateto'], 
                            ]), [[ 'PRODUCT_ID' => $Classes[$classId]['product'], 'PRICE' => $Classes[$classId]['price'], 'QUANTITY' => $quantity ]]);
                        }
 */
    }}}}
///* / БЕРЁМ КЛАСС ИЗ ПАРАМЕТРОВ ///* /
//$curClass = (!empty($request->classId)) ($request->classId ?? $Classes[0]['muzid']);

//pa($curClass); exit;
///* / БЕРЁМ УВЕДОМЛЕНИЯ ИЗ ПАРАМЕТРОВ ///* /
$addOrderNotification = (empty($request->addOrderNotification)) ? [] : [$request->addOrderNotification];

///* / ОБРАБАТЫВАЕМ ДОБАВЛЕНИЕ СДЕЛКИ ///* /    
    if('order' == $request->add){//pa($request->toArray()); exit;
///* / ОБРАБАТЫВАЕМ ДОМЕН, ЧТОБЫ ОГРАНИЧИТЬ ВИДИМОСТЬ ВНЕ БИТРИКС ПРИЛОЖЕНИЯ ///* /
        //$request->merge(['DOMAIN' => self::DOMAIN]);
///* / ПРИВОДИМ ДАТУ СО СТРАНИЦЫ К РАБОЧЕМУ ФОРМАТУ ///* /
        $arDate = explode(' ', trim($request->date));
        $day        = (!empty($arDate[0])) ? $arDate[0] : '';
        $month      = (0 <= ($keyMonth = array_search($arDate[1], $month))) ? $keyMonth+1 : '';
        $year       = (!empty($arDate[2])) ? $arDate[2] : '';
        $date       = $year.'-'.$month.'-'.$day;
///* / ОБРАБАТЫВАЕМ ПРИШЕДШИЕ С БРАУЗЕРА ПАРАМЕТРЫ, ФОРМИРУЕМ УВЕДОМЛЕНИЯ ///* /        
        $addOrderClass = Classes::where(['muzid' => $request->classid])->first()->toArray();
        //$addOrderClass = $Classes[$addOrderClassKey = (0 <= $keyClass = array_search($request->classid, array_column($Classes, 'muzid'))) ? $keyClass : ''];
        //pa($addOrderClassKey); pa($request->classid);  pa($Classes); pa($addOrderClass); exit;
        
        if(empty($addOrderClass['muzid'])){                             $addOrderNotification []='Нет доступа к классу';}
        if(empty($request->date)){                                      $addOrderNotification []= 'Не выбрана дата';}
        if(empty($timesJson = json_decode($request->times, true))){     $addOrderNotification []='Не выбрано время';}
        if(empty($request->name)){                                      $addOrderNotification []='Не введено поле имя';}
        if(empty($request->sename)){                                    $addOrderNotification []='Не введено поле фамилия';}
        if(empty($request->phone)){                                     $addOrderNotification []='Не введено поле телефон';}
        //if(empty($request->email)){                 $addOrderNotification []='Не введено поле email';}
        
        if(!$ph = $this->is_phone(($request->phone ?? ''))){$addOrderNotification []='Не валидный номер телефона';}
        //if(!$em = $this->is_email(($request->email ?? ''))){$addOrderNotification []='Не валидный email';}
        
        $phone = ($ph ?? $request->phone);
        $email = ($em ?? $request->email);
        $fio = trim($request->name.' '.$request->sename);
        //pa($request->toArray()); exit;
        //pa($addOrderClass); exit;
        //pa(self::MUZ_ID_BX.' '.self::DATE_FROM_BX.' '.self::DATE_TO_BX); exit;
        
        if(empty($addOrderNotification)){
///* / ФОРМИРУЕМ МАССИВ СО ВРЕМЕНЕМ ЗАКАЗОВ И СОРТИРУЕМ ПО ЧАСАМ ///* /        
            foreach($timesJson as $arDatetime){if($d = is_date($date.' '.$arDatetime)){$datetimes[$d->format('H')] = $d;}}
            ksort($datetimes); //$datetimes = array_values($datetimes);
///* / ВЫСЧИТЫВАЕМ ПОСЛЕДОВАТЕЛЬНЫЕ ЧАСЫ, ДЕЛИМ НА ЗАКАЗЫ ДЛЯ МУЗБУКИНГА ///* /        
            $datetimesKeys = array_keys($datetimes); $datetimesKeysMin = min($datetimesKeys); $datetimesKeysMax = max($datetimesKeys);
            $orderTimes = array_fill($datetimesKeysMin, $datetimesKeysMax-$datetimesKeysMin+1,''); 
            array_walk($datetimes, function ($v, $k) use(&$orderTimes){$orderTimes[intval($k)] = $v;});
            //pa($orderTimes);
///* / РАЗЛОЖИЛИ ЧАСОВОЙ МАССИВ НА МАССИВ ЗАКАЗОВ С ЦЕПОЧКАМИ ЧАСОВ ///* /
            $l = 0; foreach($orderTimes as $datetime){
                if(empty($datetime)){$l++; continue;}
                $browserOrders[$l][] = $datetime;
            }$browserOrders = array_values($browserOrders); 
            //pa($browserOrders);exit;
                         
///*/ ПРОВЕРЯЕМ ЕСТЬ ЛИ ПОЛЬЗОВАТЕЛЬ В БИТРИКС ПО ТЕЛЕФОНУ, ЕСЛИ НЕТ ///*/
            //try{$bxContactIdCheck = $bx->bx24->getContactsByPhone($phone);} catch(\Exception $ex){
            //    sleep('2');
            //    $bxContactIdCheck = $bx->bx24->getContactsByPhone($phone);
            //}
            //$bxContactIdCheck = $bx->getContactsByPhone($phone);
            //pa($bxContactIdCheck);exit; pa($phone);exit;
            if(empty($bxContactIdCheck = $bx->getContactsByPhone($phone))){
                //list($lastname, $firstname) = explode(' ', $fio);
///*/ СОЗДАЁМ ПОЛЬЗОВАТЕЛЯ В БИТРИКС ///*/                            
                $bxContactId = $bx->bx24->addContact([
                    'NAME'      => $request->name,
                    'LAST_NAME' => $request->sename,
                    'PHONE'     => array((object)['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']),
                    'EMAIL'     => array((object)['VALUE' => $email, 'VALUE_TYPE' => 'WORK']),
                ]);
///*/ ЕСЛИ ПОЛЬЗОВАТЕЛЬ БИТРИКС СУЩЕСТВУЕТ БЕРЁМ ЕГО ID ///*/                            
            }else{$bxContactId = $bxContactIdCheck[0]['ID'];}
///*/ ВЫБИРАЕМ ИЛИ СОЗДАЁМ ЕСЛИ НЕТ ПОЛЬЗОВАТЕЛЯ С ТАКИМ ТЕЛЕФОНО И ИМЕНЕМ В НАШЕЙ БАЗЕ ///*/
            $newUser = Users::firstOrCreate(['phone' => $phone, 'fio' => $fio]);
            $newUser->phone = $phone;
            $newUser->fio = $fio;
            $newUser->email = $email;
            //$newUser->muzid = $bxContactId;
            $newUser->bitrixid = $bxContactId;
            $newUser->save();
///*/ СОЗДАЁМ ЗАКАЗЫ ///*/
            $userId = $newUser->id;
            //pa($browserOrders);
            //pa($browserOrders[0][0]->format('c'));
            foreach($browserOrders as $k => $browserOrder){
                $hoursCount = intval(empty($m = max(array_keys($browserOrder))) ? count($browserOrder) : $m+1); //pa($hoursCount);
                $hoursStart = $browserOrder[0]->setTimezone(new \DateTimeZone('UTC'))->modify("+3 hours")->format('c');
                $retMuz[] = $newMuzOrder = $mb->syncAdd($addOrderClass['muzid'], $hoursStart, $request->name, $request->sename, $request->phone, $request->email, $hoursCount);
                
                //pa($retMuz);
                if(1 == $newMuzOrder['status'] && !empty($newMuzOrder['id']) && !empty($newMuzOrder['dateFrom']) && !empty($newMuzOrder['dateTo']) && 
                   !empty($addOrderClass['muzid']) && !empty($userId)){
                    $newMuzOrderDateFrom = new \DateTime($newMuzOrder['dateFrom']); $newMuzOrderDateFrom->setTimezone(new \DateTimeZone('Europe/Moscow'))->modify("-3 hours"); //Europe/Moscow
                    $newMuzOrderDateTo   = new \DateTime($newMuzOrder['dateTo']);   $newMuzOrderDateTo->setTimezone(new \DateTimeZone('Europe/Moscow'))->modify("-3 hours");   //Europe/Moscow
                    
                    //$newMuzOrderDateFrom = new \DateTime($newMuzOrder['dateFrom']); $newMuzOrderDateFrom->setTimezone(new \DateTimeZone('UTC'))->modify("+3 hours"); //UTC
                    //$newMuzOrderDateTo   = new \DateTime($newMuzOrder['dateTo']);   $newMuzOrderDateTo->setTimezone(new \DateTimeZone('UTC'))->modify("+3 hours");   //UTC
                    //pa($newMuzOrderDateFrom->format('Y-m-d H:i:s'));
                    //pa($newMuzOrderDateTo->format('Y-m-d H:i:s'));exit;
                    
                    $newOrder = Orders::firstOrCreate(['muzid' => $newMuzOrder['id']]);
                    $newOrder->muzid = $newMuzOrder['id']; 
                    $newOrder->classesid = $addOrderClass['id'] ?? '';
                    $newOrder->usersid = $userId;	
                    $newOrder->isour = ($request->isour ?? 1);
                    $newOrder->datefrom = $newMuzOrderDateFrom->format('Y-m-d H:i:s');
                    $newOrder->dateto = $newMuzOrderDateTo->format('Y-m-d H:i:s');
                    //$newOrder->amountpeople =  null;
                    $newOrder->comment = $request->comment ?? null;                    
                    $newOrder->save();
                    //pa($newOrder);
///*/ ВЫБИРАЕМ СДЕЛКУ ИЗ БИТРИКСА ЕСЛИ ЕСТЬ ///*/
                    try{$deal = $bx->bx24->getDeal($newOrder->deal, [\App\Bitrix24\Bitrix24API::$WITH_PRODUCTS, \App\Bitrix24\Bitrix24API::$WITH_CONTACTS]);
                        $dealId = (empty($deal['ID'])) ? 'ID is not defined or invalid' : $deal['ID'];
                    }catch(\Exception $e){
                        $dealId = (!empty($EM = $e->getMessage()) && preg_match('#error_description(?: )?\"(?: )?\:(?: )?\"(.+?)\"#m', $EM, $E)) ? 
                                  (!empty($E[1]) ? $E[1] : 'ID is not defined or invalid.' ) : 'ID is not defined or invalid.';
                    }//pa($dealId);exit;
///*/ ФОРМИРУЕМ КОЛИЧЕСТВО ТОВАРОВ ДЛЯ БИТРИКС СДЕЛКИ ///*/                       
                    $quantity = $hoursCount;
///*/ ЕСЛИ НЕТ СДЕЛКИ В БИТРИКСЕ, СОЗДАЁМ СДЕЛКУ ///*/
                    if('ID is not defined or invalid.' == $dealId){
                        $title = ((!empty($addOrderClass['name'])) ? '('.$addOrderClass['name'].') ' : '').
                                 ((!empty($newUser->fio)) ? $newUser->fio.' ' : '').
                                 ((!empty($newOrder->comment)) ? $newOrder->comment : '');
                        $title = (!empty($title)) ? $title : 'Безымянная - '.time();

                        $bx->bx24->setDealProductRows($dealId = $bx->bx24->addDeal([
                            'TITLE' => $title, 
                            'CONTACT_ID' => $bxContactId, 
                            self::MUZ_ID_BX => $newOrder->muzid, 
                            self::DATE_FROM_BX => $newOrder->datefrom, 
                            self::DATE_TO_BX => $newOrder->dateto, 
                        ]), [[ 'PRODUCT_ID' => $addOrderClass['product'], 'PRICE' => $addOrderClass['price'], 'QUANTITY' => $quantity ]]);
                    }
                    $newOrder->deal = $dealId;
                    $newOrder->save();
                    $retOur[] = $newOrder->toArray();
                    //pa($dealId); pa($clasesDb[$classId]['product']);exit;
                }

        $addOrderNotification[] = (!empty($newMuzOrder['error'])) ? 
                ($addOrderClass['name'].' : '.(new \DateTime($newMuzOrder['dateFrom']))->format('Y-m-d H:i').' - '.$newMuzOrder['error'].PHP_EOL) : 
                ((!empty($retOur)) ? $addOrderClass['name'].' : '.(new \DateTime($newMuzOrder['dateFrom']))->format('Y-m-d H:i').' - '.(new \DateTime($newMuzOrder['dateTo']))->format('H:i').' '.'Оформлено бронирование на '.$newUser->fio.PHP_EOL : '');
                
            
            }
            $newUser->muzid = $newMuzOrder['clientId'] ?? null;
            $newUser->save();
            //pa($retMuz);
            //pa($retOur); 
            //exit;
        }
        //
        //
        /*
        if(!empty($dateIn = ($request->date ?? ''))){
            $arrDateIn = explode(' ', $dateIn);
            $keyMonth = array_flip($month);
            pa($dayIn = ($arrDateIn[0] ?? ''));
            pa($monthIn = ($keyMonth[trim($arrDateIn[1] ?? '')]) ?? '');
            pa($yearIn = ($arrDateIn[2] ?? ''));
            
        }
        */

        $url = route('front.home', [
            'baseId' => $addOrderClass['corpusesid'], 
            'classId' => ($addOrderClass['id'] ?? ''), 
            'dateIn' => ($date ?? ''), 
            'addOrderNotification' => implode('PHP_EOL',str_replace(["\r", "\n"], '', $addOrderNotification)), 
            'time' => time(),
            'DOMAIN' => $domain]);
        //pa($request->toArray());exit;
        /*
        pa($addOrderNotification);
        pa($request->toArray());
        pa($url); 
        $request->toArray()); exit;
        echo date('h:i:s') . "</br>";
        sleep(10);
        echo date('h:i:s') . "</br>";
        
        pa(($retMuz ?? []));
        exit;
        */
        header('Location: '.$url); exit;
        }
///*/-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------///*/

///*/ Вывод ///*/
        $data = get_defined_vars(); unset($data['request'], $data['bx'], $data['mb']); $data = array_keys($data);
        return compact($data);
        //return ($domain == self::DOMAIN) ? view('front.home', compact($data)) : abort(404);
    }else{abort(500);}
    
}
    
public function stoimost(Request $request){
    $validator = Validator::make($request->all(), ['classid' => 'required|min:36', 'times' => 'required']);
    $ret = ($validator->passes() && is_numeric($countTimes = count(explode(',', $request->times))) &&
            ($priceDB = (!empty($request->classid) && !empty($priceDB = Classes::where('muzid', $request->classid)->first('price')->toArray())) ?  $priceDB : null)) ?
        ['result' => $priceDB['price']*$countTimes ?? null] : ['result' => null];
return response()->json($ret);}

public function reset(Request $request){
    if(empty($request->muzid)){return null;}
    $mb = new MuzController;
    $bx = new BtxController;
    
    $muz = (array) $mb->syncUpdate($request->muzid);
    $our = Orders::where('muzid', $request->muzid)->first();
    if(empty($muz['errors']) && !empty($our->id)){
        $our->deal = ($our->deal ?? null);
        $muzState = $our->muzid;
        try{
            $bxSate = (!empty($our->deal)) ? $bx->bx24->deleteDeal($our->deal) : null;
            $bxSate = ($bxSate) ? $our->deal : null;
        } catch(\Exception $e){
            $bxSate = null;
        }
        $ourState = $our->id;
        $ourState = ($our->delete()) ? $ourState : null;
    }else{$muzState = null;}
return response()->json(['muz' => (string)($muzState ?? null), 'bx' => (string)($bxSate ?? null) , 'our' => (string)($ourState ?? null)]);}


}