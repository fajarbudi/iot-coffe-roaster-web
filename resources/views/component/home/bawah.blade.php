<div class="row mt-4">
  <div style="min-width: 400px; overflow: scroll" class="col">
    <div class="row ms-1 mb-3">
      <div class="col">
        <p class="text-capitalize">Nama Tugas :
          <span class="fw-bold ms-2">{{($project) ? $project->namaProject : "-"}}</span>
        </p>
        <p class="mt-0 text-capitalize">Nama Pembuat :
          <span class="fw-bold ms-2">{{($project) ? $project->namaPembuat : "-"}}</span>
        </p>
        <p class="mt-0 text-capitalize">Status :
          <span class="fw-bold ms-2">{{($project) ? $project->status : "-"}}</span>
        </p>
        <p class="mt-0 text-capitalize">Waktu Proses :
          <span class="fw-bold ms-2">{{($project) ? $project->waktuProses : "-"}} Menit</span>
        </p>
        <p class="mt-0 text-capitalize">Waktu Dibuat :
          <span class="fw-bold ms-2">{{($project) ? $project->created_at : "-"}}</span>
        </p>
      </div>
      <div class="col">
        <h1>Tugas Terakhir</h1>
      </div>
    </div>
    <div id="chartData" style="height: 55vh"></div>
    {{-- <a href={{route('home')}} style="position: absolute; bottom: 20px;" class="btn btn-primary">Back
      Home</a>
    --}}
  </div>
  <div style=" min-width: 400px" class="col-1">
    {{-- <div id="maxPower" class="my-5"></div>
    <div id="avgPower" class="my-5"></div> --}}
    <div id="Suhu" class="my-5" style="height: 30vh"></div>
    <div id="Power" class="my-5" style="height: 30vh"></div>
  </div>
</div>
</div>

@push('jQuery')
<script>
  let data = {{ Js::from($data) }};
  console.log(data)
    let dataSuhu = []
    let dataRoR = []
    let dataPower = []
    let dataRpm = []
    let idSuhu = []
    let Tanggal;
    
    $.each( data, function( key, data ) {
        dataSuhu.push(parseFloat(data.suhu))
        dataRoR.push(parseFloat(data.RoR))
        dataPower.push(parseFloat(data.power))
        dataRpm.push(parseFloat(data.rpm))
        Tanggal = data.created_at
        idSuhu.push(key)
    });

    const Average = (data) =>{
      let totalPower = 0
      $.each(data, () =>{
        totalPower += parseFloat(data)
      })
      return totalPower / data.length
    }
// grafik
Highcharts.chart('chartData', {
  chart: {
        type: 'spline',
    },

title: {
    text: ''
},
plotOptions: {
        spline: {
            marker: {
                enabled: false
            },
        }
    },
yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}°C',
            style: {
                color: '#92A1B1'
            }
        },
        title: {
            text: 'Temperature',
            style: {
                color: '#92A1B1'
            }
        },
        opposite: true

    },{ // Secondary yAxis
        gridLineWidth: 0,
        title: {
            text: 'Power & Rpm',
            style: {
                color: '#92A1B1'
            }
        },
        labels: {
            format: '{value} %',
            style: {
                color: '#92A1B1'
            }
        }

    },
    { // Secondary yAxis
        gridLineWidth: 0,
        title: {
            text: 'RoR',
            style: {
                color: '#92A1B1'
            }
        },
        labels: {
            format: '{value}',
            style: {
                color: '#92A1B1'
            }
        }

    },
  
  ],

series: [
{
  name: "Suhu 1",
  color: '#ee005f',
  lineWidth: 4,
  data: [...dataSuhu],
  yAxis: 0,
  pointStart: 1
},
{
  name: "Suhu 2",
  color: '#ff5ba9',
  lineWidth: 4,
  data: [...dataSuhu],
  yAxis: 0,
  pointStart: 1
},
{
  name: "RoR",
  color: '#7c83ff',
  lineWidth: 4,
  data: [...dataRoR],
  yAxis: 2,
  pointStart: 1
},
{
  name: "Power",
  color: '#008f00',
  lineWidth: 4,
  data: [...dataPower],
  yAxis: 1,
  pointStart: 1
},
{
  name: "Rpm",
  color: '#0090ff',
  lineWidth: 4,
  data: [...dataRpm],
  yAxis: 1,
  pointStart: 1
},
]
});

Highcharts.chart('Suhu', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 55
        }
    },
    title: {
        text: 'Suhu 1 & Suhu 2',
        align: 'left'
    },
    subtitle: {
        text: `Tanggal : ${Tanggal}`,
        align: 'left'
    },
    plotOptions: {
        pie: {
            innerSize: 50,
            depth: 30,
        }
    },
    series: [{
        name: '',
        data: [
            ['Max Suhu 1', Math.max(...dataSuhu)],
            ['Min Suhu 1', Math.min(...dataSuhu)],
            ['Min Suhu 2', Math.min(...dataSuhu)],
            ['Max Suhu 2', Math.max(...dataSuhu)],
        ]
    }],
    tooltip: {
            valueSuffix: ' °C'
        }
});

Highcharts.chart('Power', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 55
        }
    },
    title: {
        text: 'Power & Rpm',
        align: 'left'
    },
    subtitle: {
        text: `Tanggal : ${Tanggal}`,
        align: 'left'
    },
    plotOptions: {
        pie: {
            innerSize: 50,
            depth: 30
        }
    },
    series: [{
        name: '',
        data: [
            ['Max Power', Math.max(...dataPower)],
            ['Min Power', Math.min(...dataPower)],
            ['Min Rpm', Math.min(...dataRpm)],
            ['Max Rpm', Math.max(...dataRpm)],
        ]
    }],
    tooltip: {
            valueSuffix: '%',
            color: ['#0067da','#0067da','#0067da','#0067da'],
        }
});

</script>
@endpush