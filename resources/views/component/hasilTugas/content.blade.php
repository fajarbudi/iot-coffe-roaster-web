<div class="row">
  <div style="min-width: 400px;" class="col">
    <div class="row ms-1 mb-3">
      <div class="col">
        <p class="text-capitalize">Nama Tugas :
          <span class="fw-bold ms-2">{{($data) ? $data[$first_key]->namaProject : "-"}}</span>
        </p>
        <p class="mt-0 text-capitalize">Nama Pembuat :
          <span class="fw-bold ms-2">{{($data) ? $data[$first_key]->namaPembuat : "-"}}</span>
        </p>
        <p class="mt-0 text-capitalize">Status :
          <span class="fw-bold ms-2">{{($data) ? $data[$first_key]->status : "-"}}</span>
        </p>
        <p class="mt-0 text-capitalize">Waktu Proses :
          <span class="fw-bold ms-2">{{($data) ? $data[$first_key]->waktuProses : "-"}} Menit</span>
        </p>
        <p class="mt-0 text-capitalize">Waktu Dibuat :
          <span class="fw-bold ms-2">{{($data) ? $data[$first_key]->created_at : "-"}}</span>
        </p>
      </div>
      <div class="col">
        <h1>Juduul</h1>
      </div>
    </div>
    <div id="container" style="height: 25vh; padding-right: 10vw"></div>
    <div id="chartHasil" style="height: 50vh;"></div>
  </div>
  <div style="height: 90vh; overflow: scroll; min-width: 400px" class="col">
    <table class="table border mt-3">
      <thead>
        <tr>
          <th scope="col">Menit</th>
          <th scope="col">Suhu</th>
          <th scope="col">RoR</th>
          <th scope="col">Power</th>
          <th scope="col">Rpm</th>
        </tr>
      </thead>
      <tbody id="dataTable">
      </tbody>
    </table>
  </div>
</div>


@push('jQuery')
<script>
  let dataSuhu = []
    let dataRoR = []
    let dataPower = []
    let dataRpm = []
    let idSuhu = []
    let data = {{ Js::from($data) }};
    //console.log(data[$first_key])
    $.each( data, function( key, data ) {
        $("#dataTable").prepend(`<tr class="${data.bg}"><th>${data.menit}</th>><td>${data.suhu}</td><td>${data.RoR}</td><td>${data.power}'%'</td><td>${data.rpm}'%'</td></tr>`)
        dataSuhu.push(parseFloat(data.suhu))
        dataRoR.push(parseFloat(data.RoR))
        dataPower.push(parseFloat(data.power))
        dataRpm.push(parseFloat(data.rpm))
        idSuhu.push(data.menit)
    });

    const Average = (data) =>{
      let totalData = 0
      $.each(data, () =>{
        totalData += parseFloat(data)
      })
      return totalData / data.length
    }

//3D Chart
Highcharts.chart('container', {
    chart: {
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 5,
            beta: 15,
            viewDistance: 15,
            depth: 40
        }
    },

    title: {
        text: '',
        align: 'left'
    },

    xAxis: {
        categories: ['RoR', 'Suhu 1', 'Suhu 2', 'Rpm', 'Power']
    },

    yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
            text: '',
            skew3d: true,
            style: {
                fontSize: '16px'
            }
        }
    },

    tooltip: {
        headerFormat: '<b>{point.key}</b><br>',
        pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y}'
    },

    series: [{
        name: 'Maximal',
        data: [Math.max(...dataRoR), Math.max(...dataSuhu), Math.max(...dataSuhu), Math.max(...dataRpm), Math.max(...dataPower)],
    }, {
        name: 'Average',
        data: [Average(dataRoR), Average(dataSuhu), Average(dataSuhu) ,Average(dataRpm), Average(dataPower)],
    },]
});

// grafik
Highcharts.chart('chartHasil', {
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

</script>
@endpush