<div class="row">
    <div class="col mb-2" style="min-width: 250px">
        <div style="min-height: 15vh;" class="border mx-2 rounded shadow3d">
            <h3 class=" mb-2 p-2 rounded-top namaBox">
                Suhu 1</h3>
            <div class="row">
                <div class="text-center col">
                    <p>Maximal</p>
                    <h1>{{number_format($data->max('suhu'),2)}}</h1>
                </div>
                <div class="text-center col">
                    <p>Rata - Rata</p>
                    <h1>{{number_format($data->avg('suhu'),2)}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-2" style="min-width: 250px">
        <div style="min-height: 15vh" class="border mx-2 rounded shadow3d">
            <h3 class=" mb-2 p-2 rounded-top namaBox">
                Suhu 2</h3>
            <div class="row">
                <div class="text-center col">
                    <p>Maximal</p>
                    <h1>{{number_format($data->max('suhu'),2)}}</h1>
                </div>
                <div class="text-center col">
                    <p>Rata - Rata</p>
                    <h1>{{number_format($data->avg('suhu'),2)}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-2" style="min-width: 250px">
        <div style="min-height: 15vh" class="border mx-2 rounded shadow3d">
            <h3 class=" mb-2 p-2 rounded-top namaBox">
                RoR</h3>
            <div class="text-center">
                <div class="row">
                    <div class="text-center col">
                        <p>Maximal</p>
                        <h1>{{number_format($data->max('RoR'),2)}}</h1>
                    </div>
                    <div class="text-center col">
                        <p>Rata - Rata</p>
                        <h1>{{number_format($data->avg('RoR'),2)}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-2" style="min-width: 250px">
        <div style="min-height: 15vh" class="border mx-2 rounded shadow3d">
            <h3 class=" mb-2 p-2 rounded-top namaBox">
                Rpm</h3>
            <div class="text-center">
                <div class="row">
                    <div class="text-center col">
                        <p>Maximal</p>
                        <h1>{{round($data->max('rpm'))}} %</h1>
                    </div>
                    <div class="text-center col">
                        <p>Rata - Rata</p>
                        <h1>{{round($data->avg('rpm'))}} %</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>