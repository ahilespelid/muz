<?php namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
set_time_limit(0);
setlocale(LC_ALL, 'ru_RU.utf8');
date_default_timezone_set( 'Europe/Moscow' );

use Illuminate\Http\Request;

use App\Http\Controllers\MuzController;
use App\Http\Controllers\BtxController;

use App\Models\Classes;
use App\Models\Corpuses;
use App\Models\Orders;
use App\Models\Users;

class SyncController extends Controller{
const PHONE_CODE = '+7', 
      DEFAULT_CONTACT = 199,
      AMOUT_PEOPLE_ID = 'fe7f09ae-14ac-4071-9d99-e278cef61ea5',
      MUZ_ID_BX = 'UF_CRM_1697011461644',    
      DATE_FROM_BX = 'UF_CRM_1697156890471',    
      DATE_TO_BX = 'UF_CRM_1697156942243';    
public function index(Request $request){
    $mb = new MuzController; //$api->setLogin(); 
    $bx = new BtxController;
        
    if($corpuses = (is_array($bases = $mb->listBases())) ? $bases : null){ //pa($corpuses);exit;
///*/ ПИШЕМ КОРПУСА ИЗ МУЗБУКИНГА В НАШУ БАЗУ ЕСЛИ ТАКИХ ID НЕТ ///*/
        foreach($corpuses as $corpus){
            $newBase = Corpuses::firstOrCreate(['muzid' => $corpus['id']]);
            $newBase->muzid     = $corpus['id'];
            $newBase->name      = $corpus['value'];
            $newBase->type      = $corpus['sphere'];
            $newBase->workfrom  = (isset($corpus['workHours'][0]['from']))      ? $corpus['workHours'][0]['from']       : null;
            $newBase->workto    = (isset($corpus['workHours'][0]['to']))        ? $corpus['workHours'][0]['to']         : null;
            $newBase->weekfrom  = (isset($corpus['weekendHours'][0]['from']))   ? $corpus['weekendHours'][0]['from']    : null;
            $newBase->weekto    = (isset($corpus['weekendHours'][0]['to']))     ? $corpus['weekendHours'][0]['to']      : null;

            $newBase->save();
        }

///*/-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------///*/
///*/ БЕРЁМ ТЕКУЩИЙ КОРПУС ИЗ URL АДРЕССА, ЛИБО ИЗ ПЕРВЫЙ ИЗ МАССИВА ЕСЛИ В УРЛ НЕТ ///*/        
        $curBaseKey = (!empty($request->baseId) && !empty($bases)) ? array_search($request->baseId, array_column($bases, 'id')) : null;
        $curBase = (empty($curBaseKey)) ? ((!empty($bases[0]['value']) && !empty($bases[0]['sphere'])) ? $bases[0] : null) : $bases[$curBaseKey]; 
        $curBase['workHours'][0]['from'] = (0 === $curBase['workHours'][0]['from']) ? 1 : $curBase['workHours'][0]['from'];
        $curBase['weekendHours'][0]['from'] = (0 === $curBase['weekendHours'][0]['from']) ? 1 : $curBase['weekendHours'][0]['from'];
        //pa($curBase); exit;
///*/ БЕРЁМ ВСЕ КЛАССЫ ИЗ МУЗБУКИНГА И ВЫБИРАЕМ ТОЛЬКО ДЛЯ ТЕКУЩЕГО КОРПУСА С СОРТИРОВКОЙ ПО ПОЛЮ order ///*/       
        $clases = (!empty($curBase['id'])) ? array_filter($mb->listClases(), function($el) use($curBase){return $el['baseId'] === $curBase['id'];}) : null;
        usort($clases, function($a, $b){return $a['order'] <=> $b['order'];});
///*/ ФОРМИРУЕМ МАССИВ СО ВРЕМЕНЕМ РАБОТЫ ///*/        
        if(!empty($curBase['workHours'][0]['from']) && !empty($curBase['workHours'][0]['to'])){
            $period = new \DatePeriod(new \DateTime(gmdate('H:i', $curBase['workHours'][0]['from']*3600)), new \DateInterval('PT1H'), new \DateTime(gmdate('H:i', $curBase['workHours'][0]['to']*3600-61)));
            $curTimes = []; foreach($period as $value){$curTimes[] = $value->format('H:i');} $curTimes[] =  $curBase['workHours'][0]['to'].':00';
        }else{$curTimes = ['01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00', '24:00'];}
        //pa($curBase);pa($curTimes);exit;
///*/-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------///*/

///*/ ЕСЛИ В КОРПУСЕ ЕСТЬ КЛАССЫ ///*/        
        if(is_array($clases) && !empty($clases)){
///*/ БЕРЁМ МАССИВ ЦЕН ДЛЯ КЛАССОВ ///*/          
            $prices = include(resource_path('arrays/prices.php'));
///*/ ФОРМИРУЕМ ТЕКУЩУЮ ВРЕМЕННУЮ МЕТКУ ДЛЯ ЗАПРОСА ЗАКАЗОВ ДЛЯ КЛАССА ///*/
            $curTimestamp = (empty($request->dateIn)) ? time() : strtotime($request->dateIn); 
            $curDate      = strtotime(date('Y', $curTimestamp).'-'.date('m', $curTimestamp).'-'.date('d', $curTimestamp));
 ///*/ ПЕРЕБИРАЕМ МАССИВ КЛАСОВ ИЗ МУЗБУКИНГА ///*/
            foreach($clases as $clase){
 ///*/ ФОРМИРУЕМ МАССИВ ЗАКАЗОВ В КЛАССЕ ///*/
                $orders[$clase['id']] = $mb->listOrders($clase['id'], date('Y-m-d', $curDate));

///*/ СОЗДАЁМ ИЛИ ВЫБИРАЕМ КЛАСС ИЗ НАШЕЙ БАЗЫ ПО ID МУЗБУКИНГА ///*/
                $newClass = Classes::firstOrCreate(['muzid' => $clase['id']]);
                $newClass->name = $clase['value'];
                $newClass->muzid = $clase['id'];
                $newClass->corpusesid = $clase['baseId'];
                $newClass->orders = $clase['order'];
///*/ ВЫБИРАЕМ МАССИВ ЦЕННИКОВ ИЗ РЕСУРСОВ ///*/
                $newClass->price = $prices[(0 < $keyPrice = array_search($newClass->muzid, array_column($prices, 'muzid'))) ? $keyPrice : 0]['price'];             
                $newClass->save();
                //pa($newClass->product); exit;
///*/ ВЫБИРАЕМ ТОВАР ИЗ БИТРИКСА ЕСЛИ ЕСТЬ ///*/         
                try{$bxProductId = $bx->bx24->getProduct($newClass->product)['ID'];}catch(\Exception $e){
                    $bxProductId = (str_replace(['"', '}','{', '.', ','], '', explode(':', $e->getMessage())[6]));
                }
///*/ ЕСЛИ НЕТ ТОВАРА В БИТРИКСЕ, СОЗДАЁМ ТОВАР С ЦЕНОЙ КЛАССА ///*/ 
                if('Product is not found' == $bxProductId || 'ID is not defined or invalid' == $bxProductId){
                    $bxProductId = $newClass->product = $bx->bx24->addProduct([
                        'NAME' => $newClass->name, 
                        'CURRENCY_ID' => 'RUB', 
                        'PRICE' => $newClass->price,
                    ]);
                }
                $newClass->save();           
            } 
        }
///*/-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------///*/
//pa($orders);        
///*/ ЕСЛИ В КЛАССАХ ЕСТЬ ЗАКАЗЫ ///*/        
        if(is_array($orders) && !empty($orders)){
///*/ фОРМИРУЕМ МАССИВ ТЕКУЩИХ ДЛЯ КЛАССОВ ЗАКАЗОВ ///*/
            $curOrders = array_fill_keys($curTimes, array_fill_keys(array_keys($orders), ''));
///*/ ВЫБИРАЕМ ВСЕ КЛАССЫ ИЗ НАШЕЙ БАЗЫ ///*/
            $clasesDb = Classes::all()->toArray(); //pa($clasesDb);exit;
///*/ ПРОХОДИМСЯ ЦИКЛОМ ПО ЗАКАЗАМ КЛАССОВ ИЗ ТЕКУЩЕГО КОРПУСА ///*/
            foreach($orders as $id => $ordersList){
///*/ ВЫБИРАЕМ ID КЛАССА ИЗ МУЗБУКИНГА И ИЩЕМ ТАКОЙ ID В НАШЕЙ БД, ЕСЛИ НЕ НАХОДИМ ПРОПУСКАЕМ ИТЕРАЦИЮ ЗАКАЗОВ ///*/
                if('' === $classMuzid = ((0 <= $keyClass = array_search($id, array_column($clases, 'id'))) ? $clases[$keyClass]['id'] : '')){continue;}           
                if('' === ((0 <= $classId = array_search($classMuzid, array_column($clasesDb, 'muzid'))) ? $classId : '')){continue;}
                //pa($id); pa($classMuzid); pa($classId); pa($clasesDb[$classId]); exit;
///*/ ПРОВЕРЯЕМ ЕСТЬ ЛИ ЗАКАЗЫ В ТЕКУЩЕМ КЛАССЕ ///*/
                if(!empty($ordersList)){
///*/ ПЕРЕБИРАЕМ ЗАКАЗЫ ИЗ МУЗБУКИНГА В ЦИКЛЕ ///*/
                    for($i=0,$c=count($ordersList); $i<$c; $i++){//pa($ordersList[$i]['dateFrom']);exit;
///*/ ЕСЛИ В ЗАКАЗЕ ЕСТЬ ИМЯ И ТЕЛЕФОН ///*/
                        if(!empty($phone = $ordersList[$i]['phone']) && !empty($fio = $ordersList[$i]['fio'])){
                            $phone = self::PHONE_CODE.' '.$phone;                           
///*/ ПРОВЕРЯЕМ ЕСТЬ ЛИ ПОЛЬЗОВАТЕЛЬ В БИТРИКС ПО ТЕЛЕФОНУ, ЕСЛИ НЕТ ///*/
                            if(empty($bxContactIdCheck = $bx->bx24->getContactsByPhone($phone))){
                                list($lastname, $firstname) = explode(' ', trim($fio));
///*/ СОЗДАЁМ ПОЛЬЗОВАТЕЛЯ В БИТРИКС ///*/                            
                                $bxContactId = $bx->bx24->addContact([
                                    'NAME'      => $firstname,
                                    'LAST_NAME' => $lastname,
                                    'PHONE'     => array((object)['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']),
                                    'EMAIL'     => array((object)['VALUE' => $email, 'VALUE_TYPE' => 'WORK']),
                                    
                                ]);
///*/ ЕСЛИ ПОЛЬЗОВАТЕЛЬ БИТРИКС СУЩЕСТВУЕТ БЕРЁМ ЕГО ID ///*/                            
                            }else{$bxContactId = $bxContactIdCheck[0]['ID'];}
///*/ ЕСЛИ В ЗАКАЗЕ НЕТ ИМЯ И ТЕЛЕФОН ВЫБИРАЕМ ИЗ БИТРИКС КОНТАКТ ПО УМОЛЧАНИЮ ///*/
                        }else{
                            $defaultContact = $bx->bx24->getContact(self::DEFAULT_CONTACT);
                            $phone = (empty($defaultContact['PHONE'][0]['VALUE'])) ? null : $defaultContact['PHONE'][0]['VALUE'];
                            $email = (empty($defaultContact['EMAIL'][0]['VALUE'])) ? null : $defaultContact['EMAIL'][0]['VALUE'];
                            $fio = $defaultContact['NAME'].' '.$defaultContact['LAST_NAME'];
                            $bxContactId = $defaultContact['ID'];
                        }//pa($defaultContact); exit;
///*/ ЕСЛИ В ЗАКАЗЕ НЕТ EMAIL И В БИТРИКС НЕТ ТО ПУСТОЕ ПОЛЕ ДЕЛАЕМ ДЛЯ EMAIL ///*/                            
                        $email = (empty($ordersList[$i]['email'])) ? ((empty($email)) ? null : $email) : $ordersList[$i]['email'];
///*/ ВЫБИРАЕМ ИЛИ СОЗДАЁМ ЕСЛИ НЕТ ПОЛЬЗОВАТЕЛЯ С ТАКИМ ТЕЛЕФОНО И ИМЕНЕМ В НАШЕЙ БАЗЕ ///*/
                        $newUser = Users::firstOrCreate(['phone' => $phone, 'fio' => $fio]);
                        $newUser->phone = $phone;
                        $newUser->fio = $fio;
                        $newUser->email = $email;
                        $newUser->bitrixid = $bxContactId;
                        $newUser->save();
///*/ СОЗДАЁМ ЗАКАЗ ЕСЛИ НЕТ ЗАКАЗА С ТАКИМ muzid В НАШЕЙ БАЗЕ ///*/
                        $userId = $newUser->id;

                        $newOrder = Orders::firstOrCreate(['muzid' => $ordersList[$i]['id']]);
                        $newOrder->muzid = $ordersList[$i]['id']; 
                        $newOrder->classesid = $clasesDb[$classId]['id'];
                        $newOrder->usersid = $userId;	
                        //$newOrder->deal = '';
                        $newOrder->datefrom = $ordersList[$i]['dateFrom'];
                        $newOrder->dateto = $ordersList[$i]['dateTo'];
                        $newOrder->amountpeople = (isset($ordersList[$i]['options'][0]['id']) && $ordersList[$i]['options'][0]['id'] == self::AMOUT_PEOPLE_ID && 
                                                   !empty($aname = $ordersList[$i]['options'][0]['name'])) ? $aname : null;
                        $newOrder->comment = $ordersList[$i]['comment'];                    
                        $newOrder->save();
///*/ ВЫБИРАЕМ СДЕЛКУ ИЗ БИТРИКСА ЕСЛИ ЕСТЬ ///*/
                        try{$deal = $bx->bx24->getDeal($newOrder->deal, [\App\Bitrix24\Bitrix24API::$WITH_PRODUCTS, \App\Bitrix24\Bitrix24API::$WITH_CONTACTS]);
                            $dealId = (empty($deal['ID'])) ? 'ID is not defined or invalid' : $deal['ID'];
                        }catch(\Exception $e){
                            $dealId = str_replace(['"', '}','{', '.', ','], '', (explode('.', explode(':', $e->getMessage())[11])[0]));
                        }//pa($dealId);exit;
///*/ ФОРМИРУЕМ ВРЕМЕННОЙ ПЕРИОД ЗАКАЗА И КОЛИЧЕСТВО ТОВАРОВ ДЛЯ БИТРИКС СДЕЛКИ ///*/                       
                        $periodsOrder = new \DatePeriod(new \DateTime(date('H:i', strtotime($newOrder->datefrom))), new \DateInterval('PT1H'), new \DateTime(date('H:i', strtotime($newOrder->dateto)))); 
                        $quantity = 0;
                        foreach($periodsOrder as $periodOrder){$quantity++;
                            $curOrders[$periodOrder->format('H:00')][$classId] = $ordersList[$i];
                        }
///*/ ЕСЛИ НЕТ СДЕЛКИ В БИТРИКСЕ, СОЗДАЁМ СДЕЛКУ ///*/
                        if('ID is not defined or invalid' == $dealId){
                            $title = ((!empty($clasesDb[$classId]['name'])) ? '('.$clasesDb[$classId]['name'].') ' : '').
                                     ((!empty($newUser->fio)) ? $newUser->fio.' ' : '').
                                     ((!empty($newOrder->comment)) ? $newOrder->comment : '');
                            $title = (!empty($title)) ? $title : 'Безымянная - '.time();
                            
                            $bx->bx24->setDealProductRows($dealId = $bx->bx24->addDeal([
                                'TITLE' => $title, 
                                'CONTACT_ID' => $bxContactId, 
                                self::MUZ_ID_BX => $newOrder->muzid, 
                                self::DATE_FROM_BX => $newOrder->datefrom, 
                                self::DATE_TO_BX => $newOrder->dateto, 
                            ]), [[ 'PRODUCT_ID' => $clasesDb[$classId]['product'], 'PRICE' => $clasesDb[$classId]['price'], 'QUANTITY' => $quantity ]]);
                        }
                        $newOrder->deal = $dealId;
                        $newOrder->save();
                        //pa($dealId); pa($clasesDb[$classId]['product']);exit;
        }}}}
///*/-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------///*/

///*/ Вывод ///*/
        $data = get_defined_vars(); unset($data['request'], $data['mb'], $data['bx']); $data = array_keys($data);
        //$return = ['result' => compact($data)];
        $return = ['result' => 'Ok', 'status' => 200];
    }else{
        $return = ['result' => 'Don`t connection muzbooking', 'status' => 200];}
    
return response()->json($return);

}}