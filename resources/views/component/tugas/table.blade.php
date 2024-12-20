<table class="table border mt-3">
    <thead>
        <tr>
            <th scope="col">Menit</th>
            <th scope="col">Suhu</th>
            <th scope="col">RoR</th>
        </tr>
    </thead>
    <tbody id="dataTable">
    </tbody>
</table>

@push('jQuery')
<script>
    let dataSuhu = []
    let dataRoR = []
    let dataPower = []
    let dataRpm = []
    let idSuhu = []
    let Sistem = "";
    let RoR;
    let prediksi;

$(document).ready(function () {
    setInterval(() => {
        {$.ajax({ 
        url: '{{route('sensor_json')}}', 
        type: 'GET',
        data: { get_param: 'value' }, 
        success: function (data) {
            let length = data.sensorFull.length;
            let dataSensor = data.sensorFull[length - 1];
         if(data.setting.sistem == "hidup"){
                $("#dataTable").prepend(`<tr><th>${dataSensor.menit}</th><td>${dataSensor.suhu}</td><td>${dataSensor.RoR}</td></tr>`)
                dataSuhu.push(parseFloat(dataSensor.suhu))
                dataRoR.push(parseFloat(dataSensor.RoR))
                dataPower.push(parseFloat(dataSensor.power))
                dataRpm.push(parseFloat(dataSensor.rpm))
                idSuhu.push(dataSensor.id)
                RoR = parseFloat(dataSensor.RoR)
                prediksi = dataSensor.suhu + (dataSensor.RoR * 2)
                Sistem = "hidup"  
         }
        }
    })}
    }, 5000);
});
// grafik
const grafik = Highcharts.chart('cobaaa', {

    chart: {
        type: 'spline',
    },

title: {
    text: 'Logarithmic axis demo'
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

plotOptions: {
        spline: {
            marker: {
                enabled: false
            },
        }
    },


series: [
{
  name: "Suhu 1",
  color: '#ee005f',
  data: dataSuhu,
  lineWidth: 4,
  pointStart: 1,
  yAxis: 0
},
{
  name: "Suhu 2",
  color: '#ff5ba9', 
  data: dataSuhu,
  lineWidth: 4,
  pointStart: 1,
  yAxis: 0
},
{
  name: "RoR",
  color: '#0029ff',
  data: dataRoR,
  pointStart: 1,
  lineWidth: 4,
  yAxis: 2
},
{
  name: "Power",
  color: '#008f00',
  data: dataPower,
  pointStart: 1,
  lineWidth: 4,
  yAxis: 1
},
{
  name: "Rpm",
  color: '#0090ff',
  data: dataRpm,
  pointStart: 1,
  lineWidth: 4,
  yAxis: 1
},
]
});

setInterval(() => {
  grafik.update({
    series: [
{
    name: "Suhu 1",
    data: [...dataSuhu],
},
{
    name: "Suhu 2",
    data: [25],
},
{
    name: "RoR",
    data: [...dataRoR],
},
{
    name: "Power",
    data: [...dataPower],
},
{
    name: "Rpm",
    data: [...dataRpm],
}
]
  })
}, 5000);


const gaugeOptions = {
    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '140%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    exporting: {
        enabled: false
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        tickWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// The Prediksi Suhu gauge
const chartSpeed = Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 350,
        title: {
            text: 'Prediksi Suhu'
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Prediksi Suhu',
        data: [0],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y}</span><br/>' +
                '<span style="font-size:12px;opacity:0.4">Satu Menit Kedepan</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: '°C'
        }
    }]

}));

// The RoR gauge
const chartRpm = Highcharts.chart('container-rpm', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: -50,
        max: 50,
        title: {
            text: 'RoR'
        }
    },

    series: [{
        name: 'RoR',
        data: [0],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y:.1f}</span><br/>' +
                '<span style="font-size:12px;opacity:0.4">' +
                'Setiap 30 Detik' +
                '</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: ' revolutions/min'
        }
    }]

}));

// Bring life to the dials
setInterval(function () {
    // Speed
    let point,
        newVal,
        yAxis,
        inc;

    if (chartSpeed) {
        point = chartSpeed.series[0].points[0];
        inc = Math.round((Math.random() - 0.5) * 100);
        newVal = point.y + inc;

        if (newVal < 0 || newVal > 200) {
            newVal = point.y - inc;
        }

        point.update(prediksi);
    }

    // RPM
    if (chartRpm) {
        point = chartRpm.series[0].points[0];
        inc = Math.random() - 0.5;
        newVal = point.y + inc;

        if (newVal < 0 || newVal > 5) {
            newVal = point.y - inc;
        }

        point.update(RoR);
    }

}, 2000);

</script>
@endpush