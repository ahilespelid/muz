<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description')">    
        <title>@yield('title')</title>

	<link rel="shortcut icon" type="image/png" href="https://widget.musbooking.com/favicon.png">
        
	<link rel="stylesheet" href="/assets/widget/css/all.css">
        <link rel="stylesheet" href="/assets/widget/css/icon.css">
	<link rel="stylesheet" href="/assets/widget/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/widget/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="/assets/widget/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets/widget/css/style.css">
	<link rel="stylesheet" href="/assets/widget/css/media.css">
        
        <style>
        #forma {
            all: initial;
        }
        #forma * {
            all: unset
        }
        #forma>div{display: block; width: 100%;}
        #forma input,#forma textarea{border: 1px solid #000; width: 100%}
        #forma input{}
        .card__fl_clients_item{display: block;}
        </style>

	<script type="text/javascript">
            function addOrderSubmit(){
                //console.log('click');
                let input_textarea = document.getElementById('addOrder').querySelectorAll('input,textarea');
                let form_new = document.createElement('form'); form_new.action = '/widget'; form_new.method = 'POST';
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
            
            document.addEventListener("DOMContentLoaded", () => {
@foreach($addOrderNotification ?? [] as $notificid => $item)
    @if(!empty($item))
    
                       alert('<?=str_replace('PHP_EOL', "\t '\n+'", $item);?>');
    @endif
@endforeach

            let priceReserve = document.querySelectorAll('.priceReserve'); //console.log(priceReserve);
            
            priceReserve.forEach((i, k) => {
                i.parentNode.addEventListener('click', function(e){
                    let tr = this.parentNode;
                    let issetNew = document.querySelectorAll('.nowOrder');
                    //console.log(issetNew); //tr.classList[1] == issetNew.classList[2]
                    //console.log('');

                    if(0 == issetNew.length || issetNew[0].classList.contains(this.classList[0])){
                        this.classList.toggle('nowOrder');
                        this.classList.toggle('earReserv');
                        
                        let forma = document.getElementById('forma');
                        let nowOrder = document.querySelectorAll('.nowOrder');

                        let times = [], price = 0;
                        for(let i=0;i<nowOrder.length;i++){
                            price += parseInt(nowOrder[i].dataset.price)
                            times.push(nowOrder[i].dataset.time);
                        } 
 
                        //console.log(tr.dataset.date);
                        //console.log(JSON.stringify(times));

                        forma.innerHTML = 
                        '<div class="card__fl_clients_item">'+
                            '<div>Стоимость: <span id="stoimost">'+price+'</span> ₽</div>'+
                        '</div>'+
                        ''+
                        '<div class="card__fl_clients_item">'+
                            '<div id="addOrder">'+
                            '<input type="hidden" name="add" value="order">'+
                            '<input type="hidden" name="isour" value="1">'+
                            '<input type="hidden" name="DOMAIN" value="<?=$_SERVER['SERVER_NAME']?>">'+
                            '<input type="hidden" name="classid" value="<?=$curClass['muzid']?>">'+
                            '<input type="hidden" name="date" value="'+tr.dataset.date+'">'+
                            '<input type="hidden" name="times" value=\''+JSON.stringify(times)+'\'>'+
                            '<div>Имя:&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name" value=""></div>'+
                            '<div>Фамилия:&emsp;&emsp;&nbsp;&nbsp;&nbsp;<input type="text" name="sename" value=""></div>'+
                            '<div>Телефон без +7:<input type="text" name="phone" value=""></div>'+
                            '<div>Email:&emsp;&emsp;&emsp;&emsp;&nbsp;<input type="text" name="email" value=""></div>'+
                            '<div>Коментарий:&nbsp;<textarea name="comment" cols="22"></textarea></div>'+
                            '</div>'+
                        '</div>';
                        
                    }

            });});});
	</script>
</head>
<body class="common-home">@yield('body')</body></html>