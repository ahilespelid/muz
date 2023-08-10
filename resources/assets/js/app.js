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

document.addEventListener('DOMContentLoaded', () => {
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
        //console.log(this.querySelectorAll('.button_day')[0].innerHTML = curDateTime()); 
        });
    });
    
    document.querySelectorAll('.body__tb_block_empty').forEach((i, k) => {
        i.addEventListener('click', function(e){document.querySelectorAll('.card')[0].style.display='block';
            let issetNew = document.querySelectorAll('.body__tb_block_new');
            if(0 == issetNew.length || issetNew[0] === this || this.classList[1] === issetNew[0].classList[1]){
                let timeTr = this.parentNode.parentNode;
                let timeTh = document.querySelectorAll('.'+this.classList[1])[0];
                let firstTd = timeTr.firstElementChild;
                
                this.classList.toggle('body__tb_block_new');
                firstTd.classList.toggle('active');

                [... timeTr.children].forEach((ii, kk) => {
                    if(0==kk){return;}
                    if(i === ii.firstElementChild){
                        if('' == timeTh.style.background){
                            timeTh.style.background = rgb;
                        }else
                        if(0 == document.querySelectorAll('.body__tb_block_new').length){
                            timeTh.style.background = '';}
                        return;}
                    
                    if('' == ii.firstElementChild.style.background){
                        ii.firstElementChild.style.background = rgb;
                    }else{
                        ii.firstElementChild.style.background = '';}
                });

                let times=[]; document.querySelectorAll('.body__tb_block_new').forEach((j, n) => { times.push(j.parentNode.parentNode.firstElementChild.innerText);});
                
                let upload = {
                    "name": timeTh.innerText,
                    "times": times
                };
                let data = new FormData();
                data.append("json", JSON.stringify(upload));                              
        
                fetch("/?api=stoimost",{method: "POST", body: data})
                .then(response => response.json())
                .then(stoimost => document.getElementById('stoimost').innerText = stoimost.result);
                
                document.querySelectorAll('.card')[0].innerHTML = 
'<div class="card__gr">'+
    '<div class="card__gr_label">'+
        '<div class="card__gr_label_title">'+
            '<div>'+timeTh.innerText+'</div>'+
            '<div>'+JSON.stringify(times)+'</div>'+
            '<div>'+document.querySelectorAll('.head_el__button_date button')[0].innerText+'</div>'+
            '<div>Стоимость: <span id="stoimost">0</span> ₽</div>'+
        '</div>'+
    '</div>'+
    '<div class="card__gr_label">'+
        '<div class="card__gr_label_title">'+
            '<div>Имя:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name"> </div>'+
            '<div>Фамилия:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="sename"> </div>'+
            '<div>Телефон:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="phone"> </div>'+
            '<div>Коментарий:&nbsp;<textarea name="commit"></textarea> </div>'+
        '</div>'+
    '</div>'+
'</div>';
log(document.querySelectorAll('.body__tb_block_new').length);
            if(0 == document.querySelectorAll('.body__tb_block_new').length){
                document.querySelectorAll('.card')[0].innerHTML = ''; document.querySelectorAll('.card')[0].style.display='none';}
            }            
            //this.style.background = 'rgb(0,191,255)';

        });
    });
    
});

//Calendar script

// const monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
const monthNames = ["Январь", "Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь", "Ноябрь","Декабрь"]
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
    monthsItems = document.querySelectorAll(".calendar__dropdown ul li")

    let date = new Date(),
        currYear = date.getFullYear(),
        currMonth = date.getMonth()

    const renderCalendar = () => {
        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
            lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
            lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
            lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate()
        let days = "";

        for (let i = firstDayofMonth - 1; i > 0; i--) {
            days += `<div class="calendar__body__item inactive lastMonth">${lastDateofLastMonth - i + 1}</div>`
        }

        for (let i = 1; i <= lastDateofMonth; i++) {
            days += `<div class="calendar__body__item">${i}</div>`
        }

        for (let i = lastDayofMonth; i <= 6; i++) { // creating li of next month first days
            days += `<div class="calendar__body__item inactive nextMonth">${i - lastDayofMonth + 1}</div>`
        }

        currentDate.innerText = `${monthNames[currMonth]} ${currYear}`;
        daysWrapper.innerHTML = days;
    }
    renderCalendar()

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

    arrows.forEach(icon => { // getting prev and next icons
        icon.addEventListener("click", () => { // adding click event on both icons
            // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
            currMonth = icon.classList.contains("prev") ? currMonth - 1 : currMonth + 1;
            if(currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
                // creating a new date of current year & month and pass it as date value
                date = new Date(currYear, currMonth, new Date().getDate());
                currYear = date.getFullYear(); // updating current year with new date year
                currMonth = date.getMonth(); // updating current month with new date month
            } else {
                date = new Date(); // pass the current date as date value
            }
            renderCalendar(); // calling renderCalendar function
            getDateFromCalendar()
        })
    })

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
                    dayOfWeek = date.getDay()

                output.innerText = `${currDay} ${monthNames[month]} ${fullYear}`;
                calendarHeader.innerText = `${weekDayNames[dayOfWeek !== 0 ? dayOfWeek - 1 : 6]}, ${monthNames[month].slice(0, 3)} ${currDay}`

                calendar.classList.remove("on")
                calendar.classList.add("off");
                calendarBlack.classList.remove("on")
                calendarBlack.classList.add("off")
            })
        })
    }

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
})





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
 