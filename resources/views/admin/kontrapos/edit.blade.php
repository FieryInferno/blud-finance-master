@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form action="" method="POST" id="form-kontrapos">
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
                    <h4>BUAT KONTRAPOS</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="Nomor">Nomor</label>
                          <div class="row">
                            <div class="col-md-6">
                              <input type="text" class="form-control" name="nomor" placeholder="(Auto)" readonly>
                            </div>
                            <div class="col-md-6">
                              <input type="checkbox" name="penomoran_otomatis" checked>Penomoran otomatis
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-12">
                          <label>Tanggal</label>
                          <input type="text" class="form-control date" name="tanggal">
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
                                          {{ ($kontrapos->kode_unit_kerja == $item->kode ? 'selected' : '') }}
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
                                <input type="text" class="form-control" name="keterangan" value="{{ $kontrapos->keterangan }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>Rekening Bendahara</label>
                          <select name="rekening_bendahara" class="form-control" id="rekening-bendahara">
                            @foreach ($rekeningBendahara as $item)
                                <option value="{{ $item->id }}" 
                                    {{ $item->id == $kontrapos->rekening_bendahara ? 'selected' : '' }}
                                  >{{ $item->kode_akun }} - {{ $item->nama_akun_bendahara }}</option>
                            @endforeach
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
                            <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#rincian_kontrapos" role="tab" aria-controls="home" aria-selected="false">
                              Rincian Kontrapos
                            </a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active show" id="rincian_kontrapos" role="tabpanel" aria-labelledby="home-tab">
                              <div class="row">
                                <div class="col-md-12">
                                  <button class="btn btn-primary btn-sm mb-3" type="button" data-toggle="modal" data-target="#akunModal">
                                    <i class="fas fa-plus"></i> Pilih Kegiatan
                                  </button>

                                  <table class="table" id="table-kontrapos">
                                    <thead>
                                      <th></th>
                                      <th>Kode Kegiatan</th>
                                      <th>Nama Kegiatan</th>
                                      <th>Kode Akun</th>
                                      <th>Nama Akun</th>
                                      <th>Nominal</th>
                                      <th>Realisasi SP2D</th>
                                      <th>Sumber Dana</th>
                                    </thead>
                                    <tbody>
                                      @foreach ($kontrapos->kontraposRincian as $item)
                                        <tr>
                                          <td><button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button> <input type="hidden" name="sp2d_id[]" value="{{ $item->sp2d_id }}"></td>
                                          <td>
                                            <input type="text" name="kode_kegiatan[]" class="form-control" value="{{ $item->kegiatan->kode_bidang }}.{{ $item->kegiatan->kode_program }}.{{ $item->kegiatan->kode }}" readonly>
                                          </td>
                                          <td>
                                            <input type="text" name="nama_kegiatan[]" class="form-control" value="{{ $item->kegiatan->nama_kegiatan }}" readonly><input type="hidden" name="kegiatan_id[]" value="{{ $item->kegiatan_id }}">
                                          </td>
                                          <td>
                                            <input type="text" name="kode_akun[]" class="form-control" value="{{ $item->akun->kode_akun }}" readonly>
                                          </td>
                                          <td>
                                            <input type="text" name="nama_akun[]" class="form-control" value="{{ $item->akun->nama_akun }}" readonly>
                                          </td>
                                          <td>
                                            <input type="text" name="nominal[]" class="form-control money" value="{{ format_report($item->nominal) }}">
                                          </td>
                                          <td>
                                            <input type="text" name="realisasi_sp2d[]" class="form-control money" value="{{ format_report($item->realisasi_sp2d) }}" readonly>
                                          </td>
                                          <td>
                                            <input type="text" name="sumber_dana[]" class="form-control" value="BLUD" readonly>
                                          </td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>

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

