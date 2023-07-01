@extends('templates/index')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                  <form>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="">Fitur</label>
                        <input type="text" class="form-control" id="inputIdFitur" value="" disabled hidden>
                        <input type="text" class="form-control" id="inputFitur">
                      </div>
                      <div class="form-group">
                        <label for="">Route</label>
                        <select name="" class="form-control" id="inputRoute">
                          <option></option>
                          @foreach ($route as $item)
                            <option>{{ $item }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Icon</label>
                        <input type="text" class="form-control" id="inputIcon" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="">Parent</label>
                        <select name="" class="form-control" id="inputIdParent">
                          <option value=""></option>
                          @foreach ($fitur as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="button" class="btn btn-primary" onclick="addFitur()">Submit</button>
                    </div>
                  </form>
                </div>
            </div>  
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Responsive Hover Table</h3>
                      {{-- <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                          <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
      
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </div> --}}
                    </div>
                    <div class="card-body table-responsive">
                      <table class="table table-hover text-nowrap" id="tbFitur">
                        <thead>
                          <tr>
                            <th>Opsi</th>
                            <th>Fitur</th>
                            <th>Route</th>
                            <th>Icon</th>
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
</div>
@endsection

@push('js')
<script type="text/javascript">
  var tbFitur = '';
      tbFitur = $('#tbFitur').DataTable({
          processing: true,
          serverside: true,
          ajax: { 
                  type : 'GET',
                  url  : '{{ route('fitur-datatable')}}',
                }, 
          columns:[
                    {data: 'opsi', name: 'opsi'},
                    // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    {data: 'route', name: 'route'},
                    {data: 'icon', name: 'icon'},
                    {data: 'parent', name: 'parent'},
                  ]
      });

  function addFitur() {
    
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
          clearFormFitur();
          tbFitur.ajax.reload();
        }
      }
    });
  }

  function deleteFitur(id) {
    var inputIdFitur = id;
    $.ajax({
      type : 'POST',
      url : '{{ route('fitur-delete') }}',
      data : { 
              'inputIdFitur' : inputIdFitur,
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 200) {
          tbFitur.ajax.reload();
        }
      }
    });
  }

  function setFitur(id, nama, route, icon, idParent) {
    // console.log(id);
    $('#inputIdFitur').val(id);
    $('#inputFitur').val(nama);
    $('#inputRoute').val(route);
    $('#inputIcon').val(icon);
    $('#inputIdParent').val(idParent);
  }

  function clearFormFitur() {
    $('#inputIdFitur').val("");
    $('#inputFitur').val("");
    $('#inputRoute').val("");
    $('#inputIcon').val("");
    $('#inputIdParent').val("");
  }
</script>
@endpush