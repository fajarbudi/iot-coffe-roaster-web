@extends('layout.layout')

@section('title')
Home
@endsection

@section('content')
<section class="box">
  <div id="sideBar" style="flex-grow: 1" class="sideBar sideBarHid">
    @include('component.sideBar',["namaPage" => "home"])
  </div>
  <div style="flex-grow: 10" id="content" class="content radiusHid pt-4 px-4">
    @include('component.home.atas')
    @include('component.home.bawah')
  </div>
</section>
@endsection