@extends('layout.layout')

@section('title')
Daftar Tugas
@endsection

@section('content')
<section class="box">
    <div id="sideBar" style="flex-grow: 1" class="sideBar sideBarHid">
        @include('component.sideBar',["namaPage" => 'listTugas'])
    </div>
    <div style="flex-grow: 10" id="content" class="content radiusHid pt-4 px-4 delPadding">
        @include('component.daftarTugas.content')
    </div>
</section>
@endsection