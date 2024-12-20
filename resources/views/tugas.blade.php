@extends('layout.layout')

@section('title')
Proses
@endsection

@section('content')
<section class="box">
  <div id="sideBar" style="flex-grow: 1" class="sideBar sideBarHid">
    @include('component.sideBar',["namaPage" => "proses"])
  </div>
  <div style="flex-grow: 10" id="content" class="content radiusHid pt-4 px-4">
    <div id="form"></div>
    @include('component.tugas.suhu')
    <div class="row pt-4">
      <div class="col">
        <div class="row">
          <div id="container-speed" style="min-width: 300px; height: 200px;" class=" col"></div>
          <div id="container-rpm" style="min-width: 300px; height: 200px;" class=" col"></div>
        </div>
        <div id="cobaaa" style="height: 60vh;"></div>
      </div>
      <div style=" height: 70vh; overflow: scroll; min-width: 400px" class="col">
        <h2 class="text-center text-capitalize py-2">Data Tabel <span class="ms-3">{{$projects->namaProject}}</span>
        </h2>
        @include('component.tugas.table')
      </div>
    </div>
  </div>
  {{-- <div class="p-2">
    <form action={{route('setting',1)}} method="POST">
      @csrf
      <button type="submit" class="btn mt-2">cobaaa2</button>
    </form>
  </div> --}}
</section>
@endsection