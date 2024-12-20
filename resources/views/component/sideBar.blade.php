<div>
    <h1 class="text-center mb-4 px-3 py-2">JUDUUUL</h1>
    <div class="pt-4">
        <h6 class="ps-2">Pages</h6>
        <a href="{{ route('home') }}" class="namaPage {{($namaPage == 'home') ? 'text-white' : ''}}">
            <i class="bi bi-house me-1 mb-1"></i>
            Home
        </a>
        <a href="{{ route('listTugas') }}" class="namaPage {{($namaPage == 'listTugas') ? 'text-white' : ''}}">
            <i class="bi bi-card-list me-1 mb-1"></i>
            DaftarTugas</a>
    </div>
    <div class="pt-4">
        <h6 class="ps-2">Dynamic Pages</h6>
        <a href="" class="namaPage {{($namaPage == 'proses') ? 'text-white' : ''}}">
            <i class="bi bi-activity me-1 mb-1"></i>
            Proses</a>
        <a href="" class="namaPage {{($namaPage == 'detailTugas') ? 'text-white' : ''}}">
            <i class="bi bi-journals me-1 mb-1"></i>
            Detail Tugas
        </a>
    </div>
    <div style="position: absolute; bottom: 10px; width: 250px">
        <p class="text-center">Nama Alat</p>
        <p class="text-center">Deskripsi Alat</p>
    </div>
    <button id="tutup" class="shadow3d">Menu</button>
</div>

@push('Js')
<script>
    $("#tutup").on("click", () =>{
    $("#sideBar").toggleClass("sideBarHid")
    $("#content").toggleClass("radiusHid")
})
</script>
@endpush