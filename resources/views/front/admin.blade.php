@extends('layouts.admin')

@section('title', 'Бронирование классов')
@section('description', 'Бронирование классов')

@section('body')

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="/">
                    <b class="logo-abbr"><img src="/assets/images/logo.png" alt=""> </b>
                    <span class="logo-compact"><img src="/assets/images/logo-compact.png" alt=""></span>
                    <span class="brand-title">
                        <img src="/assets/images/logo-text.png" alt="">
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content clearfix">
                {{--
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                --}}
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Объекты</li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Корпуса</span>
                        </a>
                        <ul aria-expanded="false">
@foreach($Corpuses ?? [] as $k => $item)
@if(!empty($item['muzid']) && !empty($item['name'])) 
                            <li><a href="{{ route('front.admin', ['baseId' => $item['muzid']]) }}">{{ $item['name'] }}</a></li>
@endif
@endforeach
                            <!-- <li><a href="./index-2.html">Home 2</a></li> -->
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Классы</span>
                        </a>
                        <ul aria-expanded="false">
@foreach($curClasses ?? [] as $k => $item)
@if(!empty($item['muzid']) && !empty($item['name'])) 
                            <li><a href="#{{ $item['muzid'] }}">{{ $item['name'] }}</a></li>
@endif                            
@endforeach
                            <!--li><a href="./layout-wide.html">Wide</a></li-->
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="container-fluid mt-3">
                <div class="row">
                    
@foreach($Corpuses ?? [] as $k => $item)
@if(!empty($item['muzid']) && !empty($item['name'])) 
                    <a href="{{ route('front.admin', ['baseId' => $item['muzid']]) }}" class="col-lg-3 col-sm-6">
                        <div class="card gradient-{{ ($item['muzid'] == $curCorpuses['muzid']) ? 2 : 1 }}">
                            <div class="card-body">
                                <h3 class="card-title text-white">{{ $item['name'] }}</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">{{ count($CorpusesClasses[$item['muzid']]) }}</h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                            </div>
                        </div>
                    </a>
                    
 @endif
@endforeach                   
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="active-member">
                                    <div class="table-responsive">
                                        <form enctype="multipart/form-data" action="" method="post">                                        
                                        <table class="table table-xs mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Название</th>
                                                    <th>Фото</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><img src="{{ $curCorpuses['img'] ?? '/assets/images/avatar/corpusses.png' }}" class=" rounded-circle mr-3" alt="">{{ $curCorpuses['name'] ?? '' }}</td>
                                                    <td>
                                                        <span><input type="file" name="img" accept="image/png, image/jpeg"></span>
                                                        <input type="hidden" name="corpusid" value="{{ $curCorpuses['id'] }}">
                                                        <input type="hidden" name="up" value="corpus">
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div class="progress" style="height: 6px">
                                                                <div class="progress-bar bg-success" style="width: 50%"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><i class="fa fa-circle-o text-success  mr-2"></i> <input type="submit" value="Обновить" /></td>
                                                    <td>
                                                        <span>Last Update</span>
                                                        <span class="m-0 pl-3">{{ $curCorpuses['updated_at'] ?? '' }}</span>
                                                    </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                        </form>
                                        <table class="table table-xs mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Название</th>
                                                    <th>Цена</th>
                                                    <th>Фото</th>
                                                </tr>
                                            </thead>
                                            <tbody>
@foreach($curClasses ?? [] as $k => $item)
@if(!empty($item['muzid']) && !empty($item['name'])) 
                                                <tr>
                                                    <form enctype="multipart/form-data" action="" method="post">
                                                    <td><img src="{{ $item['img'] ?? '/assets/images/avatar/classes.png' }}" class=" rounded-circle mr-3" alt="">{{ $item['name'] ?? '' }}</td>
                                                    <td><input type="number" name="price" value="{{ $item['price'] ?? '' }}"></td>
                                                    <td>
                                                        <span><input type="file" name="img" accept="image/png, image/jpeg"></span>
                                                        <input type="hidden" name="classid" value="{{ $item['id'] }}">
                                                        <input type="hidden" name="up" value="class">
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div class="progress" style="height: 6px">
                                                                <div class="progress-bar bg-success" style="width: 50%"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><i class="fa fa-circle-o text-success  mr-2"></i> <input type="submit" value="Обновить" /></td>
                                                    <td>
                                                        <span>Last Update</span>
                                                        <span class="m-0 pl-3">{{ $item['updated_at'] ?? '' }}</span>
                                                    </td>
                                                    </form>
                                                </tr>
@endif                            
@endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>

            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
@endsection