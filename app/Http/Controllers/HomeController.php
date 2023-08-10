<?php namespace App\Http\Controllers;

setlocale(LC_ALL, 'ru_RU.utf8');
date_default_timezone_set( 'Europe/Moscow' );

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MuzController;
use App\Http\Controllers\BtxController;
use \Crest;

class HomeController extends Controller{    
public function index(Request $request){
    $mb = new MuzController; //$api->setLogin(); 
    $bx = new BtxController; 

    if('stoimost' == $request->api){$mb->stoimost($request);exit;}
        
    //pa($bx->getDielAll());
     
     //pa($mb->listOrders());
     //pa($mb->listRooms());
     //pa($api->listBases());
     //pa($api->listSpheres());
    
    if($bases = (is_array($bases = $mb->listBases())) ? $bases : null){
        $curBaseKey = (!empty($request->baseId) && !empty($bases)) ? array_search($request->baseId, array_column($bases, 'id')) : null;
        $curBase = (empty($curBaseKey)) ? ((!empty($bases[0]['value']) && !empty($bases[0]['sphere'])) ? $bases[0] : null) : $bases[$curBaseKey]; 
        $curBase['workHours'][0]['from'] = (0 === $curBase['workHours'][0]['from']) ? 1 : $curBase['workHours'][0]['from'];
        
        $clases = (!empty($curBase['id'])) ? array_filter($mb->listClases(), function($el) use($curBase){return $el['baseId'] === $curBase['id'];}) : null;
        usort($clases, function($a, $b){return $a['order'] <=> $b['order'];});
        
        if(!empty($curBase['workHours'][0]['from']) && !empty($curBase['workHours'][0]['to'])){
            $period = new \DatePeriod(new \DateTime(gmdate('H:i', $curBase['workHours'][0]['from']*3600)), new \DateInterval('PT1H'), new \DateTime(gmdate('H:i', $curBase['workHours'][0]['to']*3600-61)));
            $curTimes = []; foreach($period as $value){$curTimes[] = $value->format('H:i');} $curTimes[] =  $curBase['workHours'][0]['to'].':00';
        }else{
            $curTimes = ['01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00', '24:00'];            
        }
        
        foreach($clases as $clase){//pa($mb->listOrders($clase['id']));
        }
    }
    
    $dealId = empty($request->dealId) ? (
            (!empty($request->PLACEMENT_OPTIONS) && !empty($dealJson = json_decode($request->PLACEMENT_OPTIONS, true))) ? 
                (empty($dealJson['ID']) ? null : $dealJson['ID']) : null
        ) : $request->dealId;
        
    

    
    //
    /*/
    $deal = (!empty($deal_id) && $deal = CRest::call('crm.deal.get', ['ID' => $deal_id])) ? 
        (isset($deal['result']) ? $deal['result'] : ['ID' => $deal['error_description']]) : $deal;
    $deal_into_id = (empty($deal['UF_CRM_1683462809'])) ? null : $deal['UF_CRM_1683462809'];
///*/
 
///*/ Вывод ///*/ pa($data[$view]);
    $week = ['пн','вт','ср','чт','пт','сб','вс'];
    $curBaseImg = ['https://partner.musbooking.com/res/bases/220315-1650-2.jpeg','https://partner.musbooking.com/res/bases/220314-2123-5.jpeg',];
    $data = get_defined_vars(); unset($data['request'], $data['mb'], $data['bx']); $data = array_keys($data);
return view('front.home', compact($data));}             

}