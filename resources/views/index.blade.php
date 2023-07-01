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
                        <input type="text" class="form-control" id="inputPerusahaan" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="">User Level</label>
                        <input type="text" class="form-control" id="inputUserLevel" placeholder="">
                      </div>
                      <br>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="inputtatus">
                        <label class="form-check-label" for="exampleCheck1">Aktif</label>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
            </div>  
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Responsive Hover Table</h3>
                      <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                          <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
      
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover text-nowrap">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Reason</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>183</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="tag tag-success">Approved</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                          </tr>
                          <tr>
                            <td>219</td>
                            <td>Alexander Pierce</td>
                            <td>11-7-2014</td>
                            <td><span class="tag tag-warning">Pending</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                          </tr>
                          <tr>
                            <td>657</td>
                            <td>Bob Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="tag tag-primary">Approved</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                          </tr>
                          <tr>
                            <td>175</td>
                            <td>Mike Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="tag tag-danger">Denied</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection