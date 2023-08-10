@extends('layouts.app')

@section('title', 'Бронирование классов')
@section('description', 'Бронирование классов')

@section('body')                
<div style="padding-top: 15px; width:100%; background: rgb(255,255,255);">

    <div id="head" style="width:100%; height: 50px; background: #ffffff; min-height: 55px;">
        <div class="head">
            <div class="head_el">
                
                <div class="head_el__button_day"><span class="button_day">День</span> &#9660;</div>
                <div class="head_el__button_today">Сегодня</div>
                <div class="head_el__button_nav">
                    <button>&#60;</button>
                    <button>&#62;</button>
                </div>

                <div class="head_el__button_date" style="max-width: 112px;">
                    <label>Дата</label><br>
                    <button><?=($date = new DateTime('now', new DateTimeZone('Europe/Moscow')))->format('d M y');?></button>
                </div>

            </div>
            
            <div class="head_el">         
                <div class="head_el__drop">
@if(!empty($curBase['value']) && !empty($curBase['sphere'])) 
                    <button>
                        <div class="head_el__drop_class_img">
                            <img src="https://partner.musbooking.com/res/bases/220315-1650-2.jpeg">
                            <div class="head_el__drop_class_label">{{ $curBase['value'] }}<br>
                            <span class="head_el__drop_class_sublabel">{{ $curBase['sphere'] }}</span></div>
                            <div>&#9660;</div>
                        </div>
                    </button>
@endif
                  <div class="head_el__drop_content">
@foreach($bases as $base) 
                    <a href="{{ route('front.home', ['baseId' => $base['id'],]) }}">
                        <div class="head_el__drop_content_class_img">
                            <img src="{{ $curBaseImg[array_rand($curBaseImg)] }}">
                            <div class="head_el__drop_content_class_label">{{ $base['value'] }}<br>
                            <span class="head_el__drop_content_class_sublabel">{{ $base['sphere'] }}</span></div>
                        </div>
                    </a>
@endforeach
                  </div>
                </div>
             
                <div class="head_el__help" >&#63;</div>
                <div class="head_el__setting">&#9881;</div>
                            
            
            </div>

        </div>
    </div>
    <div id="body" style="width:100%; height: 55vh; background: rgb(250,250,250);">
        <div class="body">
        <table>
            <tbody>
                <tr>
                    <td style="width: 50px"><div class="body__tb_day_title"><?=$week[$date->format('N')];?></div><div class="body__tb_day_title_number"><?=$date->format('d');?></div></td>
@foreach($clases as $k => $clase)
                    <td><div class="body__tb_room_item item_{{ $k }}"><span>{{ $clase['value'] }}</span></div></td>
@endforeach                    
@php @endphp
                </tr>
@foreach($curTimes as $time)
                <tr>
                    <td>{{ $time }}</td>
@for($i = 0; $i < count($clases); $i++)
                    <td><div class="body__tb_block_empty item_{{ $i }}">&nbsp;</div></td>
@endfor
                </tr>
