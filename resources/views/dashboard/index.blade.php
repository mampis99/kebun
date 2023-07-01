@extends('templates/index')

@section('content')
<div class="content">
  <div class="container-fluid">
    {{-- <div class="row"> --}}
      <form action="enhanced-results.html">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="row">
                  <div class="col-6">
                      <div class="form-group">
                          <label>Perusahaan:</label>
                          <select class="select2 selectPerusahaan" style="width: 100%;">
                            @foreach ($perusahaan as $item)
                              <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Kebun:</label>
                      <select class="select2 selectKebun" style="width: 100%;">

                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" class="form-control form-control-lg" id="tgl">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-lg btn-default" onclick="chart()">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </form>
    {{-- </div> --}}
    <div class="row">
      <div class="col-12" >
        <div id="setChart"></div>
      </div>
    </div>
  </div>
</div>
@endsection


@push('js')
<script type="text/javascript">
    
  var waktu = [];
  var nilai = [];
  var labelSensor = '';
    
  var salesGraphChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        ticks: {
          // fontColor: '#efefef'
        },
        gridLines: {
          display: false,
          // color: '#efefef',
          drawBorder: false
        }
      }],
      yAxes: [{
        ticks: {
          // stepSize: 5000,
          // fontColor: '#efefef'
        },
        gridLines: {
          display: true,
          // color: '#efefef',
          drawBorder: false
        }
      }]
    }
  }

  $('.selectPerusahaan').select2({
    theme: 'bootstrap4'
  });

  $('.selectPerusahaan').on('change', function () {
    $('.selectKebun').empty();  
  });

  $('.selectKebun').select2({
    theme: 'bootstrap4',
    ajax:{
      type: "POST",
      url : '{{ route('api-kebun') }}',
      data: function (e) {
        return {
          '_id' : $('.selectPerusahaan').val(),
        }
      },
      processResults: function (e) {
        return {
          results : $.map(e, function (item) {
            return {
              text : item.nama,
              id : item.id 
            }
          })
        }
      }
    }
  });

  $('#tgl').daterangepicker();
  
  chart();
  function chart() {
    var _idPerusahaan = $('.selectPerusahaan').val();
    var _idKebun = $('.selectKebun').val();
    var _tgl = $('#tgl').val();

    $.ajax({
      type : 'POST',
      url : '{{ route('sensor-log') }}',
      data : {
        '_idPerusahaan' : _idPerusahaan,
        '_idKebun' : _idKebun,
        '_tgl' : _tgl
      },
      success : function (e) {
        $.each(e, function (i, val) {
          $.each(val.data, function (x, item) {
            if ( x == 0 ) {
              labelSensor = item.nama_node;
              $.each(item.data, function (y, dt) {
                waktu.push(dt.waktu);
                nilai.push(dt.nilai);
              });  

            }
          });
          elemnetChart(val.id_kebun, val.nama, val.data, waktu, nilai);

        });
      }
    });
  }

  function elemnetChart(idKebun, kebun, node, waktu, nilai) {
    var element = `<div class="card">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="fas fa-th mr-1"></i>
          `+kebun+`
        </h3>
      </div>
      <div class="card-body">
        <canvas class="chart" id="line-chart-`+idKebun+`" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
      <div class="card-footer bg-transparent">
        <div class="row" id="setElementKnob`+idKebun+`">
          
        </div>
      </div>
    </div>`;

    $('#setChart').append(element);
    
    var salesGraphChartCanvas = $('#line-chart-'+idKebun).get(0).getContext('2d');
    var salesGraphChartData = {
          // labels: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
          labels: waktu,
          datasets: [
            {
              type: 'line',
              backgroundColor: 'transparent',
              borderColor: '#007bff',
              pointBorderColor: '#007bff',
              pointBackgroundColor: '#007bff',
              fill: false,
              data: nilai
            }
          ]
        }
    var salesGraphChart = new Chart(salesGraphChartCanvas, {
          type: 'line',
          data: salesGraphChartData,
          options: salesGraphChartOptions
        });

    elementKnob(idKebun, node);
  }

  function elementKnob(idKebun, node) {
    var element = '';
    // console.log(node);
    $.each(node, function (i, item) {
      // console.log(item.data);
      waktu = [];
      nilai = [];
      $.each(item.data, function (y, dt) {
                waktu.push(dt.waktu);
                nilai.push(dt.nilai);
              }); 
      var waktuJson = JSON.stringify(waktu);
      var nilaiJson = JSON.stringify(nilai);

      element += `<div class="col-4 text-center">
                     <input type="text" class="knob" data-readonly="true" value="`+item.nilai+`" data-angleArc="250" data-angleOffset="-125" data-width="70" data-height="70"
                        data-fgColor="#39CCCC">
                     <div> 
                        <button type="button" class="btn btn-info selectChart" data-waktu='`+waktuJson+`' data-nilai='`+nilaiJson+`'> `+item.nama_node+` </button>  
                     </div> 
                     
                   </div>`;

    });

    $('#setElementKnob'+idKebun).html(element);
    $('.knob').knob();
  }

  $(document).on("click", ".selectChart", function (event) {
    var waktu = $(this).attr('data-waktu');
    var nilai = $(this).attr('data-nilai');

    var waktuJson = jQuery.parseJSON(waktu);
    var nilaiJson = jQuery.parseJSON(nilai);
    
    var salesGraphChartCanvas = $('#line-chart-1').get(0).getContext('2d');
    var salesGraphChartData = {
          // labels: ['2011 Q1', '2011 Q2'],
          labels: waktuJson,
          datasets: [
            {
              type: 'line',
              backgroundColor: 'transparent',
              borderColor: '#007bff',
              pointBorderColor: '#007bff',
              pointBackgroundColor: '#007bff',
              fill: false,
              // data : [20, 40]
              data: nilaiJson
            }
          ]
        }
    var salesGraphChart = new Chart(salesGraphChartCanvas, {
          type: 'line',
          data: salesGraphChartData,
          options: salesGraphChartOptions
        });
  })

  // function selectChart(data) {
  //   console.log(data);
  //   var salesGraphChartCanvas = $('#line-chart-1').get(0).getContext('2d');
  //   var salesGraphChartData = {
  //         labels: ['2011 Q1', '2011 Q2'],
  //         // labels: waktu,
  //         datasets: [
  //           {
  //             type: 'line',
  //             backgroundColor: 'transparent',
  //             borderColor: '#007bff',
  //             pointBorderColor: '#007bff',
  //             pointBackgroundColor: '#007bff',
  //             fill: false,
  //             data : [20, 40]
  //             // data: nilai
  //           }
  //         ]
  //       }
  //   var salesGraphChart = new Chart(salesGraphChartCanvas, {
  //         type: 'line',
  //         data: salesGraphChartData,
  //         options: salesGraphChartOptions
  //       });
    
  // }
</script>
@endpush