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
        i.addEventListener('click', function(e){ //log(document.querySelectorAll('.card')[0])
            document.querySelectorAll('.card')[0].style.display='block';
              
            let issetNew = document.querySelectorAll('.body__tb_block_new');
            let rowTime = this.parentNode.parentNode;
            let timeSelect = rowTime.firstElementChild;
            let columnRoom = document.querySelectorAll('.'+this.classList[1]);
            let roomSelect = columnRoom[0];
            
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
                        let lst = timeint; log(lst);}
                        
                    timestr += (i === 0) ? timeint : ((timeint === parseInt(times[i-1].split(':')[0])) ? ' - ' : ' , ') + timeint;
                    
                   
                    log(timestr);
                   
                }
                
                let upload = {"name": roomSelect.innerText, "times": times};
                let data = new FormData(); data.append("json", JSON.stringify(upload));                              
                log( JSON.stringify(upload));
                
                fetch("/?api=stoimost",{method: "POST", body: data})
                .then(response => response.json())
                .then(stoimost => document.getElementById('stoimost').innerText = stoimost.result);
                
                document.querySelectorAll('.card')[0].innerHTML = 
                        
                '<form action="/" method="post"><div class="card__fl">'+
                    '<div class="card__fl_clients_item">'+
                        '<div>'+roomSelect.innerText+'</div>'+
                        '<div>'+JSON.stringify(times)+'</div>'+
                        '<div>'+document.querySelectorAll('.head_el__button_date button')[0].innerText+'</div>'+
                        '<div>Стоимость: <span id="stoimost">0</span> ₽</div>'+
                    '</div>'+
                    ''+
                    '<div class="card__fl_clients_item">'+
                        '<input type="hidden" name="add" value="order">'+
                        '<input type="hidden" name="classid" value="'+roomSelect.parentNode.getAttribute('classid')+'">'+
                        '<input type="hidden" name="date" value="'+document.querySelectorAll('.head_el__button_date button')[0].innerText+'">'+
                        '<input type="hidden" name="times" value=\''+JSON.stringify(times)+'\'>'+
                        '<div>Имя:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name"> </div>'+
                        '<div>Фамилия:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="sename"> </div>'+
                        '<div>Телефон:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="phone"> </div>'+
                        '<div>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email"> </div>'+
                        '<div>Коментарий:&nbsp;<textarea name="commit"></textarea> </div>'+
                    '</div>'+
                    
                    '<div class="card__fl_clients_item_button">'+
                        '<input class="head_el__button_today" type="submit" value="Оформить">'+
                    '</div>'+
                    ''+
                '</div></form>';
//log(document.querySelectorAll('.body__tb_block_new').length);
            if(0 == document.querySelectorAll('.body__tb_block_new').length){
                document.querySelectorAll('.card__fl')[0].innerHTML = ''; //document.querySelectorAll('.card__fl')[0].style.display='none';
            }
            }            
            //this.style.background = 'rgb(0,191,255)';

        });
    });
    
});

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
 