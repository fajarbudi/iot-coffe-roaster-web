<div class="border rounded ms-2 shadow3d setting">
    <div class=" text-start mb-2 py-2 px-3 rounded-top namaBox">
        <h3 class="text-center text-white py-2 d-inline">Setting</h3>
        <div class="d-inline float-end">
            <button
                style="box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.4), 0px 7px 13px -3px rgba(0, 0, 0, 0.3), inset 0px -3px 0px rgba(0, 0, 0, 0.2)"
                type="submit" class="btn btn-sm btn-success" id="btnSubmit">Hidupkan</button>
            <form action={{route('setting',$projects->id)}} method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="sistem2" class="form-control" name="sistem" value="mati">
                <button
                    style="box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.4), 0px 7px 13px -3px rgba(0, 0, 0, 0.3), inset 0px -3px 0px rgba(0, 0, 0, 0.2)"
                    type="submit" class="btn btn-sm visually-hidden" id="btnSistem"></button>
            </form>
        </div>
    </div>
    <div class=" mx-2">
        <form id="setting" class="row">
            @csrf
            @method('PUT')
            <input type="hidden" id="sistem2" class="form-control" name="sistem" value="hidup">
            <div class="mb-1 mx-4 col" style="min-width: 160px">
                <label for="rpm" class="form-label">Max Suhu : <span id="textmaxSuhu" class="ms-3">100</span>°C</label>
                <div class="d-flex">
                    <button onclick="kurang('maxSuhu')" class="btnHitung">-</button>
                    <input oninput="inputRealTime(this.value,'textmaxSuhu')" type="range" class="form-range pt-2 px-2"
                        id="maxSuhu" name="maxSuhu" min="0" max="400" value="100">
                    <button onclick="tambah('maxSuhu',400)" id="tambahSuhu" class="btnHitung">+</button>
                </div>
            </div>
            <div class="mb-1 mx-4 col" style="min-width: 160px">
                <label for="rpm" class="form-label">Rpm: <span id="textrpm" class="ms-3">10</span>%</label>
                <div class="d-flex">
                    <button onclick="kurang('rpm')" class="btnHitung">-</button>
                    <input oninput="inputRealTime(this.value, 'textrpm')" onchange="inputChange()" type="range"
                        class="form-range pt-2 px-2" id="rpm" name="rpm" value="10">
                    <button onclick="tambah('rpm',100)" class="btnHitung">+</button>

                </div>
            </div>
            <div class="mb-1 mx-4 col" style="min-width: 160px">
                <label for="servo" class="form-label">Power: <span id="textservo" class="ms-3">20</span>%</label>
                <div class="d-flex mb-2">
                    <button onclick="kurang('servo')" class="btnHitung">-</button>
                    <input oninput="inputRealTime(this.value,'textservo')" onchange="inputChange()" type="range"
                        class="form-range pt-2 px-2" id="servo" name="servo" value="20">
                    <button onclick="tambah('servo',100)" class="btnHitung">+</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('jQuery')
<script>
    const tambah = (id,max) => {
        let nilai = $(`#${id}`).val()
        $(`#${id}`).val(parseInt(nilai) + 5)
        $(`#text${id}`).text((parseInt(nilai) + 5 >= max) ? `${max}` : parseInt(nilai) + 5)
    }
    const kurang = (id) => {
        let nilai = $(`#${id}`).val()
        $(`#${id}`).val(parseInt(nilai) - 5)
        $(`#text${id}`).text(((parseInt(nilai) - 5 < 0)) ? '0' : parseInt(nilai) - 5)
    }

    const inputRealTime = (value,id) =>{
        $(`#${id}`).text(value)
    }

    const inputChange = () =>{
        $("#setting").submit()
    }

  $("#btnSubmit").on("click", (event) => {
    event.preventDefault();
    $("#setting").submit()
  })
  $("#setting").on("submit", function (event){
    event.preventDefault();
    console.log( $( this ).serialize() );
    $.ajax({
     type: "POST",
     url: '{{route('setting',$projects->id)}}',
     data: $( this ).serialize(),
    });
  })

$(document).ready(function () {
    setInterval(() => {
        {$.ajax({ 
        url: '{{route('sensor_json')}}', 
        type: 'GET',
        data: { get_param: 'value' }, 
        success: function (data) { 
            if(data.setting.sistem == "hidup"){
                $("#btnSistem").addClass("btn-danger")
                $("#btnSistem").removeClass("visually-hidden")
                $("#btnSistem").text("Matikan")
                $("#btnSubmit").addClass("visually-hidden")
            }
        }
    })}
    }, 2000);
});

</script>
@endpush