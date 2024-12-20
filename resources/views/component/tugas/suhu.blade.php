@php
date_default_timezone_set('Asia/Jakarta');
@endphp
<div class="row">
    <div class="col mb-2" style="min-width: 250px">
        <div style="height: 190px" class="border mx-2 rounded shadow3d">
            <h3 class=" mb-2 p-2 rounded-top namaBox">Waktu</h3>
            <div class="text-center P-2" id="keterangan">
                <p class="border-b">Selesai Pukul</p>
                <h1 id="waktuSelesai"></h1>
            </div>
        </div>
    </div>
    <div class="col mb-2" style="min-width: 300px">
        <div style="height: 190px;" class="border mx-2 rounded shadow3d">
            <h3 class=" mb-2 p-2 rounded-top namaBox">Suhu 1</h3>
            <div class="text-center col">
                <p id="tulisKe"></p>
                <h1 id="tulisSuhu"></h1>
            </div>
        </div>
    </div>
    <div class="col mb-2" style="min-width: 250px">
        <div style="height: 190px" class="border mx-2 rounded shadow3d">
            <h3 class=" mb-2 p-2 rounded-top namaBox">Suhu 2</h3>
            <div class="text-center">
                <p> - </p>
                <h1> - </h1>
            </div>
        </div>
    </div>
    <div class="col">
        @include('component.tugas.setting')
    </div>
    <form action={{ route('setting',$projects->id)}} method="POST" id="selesai">
        @csrf
        @method('PUT')
        <input type="hidden" id="sistem" class="form-control" name="sistem" value="mati">
    </form>
</div>

@push('jQuery')
<script>
    $(document).ready(function () {
    setInterval(() => {$.ajax({
        url: '{{route('sensor_json')}}', 
        type: 'GET',
        data: { get_param: 'value' }, 
        success: function (data) {
        const curentDate = new Date()
        let jam = curentDate.getHours()
        let menit = curentDate.getMinutes()
        let jamSekarang = `${jam < 10 ? "0" : ""}${jam}:${menit < 10 ? "0" : ""}${menit}`
        let length = data.sensorFull.length;
        let dataSuhu = data.sensorFull[length - 1];
        if(data.setting.sistem == "hidup" ){
         $('#tulisSuhu').text(dataSuhu.suhu);
         $('#tulisRoR').text(dataSuhu.RoR);
         $('#tulisKe').text(`ke - ${length}`);
         $('#tulisPrediksi').text(parseFloat(dataSuhu.suhu) + (parseFloat(dataSuhu.RoR) * 2));
        }
        $("#waktuSelesai").text(09.40 - jamSekarang)
        if(jamSekarang >= data.setting.waktuEnd && data.setting.sistem == "hidup"){
            $("#waktuSelesai").text("Selesai")
            if(data.setting.waktuEnd != 0){
                $("#selesai").submit()
            }
         }else{
            $("#waktuSelesai").text(data.setting.waktuEnd)
         }
        }
    });}, 5000);
});
</script>
@endpush