@extends('layouts.home')

@section('title', 'Бронирование классов')
@section('description', 'Бронирование классов')

@section('body')
<div style="padding-top: 15px; width:100%; background: rgb(255,255,255);">

    <div id="head" style="width:100%; height: 50px; background: #ffffff; min-height: 55px;">
        <div class="head">
            <div class="head_el">
                
                <!--div class="head_el__button_day"><span class="button_day">День</span> &#9660;</div-->

                <a href="{{ route('front.admin', ['baseId' => $curCorpuses['muzid'], 'DOMAIN' => $domain]) }}"><div class="head_el__button_today">Админка</div></a>
                <a href="{{ route('front.home', ['baseId' => $curCorpuses['muzid'], 'dateIn' => date('Y-m-d'), 'DOMAIN' => $domain]) }}"><div class="head_el__button_today">Сегодня</div></a>
                <div class="head_el__button_nav">
                    <a href="{{ route('front.home', ['baseId' => $curCorpuses['muzid'], 'dateIn' => date('Y-m-d', strtotime('-1 day', $curTimestamp)), 'DOMAIN' => $domain]) }}"><button>&#60;</button></a>
                    <a href="{{ route('front.home', ['baseId' => $curCorpuses['muzid'], 'dateIn' => date('Y-m-d', strtotime('+1 day', $curTimestamp)), 'DOMAIN' => $domain]) }}"><button>&#62;</button></a>
                </div>

                <div class="head_el__button_date" style="max-width: 112px;">
                    <label>Дата</label><br>
                    <button>{{ $curDate['rus'] }}</button>
                </div>

            </div>
            
            <div class="head_el">         
                <div class="head_el__drop">
@if(!empty($curCorpuses['name']) && !empty($curCorpuses['type'])) 
                    <button>
                        <div class="head_el__drop_class_img">
                            <img src="{{ $curCorpuses['img'] ?? 'https://partner.musbooking.com/res/bases/220315-1650-2.jpeg'}}">
                            <div class="head_el__drop_class_label">{{ $curCorpuses['name'] }}<br>
                            <span class="head_el__drop_class_sublabel">{{ $curCorpuses['type'] }}</span></div>
                            <div>&#9660;</div>
                        </div>
                    </button>
@endif
                  <div class="head_el__drop_content">
@foreach($Corpuses as $base)
                    <a href="{{ route('front.home', ['baseId' => $base['muzid'], 'DOMAIN' => $domain, 'dateIn' =>  $curDate['datestamp'] ?? date('Y-m-d')]) }}">
                        <div class="head_el__drop_content_class_img">
                            <img src="{{ $base['img'] ?? 'https://partner.musbooking.com/res/bases/220315-1650-2.jpeg'}}">
                            <div class="head_el__drop_content_class_label">{{ $base['name'] }}<br>
                            <span class="head_el__drop_content_class_sublabel">{{ $base['type'] }}</span></div>
                        </div>
                    </a>
@endforeach
                  </div>
                </div>
{{--             
                <div class="head_el__help" >&#63;</div>
                <div class="head_el__setting">&#9881;</div>
--}}                            
            
            </div>

        </div>
    </div>
    <div id="body" style="width:100%; height: 55vh; background: rgb(250,250,250);">
        <div class="body">
        <table>
           <tbody><tr><td style="width: 50px"><div class="body__tb_day_title"><?=$week[date('N')-1];?></div><div class="body__tb_day_title_number"><?=date('d');?></div></td>
@php $i = 1; @endphp
@foreach($rooms ?? [] as $claseid => $n)
                
                @php $k = key(array_filter($Classes, function($ar) use($claseid){return ($claseid == $ar['muzid']);})); @endphp
                @if(!empty($Classes[$k]))
                <td data-classid="{{ $Classes[$k]['muzid'] }}"><div class="body__tb_room_item item_{{ $i }}"><span>{{ $Classes[$k]['name'] }}</span></div></td>
                @endif
@php $i++ @endphp
@endforeach
 
                </tr>
                <tr>
