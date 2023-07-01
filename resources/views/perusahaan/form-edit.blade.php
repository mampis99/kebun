@extends('templates/index')

@section('navbar')
{{-- <ul class="nav nav-pills">
  <li class="nav-item d-none d-sm-inline-block">
    <a class="nav-link active" href="#tabProfil" data-toggle="tab">Profil</a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
    <a class="nav-link" href="#tabKebun" data-toggle="tab">Kebun</a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
    <a class="nav-link" href="#tabNodeSetting" data-toggle="tab">Node Setting</a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
    <a class="nav-link" href="#tabNodeRuleSetting" data-toggle="tab">Node Rule Setting</a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
    <a class="nav-link" href="#tabMapping" data-toggle="tab">Mapping</a>
  </li>
</ul> --}}
@endsection

@section('content')
<div class="content">
  <div class="container-fluid">

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
              <div class="form-group">
                <label for="">Chip SN</label>
                {{-- <input type="text" class="form-control" id="inputChip" value=""> --}}
                <input type="text" class="form-control" id="inputIdNodeSetting" value="" disabled>
                <select name="" class="form-control listChip" id="inputChip"></select>
              </div>
              <div class="form-group">
                <label for="">No. Sensor</label>
                <input type="text" class="form-control" id="inputNoSensor" value="">
              </div>
              {{-- <div class="form-group">
                <label for="">Kebun</label>
                <select class="form-control select2" id="inputIdKebun">  
                  <option></option>
                </select>
              </div> --}}
              {{-- <div class="form-group">
                <label for="">Tipe</label>
                <input type="text" class="form-control" id="inputIdTipe" value="">
              </div> --}}
              <div class="form-group">
                <label for="">Nama Node</label>
                <input type="text" class="form-control" id="inputSensor" value="">
              </div>
              {{-- <div class="form-group">
                <label for="">Tampil Di Beranda</label>
                <input type="text" class="form-control" id="inputIdOpsi" value="">
              </div> --}}
              <div class="form-group">
                <label for="">Keterangan</label>
                <textarea type="text" rows="2" class="form-control" id="inputKeterangan" value=""></textarea>
              </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="reset" class="btn btn-danger reset-select">Reset</button>
            <button type="button" class="btn btn-primary" onclick="addNode()">Save</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="tabs-profile-tab" data-toggle="pill" href="#tabs-profile" role="tab" aria-controls="tabs-profile" aria-selected="true">Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-kebun-tab" data-toggle="pill" href="#tabs-kebun" role="tab" aria-controls="tabs-kebun" aria-selected="false">Kebun</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-chip-tab" data-toggle="pill" href="#tabs-chip" role="tab" aria-controls="tabs-chip" aria-selected="false">Chip</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-node-tab" data-toggle="pill" href="#tabs-node" role="tab" aria-controls="tabs-node" aria-selected="false">Node</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-node-rule-tab" data-toggle="pill" href="#tabs-node-rule" role="tab" aria-controls="tabs-node-rule" aria-selected="false">Node Rule</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-mapping-tab" data-toggle="pill" href="#tabs-mapping" role="tab" aria-controls="tabs-mapping" aria-selected="false">Mapping</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="tabs-profile" role="tabpanel" aria-labelledby="tabs-profile-tab">
                <div class="card card-primary">
                  <form>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Nama Perusahaan</label>
                            <input type="hidden" class="form-control" id="_id" value="{{ $perusahaan['id'] }}" disabled>
                            <input type="text" class="form-control" id="inputName" value="{{ $perusahaan['nama'] }}">
                          </div>
                          <div class="form-group">
                            <label for="">Singkatan</label>
                            <input type="text" class="form-control" id="inputSingkatan" value="{{ $perusahaan['singkatan'] }}">
                          </div>
                          <div class="form-group">
                            <label for="">Alamat</label>
                            <input type="text" class="form-control" id="inputAlamat" value="{{ $perusahaan['alamat'] }}">
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Dirut</label>
                            <input type="text" class="form-control" id="inputDirut" value="{{ $perusahaan['dirut'] }}">
                          </div>
                          <div class="form-group">
                            <label for="">Telp.</label>
                            <input type="text" class="form-control" id="inputTelp" value="{{ $perusahaan['telp'] }}">
                          </div>
                          <div class="form-group">
                            <label for="">Kota</label>
                            <input type="text" class="form-control" id="inputKota" value="{{ $perusahaan['kota'] }}">
                          </div>
                          <div class="form-group">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" name="status" class="custom-control-input" id="customSwitch1" @if($perusahaan['flag'] == 1) checked @else  @endif>
                              <label class="custom-control-label" for="customSwitch1">Aktif</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="button" class="btn btn-primary float-right" onclick="updatePerusahaan()">Update</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="tabs-kebun" role="tabpanel" aria-labelledby="tabs-kebun-tab">
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
                      <table class="table table-hover text-nowrap" id="tbKebun" width="100%">
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

              <div class="tab-pane fade" id="tabs-chip" role="tabpanel" aria-labelledby="tabs-chip-tab">
                <div class="col-md-12">
                  <div class="card">
                    <form>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Kebun</label>
                                  <input type="text" id="idChip" value="" disabled>
                                  <select name="" class="form-control select2" id="inputIdKebun" value="" ></select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Chip</label>
                                  <input type="text" class="form-control" id="inputNamaChip">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Tipe</label>
                                  {{-- <input type="text" class="form-control" id="inputIdTipe"> --}}
                                  <select name="" class="form-control" id="inputIdTipe">
                                    <option value=""></option>
                                    @foreach ($perusahaan['tipe'] as $item)
                                      <option value="{{ $item->id }}">{{ $item->nama }} || {{ $item->keterangan }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Versi</label>
                                  <input type="text" class="form-control" id="inputVersi">
                                </div>
                                <div class="form-group">
                                  <label for="">Build</label>
                                  <input type="text" class="form-control" id="inputBuild">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Keterangan</label>
                                  <input type="text" class="form-control" id="inputKeteranganChip">
                                </div>
                                
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <button type="button" class="btn btn-success float-right" onclick="saveChip()">Submit</button>
                        <button type="reset" class="btn btn-danger reset-select">Reset</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body table-responsive">
                      <table class="table table-hover text-nowrap" id="tbChip" width="100%">
                        <thead>
                          <tr>
                            <th>Opsi</th>
                            <th>No.</th>
                            <th>Chip</th>
                            <th>Kebun</th>
                            <th>Tipe</th>
                            <th>Versi</th>
                            <th>Build</th>
                            <th>Keterangan</th>
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

              <div class="tab-pane fade" id="tabs-node" role="tabpanel" aria-labelledby="tabs-node-tab">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Node Setting</h3>
                      <div class="card-tools">
                        <button data-toggle="modal" data-target="#addNode" class="btn btn-success modalAddNode">
                          <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body table-responsive">
                      <table class="table table-hover text-nowrap" id="tbNode" width="100%">
                        <thead>
                          <tr>
                            <th>Opsi</th>
                            <th>ID Node</th>
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
              <div class="tab-pane fade" id="tabs-node-rule" role="tabpanel" aria-labelledby="tabs-node-rule-tab">
                <div class="col-md-12">
                  <div class="card">
                    <form>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">ID Node</label>
                              <select name="" class="form-control select2" id="inputIdNode"></select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Referensi Node 1</label>
                              <select name="" class="form-control select2" id="inputIdNode1"></select>
                            </div>
                            <div class="form-group">
                              <label for="">Referensi Node 4</label>
                              <select name="" class="form-control select2" id="inputIdNode4"></select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Referensi Node 2</label>
                              <select name="" class="form-control select2" id="inputIdNode2"></select>
                            </div>
                            <div class="form-group">
                              <label for="">Referensi Node 5</label>
                              <select name="" class="form-control select2" id="inputIdNode5"></select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Referensi Node 3</label>
                              <select name="" class="form-control select2" id="inputIdNode3"></select>
                            </div>
                            <div class="form-group">
                              <label for="">Referensi Node 6</label>
                              <select name="" class="form-control select2" id="inputIdNode6"></select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                              <div class="form-group">
                              <label for="">Sleep Time</label>
                              <input type="text" class="form-control" id="inputSleepTime">
                            </div>
                            <div class="form-group">
                              <label for="">Jam Mulai</label>
                              <input type="text" class="form-control" id="inputJamMulai">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Exe Time</label>
                              <input type="text" class="form-control" id="inputExeTime">
                            </div>
                              <div class="form-group">
                              <label for="">Jam Akhir</label>
                              <input type="text" class="form-control" id="inputJamakhir">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Relay</label>
                              <input type="text" class="form-control" id="inputRelay">
                            </div>
                            <div class="form-group">
                              <label for="">Limval 0</label>
                              <input type="text" class="form-control" id="inputLimval0">
                            </div>
                            <div class="form-group">
                              <label for="">Limval 1</label>
                              <input type="text" class="form-control" id="inputLimval1">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Keterangan</label>
                              <textarea name="" class="form-control" id="inputKetNodeRole" cols="5" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                              <div class="custom-control custom-switch">
                                <input type="checkbox" name="statuss" class="custom-control-input" id="customSwitch2">
                                <label class="custom-control-label" for="customSwitch2">Aktif</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <button type="button" class="btn btn-success" onclick="">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body table-responsive">
                      <table class="table table-hover text-nowrap" id="tbNodeRoleSetting" width="100%">
                        <thead>
                          <tr>
                            <th>Opsi</th>
                            <th>Node Role</th>
                            <th>Reff Node 1</th>
                            <th>Reff Node 2</th>
                            <th>Reff Node 3</th>
                            <th>Reff Node 4</th>
                            <th>Reff Node 5</th>
                            <th>Reff Node 6</th>
                            <th>Relay</th>
                            <th>Repeater</th>
                            <th>Sleeptime</th>
                            <th>Exetime</th>
                            <th>Jam Awal</th>
                            <th>Jam Akhir</th>
                            <th>limval0</th>
                            <th>limval1</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>   
              </div>

              <div class="tab-pane fade" id="tabs-mapping" role="tabpanel" aria-labelledby="tabs-mapping-tab">
                <div class="col-md-12">
                  <div class="card">
                    <form>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">ID Node</label>
                                  <select name="" class="form-control listNode" id="inputIdNodeMap" value="" ></select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Value 0</label>
                                  <input type="text" class="form-control" id="inputVal0">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Mapping 0</label>
                                  <input type="text" class="form-control" id="inputMap0">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Value 1</label>
                                  <input type="text" class="form-control" id="inputVal1">
                                </div>
                                <div class="form-group">
                                  <label for="">Value 2</label>
                                  <input type="text" class="form-control" id="inputVal2">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Mapping 1</label>
                                  <input type="text" class="form-control" id="inputMap1">
                                </div>
                                <div class="form-group">
                                  <label for="">Mapping 2</label>
                                  <input type="text" class="form-control" id="inputMap2">
                                </div>
                              </div>
                            </div>
                          </div>
        
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Min</label>
                                  <input type="text" class="form-control" id="inputMin">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Max</label>
                                  <input type="text" class="form-control" id="inputMax">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <button type="button" class="btn btn-success float-right" onclick="saveMapping()">Submit</button>
                        <button type="reset" class="btn btn-danger reset-select">Reset</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body table-responsive">
                      <table class="table table-hover text-nowrap" id="tbMapSetting" width="100%">
                        <thead>
                          <tr>
                            <th>Opsi</th>
                            <th>ID Node</th>
                            <th>Chip</th>
                            <th>Kebun</th>
                            <th>Map 0</th>
                            <th>Val 0</th>
                            <th>Map 1</th>
                            <th>Val 1</th>
                            <th>Map 2</th>
                            <th>Val 2</th>
                            <th>Min</th>
                            <th>Max</th>
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
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script type="text/javascript">

  var _id = $('#_id').val();

  $('.select2').select2({
    theme: 'bootstrap4',
    ajax:{
      type: "POST",
      url : '{{ route('kebun-datatable') }}',
      data: function (e) {
        return {
          '_id' : _id,
          '_nama' : e.term
        }
      },
      processResults: function (e) {
        return {
          results : $.map(e.data, function (item) {
            return {
              text : item.nama,
              id : item.id 
            }
          })
        }
      }
    }
  });

  var listChip = $('.listChip');
  listChip.select2({
    theme: 'bootstrap4',
    ajax:{
      type: "POST",
      url : '{{ route('api-chip') }}',
      data: function (e) {
        return {
          '_id' : _id,
        }
      },
      processResults: function (e) {
        return {
          results : $.map(e, function (item) {
            return {
              text : item.chip+" / "+item.keterangan,
              id : item.id 
            }
          })
        }
      }
    }
  });

  var listNode = $('.listNode');
  listNode.select2({
    theme: 'bootstrap4',
    ajax:{
      type: "POST",
      url : '{{ route('api-node') }}',
      data: function (e) {
        return {
          '_id' : _id,
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

  // $(document).on("change", "#inputIdNodeMap", function (event) {
  //   // alert("as");
  //   // listNode.select2().val(0)
  //   // listNode.trigger('change');
  // });
  
  $(document).on("click", ".modalAddNode", function (event) {
    clearFormNode();
  });

  $(document).on("click", ".reset-select", function (event) {
    resetSelect();    
    clearFormNode();
  });

  function resetSelect() {
    $("#inputChip").val("")
      .trigger('change')
      .trigger('select2:select');

    $("#inputIdKebun").val("")
      .trigger('change')
      .trigger('select2:select');

    $("#inputIdNodeMap").val("")
      .trigger('change')
      .trigger('select2:select');
  }

  // $(document).on("click", ".ok", function (event) {
  //   var opt = new Option('ok', 9, true, true);
  //   listNode.append(opt).trigger('change');

  //   listNode.trigger({
  //     type: 'select2:select',
  //     params : {
  //       data: {
  //         text : 'oooo',
  //         id :9 
  //       }
  //     }
  //   }); 
  //   // $('#inputIdNodeMap').val('9');
  //   // $('#inputIdNodeMap').trigger('change');
  //   // listNode.val("data", { "id" : "9" , "text" : "ok" });
  //   // var listNode = $('.listNode').select2();
  //   // listNode.select2("val", "9");
  //   // listNode.val(9).trigger('change');
  //   // listNode.val('data', {id: '9', text: 'a', 'selected' : true})
  //   // listNode.trigger('change');
  //   // listNode.trigger({
  //   //   type : 'select2:select',
  //   //   params : {
  //   //     data : {
  //   //       text : "hj",
  //   //       id : "9"
  //   //     }
  //   //   }
  //   // });

  //   // console.log(listNode);
  // })

  var tbKebun = $('#tbKebun').DataTable({
          responsive: true,
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

  var tbChip = $('#tbChip').DataTable({
          responsive: true,
          processing: true,
          serverside: true,
          ajax: { 
                  type : 'POST',
                  url  : '{{ route('chip-datatable')}}',
                  data : function (e) {
                    e._id = $('#_id').val();
                  }
                }, 
          columns:[
                    {data: 'opsi', name: 'opsi'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'chip', name: 'chip'},
                    {data: 'nama_kebun', name: 'nama_kebun'},
                    {data: 'nama_tipe', name: 'nama_tipe'},
                    {data: 'versi', name: 'versi'},
                    {data: 'build', name: 'build'},
                    {data: 'keterangan', name: 'keterangan'},
                    {data: 'flag', name: 'flag'},
                  ]
      });
  function saveChip() {
    var idChip = $('#idChip').val();
    var inputIdKebun = $('#inputIdKebun').val();
    var inputNamaChip = $('#inputNamaChip').val();
    var inputIdTipe = $('#inputIdTipe').val();
    var inputVersi = $('#inputVersi').val();
    var inputBuild = $('#inputBuild').val();
    var inputKeteranganChip = $('#inputKeteranganChip').val();

    $.ajax({
      type : 'POST',
      url : '{{ route('chip-add') }}',
      data : { 
               'idChip' : idChip,
               'inputIdKebun' : inputIdKebun,
               'inputNamaChip' : inputNamaChip,
               'inputIdTipe' : inputIdTipe,
               'inputVersi' : inputVersi,
               'inputBuild' : inputBuild,
               'inputKeteranganChip' : inputKeteranganChip
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 200) {
          // clearMapping();
          // resetSelect();
          tbChip.ajax.reload();
        }
      }
    });
  }
  
  function setChip(idEncode, namaChip, idKebun, namaKebun, idTipe, keterangan, versi, build) {

    $('#idChip').val(idEncode);
    // $('#inputIdKebun').val(idKebun);
    var opt = new Option(namaKebun, idKebun, true, true);
    $("#inputIdKebun").append(opt)
      .trigger('change')
      .trigger('select2:select');


    $('#inputNamaChip').val(namaChip);
    $('#inputIdTipe').val(idTipe);
    $('#inputVersi').val(versi);
    $('#inputBuild').val(build);
    $('#inputKeteranganChip').val(keterangan);
  }

  var tbNode = $('#tbNode').DataTable({
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
                    {data: 'id', name: 'id'},
                    {data: 'chip', name: 'chip'},
                    {data: 'sub_node', name: 'sub_node'},
                    {data: 'nama_tipe', name: 'nama_tipe'},
                    {data: 'nama_kebun', name: 'nama_kebun'},
                    {data: 'keterangan', name: 'keterangan'}
                  ]
      });
  
  function setNode(id, namaChip, idChip, subNode, namaNode, ket) {
    $('#addNode').modal("show");

    $('#inputIdNodeSetting').val(id);
    $('#inputChip').val(idChip);

    var opt = new Option(namaChip, idChip, true, true);
    $("#inputChip").append(opt)
      .trigger('change')
      .trigger('select2:select');

    $('#inputNoSensor').val(subNode);
    $('#inputSensor').val(namaNode);
    $('textarea#inputKeterangan').text(ket);
  }

  // var tbNodeRoleSetting = '';
  // tbNodeRoleSetting = $('#tbNodeRoleSetting').DataTable({
  //         processing: true,
  //         serverside: true,
  //         ajax: { 
  //                 type : 'GET',
  //                 url  : '{{ route('node-role-setting-datatable')}}',
  //                 // data : function (e) {
  //                 //   e._id = $('#_id').val();
  //                 // }
  //               }, 
  //         columns:[
  //                   {data: 'opsi', name: 'opsi'},
  //                   {data: 'chip_node', name: 'chip_node'},
  //                   {data: 'chip_reff_node', name: 'chip_reff_node'},
  //                   {data: 'chip_reff_node2', name: 'chip_reff_node2'},
  //                   {data: 'chip_reff_node3', name: 'chip_reff_node3'},
  //                   {data: 'chip_reff_node4', name: 'chip_reff_node4'},
  //                   {data: 'chip_reff_node5', name: 'chip_reff_node5'},
  //                   {data: 'chip_reff_node6', name: 'chip_reff_node6'},
  //                   {data: 'relay', name: 'relay'},
  //                   {data: 'repeater', name: 'repeater'},
  //                   {data: 'sleeptime', name: 'sleeptime'},
  //                   {data: 'exetime', name: 'exetime'},
  //                   {data: 'time0', name: 'time0'},
  //                   {data: 'time1', name: 'time1'},
  //                   {data: 'limval0', name: 'limval0'},
  //                   {data: 'limval1', name: 'limval1'},
  //                 ]
  //     });

  var tbNtbMapSettingode = $('#tbMapSetting').DataTable({
          processing: true,
          serverside: true,
          ajax: { 
                  type : 'POST',
                  url  : '{{ route('map-setting-datatable')}}',
                  data : function (e) {
                    e._id = $('#_id').val();
                  }
                }, 
          columns:[
                    {data: 'opsi', name: 'opsi'},
                    {data: 'id_node', name: 'id_node'},
                    {data: 'chip', name: 'chip'},
                    {data: 'kebun', name: 'kebun'},
                    {data: 'raw_nol', name: 'raw_nol'},
                    {data: 'val_nol', name: 'val_nol'},
                    {data: 'raw_satu', name: 'raw_satu'},
                    {data: 'val_satu', name: 'val_satu'},
                    {data: 'raw_dua', name: 'raw_dua'},
                    {data: 'val_dua', name: 'val_dua'},
                    {data: 'min', name: 'min'},
                    {data: 'max', name: 'max'},
                  ]
      });

  function saveMapping() {
    var inputIdNodeMap = $('#inputIdNodeMap').val();
    var inputVal0 = $('#inputVal0').val();
    var inputMap0 = $('#inputMap0').val();
    var inputVal1 = $('#inputVal1').val();
    var inputVal2 = $('#inputVal2').val();
    var inputMap1 = $('#inputMap1').val();
    var inputMap2 = $('#inputMap2').val();
    var inputMin = $('#inputMin').val();
    var inputMax = $('#inputMax').val();

    $.ajax({
      type : 'POST',
      url : '{{ route('map-setting-add') }}',
      data : { 
              'inputIdNodeMap': inputIdNodeMap,
              'inputVal0': inputVal0,
              'inputMap0': inputMap0,
              'inputVal1': inputVal1,
              'inputVal2': inputVal2,
              'inputMap1': inputMap1,
              'inputMap2': inputMap2,
              'inputMin': inputMin,
              'inputMax': inputMax,
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 200) {
          clearMapping();
          resetSelect();
          tbNtbMapSettingode.ajax.reload();
        }
      }
    });
  }

  function deleteChip(id) {
    $.ajax({
      type : 'POST',
      url : '{{ route('chip-delete') }}',
      data : { 
              '_id': id,
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 200) {
          tbChip.ajax.reload();
        }
      }
    });
  }

  function deleteMap(id) {
    $.ajax({
      type : 'POST',
      url : '{{ route('map-setting-delete') }}',
      data : { 
              '_id': id,
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 200) {
          tbNtbMapSettingode.ajax.reload();
        }
      }
    });
  }

  function deleteNode(id) {
    $.ajax({
      type : 'POST',
      url : '{{ route('node-delete') }}',
      data : { 
              '_id': id,
            },
      success: function (e) {
        notif(e.code, e.message);
        if (e.code == 200) {
          tbNode.ajax.reload();
        }
      }
    });
  }

  function setMap(idNode, nama, raw0, raw1, raw2, val0, val1, val2, min, max) {
    // $('#inputIdNodeMap').select2('data', { id : 9, a_key : 'aktuator 2' }).trigger("change");
    // $('#inputIdNodeMap').select2({ id : "9", text : "aktuator 2" }).trigger("change");
    // $('#inputIdNodeMap').trigger('change');
    // $('#inputIdNodeMap').select2().val("9").trigger("change");
    // var btt = $('#inputIdNodeMap').select2(); 
    // btt.val("OP").trigger("change");
    var opt = new Option(nama, idNode, true, true);
    listNode.append(opt).trigger('change');

    listNode.trigger({
      type: 'select2:select',
    }); 

    $('#inputVal0').val(raw0);
    $('#inputMap0').val(val0);
    $('#inputVal1').val(raw1);
    $('#inputVal2').val(raw2);
    $('#inputMap1').val(val1);
    $('#inputMap2').val(val2);
    $('#inputMin').val(min);
    $('#inputMax').val(max);
  }

  function clearMapping() {
    $('#inputIdNodeMap').val('');
    $('#inputVal0').val('');
    $('#inputMap0').val('');
    $('#inputVal1').val('');
    $('#inputVal2').val('');
    $('#inputMap1').val('');
    $('#inputMap2').val('');
    $('#inputMin').val('');
    $('#inputMax').val('');
  }

  function updatePerusahaan() {
    var _id = $('#_id').val();
    var nama = $('#inputName').val();
    var singkatan = $('#inputSingkatan').val();
    var dirut = $('#inputDirut').val();
    var alamat = $('#inputAlamat').val();
    var kota = $('#inputKota').val();
    var telp = $('#inputTelp').val();
    var status = $('input[name="status"]:checked').serialize();

    $.ajax({
      type : 'POST',
      url : '{{ route('perusahaan-update') }}',
      data : { 
              '_id' : _id,
              'nama' : nama,
              'singkatan' : singkatan,
              'dirut' : dirut,
              'alamat' : alamat,
              'kota' : kota,
              'telp' : telp,
              'status' : status
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
  
  function addKebun() {
    var _id = $('#_id').val();
    var kebun = $('#inputKebun').val();
    var keterangan = $('#inputKeterangan').val();
    var apiKey = $('#inputApi').val();
    
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

  function addNode() {
    var inputIdNodeSetting = $('#inputIdNodeSetting').val();
    var inputChip = $('#inputChip').val();
    var inputNoSensor = $('#inputNoSensor').val();
    var inputSensor = $('#inputSensor').val();
    var inputKeterangan = $('textarea#inputKeterangan').val();
    
    $.ajax({
      type : 'POST',
      url : '{{ route('node-add') }}',
      data : { 
              inputIdNodeSetting : inputIdNodeSetting,
              inputChip : inputChip,
              inputNoSensor : inputNoSensor,
              inputSensor : inputSensor,
              inputKeterangan : inputKeterangan
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
    $('#inputIdNodeSetting').val("");
    $("#inputChip").val("")
      .trigger('change')
      .trigger('select2:select');

    $('#inputNoSensor').val("");
    $('#inputSensor').val("");
    $('textarea#inputKeterangan').text("");
  }

  
</script>
@endpush