@extends('layout.layout')

@section('title')
Hasil Tugas
@endsection

@section('content')
@php
$first_key = array_key_first($data);
@endphp
<section class="box">
  <div id="sideBar" style="flex-grow: 1" class="sideBar sideBarHid">
    @include('component.sideBar',["namaPage" => "detailTugas"])
  </div>

  <div style="flex-grow: 10" id="content" class="content radiusHid pt-4 px-4">
    @include('component.hasilTugas.content')
  </div>
</section>
@endsection