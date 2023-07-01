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
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="inputName" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control" id="inputUsername" placeholder="">
                      </div>
                      <br>
                      <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="">Password</label>
                        <input type="text" class="form-control" id="inputPassword" placeholder="">
                      </div>
                      <br>
                      <div class="form-group">
                        <label for="">Perusahaan</label>
                        {{-- <input type="text" class="form-control" id="inputPerusahaan" placeholder=""> --}}
                        <select name="" class="form-control" id="inputPerusahaan">
                          <option value=""> - </option>
                          @foreach ($perusahaan as $item)
                              <option value="{{ $item->id }}">{{ $item->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">User Level</label>
                        {{-- <input type="text" class="form-control" id="inputUserLevel" placeholder=""> --}}
                        <select name="" class="form-control" id="inputUserLevel">
                          <option value=""> - </option>
                          @foreach ($users_level as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                      <br>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="inputStatus">
                        <label class="form-check-label" for="exampleCheck1">Aktif</label>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="button" class="btn btn-primary" onclick="addUser()">Submit</button>
                    </div>
                  </form>
                </div>
            </div>  
            <div class="col-md-8">
              <div class="card">
                <div class="table-responsive p-0">
                  <table class="table" id="tbUsers">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Opsi</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
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

    var tbUsers = '';
        tbUsers = $('#tbUsers').DataTable({
            processing: true,
            serverside: true,
            ajax: { 
                type : 'GET',
                url  : '{{ route('users-datatable')}}',
              }, 
            
            columns:[
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'opsi', name: 'opsi'},
              {data: 'fullname', name: 'fullname'},
              {data: 'username', name: 'username'},
              {data: 'email', name: 'email'},
              {data: 'flag_active', name: 'flag_active'},
            ]
        });
    
    function addUser() {

      var inputName = $('#inputName').val();
      var inputUsername = $('#inputUsername').val();
      var inputEmail = $('#inputEmail').val();
      var inputPassword = $('#inputPassword').val();
      var inputPerusahaan = $('#inputPerusahaan').val();
      var inputUserLevel = $('#inputUserLevel').val();
      var inputStatus = $('inputStatus').val();

      $.ajax({
        type : 'POST',
        url : '{{ route('users-add') }}',
        data : { 
                'inputName' : inputName,
                'inputUsername' : inputUsername,
                'inputEmail' : inputEmail,
                'inputPassword' : inputPassword,
                'inputPerusahaan' : inputPerusahaan,
                'inputUserLevel' : inputUserLevel,
                'inputStatus' : inputStatus
              },
        success: function (e) {
          notif(e.code, e.message);
          if (e.code == 200) {
            // clearForm();
            tbUsers.ajax.reload();
          }
        }
      });
    }

    function deleteUser(id) {
      $.ajax({
        type : 'POST',
        url : '{{ route('users-delete') }}',
        data : { 
                'inputIdUser' : id,
              },
        success: function (e) {
          notif(e.code, e.message);
          if (e.code == 200) {
            // clearForm();
            tbUsers.ajax.reload();
          }
        }
      });
    }


</script>
@endpush