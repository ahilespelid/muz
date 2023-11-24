<?php namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
set_time_limit(0);
setlocale(LC_ALL, 'ru_RU.utf8');
date_default_timezone_set( 'Europe/Moscow' );

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use App\Models\Classes;
use App\Models\Corpuses;
/*
use App\Http\Controllers\MuzController;
use App\Http\Controllers\BtxController;
;
use App\Models\Orders;
use App\Models\Users;
*/

class AdminController extends Controller{    
public function index(Request $request){
///* / БЕРЁМ ИЗ БАЗЫ КОРПУСА И КЛАССЫ ///* / 
    if(!empty($Corpuses = (!empty($Corpuses = Corpuses::all()->toArray())) ? $Corpuses : null) && 
       !empty($Classes = (!empty($Classes = Classes::all()->toArray())) ? $Classes : null)){
        $muzidCorpuses = array_column($Corpuses, 'muzid');
///* / ФОРМИРУЕМ МАССИВ ПРИНАДЛЕЖНОСТИ КЛАССОВ К КОРПУСАМ ///* /       
        foreach(($CorpusesClasses = array_fill_keys(array_keys(array_flip($muzidCorpuses)), '')) as $corpusid => $v){
            $CorpusesClasses[$corpusid] = array_values(array_filter($Classes, function($e) use($corpusid){return isset($e['corpusesid']) && $e['corpusesid'] == $corpusid;}));
        }
    
///* / БЕРЁМ ТЕКУЩИЙ КОРПУС ИЗ МАССИВА КОРПУСОВ УЧИТЫВАЯ ПАРАМЕТР ЗАПРОСА КОРПУСА ///* /       
        $curCorpuses = $Corpuses[(!empty($request->baseId)) ? array_search($request->baseId, $muzidCorpuses) : 0];
///* / БЕРЁМ КЛАССЫ ДЛЯ КОРПУСА ИЗ БАЗЗЫ ///* /               
        $curClasses = (!empty($curClasses = $CorpusesClasses[$curCorpuses['muzid']])) ?  $curClasses : null;
///* / БЕРЁМ КЛАССЫ ДЛЯ КОРПУСА ИЗ БАЗЗЫ ///* /

        //pa($request->toArray());
        if(!empty($request->toArray()['up'])){
            if(!empty($request->img)){$img = (!empty($p = $request->img->path())) ? 'data:'.$request->img->getClientMimeType().';base64, '.base64_encode(file_get_contents($p)) : null;}
            
            if('corpus' == $request->up && !empty($request->corpusid)){
                $up = Corpuses::find($request->corpusid);
                $up->img = $img ?? $up->img;
                $up->save();
            }elseif('class' == $request->up && !empty($request->classid)){
                $up = Classes::find($request->classid);
                $up->img = $img ?? $up->img;
                $up->price = $request->price ?? $up->price;
                $up->save();
            }
            header('Location: '.route('front.admin', ['baseId' => $curCorpuses['muzid'], 'time' => time()])); exit;
        }

    
///*/ Вывод ///*/
    $domain = ($_REQUEST['DOMAIN'] ?? $_SERVER['HTTP_HOST']);
    $data = get_defined_vars(); unset($data['request'], $data['mb'], $data['bx']); $data = array_keys($data);
    return ($domain == self::DOMAIN) ? view('front.admin', compact($data)) : abort(404);        

}else{abort(500);}}}