<?php

$ch = curl_init('https://mzc.inter-inc-test.ru/sync' . http_build_query(['baseId'  => '']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
 
echo $html;
?>