<div class="modal fade" tabindex="-1" role="dialog" id="akunModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Kegiatan </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table table-rekening"  style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Kode Kegiatan</th>
                  <th>Nama Kegiatan</th>
                  <th>Kode Akun</th>
                  <th>Nama Akun</th>
                </tr>
              </thead>
              <tbody>
                {{-- <tr data-kode-kegiatan="127.0.0.1"
                    data-nama-kegiatan="Nama Kegiatan"
                    data-kode-akun="185.28.291.1"
                    data-nama-akun="Nama Akun"
                    data-realisasi-sp2d="1000000011"
                    data-sumberdana="BLUD"
                    >
                  <td><input type="checkbox"></td>
                  <td>127.0.0.1</td>
                  <td>Nama Kegiatan</td>
                </tr> --}}
              </tbody>
            </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="get-rekening">Simpan</button>
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
        initMaskMoney();
        @if (auth()->user()->hasRole('Puskesmas'))
          getSp2d();
        @endif
        
        const tableKontrapos = $('#table-kontrapos').DataTable({
          scrollX: true,
          scrollCollapse: true,
          paging: false,
          info: false,
          bFilter: false,
          ordering: false,
          columns:[
            {data: ''},
            {data: 'Kode Kegiatan'},
            {data: 'Nama Kegiatan'},
            {data: 'Kode Akun'},
            {data: 'Nama Akun'},
            {data: 'Nominal'},
            {data: 'Realisasi SP2D'},
            {data: 'Sumber Dana'}
          ],
          columnDefs: [
              { width: 200, targets: 1 },
              { width: 500, targets: 2 },
              { width: 200, targets: 3 },
              { width: 250, targets: 4 },
              { width: 150, targets: 5 },
              { width: 150, targets: 6 },
              { width: 150, targets: 7 },
          ],
          fixedColumns: true,
          display : true
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
        });    

        $('input[name="penomoran_otomatis"]').click(function(){
          if($(this). prop("checked") == true){
            $('input[name=nomor]').val('');
            $('input[name=nomor]').prop('readonly', true);
          }else {
            $('input[name=nomor]').prop('readonly', false);
          }
        });
        $("#unit_kerja").change(function(){
          getRekeningBendahara();
          getSp2d();
          $('#table-kontrapos tbody').empty();
        });

        $(".date").datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
          orientation: 'bottom',
        });
        $(".date").datepicker('update', '{{ $kontrapos->tanggal }}');

        $('#form-kontrapos').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: "PUT",
          url: "{{ route('admin.kontrapos.update', $kontrapos->id) }}",
          data: formData,
          beforeSend:function() {
            $("#buttonSubmit").prop('disabled', true);
          },
          success:function(response){
            iziToast.success({
              title: 'Sukses!',
              message: 'Kontrapos berhasil disimpan',
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

          // event get rekening
        $('#get-rekening').click(function () {
          let rekening = []
          $('.table-rekening input:checked').each(function() {
            rekening.push({
              kodeKegiatan: $(this).closest('tr').attr('data-kode-kegiatan'),
              namaKegiatan: $(this).closest('tr').attr('data-nama-kegiatan'),
              kodeAkun: $(this).closest('tr').attr('data-kode-akun'),
              namaAkun: $(this).closest('tr').attr('data-nama-akun'),
              realisasiSP2D: $(this).closest('tr').attr('data-realisasi-sp2d'),
              sumberDana: $(this).closest('tr').attr('data-sumberdana'),
              sp2dId: $(this).closest('tr').attr('data-sp2did'),
              kegiatanId: $(this).closest('tr').attr('data-kegiatanid'),
            });
          });

          let data = [];
          rekening.forEach(function (item) {
            data.push({
              '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button><input type="hidden" value="${item.sp2dId}" name="sp2d_id[]">`,
              'Kode Kegiatan': `<input type="text" name="kode_kegiatan[]" class="form-control" value="${item.kodeKegiatan}" readonly><input type="hidden" value="${item.kegiatanId}" name="kegiatan_id[]">`,
              'Nama Kegiatan': `<input type="text" name="nama_kegiatan[]" class="form-control" value="${item.namaKegiatan}" readonly>`,
              'Kode Akun': `<input type="text" name="kode_akun[]" class="form-control" readonly value="${item.kodeAkun}">`,
              'Nama Akun' : `<input type="text" class="form-control" readonly name="nama_akun[]" value="${item.namaAkun}">`,
              'Nominal' : '<input type="text" class="form-control money" name="nominal[]" value="0">',
              'Realisasi SP2D' : `<input type="text" class="form-control money" name="realisasi_sp2d[]" value="${rupiah(item.realisasiSP2D)}" readonly>`,
              'Sumber Dana' : `<input type="text" class="form-control" readonly name="sumber_dana[]" value="BLUD">`
            });
          });

          tableKontrapos.rows.add(data).draw();
          $('#akunModal').modal('hide');
          initMaskMoney();
        });

          // remove item
          $('#table-kontrapos tbody').on('click', '.btn-remove', function () {
            $(this).closest('tr').remove();
          });
        });

      function getRekeningBendahara(){
        var dropdown = $("#rekening-bendahara");
        dropdown.empty();
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.rekeningbendahara.data') }}",
          data: "unit_kerja="+$("#unit_kerja").val(),
          success:function(response) {
            dropdown.append($("<option />").text('Pilih Rekening Bendahara'));
            $.each(response, function() {
                dropdown.append($("<option />").val(this.id).text(this.kode_akun+" - "+this.nama_akun_bendahara));
            });
          }
        })
      }

      function getSp2d() {
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.sp2d.kontrapos') }}",
          data: "unit_kerja="+$("#unit_kerja").val(),
          success:function(response) {
            let data = response.data
            $('.table-rekening tbody').empty();
            data.forEach(function (item) {
                  $('.table-rekening tbody').append(`
                    <tr data-kode-kegiatan="${item.kode_kegiatan}"
                      data-nama-kegiatan="${item.nama_kegiatan}"
                      data-kode-akun="${item.kode_akun}"
                      data-nama-akun="${item.nama_akun}"
                      data-realisasi-sp2d="${item.realisasi_sp2d}"
                      data-sp2did="${item.sp2d_id}"
                      data-kegiatanid="${item.kegiatan_id}"
                      data-sumberdana="BLUD"
                      >
                    <td><input type="checkbox"></td>
                    <td>${item.kode_kegiatan}</td>
                    <td>${item.nama_kegiatan}</td>
                    <td>${item.kode_akun}</td>
                    <td>${item.nama_akun}</td>
                  </tr>
                  `);
                });
          }
        })
      }

      function typingNominal(event) {
        let tr = $(event.srcElement).closest('tr');
        let nominal = parseFloat($(event.srcElement).val().replace(/\./g, '').replace(',', '.')).toFixed(2);
        let spdSebelumnya = parseInt($(tr).children('td').find('input[name="spd_sebelumnya[]"]').val().replace(/,.*|[^0-9]/g, ''), 10);
        $(tr).children('td').find('input[name="total_spd[]"]').val(formatCurrency(spdSebelumnya + parseFloat(nominal)));
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