@extends('templates/index')

@section('content')
<div class="content">
    <div class="container-fluid">
      
      <div class="modal fade" id="addNode">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Node Setting</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="fm">
                {{-- <div class="form-group">
                  <label for="">Chip SN</label>
                  <input type="text" class="form-control" id="inputChip" value="">
                </div> --}}
                <div class="form-group">
                  <label for="">Chip SN</label>
                  <select class="form-control select2" id="inputChip">  
                    @php
                        $chip_ = DB::table('chip')->get(); 
                    @endphp
                    <option value=""></option>
                    @foreach ($chip_ as $item)
                      <option value="{{ $item->id }}">{{ $item->chip }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="">No. Sensor</label>
                  <input type="text" class="form-control" id="inputNoSensor" value="">
                </div>
                <div class="form-group">
                  <label for="">Nama</label>
                  <input type="text" class="form-control" id="inputNama" value="">
                </div>
                <div class="form-group">
                  <label for="">Tampil Di Beranda</label>
                  <input type="text" class="form-control" id="inputIdOpsi" value="">
                </div>
                <div class="form-group">
                  <label for="">Keterangan</label>
                  <textarea type="text" rows="2" class="form-control" id="inputKeterangan" value=""></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="addNode()">Save</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="editNode">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Node Setting Edit</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="fm">
                {{-- <div class="form-group">
                  <label for="">Chip SN</label>
                  <input type="text" class="form-control" id="inputChip" value="">
                </div> --}}
                <div class="form-group">
                  <input type="text" class="form-control" id="idNode" value="">
                  <label for="">Chip SN</label>
                  <select class="form-control select2" id="inputChipEdit">  
                    @php
                        $chip_ = DB::table('chip')->get(); 
                    @endphp
                    <option value=""></option>
                    @foreach ($chip_ as $item)
                      <option value="{{ $item->id }}">{{ $item->chip }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="">No. Sensor</label>
                  <input type="text" class="form-control" id="inputNoSensorEdit" value="">
                </div>
                <div class="form-group">
                  <label for="">Nama</label>
                  <input type="text" class="form-control" id="inputNamaEdit" value="">
                </div>
                <div class="form-group">
                  <label for="">Tampil Di Beranda</label>
                  <input type="text" class="form-control" id="inputIdOpsiEdit" value="">
                </div>
                <div class="form-group">
                  <label for="">Keterangan</label>
                  <textarea type="text" rows="2" class="form-control" id="inputKeteranganEdit" value=""></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="editNode()">Edit</button>
            </div>
          </div>
        </div>
      </div>

        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Node</h3>
                  <div class="card-tools">
                    <button data-toggle="modal" data-target="#addNode" class="btn btn-success">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover text-nowrap" id="tbNode">
                    <thead>
                      <tr>
                        <th>Opsi</th>
                        <th>No.</th>
                        <th>CHIP SN</th>
                        <th>No Sensor</th>
                        <th>Tipe</th>
                        <th>Kebun</th>
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
  var tbNode = '';
  tbNode = $('#tbNode').DataTable({
          processing: true,
          serverside: true,
          ajax: { 
                  type : 'POST',
                  url  : '{{ route('node-datatable')}}',
                  data : function (e) {
                    e._id = $('#_id').val();
                  }
                }, 
          columns:[
                    {data: 'opsi', name: 'opsi'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'chip', name: 'chip'},
                    {data: 'sub_node', name:'sub_node'},
                    {data: 'nama_tipe', name:'nama_tipe'},
                    {data: 'nama_kebun', name: 'nama_kebun'},
                    {data: 'keterangan_kebun', name: 'keterangan_kebun'},
                  ]
      });

    function addNode() {
      var chip = $('#inputChip').val();
      var noSensor = $('#inputNoSensor').val();
      var nama = $('#inputNama').val();
      var opsi = $('#inputIdOpsi').val();
      var keterangan = $('textarea#inputKeterangan').val();
      
      $.ajax({
        type : 'POST',
        url : '{{ route('node-add') }}',
        data : { 
                'chip' : chip,
                'noSensor' : noSensor,
                'nama' : nama,
                'opsi' : opsi,
                'keterangan' : keterangan
              },
        success: function (e) {
          notif(e.code, e.message);
          if (e.code == 200) {
            clearFormNode();
            $('#addNode').modal('hide');
            tbNode.ajax.reload();
          }
        }
      });
    }

  function clearFormNode() {
    $('#inputChip').val("");
    $('#inputNoSensor').val("");
    $('#inputNama').val("");
    $('#inputIdOpsi').val("");
    $('textarea#inputKeterangan').val("");
  }

  $('#editNode').on('shown.bs.modal', function (event) {
        var $button = $(event.relatedTarget);
        var idNode = $button.data('id');
        var idChip = $button.data('idchip')
        var subnode = $button.data('subnode');
        var nama = $button.data('nama');
        var flag = $button.data('flag');
        var keterangan = $button.data('keterangan');

        $('#idNode').val(idNode);
         $.each($('#inputChipEdit option'),function(a,b){
          if($(this).val() == idChip){
                    $(this).attr('selected',true)
          }
        });
        $('#inputNoSensorEdit').val(subnode);
        $('#inputNamaEdit').val(nama);
        $('#inputIdOpsiEdit').val(flag);
        $('textarea#inputKeteranganEdit').val(keterangan);
      });


      function cleraFormNodeEdit() {
        $('#inputChip').val("");
        $('#inputNoSensor').val("");
        $('#inputNama').val("");
        $('#inputIdOpsi').val("");
        $('textarea#inputKeterangan').val("");
      }
      
      function editNode() {
        var idNode = $('#idNode').val();
        var idChip = $('#inputChipEdit').val();
        var subNode = $('#inputNoSensorEdit').val();
        var nama = $('#inputNamaEdit').val();
        var opsi = $('#inputIdOpsiEdit').val();
        var keterangan = $('textarea#inputKeteranganEdit').val();

        $.ajax({
          type : 'POST',
          url : '{{ route('node-edit') }}',
          data : { 
                  'idNode' : idNode,
                  'idChip' : idChip,
                  'subnode' : subNode,
                  'nama' : nama,
                  'opsi' : opsi,
                  'keterangan' : keterangan
                },
          success: function (e) {
            notif(e.code, e.message);
            if (e.code == 201) {
              cleraFormNodeEdit();
              $('#editNode').modal('hide');
              tbNode.ajax.reload();
            }
          }
        });
      }

      function delete_node(id) {
        var txt;
        var r = confirm('Apakah Anda yakin ingin menghapus?');

        if(r == true) {
          $.ajax({
            type    : 'GET',
            url     : '{{ route('node-delete') }}',
            data    : { '_id' : id },
            success : function (e) {
              notif(e.code, e.message);
              tbNode.ajax.reload();
            }
          });
        } else {
          txt = 'n';
        }

      }
      
      
</script>
@endpush