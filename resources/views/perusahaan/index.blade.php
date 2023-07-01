@extends('templates/index')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-primary">
          <form>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Nama Perusahaan</label>
                    <input type="text" class="form-control" id="inputName" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="">Singkatan</label>
                    <input type="text" class="form-control" id="inputSingkatan" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="">Alamat</label>
                    <input type="text" class="form-control" id="inputAlamat" placeholder="">
                  </div>
                  
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Dirut</label>
                    <input type="text" class="form-control" id="inputDirut" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="">Telp.</label>
                    <input type="text" class="form-control" id="inputTelp" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="">Kota</label>
                    <input type="text" class="form-control" id="inputKota" placeholder="">
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="button" class="btn btn-primary" onclick="addPerusahaan()">Submit</button>
              {{-- <button type="button" onclick="tes()">tes</button> --}}
            </div>
          </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Perusahaan</h3>
                    </div>
                    <div class="card-body table-responsive ">
                      {{-- <a class="btn btn-sm btn-success" href="{{ route('perusahaan-form') }}"><span class="fa fa-plus"></span></a> --}}
                      <table class="table table-hover text-nowrap" id="tbPerusahaan">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Opsi</th>
                            <th>Nama</th>
                            <th>Singkatan</th>
                            <th>Dirut</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Telp.</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
    //     $('#tgl').datetimepicker({
    //         format: 'YYYY-MM-DD'
    // });
    // $("#tgl").on("dp.change", function (e) {
    //     var tgl = $(this).val();
    // });
  // function tes() {
  //   notif(200, "ok");
  // }

  var tbPerusahaan = '';
      tbPerusahaan = $('#tbPerusahaan').DataTable({
          processing: true,
          serverside: true,
          ajax: { 
                  type : 'GET',
                  url  : '{{ route('perusahaan-datatable')}}',
                }, 
          columns:[
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'opsi', name: 'opsi'},
                    {data: 'nama', name: 'nama'},
                    {data: 'singkatan', name: 'singkatan'},
                    {data: 'dirut', name: 'dirut'},
                    {data: 'alamat', name: 'alamat'},
                    {data: 'kota', name: 'kota'},
                    {data: 'telp', name: 'telp'},
                    {data: 'flag', name: 'flag'},
                  ]
      });
  
  function addPerusahaan() {
    var nama = $('#inputName').val();
    var singkatan = $('#inputSingkatan').val();
    var dirut = $('#inputDirut').val();
    var alamat = $('#inputAlamat').val();
    var kota = $('#inputKota').val();
    var telp = $('#inputTelp').val();

    $.ajax({
      type : 'POST',
      url : '{{ route('perusahaan-add') }}',
      data : { 
              'nama' : nama,
              'singkatan' : singkatan,
              'dirut' : dirut,
              'alamat' : alamat,
              'kota' : kota,
              'telp' : telp,
              // 'status' : status
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 200) {
          clearForm();
          tbPerusahaan.ajax.reload();
        }
      }
    });
  }

  function clearForm() {
    $('#inputName').val("");
    $('#inputSingkatan').val("");
    $('#inputDirut').val("");
    $('#inputAlamat').val("");
    $('#inputKota').val("");
    $('#inputTelp').val("");
  }

</script>
@endpush