@endforeach
                <!--tr>
                    <td>10:00</td>
                    <td><div class="body__tb_block_select item_0">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_1">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_2">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_3">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_4">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_5">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_6">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_7">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_8">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_9">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_10">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_11">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_12">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_13">&nbsp;</div></td>
                </tr>
                <tr>
                    <td>11:00</td>
                    <td><div class="body__tb_block_import item_0">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_1">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_2">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_3">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_4">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_5">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_6">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_7">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_8">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_9">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_10">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_11">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_12">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_13">&nbsp;</div></td>
                </tr>
                <tr>
                    <td>12:00</td>
                    <td>
                        <div class="body__tb_block_select item_0">
                            <div class="body__tb_block_part">
                                <i aria-hidden="true" class="v-icon calendar_month-icon material-icons theme--light">phone_iphone</i>
                                <span class="calendar_day-second_text" style="width: 5px; margin-left: 3px;">Бардышевская Кира</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="body__tb_block_select item_1">
                            <div class="body__tb_block_part">
                                <i aria-hidden="true" class="v-icon calendar_month-icon material-icons theme--light">calendar_view_month</i>
                                <span class="calendar_day-second_text" style="width: 5px; margin-left: 3px;">Sotniko Vadim</span>
                            </div>
                        </div>
                    </td>
                    <td><div class="body__tb_block_select item_2">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_3">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_4">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_5">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_6">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_7">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_8">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_9">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_10">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_11">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_12">&nbsp;</div></td>
                    <td><div class="body__tb_block_select item_13">&nbsp;</div></td>
                </tr>
                <tr>
                    <td>13:00</td>
                    <td><div class="body__tb_block_import item_0">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_1">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_2">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_3">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_4">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_5">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_6">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_7">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_8">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_9">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_10">&nbsp;</div></td>
                    <td><div class="body__tb_block_import item_11">&nbsp;</div></td>
                    <td>
                        <div class="body__tb_block_import item_12">
                            <div class="body__tb_block_part">
                                <i aria-hidden="true" class="v-icon calendar_month-icon material-icons theme--light">calendar_today</i>
                                <i aria-hidden="true" class="v-icon calendar_month-icon material-icons theme--light">chat_bubble_outline</i>
                                <span class="calendar_day-second_text" style="width: 5px; margin-left: 3px;">Sotniko Vadim</span>
                            </div>                    
                        </div>
                    </td>
                    <td><div class="body__tb_block_import item_13">&nbsp;</div></td>
                </tr>
                <tr>
                    <td>14:00</td>
                    <td><div class="body__tb_block_empty item_0">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_1">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_2">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_3">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_4">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_5">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_6">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_7">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_8">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_9">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_10">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_11">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_12">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_13">&nbsp;</div></td>
                </tr>
                <tr>
                    <td>15:00</td>
                    <td><div class="body__tb_block_empty item_0">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_1">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_2">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_3">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_4">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_5">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_6">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_7">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_8">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_9">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_10">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_11">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_12">&nbsp;</div></td>
                    <td><div class="body__tb_block_empty item_13">&nbsp;</div></td>
                </tr-->

            </tbody>
        </table>    
    </div>
    </div>
    <div id="foot" style="width:100%; height: 30vh; background: rgb(250,250,250);"> 
        <div class="card">
                <div class="card__fl">
                    <div class="card__fl_clients_item">
                        <ul>
                            <li><span class="caption comment">Событие на: </span><strong>26-06-2023, 20:00 - 21:00</strong></li>
                            <li><span class="caption comment">Площадка: </span><strong>Шаляпин</strong></li>
                            <li><span class="caption comment">Ф.И.О: </span><strong>Sotniko Vadim</strong></li>
                            <li><span class="caption comment">Телефон: </span><a class="orange-title">9252010982</a></li>
                            <li><span class="caption comment">Почта: </span><a class="orange-tile">sotnikovve@yandex.ru</a></li>
                            <li><span class="caption comment">Количество человек: </span><strong>Вдвоём</strong></li>
                            <li><span class="caption comment">Стоимость заказа: </span><strong>550 ₽ (оплачено 550 ₽)</strong></li>
                        </ul>
                    </div>
                    
                    <div class="card__fl_clients_item">
                        <ul>
                            <li>
                                <div class="caption comment">Комментарий сотрудника</div>
                                <div><strong>Импорт из google: 28.06.2023 13:00:00-28.06.2023 18:00:00 Импорт из google: 28.06.2023 13:00:00-28.06.2023 18:00:00 Импорт из google: 28.06.2023 13:00:00-28.06.2023 18:00:00</strong></div>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card__fl_clients_item_button">
                        <button type="button" class="card__fl_clients_item_button_deil"><div>Детали заказа</div></button><br>
                        <button type="button" class="card__fl_clients_item_button_reset"><div>Отменить без сбора</div></button>
                    </div>
                </div>
        </div>
    </div>

    <div class="calendar off">
        <div class="calendar__header"></div>
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