@extends('layouts.home')

@section('title', 'Бронирование классов')
@section('description', 'Бронирование классов')

@section('body')                
<div style="padding-top: 15px; width:100%; background: rgb(255,255,255);">

    <div id="head" style="width:100%; height: 50px; background: #ffffff; min-height: 55px;">
        <div class="head">
            <div class="head_el">
                
                <!--div class="head_el__button_day"><span class="button_day">День</span> &#9660;</div-->

                <a href="{{ route('front.admin', ['baseId' => $curCorpuses['muzid']]) }}"><div class="head_el__button_today">Админка</div></a>
                <a href="{{ route('front.home', ['baseId' => $curCorpuses['muzid'], 'dateIn' => date('Y-m-d')]) }}"><div class="head_el__button_today">Сегодня</div></a>
                <div class="head_el__button_nav">
                    <a href="{{ route('front.home', ['baseId' => $curCorpuses['muzid'], 'dateIn' => date('Y-m-d', strtotime('-1 day', $curTimestamp))]) }}"><button>&#60;</button></a>
                    <a href="{{ route('front.home', ['baseId' => $curCorpuses['muzid'], 'dateIn' => date('Y-m-d', strtotime('+1 day', $curTimestamp))]) }}"><button>&#62;</button></a>
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
                    <a href="{{ route('front.home', ['baseId' => $base['muzid'],]) }}">
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
                <td classid="{{ $Classes[$k]['muzid'] }}"><div class="body__tb_room_item item_{{ $i }}"><span>{{ $Classes[$k]['name'] }}</span></div></td>
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
                echo '<td classid="'.$room.'">';
                
            if(empty($order)){echo '<div class="body__tb_block_empty item_'.$i.'">&nbsp;</div>';}
            else{echo'
                    <div class="'.((preg_match('/^Импорт/m', $order['comment'])) ? 'body__tb_block_import item_'.$i.'">'.$order['comment'] : 'body__tb_block_select item_'.$i.'">'.$order['users']['fio']).'
                        <div class="fl" style="display: none;">
                            <div class="card__fl_clients_item">
                                <ul>
                                    <li><span class="caption comment">Событие на: </span><strong>'.date('d-m-Y', $fd = strtotime($order['datefrom'])).', с '.date('H:i', $fd).' до '.date('H:i', strtotime($order['dateto'])).'</strong></li>
                                    <li><span class="caption comment">Площадка: </span><strong>'.$Classes[$kk]['name'].'</strong></li>
                                    <li><span class="caption comment">Ф.И.О: </span><strong>'.($order['users']['fio'] ?? '').'</strong></li>
                                    <li><span class="caption comment">Телефон: </span><a class="orange-title">'.($order['users']['phone'] ?? '').'</a></li>
                                    <li><span class="caption comment">Почта: </span><a class="orange-tile">'.($order['users']['email'] ?? '').'</a></li>
                                    <li><span class="caption comment">Количество человек: </span><strong>'.($order['amountpeople'] ?? '').'</strong></li>
                                    <li><span class="caption comment">Стоимость заказа: </span><strong>'.((!empty($order['totalSum'])) ? $order['totalSum'].' ₽ (оплачено '.$order['totalSum'].' ₽)' : '').'</strong></li>
                                </ul>
                            </div>
                            <div class="card__fl_clients_item">
                                <ul>
                                    <li>
                                        <div class="caption comment">Комментарий сотрудника</div>
                                        <div><strong>'.$order['comment'].'</strong></div>
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
                        <div class="caption comment">{{ $item }}</div>
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

<script>
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}
function getDateFromCalendar() {
    let days = document.querySelectorAll(".calendar__body__days .calendar__body__item")

    days.forEach(day => {
        day.addEventListener("click", function () {

            days.forEach(item => item.classList.contains("active") && item.classList.remove("active"))

            day.classList.add("active")
            let date;
            if(day.classList.contains("lastMonth")) {
                date = new Date(currYear, currMonth - 1, day.innerText)
            } else if (day.classList.contains("nextMonth")) {
                date = new Date(currYear, currMonth + 1, day.innerText)
            } else {
                date = new Date(currYear, currMonth, day.innerText)
            }

            let month = date.getMonth(),
                currDay = date.getDate(),
                fullYear = date.getFullYear(),
                dayOfWeek = date.getDay(),
                dateIn = formatDate(date)

            // if ('URLSearchParams' in window) {
            //     var searchParams = new URLSearchParams(window.location.search)
            //     searchParams.set("dateIn", dateIn);
            //     var newRelativePathQuery = window.location.pathname + '&' + searchParams.toString();
            //     history.pushState(null, '', newRelativePathQuery);
            // }

            const origin = window.location.origin

            window.location.replace(origin + "?baseId=" + baseId + "&dateIn=" + dateIn)

            console.log(window.location)
            console.log(myParam)

            output.innerText = `${currDay} ${monthNames[month]} ${fullYear}`;
            calendarHeader.innerText = `${weekDayNames[dayOfWeek !== 0 ? dayOfWeek - 1 : 6]}, ${monthNames[month].slice(0, 3)} ${currDay}`

            calendar.classList.remove("on")
            calendar.classList.add("off");
            calendarBlack.classList.remove("on")
            calendarBlack.classList.add("off")
        })
    })
}

    var baseId = '{{ $Classes[0]["muzid"] ?? ""}}';

    const monthNames = ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"]
    const weekDayNames = ["пн","вт","ср","чт","пт","сб","вс"]

    document.addEventListener("DOMContentLoaded", function () {
        let currentDate = document.querySelector("#currentDate"),
            calendar = document.querySelector(".calendar"),
            calendarHeader = document.querySelector(".calendar__header"),
            calendarBlack = document.querySelector(".calendarBlack"),
            daysWrapper = document.querySelector(".calendar__body__days"),
            arrows = document.querySelectorAll(".calendar__body__month button"),
            output = document.querySelector(".head_el__button_date button"),
            dropdown = document.querySelector(".calendar__dropdown"),
            dropdownUl = document.querySelector(".calendar__dropdown ul"),
            dropdownToggle = document.querySelector(".dropdownToggle"),
            monthsItems = document.querySelectorAll(".calendar__dropdown ul li"),
            card = document.querySelectorAll(".card__fl")[0],
            blockImportSelect = Array.from(document.querySelectorAll(".body__tb_block_import, .body__tb_block_select"));

        let date = new Date(),
            currYear = date.getFullYear(),
            currMonth = date.getMonth()

        const renderCalendar = () => {
            let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
                lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
                lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
                lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate()
            let days = "";
            for(let i = firstDayofMonth - 1; i > 0; i--){days += `<div class="calendar__body__item inactive lastMonth">${lastDateofLastMonth - i + 1}</div>`;}
            for(let i = 1; i <= lastDateofMonth; i++){days += `<div class="calendar__body__item">${i}</div>`;}
            for(let i = lastDayofMonth; i <= 6; i++){days += `<div class="calendar__body__item inactive nextMonth">${i - lastDayofMonth + 1}</div>`;}

            currentDate.innerText = `${monthNames[currMonth]} ${currYear}`;
            daysWrapper.innerHTML = days;
        }
        renderCalendar();

        const showMonths = () => {
            if(dropdown.classList.contains("off")) {
                dropdown.classList.remove("off")
                dropdown.classList.add("on")
            } else {
                dropdown.classList.remove("on")
                dropdown.classList.add("off")
            }
        }

        monthsItems.forEach(month => {
            month.addEventListener("click", function () {
                currMonth = month.dataset.index
                showMonths()
                renderCalendar()
                getDateFromCalendar()
            })
        })

        dropdownToggle.addEventListener("click", function () {
            showMonths()
        })

        arrows.forEach(icon => {
            icon.addEventListener("click", () => {
                currMonth = icon.classList.contains("prev") ? currMonth - 1 : currMonth + 1;
                if(currMonth < 0 || currMonth > 11) {
                    date = new Date(currYear, currMonth, new Date().getDate());
                    currYear = date.getFullYear();
                    currMonth = date.getMonth();
                } else {
                    date = new Date();
                }
                renderCalendar(); getDateFromCalendar()
            })
        })


        const urlParams = new URLSearchParams(window.location.search);
        const myParam = urlParams;

        getDateFromCalendar()

        output.addEventListener("click", function () {
            calendar.classList.contains("on") ? calendar.classList.remove("on") : calendar.classList.add("on");
            calendarBlack.classList.contains("on") ? calendarBlack.classList.remove("on") : calendarBlack.classList.add("on")
        })

        calendarBlack.addEventListener("click", function () {
            calendar.classList.remove("on")
            calendar.classList.add("off");
            calendarBlack.classList.remove("on")
            calendarBlack.classList.add("off")
        })
        
        blockImportSelect.forEach((el, index) => {el.addEventListener("click", () => {
            console.log(card.innerHTML);
            card.innerHTML = el.querySelector('.fl').innerHTML;
            console.log(card);
        });});
 
        
    })

</script>

@endsection