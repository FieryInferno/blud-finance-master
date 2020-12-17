@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form action="" method="POST" id="form-sp3bp">
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
                    <h4>BUAT SP3BP</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="Nomor">Nomor SP3B</label>
                          <input type="text" class="form-control" name="nomor" value="{{ $sp3b->nomor }}">
                        </div>
                        <div class="col-md-3">
                          <label>Tanggal</label>
                          <input type="text" class="form-control date" name="tanggal">
                        </div>
                        <div class="col-md-3">
                          <label>Triwulan</label>
                          <select name="triwulan" id="triwulan" class="form-control">
                            <option value="">Pilih Triwulan</option>
                            @for ($i = 1; $i <= 4; $i++)
                                <option value="{{ $i }}" {{ $sp3b->triwulan == $i ? 'selected' : '' }}
                                  >{{ $i }}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                   
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>SKPD</label>
                          <div class="row">
                            <div class="col-md-2">
                              <input type="text" name="" class="form-control" readonly value="1.02.01">
                            </div>
                            <div class="col-md-10">
                              <input type="text" name="" class="form-control" readonly value="DINAS KESEHATAN">
                            </div>
                          </div>
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
                                          {{ $sp3b->kode_unit_kerja == $item->kode ? 'selected' : '' }}
                                          >{{ $item->kode }} - {{ $item->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>Akun Bendahara Penerimaan</label>
                          <select name="bendahara_penerimaan" id="bendahara_penerimaan" class="form-control">
                            <option value="">Pilih Akun Bendahara Penerimaan</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>Akun Bendahara Pengeluaran</label>
                          <select name="bendahara_pengeluaran" id="bendahara_pengeluaran" class="form-control">
                            <option value="">Pilih Akun Bendahara Pengeluaran</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>Keterangan</label>
                          <input type="text" class="form-control" name="keterangan" value="{{ $sp3b->keterangan }}">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>Pejabat</label>
                          <select name="pejabat_unit" id="pejabat" class="form-control">
                            <option value="">Pilih Pejabat</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card" style="min-height:400px">
                      
                      <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#rincian_pengesahan" role="tab" aria-controls="home" aria-selected="false">
                              Rincian Pengesahan
                            </a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active show" id="rincian_pengesahan" role="tabpanel" aria-labelledby="home-tab">
                              <div class="row">
                                <div class="col-md-12 table-responsive">
                                  <table class="table dataTable table-striped table-sp3b">
                                    <thead>
                                      <th>Nomor</th>
                                      <th>Kode Kegiatan</th>
                                      <th>Nama Kegiatan</th>
                                      <th>Kode Kegiatan APBD</th>
                                      <th>Nama Kegiatan APBD</th>
                                      <th>Kode Akun</th>
                                      <th>Nama Akun</th>
                                      <th>Kode Akun APBD</th>
                                      <th>Nama Akun APBD</th>
                                      <th>Pendapatan</th>
                                      <th>Pengeluaran</th>
                                    </thead>
                                    <tbody>
                                      @foreach ($sp3b->sp3bRincian as $item)
                                        <tr>
                                          <td><input type="text" name="nomor_rincian[]" value="{{ $item->nomor }}" class="form-control" readonly></td>
                                          <td>
                                            <input type="text" value="{{ $item->kegiatan ? $item->kegiatan->kode_program .'.'. $item->kegiatan->kode_bidang .'.'. $item->kegiatan->kode : '' }}" class="form-control" readonly>
                                            <input type="hidden" name="kegiatan_id[]" value="{{ $item->kegiatan_id }}">
                                          </td>
                                          <td>{{ $item->kegiatan ? $item->kegiatan->nama_kegiatan : '' }}</td>
                                          <td>
                                            <input type="text" value="{{ $item->kegiatanApbd ? $item->kegiatanApbd->kode_program .'.'. $item->kegiatanApbd->kode_bidang .'.'. $item->kegiatanApbd->kode : '' }}" class="form-control" readonly>
                                            <input type="hidden" name="kegiatan_apbd_id[]" value="{{ $item->kegiatan_apbd_id }}">
                                          </td>
                                          <td>{{ $item->kegiatanApbd ? $item->kegiatanApbd->nama_kegiatan : '' }}</td>
                                          <td><input type="text" name="kode_akun[]" value="{{ $item->akun ? $item->akun->kode_akun : '' }}" class="form-control" readonly></td>
                                          <td>{{ $item->akun ? $item->akun->nama_akun : '' }}</td>
                                          <td><input type="text" name="kode_akun_apbd[]" value="{{ $item->akunApbd ? $item->akunApbd->kode_akun : '' }}" class="form-control" readonly></td>
                                          <td>{{ $item->akunApbd ? $item->akunApbd->nama_akun : '' }}</td>
                                          <td><input type="text" name="pendapatan[]" value="{{ format_report($item->pendapatan) }}" class="form-control" readonly></td>
                                          <td><input type="text" name="pengeluaran[]" value="{{ format_report($item->pengeluaran) }}" class="form-control" readonly></td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                  <div id="totalrincian">
                                      <table class='table'>
                                        <thead>
                                          <th colspan='4'></th>
                                          <th>Total Pendapatan : {{ $totalPendapatan }}</th>
                                          <th>Total Pengeluaran : {{ $totalPengeluaran }} </th>
                                        </thead>
                                      </table>
                                  </div>
                                  
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
    </form>
  </section>
</div>
@endsection
@section('js')
  <script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>
  <script>
      $(document).ready(function () {
          getRekeningBendaharaPenerimaan({{ $sp3b->bendahara_penerimaan }});
          getRekeningBendaharaPengeluaran({{ $sp3b->bendahara_pengeluaran }});
          getPejabatUnit({{ $sp3b->pejabat_unit }});
        $(".dataTable").dataTable({
          scrollX: true,
          paging: false,
          info: false,
          bFilter: false,
          scrollY: '50vh',
          scrollX: true,
          columnDefs: [
                  { width: 200, targets: 0 },
                  { width: 150, targets: 1 },
                  { width: 150, targets: 2 },
                  { width: 150, targets: 3 },
                  { width: 150, targets: 4 },
                  { width: 150, targets: 5 },
                  { width: 200, targets: 6 },
                  { width: 200, targets: 7 },
                  { width: 200, targets: 8 },
              ],
          fixedColumns: true,
        });
        $(".date").datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
          orientation: 'bottom',
        });
        $(".date").datepicker('update', '{{ $sp3b->tanggal }}');

        $('#form-sp3bp').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: "PUT",
          url: "{{ route('admin.sp3bp.update', $sp3b->id ) }}",
          data: formData,
          beforeSend:function() {
            $("#buttonSubmit").prop('disabled', true);
          },
          success:function(response){
            iziToast.success({
              title: 'Sukses!',
              message: 'SP3B berhasil disimpan',
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

      });

      $("#unit_kerja").change(function(){
            getRekeningBendaharaPenerimaan();
            getRekeningBendaharaPengeluaran();
            getPejabatUnit();
            getRincianSp3b();
      });
      
      $("#triwulan").change(function() {
        getRincianSp3b();
      })

      function getPejabatUnit(pejabatUnit = null){
        var pejabat = $("#pejabat");
        pejabat.empty();
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.pejabatunit.data') }}",
          data: "kode_unit_kerja="+$("#unit_kerja").val(),
          success:function(response){
            $.each(response.data, function() {
              if (pejabatUnit && pejabatUnit == this.id){
                pejabat.append($("<option />").val(this.id).text(this.jabatan.nama_jabatan + " - " + this.nama_pejabat));
              }else{
                pejabat.append($("<option />").val(this.id).text(this.jabatan.nama_jabatan + " - " + this.nama_pejabat));
              }
            });
          }
        })
      }

      function getRekeningBendaharaPenerimaan(bendaharaPenerimaan = null){
        var dropdown = $("#bendahara_penerimaan");
        dropdown.empty();
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.rekeningbendahara.data') }}",
          data: "unit_kerja="+$("#unit_kerja").val()+"&jenis=penerimaan",
          success:function(response) {
            $.each(response, function() {
                if (bendaharaPenerimaan && bendaharaPenerimaan == this.id){
                  dropdown.append($("<option />").val(this.id).text(this.kode_akun+" - "+this.nama_akun_bendahara).attr('selected', true));
                }else {
                  dropdown.append($("<option />").val(this.id).text(this.kode_akun+" - "+this.nama_akun_bendahara));
                }
            });
          }
        })
      }

      function getRekeningBendaharaPengeluaran(bendaharaPengeluaran = null) {
        var dropdown = $("#bendahara_pengeluaran");
        dropdown.empty();
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.rekeningbendahara.data') }}",
          data: "unit_kerja="+$("#unit_kerja").val()+"&jenis=pengeluaran",
          success:function(response) {
            $.each(response, function() {
              if (bendaharaPengeluaran && bendaharaPengeluaran == this.id){
                dropdown.append($("<option />").val(this.id).text(this.kode_akun+" - "+this.nama_akun_bendahara).attr('selected', true));
              }else {
                dropdown.append($("<option />").val(this.id).text(this.kode_akun+" - "+this.nama_akun_bendahara));
              }
            });
          }
        })
      }

      function getRincianSp3b() {
         var unitKerja = $("#unit_kerja").val();
         var triwulan = $("#triwulan").val();
         if (triwulan != '' && unitKerja != '') {
           $.ajax({
             type: "GET",
             url: "{{ route('admin.rinciansp3b.data') }}",
             data: "unit_kerja="+unitKerja+"&triwulan="+triwulan,
             success:function(response) {
                $("#totalrincian").html('');
                $('.table-sp3b tbody').empty();
                response.data.sp3b.forEach(function (item) {
                  $('.table-sp3b tbody').append(`
                    <tr>
                      <td><input type="text" name="nomor_rincian[]" value="${item.nomor}" class="form-control" readonly></td>
                      <td>
                        <input type="text" value="${item.kode_kegiatan}" class="form-control" readonly>
                        <input type="hidden" value="${item.kegiatan_id}" name="kegiatan_id[]" class="form-control" readonly>
                      </td>
                      <td>${item.nama_kegiatan}</td>
                      <td>
                        <input type="text" value="${item.kode_kegiatan_apbd}" class="form-control" readonly>
                        <input type="hidden" name="kegiatan_id_apbd[]" value="${item.kegiatan_id_apbd}" class="form-control" readonly>
                      </td>
                      <td>${item.nama_kegiatan_apbd}</td>
                      <td><input type="text" name="kode_akun[]" value="${item.kode_akun}" class="form-control" readonly></td>
                      <td>${item.nama_akun}</td>
                      <td><input type="text" name="kode_akun_apbd[]" value="${item.kode_akun_apbd}" class="form-control" readonly></td>
                      <td>${item.nama_akun_apbd}</td>
                      <td><input type="text" name="pendapatan[]" value="${formatCurrency(item.pendapatan)}" class="form-control" readonly></td>
                      <td><input type="text" name="pengeluaran[]" value="${formatCurrency(item.pengeluaran)}" class="form-control" readonly></td>
                    </tr>
                  `);
                })
                $("#totalrincian").html(`
                  <table class='table'>
                    <thead>
                      <th colspan='4'></th>
                      <th>Total Pendapatan : ${formatCurrency(response.data.total.pendapatan)}</th>
                      <th>Total Pengeluaran : ${formatCurrency(response.data.total.pengeluaran)}</th>
                    </thead>
                  </table>
                `);
             }
           })
         }
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