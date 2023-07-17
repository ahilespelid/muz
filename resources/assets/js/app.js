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
'</div>';
log(document.querySelectorAll('.body__tb_block_new').length);
            if(0 == document.querySelectorAll('.body__tb_block_new').length){
                document.querySelectorAll('.card')[0].innerHTML = ''; document.querySelectorAll('.card')[0].style.display='none';}
            }            
            //this.style.background = 'rgb(0,191,255)';

        });
    });
    
});

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
 