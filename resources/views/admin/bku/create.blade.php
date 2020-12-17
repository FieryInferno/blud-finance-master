@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <form action="{{ route('admin.bku.store') }}" method="POST" id="form-tbp">
      @csrf
      <div class="section-body">
          <div class="row">
              @if ($errors->any())
                <div class="alert alert-danger alert-has-icon w-100 mx-3">
                  <div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Kesalahan Validasi</div>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </div>
                </div>
              @endif

              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>BUAT BKU</h4>
                  </div>
                  <div class="card-body">

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="Nomor">Nomor</label>
                          <div class="row">
                            <div class="col-md-9">
                              <input type="text" class="form-control" name="nomor" readonly>
                            </div>
                            <div class="col-md-3">
                              <input type="checkbox" name="penomoran_otomatis" checked>Penomoran otomatis
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="Nomor">Tanggal</label>
                          <input type="text" class="form-control date" name="tanggal_bku">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Unit Kerja</label>
                                <select name="unit_kerja" id="unit_kerja" class="form-control" {{ (auth()->user()->hasRole('Puskesmas') ? 'readonly' : '') }}>
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach ($unitKerja as $item)
                                        <option value="{{ $item->kode }}"
                                          @if (auth()->user()->hasRole('Puskesmas'))
                                            {{ (auth()->user()->kode_unit_kerja == $item->kode ? 'selected' : '') }}
                                          @endif
                                          >{{ $item->kode }} - {{ $item->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" name="keterangan">
                            </div>
                        </div>
                    </div>

                    <div class="card" style="min-height:400px">
                      
                      <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link  active show" id="home-tab" data-toggle="tab" href="#rincian_anggaran" role="tab" aria-controls="home" aria-selected="false">
                              Rincian Bendahara Umum Daerah
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="sumber-dana-tab" data-toggle="tab" href="#sumber_dana" role="tab" aria-controls="sumber-dana" aria-selected="false">
                              Saldo Sumber Dana
                            </a>
                          </li>
                          
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active show" id="rincian_anggaran" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary btn-sm mb-3 px-3" type="button" data-toggle="modal" data-target="#stsModal">
                                        STS
                                    </button>
                                    <button class="btn btn-primary btn-sm mb-3 px-3" type="button" data-toggle="modal" data-target="#sp2dModal">
                                        SP2D
                                    </button>
                                    <button class="btn btn-primary btn-sm mb-3 px-3" type="button" data-toggle="modal" data-target="#setorPajakModal">
                                        Setor Pajak
                                    </button>
                                    <button class="btn btn-primary btn-sm mb-3 px-3" type="button" data-toggle="modal" data-target="#kontraposModal">
                                        Kontrapos
                                    </button>
                                    <table class="table table-rba">
                                      <thead>
                                        <th></th>
                                        <th>No Aktivitas</th>
                                        <th>Tipe</th>
                                        <th>Tanggal</th>
                                        <th>Penerimaan</th>
                                        <th>Pengeluaran</th>
                                        <th>Unit Kerja</th>
                                        <th>Nama Unit Kerja</th>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="sumber_dana" role="tabpanel" aria-labelledby="sumber-dana-tab">
                                <div class="row">
                                    <div class="col">
                                    <table class="table table-sumber-dana">
                                        <thead>
                                            <th>Nomor</th>
                                            <th>Tipe</th>
                                            <th>Tanggal</th>
                                            <th>Nomor Aktifitas</th>
                                            <th>Penerimaan</th>
                                            <th>Pengeluaran</th>
                                            <th>Unit Kerja</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <p id="total-sumber-dana" class="text-right font-weight-bold"></p>
                                    <button type="submit" id="buttonSubmit" class="btn btn-primary mt-3">
                                        <i class="fa fa-save"></i>
                                        Simpan
                                    </button>
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
  </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="stsModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih STS </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table table-sts"  style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Nomor</th>
                  <th>Tanggal</th>
                  <th>Keterangan</th>
                  <th>Nominal</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="get-sts">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="sp2dModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih SP2D </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table table-sp2d"  style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Nomor</th>
                  <th>Tanggal</th>
                  <th>Keterangan</th>
                  <th>Nominal</th>
                </tr>
              </thead>
              <tbody>
               
              </tbody>
            </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="get-sp2d">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="setorPajakModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Setor Pajak </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table table-setor-pajak"  style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Nomor</th>
                  <th>Tanggal</th>
                  <th>Keterangan</th>
                  <th>Nominal</th>
                </tr>
              </thead>
              <tbody>
               
              </tbody>
            </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="get-setor-pajak">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="kontraposModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Kontrapos </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table table-kontrapos"  style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Nomor</th>
                  <th>Tanggal</th>
                  <th>Keterangan</th>
                  <th>Nominal</th>
                </tr>
              </thead>
              <tbody>
                  {{-- <tr
                    data-id="1"
                    data-nomor="1010101"
                    data-tanggal="2019-02-22"
                    data-keterangan="Dor"
                    data-unit-kerja="1"
                    data-nominal="0"
                    data-nama-unit-kerja="Unit Dor"
                    >
                    <td><input type="checkbox"></td>
                    <td>10101010</td>
                    <td>2019-02-22</td>
                    <td>Dor</td>
                    <td>100.000.000</td>
                  </tr> --}}
              </tbody>
            </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="get-kontrapos">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
    <script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
           $('input[name="penomoran_otomatis"]').click(function(){
          if($(this). prop("checked") == true){
            $('input[name=nomor]').val('');
            $('input[name=nomor]').prop('readonly', true);
          }else {
            $('input[name=nomor]').prop('readonly', false);
          }
        });
            @if (auth()->user()->hasRole('Puskesmas'))
              initMaskMoney();
              getRekeningSts();
              getSp2d();
              getSetorPajak();
              getKontrapos();
            @endif
            const tableRBA = $('.table-rba').DataTable({
              // scrollY: "600px",
              scrollX: true,
              scrollCollapse: true,
              paging: false,
              info: false,
              bFilter: false,
              ordering: false,
              columns:[
                {data: ''},
                {data: 'No Aktivitas'},
                {data: 'Tipe'},
                {data: 'Tanggal'},
                {data: 'Penerimaan'},
                {data: 'Pengeluaran'},
                {data: 'Unit Kerja'},
                {data: 'Nama Unit Kerja'}
              ],
              columnDefs: [
                  { width: 350, targets: 1 },
                  { width: 150, targets: 2 },
                  { width: 150, targets: 3 },
                  { width: 150, targets: 4 },
                  { width: 150, targets: 5 },
                  { width: 150, targets: 6 },
                  { width: 200, targets: 7 }
              ],
              fixedColumns: true,
              display : true
            });

        $(".date").datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
          orientation: 'bottom',
        });

      $('#form-tbp').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: "POST",
          url: "{{ route('admin.bku.save') }}",
          data: formData,
          beforeSend:function() {
            $("#buttonSubmit").prop('disabled', true);
          },
          success:function(response){
            console.log(response);
            iziToast.success({
              title: 'Sukses!',
              message: 'BKU berhasil disimpan',
              position: 'topRight',
              timeout: 2000,
              onClosed: function () {
                window.location.href = document.referrer
              }
            });
          },
          error:function (data, jqXHR) {
            let errors = [];
            let validationMessages = data.responseJSON.errors;
            for (var property in validationMessages) {
              if (validationMessages.hasOwnProperty(property)) {
                errors.push(validationMessages[property][0]);
              }
            }

            iziToast.error({
              title: 'Gagal!',
              message: errors.toString(),
              position: 'topRight'
            });

            $("#buttonSubmit").prop('disabled', false);
          }
        })

      });
        
        $(".date").datepicker('update', '{{ date('Y-m-d') }}');

            $("#unit_kerja").change(function(){
                tableRBA.clear().draw();
                getRekeningSts();
                getSp2d();
                getSetorPajak();
            })

            $('#get-sts').click(function () {
                let sts = []
                $('.table-sts input:checked').each(function() {
                  sts.push({
                    id: $(this).closest('tr').attr('data-id'),
                    nomor: $(this).closest('tr').attr('data-nomor'),
                    tanggal: $(this).closest('tr').attr('data-tanggal'),
                    nominal: $(this).closest('tr').attr('data-nominal'),
                    unitKerja: $(this).closest('tr').attr('data-unit-kerja'),
                    namaUnitKerja: $(this).closest('tr').attr('data-nama-unit-kerja'),
                  });
                });

                let data = [];
                sts.forEach(function (item) {
                  data.push({
                    '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button><input type="hidden" name="sts_id[]" value="${item.id}"> `,
                    'No Aktivitas': `<input type="text" name="no_aktivitas[]" class="form-control" value="${item.nomor}" readonly> <input type="hidden" name="sp2d_id[]" value="">`,
                    'Tipe': `<input type="text" name="tipe[]" class="form-control" value="STS" readonly> <input type="hidden" name="setor_pajak_id[]" value="">`,
                    'Tanggal': `<input type="text" name="tanggal[]" class="form-control" value="${item.tanggal}" readonly><input type="hidden" name="kontrapos_id[]" value="">`,
                    'Penerimaan': `<input type="text" name="penerimaan[]" class="form-control money" value="${formatCurrency(item.nominal)}" readonly>`,
                    'Pengeluaran': `<input type="text" name="pengeluaran[]" class="form-control money" value="0" readonly>`,
                    'Unit Kerja': `<input type="text" name="kode_unit_kerja[]" class="form-control" value="${item.unitKerja}" readonly>`,
                    'Nama Unit Kerja': `<input type="text" class="form-control" value="${item.namaUnitKerja}" readonly>`
                  });
                });

                tableRBA.rows.add(data).draw();
                $('#stsModal').modal('hide');
                initMaskMoney();
              });

            $('#get-sp2d').click(function () {
                let sp2d = []
                $('.table-sp2d input:checked').each(function() {
                  sp2d.push({
                    id: $(this).closest('tr').attr('data-id'),
                    nomor: $(this).closest('tr').attr('data-nomor'),
                    tanggal: $(this).closest('tr').attr('data-tanggal'),
                    nominal: $(this).closest('tr').attr('data-nominal'),
                    unitKerja: $(this).closest('tr').attr('data-unit-kerja'),
                    namaUnitKerja: $(this).closest('tr').attr('data-nama-unit-kerja'),
                  });
                });

                let data = [];
                sp2d.forEach(function (item) {
                  data.push({
                    '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button><input type="hidden" name="sp2d_id[]" value="${item.id}">`,
                    'No Aktivitas': `<input type="text" name="no_aktivitas[]" class="form-control" value="${item.nomor}" readonly> <input type="hidden" name="sts_id[]" value="">`,
                    'Tipe': `<input type="text" name="tipe[]" class="form-control" value="SP2D" readonly> <input type="hidden" name="setor_pajak_id[]" value="">`,
                    'Tanggal': `<input type="text" name="tanggal[]" class="form-control" value="${item.tanggal}" readonly><input type="hidden" name="kontrapos_id[]" value="">`,
                    'Penerimaan': `<input type="text" name="penerimaan[]" class="form-control money" value="0" readonly>`,
                    'Pengeluaran': `<input type="text" name="pengeluaran[]" class="form-control money" value="${formatCurrency(item.nominal)}" readonly>`,
                    'Unit Kerja': `<input type="text" name="kode_unit_kerja[]" class="form-control" value="${item.unitKerja}" readonly>`,
                    'Nama Unit Kerja': `<input type="text" class="form-control" value="${item.namaUnitKerja}" readonly>`
                  });
                });

                tableRBA.rows.add(data).draw();
                $('#sp2dModal').modal('hide');
                initMaskMoney();
              });

            $('#get-setor-pajak').click(function () {
                let setorPajak = []
                $('.table-setor-pajak input:checked').each(function() {
                  setorPajak.push({
                    id: $(this).closest('tr').attr('data-id'),
                    nomor: $(this).closest('tr').attr('data-nomor'),
                    tanggal: $(this).closest('tr').attr('data-tanggal'),
                    nominal: $(this).closest('tr').attr('data-nominal'),
                    unitKerja: $(this).closest('tr').attr('data-unit-kerja'),
                    namaUnitKerja: $(this).closest('tr').attr('data-nama-unit-kerja'),
                  });
                });

                let data = [];
                setorPajak.forEach(function (item) {
                  data.push({
                    '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button><input type="hidden" name="setor_pajak_id[]" value="${item.id}">`,
                    'No Aktivitas': `<input type="text" name="no_aktivitas[]" class="form-control" value="${item.nomor}" readonly> <input type="hidden" name="sts_id[]" value="">`,
                    'Tipe': `<input type="text" name="tipe[]" class="form-control" value="Setor Pajak" readonly> <input type="hidden" name="sp2d_id[]" value="">`,
                    'Tanggal': `<input type="text" name="tanggal[]" class="form-control" value="${item.tanggal}" readonly><input type="hidden" name="kontrapos_id[]" value="">`,
                    'Penerimaan': `<input type="text" name="penerimaan[]" class="form-control money" value="0" readonly>`,
                    'Pengeluaran': `<input type="text" name="pengeluaran[]" class="form-control money" value="${formatCurrency(item.nominal)}" readonly>`,
                    'Unit Kerja': `<input type="text" name="kode_unit_kerja[]" class="form-control" value="${item.unitKerja}" readonly>`,
                    'Nama Unit Kerja': `<input type="text" class="form-control" value="${item.namaUnitKerja}" readonly>`
                  });
                });

                tableRBA.rows.add(data).draw();
                $('#setorPajakModal').modal('hide');
                initMaskMoney();
              });

            $('#get-kontrapos').click(function () {
                let kontrapos = []
                $('.table-kontrapos input:checked').each(function() {
                  kontrapos.push({
                    id: $(this).closest('tr').attr('data-id'),
                    nomor: $(this).closest('tr').attr('data-nomor'),
                    tanggal: $(this).closest('tr').attr('data-tanggal'),
                    nominal: $(this).closest('tr').attr('data-nominal'),
                    unitKerja: $(this).closest('tr').attr('data-unit-kerja'),
                    namaUnitKerja: $(this).closest('tr').attr('data-nama-unit-kerja'),
                  });
                });

                let data = [];
                kontrapos.forEach(function (item) {
                  data.push({
                    '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button><input type="hidden" name="setor_pajak_id[]" value="">`,
                    'No Aktivitas': `<input type="text" name="no_aktivitas[]" class="form-control" value="${item.nomor}" readonly> <input type="hidden" name="sts_id[]" value="">`,
                    'Tipe': `<input type="text" name="tipe[]" class="form-control" value="Kontrapos" readonly> <input type="hidden" name="sp2d_id[]" value="">`,
                    'Tanggal': `<input type="text" name="tanggal[]" class="form-control" value="${item.tanggal}" readonly><input type="hidden" name="kontrapos_id[]" value="${item.id}">`,
                    'Penerimaan': `<input type="text" name="penerimaan[]" class="form-control money" value="${formatCurrency(item.nominal)}" readonly>`,
                    'Pengeluaran': `<input type="text" name="pengeluaran[]" class="form-control money" value="0" readonly>`,
                    'Unit Kerja': `<input type="text" name="kode_unit_kerja[]" class="form-control" value="${item.unitKerja}" readonly>`,
                    'Nama Unit Kerja': `<input type="text" class="form-control" value="${item.namaUnitKerja}" readonly>`
                  });
                });

                tableRBA.rows.add(data).draw();
                $('#kontraposModal').modal('hide');
                initMaskMoney();
              });

              // remove item
              $('.table-rba tbody').on('click', '.btn-remove', function () {
                $(this).closest('tr').remove();
              });
        })

      function getRekeningSts(){
          $.ajax({
              type: "GET",
              url: "{{ route('admin.sts.data') }}",
              data: "kode_unit_kerja="+$("#unit_kerja").val(),
              success:function(response) {
                let data = response.data
                $('.table-sts tbody').empty();
                data.forEach(function (item) {
                  $('.table-sts tbody').append(`
                    <tr data-id="${item.id}" data-nomor="${item.nomorfix}" data-tanggal="${item.tanggal}"
                      data-nominal="${item.total_nominal}" data-keterangan="${item.keterangan}" data-unit-kerja="${item.kode_unit_kerja}" data-nama-unit-kerja="${item.unit_kerja.nama_unit}">
                      <td><input type="checkbox" name="rekening" value="${item.id}"></td>
                      <td>${item.nomorfix}</td>
                      <td>${item.tanggal}</td>
                      <td>${item.keterangan}</td>
                      <td>${formatCurrency(item.total_nominal)}</td>
                    </tr>
                  `);
                });
              }
          })
      }

      function getSp2d() {
        $.ajax({
              type: "GET",
              url: "{{ route('admin.sp2d.data') }}",
              data: "kode_unit_kerja="+$("#unit_kerja").val(),
              success:function(response) {
                let data = response.data
                $('.table-sp2d tbody').empty();
                data.forEach(function (item) {
                  $('.table-sp2d tbody').append(`
                    <tr data-id="${item.id}" data-nomor="${item.nomorfix}" data-tanggal="${item.tanggal}"
                      data-nominal="${item.nominal_sumber_dana}" data-keterangan="${item.keterangan}" data-unit-kerja="${item.kode_unit_kerja}" data-nama-unit-kerja="${item.unit_kerja.nama_unit}">
                      <td><input type="checkbox" name="rekening" value="${item.id}"></td>
                      <td>${item.nomorfix}</td>
                      <td>${item.tanggal}</td>
                      <td>${item.keterangan}</td>
                      <td>${formatCurrency(item.nominal_sumber_dana)}</td>
                    </tr>
                  `);
                });
              }
          })
      }

      function getSetorPajak(){
        $.ajax({
              type: "GET",
              url: "{{ route('admin.setor_pajak.datapajak') }}",
              data: "kode_unit_kerja="+$("#unit_kerja").val(),
              success:function(response) {
                let data = response.data
                $('.table-setor-pajak tbody').empty();
                data.forEach(function (item) {
                  $('.table-setor-pajak tbody').append(`
                    <tr data-id="${item.id}" data-nomor="${item.nomorfix}" data-tanggal="${item.setor_pajak.tanggal}"
                      data-nominal="${item.nominal}" data-keterangan="${item.pajak.nama_pajak}" data-unit-kerja="${item.setor_pajak.kode_unit_kerja}" data-nama-unit-kerja="${item.setor_pajak.unit_kerja.nama_unit}">
                      <td><input type="checkbox" name="rekening" value="${item.id}"></td>
                      <td>${item.nomorfix}</td>
                      <td>${item.setor_pajak.tanggal}</td>
                      <td>${item.pajak.nama_pajak}</td>
                      <td>${formatCurrency(item.nominal)}</td>
                    </tr>
                  `);
                });
              }
          })
      }

      function getKontrapos(){
        $.ajax({
              type: "GET",
              url: "{{ route('admin.kontrapos.data') }}",
              data: "kode_unit_kerja="+$("#unit_kerja").val(),
              success:function(response) {
                let data = response.data
                $('.table-kontrapos tbody').empty();
                data.forEach(function (item) {
                  $('.table-kontrapos tbody').append(`
                    <tr data-id="${item.id}" data-nomor="${item.nomorfix}" data-tanggal="${item.tanggal}" 
                    data-keterangan="${item.keterangan}" data-unit-kerja="${item.kode_unit_kerja}" data-nominal="${item.nominal}" 
                    data-nama-unit-kerja="${item.unit_kerja.nama_unit}">
                    <td><input type="checkbox"></td>
                    <td>${item.nomorfix}</td>
                    <td>${item.tanggal}</td>
                    <td>${item.keterangan}</td>
                    <td>${rupiah(item.nominal)}</td>
                  </tr>
                  `);
                });
              }
          })
      }
      
      function initMaskMoney() {
        jQuery(function($){
          $('.money').maskMoney({
            thousands: '.',
            decimal: ',',
            allowZero: true
          });
        });
      }

      function rupiah(angka) {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('') + ',00';
      }

      function formatCurrency(amount, decimalSeparator, thousandsSeparator, nDecimalDigits){  
        let num = parseFloat( amount ); //convert to float  
        //default values  
        decimalSeparator = decimalSeparator || ',';  
        thousandsSeparator = thousandsSeparator || '.';  
        nDecimalDigits = nDecimalDigits == null? 2 : nDecimalDigits;  
      
        let fixed = num.toFixed(nDecimalDigits); //limit or add decimal digits  
        //separate begin [$1], middle [$2] and decimal digits [$4]  
        let parts = new RegExp('^(-?\\d{1,3})((?:\\d{3})+)(\\.(\\d{' + nDecimalDigits + '}))?$').exec(fixed);   
      
        if(parts){ //num >= 1000 || num < = -1000  
            return parts[1] + parts[2].replace(/\d{3}/g, thousandsSeparator + '$&') + (parts[4] ? decimalSeparator + parts[4] : '');  
        }else{  
            return fixed.replace('.', decimalSeparator);  
        }  
      }
    </script>
@endsection     