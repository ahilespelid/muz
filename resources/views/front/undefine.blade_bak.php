@extends('layouts.app')

@section('title', 'Бронирование классов')
@section('description', 'Бронирование классов')

@section('content')
            <h1>Бронирование классов</h1>
            
<div class="wrapper">
  <header>
    <h1> Kids’ timetable generator</h1>
  </header>
  <div class="button-wrapper">
    <button data-btn type="button">Sort activities</button>
    <button class="clear-button" data-clear type="button">Clear timetable</button>
  </div>
  <div class="grid">
    <table>
      <thead>
      <th scope="col">Time</th>
@php
list($y, $m, $d) = explode('-', date('Y-m-d')); $dOfm = date('t',mktime(0, 0, 0, $m, 1, $y));
@endphp

@for($j=date('j'); $j<$dOfm; $j++)<th scope="col">{{ $j }}</th>@endfor
      </thead>
      <tbody>
@for($i = 0; $i<24; $i++)
        <tr>
          <th scope="row">{{ $i }}:00</th>
          <td><span><div class="activity" style="--bg: #adff8a; --r: -4deg">Running</div></span></td>
          <td><span><div class="activity" style="--bg: #adff8a; --r: -4deg">Painting</div></span></td>
          <td><span><div class="activity" style="--bg: #adff8a; --r: 1.25deg">Treasure hunt</div></span></td>
          <td><span><div class="activity" style="--bg: #adff8a; --r: -4deg">Treasure hunt</div></span></td>
          <td><span><div class="activity" style="--bg: #adff8a; --r: -4deg">Treasure hunt</div></span></td>
          <td><span><div class="activity" style="--bg: #adff8a; --r: -4deg">Treasure hunt</div></span></td>
          <td><span><div class="activity" style="--bg: #adff8a; --r: -4deg">Treasure hunt</div></span></td>
          <td><span><div class="activity" style="--bg: #ff8af5; --r: 2.5deg">Treasure hunt</div></span></td>
        </tr>
@endfor
      </tbody>
    </table>

    
  </div>
</div>
@endsection