@extends('templates/index')

@section('content')
<div class="content">
    <div class="container-fluid">
      <input type="text" id="_id" value="{{ $idPerusahaan }}" disabled hidden>
      <div class="modal fade" id="addKebun">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kebun</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="">Perusahaan</label>
                  <select name="" class="form-control" id="idPerusahaan">
                    @foreach ($perusahaan as $item)
                      <option value="{{ base64_encode($item->id) }}" selected disabled>{{ $item->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Nama Kebun</label>
                  <input type="text" class="form-control" id="inputKebun" value="">
                </div>
                <div class="form-group">
                  <label for="">Keterangan</label>
                  <input type="text" class="form-control" id="inputKeterangan" value="">
                </div><div class="form-group">
                  <label for="">Api Key</label>
                  <input type="text" class="form-control" id="inputApi" value="">
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="addKebun()">Save</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="editKebun">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Kebun</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <input type="text" class="form-control" id="_idEdit" value="" hidden>
                  <label for="">Perusahaan</label>
                  <select name="" class="form-control" id="_idPerusahaanEdit">
                    <option value=""></option>
                    @php
                       $perusahaan_ = DB::table('perusahaan')->get(); 
                    @endphp
                    @foreach ($perusahaan_ as $item)
                      <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Nama Kebun</label>
                  <input type="text" class="form-control" id="inputKebunEdit" value="">
                </div>
                <div class="form-group">
                  <label for="">Keterangan</label>
                  <input type="text" class="form-control" id="inputKeteranganEdit" value="">
                </div><div class="form-group">
                  <label for="">Api Key</label>
                  <input type="text" class="form-control" id="inputApiEdit" value="">
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="editKebun()">Edit</button>
            </div>
          </div>
        </div>
      </div>

        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Kebun</h3>
                  <div class="card-tools">
                    <button data-toggle="modal" data-target="#addKebun" class="btn btn-success">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover text-nowrap" id="tbKebun">
                    <thead>
                      <tr>
                        <th>Opsi</th>
                        <th>No.</th>
                        <th>Nama Kebun</th>
                        <th>Keterangan</th>
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
  var tbKebun = $('#tbKebun').DataTable({
          processing: true,
          serverside: true,
          ajax: { 
                  type : 'POST',
                  url  : '{{ route('kebun-datatable')}}',
                  data : function (e) {
                    e._id = $('#_id').val();
                  }
                }, 
          columns:[
                    {data: 'opsi', name: 'opsi'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    {data: 'keterangan', name: 'keterangan'},
                  ]
      });

      function addKebun() {
        var _id = $('#_id').val();
        var kebun = $('#inputKebun').val();
        var keterangan = $('#inputKeterangan').val();
        var apiKey = $('#inputApi').val();
        console.log(_id);
        $.ajax({
          type : 'POST',
          url : '{{ route('kebun-add') }}',
          data : { 
                  '_id' : _id,
                  'kebun' : kebun,
                  'keterangan' : keterangan,
                  'apiKey' : apiKey,
                },
          success: function (e) {
            notif(e.code, e.message);
            if (e.code == 200) {
              cleraFormKebun();
              $('#addKebun').modal('hide');
              tbKebun.ajax.reload();
            }
          }
        });
      }

      function cleraFormKebun() {
        $('#inputKebun').val("");
        $('#inputKeterangan').val("");
        $('#inputApi').val("");
      }

      $('#editKebun').on('shown.bs.modal', function (event) {
        var $button = $(event.relatedTarget);
        var idEdit = $button.data('id');
        var idPerusahaan = $button.data('idperusahaan');
        var kebun = $button.data('kebun');
        var keterangan = $button.data('keterangan');
        var apikey = $button.data('apikey');

        $('#_idEdit').val(idEdit);
         $.each($('#_idPerusahaanEdit option'),function(a,b){
          if($(this).val() == idPerusahaan){
                    $(this).attr('selected',true)
          }
        });
        $('#inputKebunEdit').val(kebun);
        $('#inputKeteranganEdit').val(keterangan);
        $('#inputApiEdit').val(apikey);
      });


      function cleraFormKebunEdit() {
        $('#inputKebunEdit').val("");
        $('#inputKeteranganEdit').val("");
        $('#inputApiEdit').val("");
      }

      function editKebun() {
        var idEdit = $('#_idEdit').val();
        var idPerusahaan = $('#_idPerusahaanEdit').val();
        var kebun = $('#inputKebunEdit').val();
        var keterangan = $('#inputKeteranganEdit').val();
        var apiKey = $('#inputApiEdit').val();

        $.ajax({
          type : 'POST',
          url : '{{ route('kebun-edit') }}',
          data : { 
                  '_idEdit' : idEdit,
                  '_idPerusahaan' : idPerusahaan,
                  'kebun' : kebun,
                  'keterangan' : keterangan,
                  'apiKey' : apiKey,
                },
          success: function (e) {
            notif(e.code, e.message);
            if (e.code == 201) {
              cleraFormKebunEdit();
              $('#editKebun').modal('hide');
              tbKebun.ajax.reload();
            }
          }
        });
      }

      function delete_kebun(id) {
        var txt;
        var r = confirm('Apakah Anda yakin ingin menghapus?');

        if(r == true) {
          $.ajax({
            type    : 'GET',
            url     : '{{ route('kebun-delete') }}',
            data    : { '_id' : id },
            success : function (e) {
              notif(e.code, e.message);
              tbKebun.ajax.reload();
            }
          });
        } else {
          txt = 'n';
        }

      }
      
</script>
@endpush