<?php 
if(!empty($curOrders)){
    foreach($curOrders as $time => $rooms){       
        echo '<td>'.$time.'</td>'; 

        foreach($rooms as $room => $order){
            $i = ($room === array_key_first($rooms)) ? 1 : $i; 
            $kk = key(array_filter($Classes, function($ar) use($room){return ($room == $ar['muzid']);}));
                echo '<td data-classid="'.$room.'">';
                
            if(empty($order)){echo '<div class="body__tb_block_empty item_'.$i.'">&nbsp;</div>';}
            else{echo'
                    <div class="'.((preg_match('/^Импорт/m', $order['comment'] ?? '')) ? 'body__tb_block_import item_'.$i.'">'.$order['comment'] : 'body__tb_block_select item_'.$i.'">'.$order['users']['fio']).'
                        <div class="fl" style="display: none;">
                            <div class="card__fl_clients_item">
                                <ul>
                                    <li><span class="caption comment">Событие на: </span><strong>'.date('d-m-Y', $fd = strtotime($order['datefrom'])).', с '.date('H:i', $fd).' до '.date('H:i', strtotime($order['dateto'])).'</strong></li>
                                    <li><span class="caption comment">Площадка: </span><strong>'.$Classes[$kk]['name'].'</strong></li>
                                    <li><span class="caption comment">Ф.И.О: </span><strong>'.($order['users']['fio'] ?? '').'</strong></li>
                                    <li><span class="caption comment">Телефон: </span><a class="orange-title">'.($order['users']['phone'] ?? '').'</a></li>
                                    <li><span class="caption comment">Почта: </span><a class="orange-tile">'.($order['users']['email'] ?? '').'</a></li>
                                    <li><span class="caption comment">Сделан здесь: <input type="checkbox" '.((empty($order['isour'])) ? '' : 'checked').' disabled></span></li>
                                    <li><span class="caption comment">Количество человек: </span><strong>'.($order['amountpeople'] ?? '').'</strong></li>
                                    <li><span class="caption comment">Стоимость заказа: </span><strong>'.((!empty($Classes[$kk]['price'])) ? $Classes[$kk]['price'].' ₽ ' : '').'</strong></li>
                                </ul>
                            </div>
                            <div class="card__fl_clients_item">
                                <ul>
                                    <li>
                                        <div class="caption comment">Комментарий сотрудника</div>
                                        <div><strong>'.$order['comment'].'</strong></div>
                                    </li>
                                    <li>
                                        <div class="caption comment">Ссылка</div>
                                        <a target="_blank" href="https://b24-9948j5.bitrix24.ru/crm/deal/details/'.$order['deal'].'/"><strong>'.($order['users']['fio'] ?? '_').'</strong></a>
                                    </li>
                                    <li>
                                        <div class="reset_order" onclick="resetOrder(this);" data-id="'.($order['id'] ?? '_').'" data-muzid="'.($order['muzid'] ?? '_').'">Отменить бронирование</div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card__fl_clients_item_button"></div>
                        </div>
                    </div>';
            }echo '</td>'; 
            $i++;        
        }echo '</tr>';             
    }
}
?>
            </tbody>
        </table>    
    </div>
    </div>
    
    <div id="foot" style="width:100%; height: 30vh; background: rgb(250,250,250);"> 
        <div class="card">
                <div class="card__fl">
                    <div class="card__fl_clients_item">
                        {{--
                        <ul>
                            <li><span class="caption comment">Событие на: </span><strong></strong></li>
                            <li><span class="caption comment">Площадка: </span><strong></strong></li>
                            <li><span class="caption comment">Ф.И.О: </span><strong></strong></li>
                            <li><span class="caption comment">Телефон: </span><a class="orange-title"></a></li>
                            <li><span class="caption comment">Почта: </span><a class="orange-tile"></a></li>
                            <li><span class="caption comment">Количество человек: </span><strong></strong></li>
                            <li><span class="caption comment">Стоимость заказа: </span><strong></strong></li>
                        </ul>
                        --}}
                    </div>
                    
                    <div class="card__fl_clients_item">
@foreach($addOrderNotification ?? [] as $notificid => $item)
                        <div class="caption comment"><?=str_replace('PHP_EOL', '<br>', $item);?></div>
@endforeach

                        {{--
                        <ul>
                            <li>
                                <div class="caption comment">Комментарий сотрудника</div>
                                <div><strong>Импорт из google: 28.06.2023 13:00:00-28.06.2023 18:00:00 Импорт из google: 28.06.2023 13:00:00-28.06.2023 18:00:00 Импорт из google: 28.06.2023 13:00:00-28.06.2023 18:00:00</strong></div>
                            </li>
                        </ul>
                        --}}
                    </div>
                    
                    <div class="card__fl_clients_item_button">
                        {{--
                        <button type="button" class="card__fl_clients_item_button_deil"><div>Детали заказа</div></button><br>
                        <button type="button" class="card__fl_clients_item_button_reset"><div>Отменить без сбора</div></button>
                        --}}
                    </div>
                    
                </div>
        </div>
    </div>

    <div class="calendar off">
        <div class="calendar__header">{{ $curDate['calendar'] }}</div>
        <div class="calendar__dropdown off">
            <ul>
                <li data-index=0>Январь</li>
                <li data-index=1>Февраль</li>
                <li data-index=2>Март</li>
                <li data-index=3>Апрель</li>
                <li data-index=4>Май</li>
                <li data-index=5>Июнь</li>
                <li data-index=6>Июль</li>
                <li data-index=7>Август</li>
                <li data-index=8>Сентябрь</li>
                <li data-index=9>Октябрь</li>
                <li data-index=10>Ноябрь</li>
                <li data-index=11>Декабрь</li>
            </ul>
        </div>
        <div class="calendar__body">
            <div class="calendar__body__month">
                <button class="prev">
                    <img src="/assets/svg/arrow-left.svg" alt="">
                </button>

                <p class="dropdownToggle">
                    <span id="currentDate"></span>
                    <img src="/assets/svg/arrow-down.svg" alt="">
                </p>

                <button class="next">
                    <img class="arrow-right" src="/assets/svg/arrow-left.svg" alt="">
                </button>
            </div>
            <div class="calendar__body__wrapper">
                <div class="calendar__body__week">
                    <div class="calendar__body__item">пт</div>
                    <div class="calendar__body__item">вт</div>
                    <div class="calendar__body__item">ср</div>
                    <div class="calendar__body__item">чт</div>
                    <div class="calendar__body__item">пт</div>
                    <div class="calendar__body__item">сб</div>
                    <div class="calendar__body__item">вс</div>
                </div>
                <div class="calendar__body__days">

                </div>
            </div>
        </div>
    </div>
    <div class="calendarBlack off"></div>

</div>

@endsection