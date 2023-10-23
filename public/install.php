<?php  //var_dump(__DIR__.'/crest.php'); exit;
require_once ($crest = __DIR__.'/crest.php');
//var_dump($crest);
$handler = 'https://mzc.inter-inc-test.ru/';
$result = CRest::installApp();
if($result['rest_only'] === false):?>
    <head>
        <script src="//api.bitrix24.com/api/v1/"></script>
        <?php if($result['install'] == true):?>
            <script>function sleep(ms){return new Promise(resolve => setTimeout(resolve, ms));}
                BX24.init(function(){
                    ///*/ Сформируем запрос на встраивание ///*/
                    var requests = [];
                    var handler = '<?=$handler;?>';
                    console.log(handler);
                    requests.push({
                        method: 'placement.bind', 
                        params: {
                            PLACEMENT: 'CRM_DEAL_DETAIL_TAB',
                            HANDLER: handler,
                            TITLE: 'Бронирование классов',
                            DESCRIPTION: 'Локальное приложение',
                            GROUP_NAME: 'undefaind'
                        },
                    });
                    ///*/ 
                    BX24.callBatch(requests, function(data){console.log('Инициализация завершена!', BX24.placement.info(), data);}); ///*/
                                          
                    sleep(10000).then(() => {BX24.installFinish();});
                });
            </script>
        <?php endif;?>
    </head>
    <body>
<?php 
if($result['install'] == true):
//
/*/ 
var_dump(CRest::call('placement.bind',[
'PLACEMENT' => 'CRM_DEAL_DETAIL_TAB',
'HANDLER' => $handler,
'LANG_ALL' => [
'ru' => [
'TITLE' => 'Бронирование классов',
'DESCRIPTION' => 'Локальное приложение',
'GROUP_NAME' => 'undefaind',
],],]));
///*/?>
            installation has been finished
        <?php else:?>
            installation error
        <?php endif;?>
    </body>
<?php ///*/ 
endif; ?>