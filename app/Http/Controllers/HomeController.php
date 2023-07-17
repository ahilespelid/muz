<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\BtxController;
use \Crest;

class HomeController extends Controller{    
public function index(Request $request){
    if('stoimost' == $request->api){$api->stoimost($request);exit;}

    $api = new ApiController; //$api->setLogin(); 
    $bx = new BtxController; 
        
    //pa($bx->getDielAll());
    
    
    //
    pa($api->listBases());
    //pa($api->listSpheres());
    
    $api->setLogin('new_domain', 'Xepg6p', 'https://dev.musbooking.com');
    //
    pa($api->listBases());
    //pa($api->listSpheres());
    //pa($_REQUEST);
    //pa($this->musGetToken('musicclasses24', 'Lg5BJ8'));
    
    $_REQUEST['deal_id'] = empty($_REQUEST['deal_id']) ? '' : $_REQUEST['deal_id'];
    $_REQUEST['tab'] = empty($_REQUEST['tab']) ? 'Not found' : $_REQUEST['tab'];
    $_REQUEST['PLACEMENT_OPTIONS'] = empty($_REQUEST['PLACEMENT_OPTIONS']) ? '' : $_REQUEST['PLACEMENT_OPTIONS'];
    
    $_REQUEST['deal_id'] = $deal_id = empty($deal = json_decode($_REQUEST['PLACEMENT_OPTIONS'], true)) ? 
        (empty($deal_id = $_REQUEST['deal_id']) ? null : $deal_id) : (empty($deal['ID']) ? null : $deal['ID']);
    $deal = (!empty($deal_id) && $deal = CRest::call('crm.deal.get', ['ID' => $deal_id])) ? 
        (isset($deal['result']) ? $deal['result'] : ['ID' => $deal['error_description']]) : $deal;
    $deal['ID'] = (empty($deal['ID'])) ? 'Not found' : $deal['ID'];        
    $deal['CATEGORY_ID'] = (empty($deal['CATEGORY_ID'])) ? null : $deal['CATEGORY_ID'];        
    $deal_into_id = (empty($deal['UF_CRM_1683462809'])) ? null : $deal['UF_CRM_1683462809'];
    
    
    
///*/
 
///*/ Вывод ///*/ pa($data[$view]);
    return view('front.undefine', [
         ///*/
        'deal' => $deal,
        'deal_into_id' => $deal_into_id,
         ///*/
    ]);
}

}