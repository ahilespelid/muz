@extends('layouts.widget')

@section('title', 'Бронирование классов')
@section('description', 'Бронирование классов')

@section('body')
	<div class="main ">

		<div class="content-wrapper" id="content">
			<div class="my__wrapper--table" id="calendar_page">
				<div class="select-page-content-wrapper">
					<div class="table-wrap my_box">
						<div class="table-hour tr tr-2x">
							<div class="td mounth my_box my_box-center my_box--end">
								<div class="btn-group bootstrap-select select-month asdas">
									<a href="widget?classId={{ $curClass['id'] ?? ' ' }}" type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" role="button" title="{{ $curDate['monthRus'] ?? ' ' }}">{{ $monthShort[$curDate['month'] - 1] ?? ' ' }}</a>
								</div>
							</div>
 @foreach($curTimes as $ctime)                             
 							<div class="td td-row-{{  explode(':', $ct = ($ctime ?? ' : '))[0] }}">{{  $ct ?? '' }} </div>
 @endforeach                             

						</div>
						<div id="table" class="my_box">
@for($i=0, $c=count($periodWidget); $i<$c; $i++)
							<div class="tr tr-{{ $i }}" data-date="{{ $periodWidget[$i]['date']->format('d').' '.$month[$periodWidget[$i]['date']->format('m')-1].' '.$periodWidget[$i]['date']->format('Y') }}">
								<div class="td days td-col-{{ $i }}">
									<p class="text-center">{{ $periodWidget[$i]['weekday'] ?? ' ' }}</p>
									<p class="text-center">{{ $periodWidget[$i]['day'] ?? ' ' }}</p>
								</div>
@php $col=$i+1; $row=1 @endphp
@foreach(App\Http\Controllers\HomeController::getOrdersFromOurOneDay($curClass['id'], $periodWidget[$i]['date']->format('Y-m-d'), $curTimes) as $time => $order)
    @if(!empty($order))
                                                                <div class="td td-time td-col-{{ $col }} td-row-{{ $row }} earReserv" data-time="{{ $time ?? ' ' }}">
                                                                </div>    
    @else
								<div class="tr-{{ $i }} td td-time td-col-{{ $col }} td-row-{{ $row }}" data-price="{{ $curClass['price'] ?? ' ' }}" data-time="{{ $time ?? ' ' }}">
									<div class="priceReserve"> {{ $curClass['price'] ?? ' ' }} ₽</div>
								</div>
    @endif
@php $row++; @endphp                                                                
@endforeach
							</div>
@endfor

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="before-footer"></div>
	<footer>
		<div class="container">
			<div class="footer-inner">
				<div class="footer-items my_box my_box-start my_box--between">
					<div class="footer-items__item footer-items__item-left">
						<div id="base-img" class="view_photo"> <img src="{{ $curClass['img'] ?? '/assets/admin/images/avatar/classes.png' }}">
							<div id="base-img" class="base_img__btn"> </div>
						</div>
						<div class="footer-selected-box your_change">
							<div class="footer_info">
								<ul class="my_list-unstyled footer-selected-list">
									<li> <span class="footer-selected-list__value footer_data_base">{{ $curCorpuses['name'] ?? ' ' }}</span> </li>
									<li> <span class="footer-selected-list__value footer_data_room">{{ $curClass['name'] ?? ' ' }} </span> </li>
								</ul>
								<p><span class="footer-date"></span></p>
							</div>
							<div id="forma"></div>
						</div>
					</div>
					<div id="footer-item-right" class="my_box my_box-start my_box--end footer-items__item footer-items__item-right">
						<div class="my_box my_box-column footer-total-block">
							<div class="footer-cost-box my_box my_box-column footer_reserve_info">
								<h4 class="my_box my_box-column totalSum"></h4></div>
							<div class="my_box my_box-column footer-prepay-info"> <span class="footer-prepay-label">Размер предоплаты:</span>
								<h4 class="footer-prepay-value">0</h4> </div>
						</div>
						<div id="footer-next-btn" class="footer-next-btn-box">
							<a class="footer-next-btn-box__button_button-gradient my_box my_box-center my_box--center next_button_move next_button_check" onclick="addOrderSubmit()"> <span>Далее</span> </a>
@if(!empty($addOrderNotification))
@foreach($addOrderNotification ?? [] as $notificid => $item)
                        <div class="caption comment"><?=str_replace('PHP_EOL', '<br>', $item);?></div>
@endforeach
@endif

						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<script type="text/javascript" id="">

	</script>

@endsection