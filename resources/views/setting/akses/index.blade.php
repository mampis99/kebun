@extends('templates/index')

@section('content')
<div class="content">
    <div class="container-fluid">

      <div class="modal fade" id="modalListFitur">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Fitur</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <table width="100%" class="table" id="listFitur">
                    <thead>
                      <tr>
                        <th>Opsi</th>
                        <th>Fitur</th>
                        <th>Parent</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

        <div class="row">
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="form-group">
                        <label for="">Perusahaan</label>
                        <select name="" class="form-control" id="inputIdPerusahaan">
                          <option value="{{ base64_encode(0) }}">All</option>
                          @foreach ( $perusahaan as $v )
                            <option value="{{ base64_encode($v->id) }}">{{  $v->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Users Level</label>
                        <input type="text" class="form-control" id="inputIdUsersLevel" value="" disabled >
                        <input type="text" class="form-control" id="inputUsersLevel">
                      </div>
                        <button type="button" class="btn btn-default"><i class="fa fa-sync-alt"></i></button>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalListFitur"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="card-body table-responsive">
                      <table class="table table-hover text-nowrap" id="tbListAkses">
                        <thead>
                          <tr>
                            <th>Opsi</th>
                            <th>Fitur</th>
                            <th>Parent</th>
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

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Responsive Hover Table</h3>
                    </div>
                    <div class="card-body table-responsive">
                      <table class="table table-hover text-nowrap" id="tbAkses">
                        <thead>
                          <tr>
                            <th>Opsi</th>
                            <th>No.</th>
                            <th>Perusahaan</th>
                            <th>Nama</th>
                            <th>Fitur</th>
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

   var tbAkses = '';
       tbAkses = $('#tbAkses').DataTable({
           processing: true,
           serverside: true,
           ajax: { 
                   type : 'GET',
                   url  : '{{ route('akses-datatable')}}',
                 }, 
           columns:[
                    {data: 'opsi', name: 'opsi'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama_perusahaan', name: 'nama_perusahaan'},
                    {data: 'nama', name: 'nama'},
                    {data: 'fitur', name: 'fitur'},
                    //  {data: 'icon', name: 'icon'},
                    //  {data: 'parent', name: 'parent'},
                   ]
       });

  var tbListAkses = '';
      tbListAkses = $('#tbListAkses').DataTable({
          processing: true,
          serverside: true,
          ajax: { 
                  type : 'POST',
                  url  : '{{ route('akses-list')}}',
                  data : function (e) {
                    e.idFitur = $('#inputIdUsersLevel').val();
                  }
                }, 
          columns:[
                    {data: 'opsi', name: 'opsi'},
                    {data: 'fitur', name: 'fitur'},
                    {data: 'parent', name: 'parent'},
                  ]
      });

  var listFitur = '';
      listFitur = $('#listFitur').DataTable({
          processing: true,
          serverside: true,
          ajax: { 
                  type : 'GET',
                  url  : '{{ route('fitur-list-datatable')}}',
                }, 
          columns:[
                  {data: 'opsi', name: 'opsi'},
                  {data: 'nama', name: 'nama'},
                  {data: 'parent', name: 'parent'},
                  ]
      });    

  function addFitur(id) {
    var inputIdPerusahaan = $('#inputIdPerusahaan').val();
    var inputIdUsersLevel = $('#inputIdUsersLevel').val();
    var inputUsersLevel = $('#inputUsersLevel').val();

    $.ajax({
      type : 'POST',
      url : '{{ route('akses-add') }}',
      data : { 
              'inputIdFitur' : id,
              'inputIdPerusahaan' : inputIdPerusahaan,
              'inputIdUsersLevel' : inputIdUsersLevel,
              'inputUsersLevel' : inputUsersLevel,
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 200) {
          $('#inputIdUsersLevel').val(e.idAkses);
          tbListAkses.ajax.reload();
        }

        if (e.new == "Y") {
          tbAkses.ajax.reload();
        }
      }
    });
  }

  function deleteFitur(id) {
    $.ajax({
      type : 'POST',
      url : '{{ route('akses-list-delete') }}',
      data : { 
              'idFitur' : id,
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 300) {
          tbListAkses.ajax.reload();
        }
      }
    });
  }

  function deleteAkses(id) {
    $.ajax({
      type : 'POST',
      url : '{{ route('fitur-list-delete') }}',
      data : { 
              'idAkses' : id,
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 300) {
          tbAkses.ajax.reload();
        }
      }
    });
  }

  function addAkses() {
    
    var inputIdFitur = $('#inputIdFitur').val();
    var inputFitur = $('#inputFitur').val();
    var inputRoute = $('#inputRoute').val();
    var inputIcon = $('#inputIcon').val();
    var inputIdParent = $('#inputIdParent').val();
    
    $.ajax({
      type : 'POST',
      url : '{{ route('fitur-add') }}',
      data : { 
              'inputIdFitur' : inputIdFitur,
              'inputFitur' : inputFitur,
              'inputRoute' : inputRoute,
              'inputIcon' : inputIcon,
              'inputIdParent' : inputIdParent,
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 200) {
          tbFitur.ajax.reload();
        }

        console.log(e.new);
        if (e.new == 'Y') {
          tbAkses.ajax.reload();
        }
      }
    });
  }

  // function deleteFitur(id) {
  //   var inputIdFitur = id;
  //   $.ajax({
  //     type : 'POST',
  //     url : '{{ route('fitur-delete') }}',
  //     data : { 
  //             'inputIdFitur' : inputIdFitur,
  //           },
  //     success: function (e) {
  //       notif(e.code, e.message);
  //       if (e.code == 200) {
  //         tbFitur.ajax.reload();
  //       }
  //     }
  //   });
  // }

  function setAkses(id, nama) {
    $('#inputIdUsersLevel').val(id);
    $('#inputUsersLevel').val(nama);
    tbListAkses.ajax.reload();
  }

  // function clearFormFitur() {
  //   $('#inputIdFitur').val("");
  //   $('#inputFitur').val("");
  //   $('#inputRoute').val("");
  //   $('#inputIcon').val("");
  //   $('#inputIdParent').val("");
  // }
</script>
@endpush