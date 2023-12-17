<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description')">    
        <title>@yield('title')</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet">
        <?php //<link rel="stylesheet" href="/assets/css/app.css?<=time();>"/> ?>
        <?php //<script src="/assets/js/app.js?<=time();>"></script> ?>
        <script src="//api.bitrix24.com/api/v1/"></script>
{{-- 
        <style type="text/css"><?php if(file_exists($css = resource_path('assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'app.css'))){include $css;}?></style>
        <script type="text/javascript"><?php if(file_exists($js = resource_path('assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'app.js'))){include $js;}?></script>
--}}
        <style type="text/css">
*{margin:0; padding:0; font-family: Roboto,sans-serif;}
body{font-size: 16px;line-height: 1.5;color: rgba(0,0,0,.87); background-repeat: no-repeat;}
button{
    font-size: 20px;
    cursor: pointer;
    text-transform: none;
    background-color: transparent;
    border-style: none;
    color: inherit;
    height: 33px;
}


.head{
    display: flex;
    flex-wrap: wrap;    
    justify-content: space-between;
    align-items: center;   
}

.head_el{
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 22%;    
}
.head_el a{text-decoration: none; color:#000;}

.head_el__button_day,.head_el__button_today{
    margin: 0 5px;
    border: 1px solid rgb(225,195,195);
    border-radius: 8px;
    cursor: pointer;
    padding: 12px 16px;
}.head_el__button_day:hover,.head_el__button_today:hover{
    background: rgb(225,195,195);
    
}


.head_el__button_nav{
    margin: 0 8px!important;
    display: flex;
    flex: 1 1 auto;
    flex-wrap: nowrap;
    align-items: center;
    flex-direction: row;
    max-width: 15%;
    color: #836565;
}.head_el__button_nav button{margin: 0 7px;}


.head_el__button_date label{
    position: relative;
    bottom: 0;
    color: rgb(175, 175, 175);
    font-size: 14px;
}
.head_el__button_date button{
    position: relative;
    bottom: 5px;
    color: rgb(0 0 0);
    font-size: 11px;
    /* border-bottom: 1px solid rgb(0,0,0); */
    
}
.head_el__drop{position: relative; display: inline-block;min-width: 300px;}
.head_el__drop > button{
    background: rgb(255,255,255);    
    padding: 5px;
    font-size: 12px;   
    cursor: pointer;
    height: 100%;
}.head_el__drop:hover button{background: rgb(200,200,200);}  


.head_el__drop_content{
    display: none;
    position: absolute;
    background: rgb(240, 240, 240);
    width: 100%;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}  
.head_el__drop_content a{
    color: black;
    padding: 0px;
    text-decoration: none;
    display: block;
} 
.head_el__drop_content a:hover{background-color: #f1f1f1}  
/* .head_el__drop:hover .head_el__drop_content{display: block;} */

.head_el__drop_class_img{
    display: flex;
    align-items: center;
    font-size: 10px;
    white-space: nowrap;
}
.head_el__drop_class_img img{
    width: 50px;
    margin-right: 5px;
    border: 1px solid rgb(255,255,255);
    border-radius: 8px;
}
.head_el__drop_class_label{
    padding: 5px;
    white-space: normal;    
}
.head_el__drop_class_sublabel{
    color: rgba(0, 0, 0, 0.54);
    text-transform: none;    
}

.head_el__drop_content_class_img:hover{
    border-top: 2px solid rgb(255,165,0);
    border-bottom: 2px solid rgb(255,165,0);
    background: rgb(200,200,200);
}
.head_el__drop_content_class_img{
    display: flex;
    align-items: center;
    font-size: 9px;
    text-align: left;
    /* white-space: nowrap; */
}
.head_el__drop_content_class_img img{
    width: 70px;
    margin-right: 2px;
    border: 1px solid rgb(255,255,255);
    border-radius: 8px;
}
.head_el__drop_content_label{
    padding: 5px;    
}
.head_el__drop_content_class_sublabel{
    color: rgba(0, 0, 0, 0.54);
    text-transform: none;    
}
.head_el__setting{font-size: 32px;} .head_el__help{font-size: 28px;}
.head_el__setting, .head_el__help{
    text-align: center;
    padding: 0px 5px;
    cursor: pointer;
}
.head_el__setting:hover, .head_el__help:hover{
    background: rgb(200,200,200);
}


.body::-webkit-scrollbar {
    display: none;
}
.body{
  position: relative;
  overflow-x: auto;
  width: 100%;
  max-width: 100%;
  height: 55vh;
}
.body table{width:100%; table-layout: fixed;}
.body table td{padding: 0 5px; min-width: 50px;}
.body{
    text-align: center;
}
.reset_order, .body__tb_room_item{
    width: 100%; 
    flex-basis: auto; 
    background: rgb(248, 150, 35);
    border-radius: 8px;
    color: rgb(255, 255, 255);
    line-height: normal;
    margin: 0px -5px;
    padding: 0 5px;
}
.reset_order{width: 200px!important; text-align: center; cursor: pointer; margin: 15px 0;}
.body__tb_block_import{background: rgb(108,108,108); border: 3px solid rgb(108,108,108);}
.body__tb_block_import:hover{border: 3px solid rgb(0,191,255);}
.body__tb_block_select{background: rgb(31,235,0); border: 3px solid rgb(31,235,0);}
.body__tb_block_select:hover{border: 3px solid rgb(0,191,255);}
.body__tb_block_empty{background: rgb(233,233,233); border: 3px solid rgb(233,233,233);}
.body__tb_block_empty:hover{border: 3px solid rgb(0,191,255);}
.body__tb_block_empty, .body__tb_block_select, .body__tb_block_import{
    transform: unset; 
    display: flex; 
    flex-direction: row; 
    width: 100%;
    font-size: xx-small;
    border-radius: 8px;
    cursor: pointer;
}
.body__tb_block_part{
    display: flex;
    padding-top: 3px;
}
.body__tb_block_new{background: rgb(0,191,255);}


.card{
    border: 1px solid rgb(175,175,175);
    border-radius: 8px;
    padding: 10px 20px;
    background: rgb(255,255,255);
}
.card ul{
    list-style: none;
}
.card__fl{
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgb(255,255,255);
    border: 1px solid rgb(214,213,213);
    border-radius: 0px;
}
.card__fl_clients_item_button_deil{
    background-repeat: no-repeat;
    font: inherit;
    overflow: visible;
    border-style: none;
    cursor: pointer;
    -webkit-box-align: center;
    align-items: center;
    display: inline-flex;
    height: 36px;
    -webkit-box-flex: 0;
    flex: 0 0 auto;
    font-size: 14px;
    font-weight: 500;
    -webkit-box-pack: center;
    justify-content: center;
    margin: 6px 8px;
    min-width: 88px;
    outline: 0;
    text-transform: uppercase;
    text-decoration: none;
    transition: .3s cubic-bezier(.25,.8,.5,1),color 1ms;
    vertical-align: middle;
    padding: 0 16px;
    border-radius: 28px;
    width: 295px;
    max-width: 295px;
    background-color: #f89623 !important;
    border-color: #f89623 !important;
    position: relative;
    box-shadow: 0 3px 1px -2px rgba(0,0,0,.2),0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12);
    color: #fff;
    }
.card__fl_clients_item_button_reset{
    font: inherit;
    overflow: visible;
    border-style: none;
    cursor: pointer;
    align-items: center;
    display: inline-flex;
    height: 36px;
    -webkit-box-flex: 0;
    flex: 0 0 auto;
    font-size: 14px;
    font-weight: 500;
    justify-content: center;
    margin: 6px 8px;
    min-width: 88px;
    outline: 0;
    text-transform: uppercase;
    text-decoration: none;
    transition: .3s cubic-bezier(.25,.8,.5,1),color 1ms;
    position: relative;
    vertical-align: middle;
    user-select: none;
    padding: 0 16px;
    border-radius: 28px;
    background: #f49bad!important;
    width: 295px;
    max-width: 295px;
    color: rgba(0,0,0,.87);
    box-shadow: 0 3px 1px -2px rgba(0,0,0,.2),0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12);    
}
.card__gr{
    display: flex;
    gap: 50px;
}
.card__gr_label_title{
    color: rgba(0,0,0,.87);
    box-sizing: inherit;
    background-repeat: no-repeat;
    margin: 0;
    font-size: 20px!important;
    font-weight: 500;
    line-height: 1!important;
    letter-spacing: .02em!important;
    font-family: Roboto,sans-serif!important;
    padding: 0 10px;
    text-align: left;
}

.calendar {
    width: 350px;
    /*min-height: 600px;*/
    max-height: 500px;

    color: #000;

    border-radius: 10px;
    background-color: #fff;

    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    z-index: 5;
}

.calendar.off {
    transform: translate(-50%, -50%) scale(0.8);
    opacity: 0;

    pointer-events: none;

    transition: .3s;
}

.calendar.on {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;

    pointer-events: all;

    transition: .3s;
}

.calendarBlack {
    width: 100vw;
    height: 100vh;

    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    left: 0;
}

.calendarBlack.off {
    opacity: 0;

    pointer-events: none;

    transition: .3s;
}

.calendarBlack.on {
    opacity: 1;

    pointer-events: all;

    transition: .3s;
}


.calendar .inactive {
    color: #848484;
}

.calendar__header {
    background-color: #e79a00;
    height: 120px;

    box-sizing: border-box;

    font-weight: bold;

    font-size: 32px;
    padding: 20px 30px;
    display: flex;
    align-items: end;

    color: #fff;

    border-radius: 10px 10px 0 0;

    user-select: none;
}

.calendar__body {
    padding: 10px 30px 50px 30px;
}

.calendar__body__month {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;

    cursor: pointer;
}

.calendar__body__month p {
    font-weight: bold;
}

.calendar__body__month img {
    cursor: pointer;

    margin-left: 10px;
    width: 12px;
}

.calendar__body__month button img {
    width: 20px;
}

.calendar__body__month .arrow-right {
    transform: rotate(180deg);
}

.calendar__body__wrapper {
    margin-top: 20px;
}

.calendar__body__week {
    display: grid;

    color: #848484;
    text-transform: uppercase;

    gap: 2px;

    grid-template-rows: 100%;
    grid-template-columns: calc(100% / 7) calc(100% / 7) calc(100% / 7) calc(100% / 7) calc(100% / 7) calc(100% / 7) calc(100% / 7);
}

.calendar__body__days {
    gap: 2px;

    display: grid;
    grid-template-columns: calc(100% / 7) calc(100% / 7) calc(100% / 7) calc(100% / 7) calc(100% / 7) calc(100% / 7) calc(100% / 7);
    grid-template-rows:  calc(100% / 6) calc(100% / 6) calc(100% / 6) calc(100% / 6) calc(100% / 6) calc(100% / 6);
}

.calendar__body__item {
    border-radius: 50%;

    cursor: pointer;

    min-height: 41px;

    display: flex;
    align-items: center;
    justify-content: center;
    
    transition: .3s;
}

.calendar__body__item:hover {
    background-color: #ddd;

    transition: .3s;
}

.calendar__body__item.active {
    color: #fff;
    background-color: #9929d7;

    transition: .3s;
}

.calendar__dropdown {
    width: 150px;
    max-height: 300px;

    background-color: #fff;

    border-radius: 4px;

    padding: 10px 0;

    overflow-y: auto;

    position: absolute;

    bottom: 5px;
    left: 86px;
    box-shadow: 0 0 5px 0 #000;
}

.calendar__dropdown.on {
    transform: translateY(0px);

    pointer-events: all;

    opacity: 1;

    transition: .3s;
}

.calendar__dropdown.off {
    transform: translateY(-20px);

    pointer-events: none;

    opacity: 0;

    transition: .3s;
}

.calendar__dropdown ul {
    list-style: none;
}

.calendar__dropdown li {
    cursor: pointer;

    padding: 5px 30px;

    transition: .3s;
}

.calendar__dropdown li:hover {
    background-color: #cecece;

    transition: .3s;
}
        </style>
        <script type="text/javascript">
"use strict"
const log = console.log;

let hasClass = (typeof document.documentElement.classList == "undefined") ?
    function(el, clss){return el.className && new RegExp("(^|\\s)" + clss + "(\\s|$)").test(el.className);} :
    function(el, clss){return el.classList.contains(clss);};

function curDateTime(){
    var d = new Date();
    var year = d.getFullYear(), month = d.getMonth()+1, day = d.getDay();
    var hours = d.getHours(), minutes = d.getMinutes(), seconds = d.getSeconds(); 
    var date = d.getDate(), ms = d.getMilliseconds();   
    var curDateTime = year;
    curDateTime += ((month>9) ? '-': '-0')+month;
    curDateTime += ((date>9) ? '-': '-0')+date;
    curDateTime += ((hours>9) ? ' ': ' 0')+hours;
    curDateTime += ((minutes>9) ? ':': ':0')+minutes;
    curDateTime += ((seconds>9) ? ':': ':0')+seconds;
return curDateTime;}

function addOrderSubmit(){
    let input_textarea = document.getElementById('addOrder').querySelectorAll('input,textarea');
    let form_new = document.createElement('form'); form_new.action = '/'; form_new.method = 'POST';
    let i = 0; let objInp = {};
    for(var key in input_textarea){
        if(undefined === input_textarea[key].value){continue;}
        let newInp = "inp_"+ i; //console.log(newInp);
        
        objInp[newInp] = document.createElement("input");
        objInp[newInp].name = input_textarea[key].name; 
        objInp[newInp].value = input_textarea[key].value;
        //console.log(objInp[newInp].value);
        form_new.appendChild(objInp[newInp]);
    i++;}
    //console.log(form_new.length); console.log(objInp);
    form_new.style.display = "none";
    document.body.append(form_new); form_new.submit();    
}

function resetOrder(e){
    const request = new XMLHttpRequest();
    request.open("POST", "/reset");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            let jsonRes = JSON.parse(request.responseText);
            if(0 < parseInt(jsonRes.our)){//log(jsonRes.our);
                window.location.reload();
            }
        }
    });
    
    request.send("muzid="+e.dataset.muzid);

    log(e.dataset.id);
    log(e.dataset.muzid);

}

document.addEventListener('DOMContentLoaded', () => {
    let baseList = document.querySelectorAll('.head_el__drop_content')[0];
    document.querySelectorAll('.head_el__drop')[0].addEventListener('click', function(e){
        baseList.style.display = ('none' == baseList.style.display) ? 'block' : 'none';
    });
    //*/ День -> Месяц//*/
    let span = document.createElement("span"),
        rgb = 'rgb(0 191 255 / 20%)';
    
    document.querySelectorAll('.head_el__button_day').forEach((i, k) => {
        i.addEventListener('click', function(e){
            let button_day = this.querySelectorAll('.button_day')[0],
                button_mon = this.querySelectorAll('.button_mon')[0];
            if(undefined != button_day){
                span.className = 'button_mon'; 
                span.innerText = 'Месяц';
                button_day.remove();
                this.insertBefore(span, this.firstChild);
            }else
            if(undefined != button_mon){
                span.className = 'button_day'; 
                span.innerText = 'День';
                button_mon.remove();
                this.insertBefore(span, this.firstChild);
            }
        });
    });
    
    document.querySelectorAll('.body__tb_block_empty').forEach((i, k) => {
        i.addEventListener('click', function(e){ //log(document.querySelectorAll('.card')[0])
            document.querySelectorAll('.card')[0].style.display='block';
              
            let issetNew = document.querySelectorAll('.body__tb_block_new');
            let rowTime = this.parentNode.parentNode;
            let timeSelect = rowTime.firstElementChild;
            let columnRoom = document.querySelectorAll('.'+this.classList[1]);
            let roomSelect = columnRoom[0];
            let classid = roomSelect.parentNode.dataset.classid;
            //log(classid);
            //log(rowTime); log(timeSelect); log(columnRoom); log(roomSelect); log(issetNew);
            //log(this.classList[1] === roomSelect.classList[1]);
            //log(this.classList[1]); 
            //log(roomSelect.parentNode.getAttribute('classid') );
            //log(roomSelect.parentChild.classList[1]);
            //log(columnRoom);
            
            if(0 == issetNew.length || this.classList[1] === issetNew[0].classList[1]){
                this.classList.toggle('body__tb_block_new'); timeSelect.classList.toggle('active');

                [... rowTime.children].forEach((ii, kk) => {
                    if(0==kk){return;}
                    if(i === ii.firstElementChild){
                        if('' == roomSelect.style.background){roomSelect.style.background = rgb;}else
                        if(0 == document.querySelectorAll('.body__tb_block_new').length){roomSelect.style.background = '';}
                    return;}
                    
                    if('' == ii.firstElementChild.style.background){ii.firstElementChild.style.background = rgb;}else{ii.firstElementChild.style.background = '';}
                });

                let times=[]; document.querySelectorAll('.body__tb_block_new').forEach((j, n) => {times.push(j.parentNode.parentNode.firstElementChild.innerText);});
                let timestr = '';
                for(let i = 0; i < times.length; i++){
                    let timei = parseInt(times[i].split(':')[0]);
                    let timeint = (24 === timei) ? 0 : timei;
                    
                    
                    if(i === 0){
                        let str = timeint;}
                    if(i > 0 && i < times.length - 1){
                        let cur = timeint; log(cur);}
                    if(i === times.length - 1){
                        let lst = timeint;}
                        
                    timestr += (i === 0) ? timeint : ((timeint === parseInt(times[i-1].split(':')[0])) ? ' - ' : ' , ') + timeint;
                    //log(timestr);
                }
                let upload = {"name": roomSelect.innerText, "times": times};
                let data = new FormData(); data.append("json", JSON.stringify(upload));                              
                //log( JSON.stringify(upload));
/*                                    
                fetch("/?api=stoimost",{method: "POST", body: data})
                .then(response => response.json())
                .then(stoimost => document.getElementById('stoimost').innerText = stoimost.result);
*/
                fetch("/api/stoimost?classid="+classid+"&times="+times)
                .then(response => response.json())
                .then(stoimost => document.getElementById('stoimost').innerText = stoimost.result);
                
                //log(document.querySelectorAll('.card .card__fl')[0].innerHTML);
                
                document.querySelectorAll('.card .card__fl')[0].innerHTML = 
                        
                //'<form action="" method="post"><div class="card__fl">'+
                    '<div class="card__fl_clients_item">'+
                        '<div>'+roomSelect.innerText+'</div>'+
                        '<div>'+JSON.stringify(times)+'</div>'+
                        '<div>'+document.querySelectorAll('.head_el__button_date button')[0].innerText+'</div>'+
                        '<div>Стоимость: <span id="stoimost">0</span> ₽</div>'+
                    '</div>'+
                    ''+
                    '<div class="card__fl_clients_item">'+
                        //'<form id="addOrder" action="" method="post">'+
                        '<div id="addOrder">'+
                        '<input type="hidden" name="add" value="order">'+
                        '<input type="hidden" name="DOMAIN" value="<?=$domain?>">'+
                        '<input type="hidden" name="classid" value="'+classid+'">'+
                        '<input type="hidden" name="date" value="'+document.querySelectorAll('.head_el__button_date button')[0].innerText+'">'+
                        '<input type="hidden" name="times" value=\''+JSON.stringify(times)+'\'>'+
                        '<div>Имя:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name" value=""> </div>'+
                        '<div>Фамилия:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="sename" value=""> </div>'+
                        '<div>Телефон без +7:&nbsp;<input type="text" name="phone" value=""> </div>'+
                        '<div>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" value=""> </div>'+
                        '<div>Сделан здесь:&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" checked disabled><input type="hidden" name="isour" value="1"></div>'+
                        '<div>Коментарий:&nbsp;<textarea name="comment" cols="24"></textarea> </div>'+
                        '</div>'+
                        //'</form>'+
                    '</div>'+
                    
                    '<div class="card__fl_clients_item_button">'+
                        '<input class="head_el__button_today" type="submit" value="Оформить" onclick="addOrderSubmit()">'+
                    '</div>';
                //'</div></form>';
//log(document.querySelectorAll('.body__tb_block_new').length);
            if(0 == document.querySelectorAll('.body__tb_block_new').length){
                document.querySelectorAll('.card__fl')[0].innerHTML = ''; //document.querySelectorAll('.card__fl')[0].style.display='none';
            }
            }            
            //this.style.background = 'rgb(0,191,255)';

        });
    });
});

let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth()

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
        // dropdownUl = document.querySelector(".calendar__dropdown ul"),
        dropdownToggle = document.querySelector(".dropdownToggle"),
        monthsItems = document.querySelectorAll(".calendar__dropdown ul li"),
        card = document.querySelectorAll(".card__fl")[0],
        blockImportSelect = Array.from(document.querySelectorAll(".body__tb_block_import, .body__tb_block_select"));

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

                const origin = window.location.origin

                //console.log(origin + "?baseId=<?=$curCorpuses['muzid'];?>&dateIn=" + dateIn + "&DOMAIN=<?=$domain;?>");
                window.location.replace(origin + "?baseId=<?=$curCorpuses['muzid'];?>&dateIn=" + dateIn + "&DOMAIN=<?=$domain;?>")

                // output.innerText = `${currDay} ${monthNames[month]} ${fullYear}`;
                calendarHeader.innerText = `${weekDayNames[dayOfWeek !== 0 ? dayOfWeek - 1 : 6]}, ${monthNames[month].slice(0, 3)} ${currDay}`

                calendar.classList.remove("on")
                calendar.classList.add("off");
                calendarBlack.classList.remove("on")
                calendarBlack.classList.add("off")
            })
        })
    }

    const renderCalendar = () => {
        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
            lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
            lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
            lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate()

        let days = "";
        for(let i = firstDayofMonth - 1; i > 0; i--){days += `<div class="calendar__body__item inactive lastMonth" data-date='${formatDate(new Date(currYear, currMonth - 1, lastDateofLastMonth - i + 1))}'>${lastDateofLastMonth - i + 1}</div>`;}
        for(let i = 1; i <= lastDateofMonth; i++){days += `<div class="calendar__body__item" data-date="${formatDate(new Date(currYear, currMonth, i))}">${i}</div>`;}
        for(let i = lastDayofMonth; i <= 6; i++){days += `<div class="calendar__body__item inactive nextMonth" data-date="${formatDate(new Date(currYear, currMonth + 1, i - lastDayofMonth + 1))}">${i - lastDayofMonth + 1}</div>`;}

        currentDate.innerText = `${monthNames[currMonth]} ${currYear}`;
        daysWrapper.innerHTML = days;

        let allDays = document.querySelectorAll('.calendar__body__days .calendar__body__item')

        checkActive(allDays)
    }
    renderCalendar();


    function checkActive(allDays) {
        allDays.forEach(item => {
            let data = item.getAttribute('data-date');
            let currentDate = String(window.location.search);
            if(currentDate.includes('dateIn')) {
                currentDate = window.location.search.split("&")[1].split("=")[1];
            }

            if(data === currentDate) {
                item.classList.add("active")
            }
        })
    }

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
            currMonth = Number(month.dataset.index);

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
            console.log(currMonth, currYear)
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
        card.innerHTML = el.querySelector('.fl').innerHTML;
    });
    });
})

//Calendar script


/* BX24.init(function(){
   
    BX24.callMethod(
        "crm.deal.fields", {},  
        function(result) {
            if(result.error()) console.error(result.error());
            else console.log(result.data()['ID']);
        }
    );
    console.log(BX24.getDomain(), BX24.placement.info());
    ///* / Сформируем запрос на встраивание ///* /
});
*/
         
        
        </script>
</head>
<body>@yield('body')</body></html>