@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form action="" method="POST" id="form-spd">
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
                    <h4>BUAT SPD</h4>
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
                        <div class="col-md-5">
                          <label>Tanggal</label>
                          <input type="text" class="form-control date" name="tanggal">
                        </div>
                        <div class="col-md-3">
                          <label>Triwulan</label>
                          <select name="triwulan" class="form-control">
                            <option value="">Pilih triwulan</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                          </select>
                        </div>
                        <div class="col-md-2">
                          <label>Bulan Awal</label>
                          <input type="text" class="form-control" name="bulan_awal">
                        </div>
                        <div class="col-md-2">
                          <label>Bulan Akhir</label>
                          <input type="text" class="form-control" name="bulan_akhir">
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
                  </div>
                </div>
                <div class="card" style="min-height:400px">
                      
                      <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#rincian_anggaran" role="tab" aria-controls="home" aria-selected="false">
                              Unit Kerja
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="data-tbp-tab" data-toggle="tab" href="#data_tbp" role="tab" aria-controls="data-tbp" aria-selected="false">
                              Sub Kegiatan
                            </a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active show" id="rincian_anggaran" role="tabpanel" aria-labelledby="home-tab">
                              <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      <label>Nomor DPA</label>
                                      <input type="text" class="form-control" name="nomor_dpa" id="nomor_dpa" value="00.00.00.5.2">
                                    </div>
                                    <div class="form-group">
                                      <label>Sisa SPD</label>
                                      <input type="text" class="form-control" name="sisa_spd" readonly>
                                    </div>
                                    
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Bendahara Pengeluaran</label>
                                      <select class="form-control" id="rekening_bendahara" name="bendahara_pengeluaran">
                                          <option value="">Pilih Bendahara Pengeluaran</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label>BUD / Kuasa BUD</label>
                                      <select class="form-control" name="kuasa_bud" id="kuasa_bud">
                                          <option value="">Pilih BUD</option>
                                      </select>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="data_tbp" role="tabpanel" aria-labelledby="data-tbp-tab">
                            <div class="row">
                              <div class="col-md-12">
                                <button class="btn btn-primary btn-sm mb-3" type="button" data-toggle="modal" data-target="#akunModal">
                                  <i class="fas fa-plus"></i> Pilih Sub Kegiatan
                                </button>
                                <table class="table table-rba">
                                  <thead>
                                    <th></th>
                                    <th>Kode Sub Kegiatan</th>
                                    <th>Nama Sub Kegiatan</th>
                                    <th>Anggaran</th>
                                    <th>SPD Sebelumnya</th>
                                    <th>Nominal</th>
                                    <th>Total SPD Saat Ini</th>
                                  </thead>
                                  <tbody>
                                  
                                  </tbody>
                                </table>
                              </div>
                              <div class="col-md-12">
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
        <h5 class="modal-title">Pilih Sub Kegiatan </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table table-rekening"  style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Kode Sub Kegiatan</th>
                  <th>Nama Sub Kegiatan</th>
                </tr>
              </thead>
              <tbody>
                
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
        $("select[name=triwulan]").change(function (){
          let triwulan = $(this).val();
          let bulan_awal = (triwulan*3)-2;
          let bulan_akhir = bulan_awal+2;
          $("input[name=bulan_awal]").val(bulan_awal);
          $("input[name=bulan_akhir]").val(bulan_akhir);
        });    
        @if (auth()->user()->hasRole('Puskesmas'))
          getRba221();
            getPejabatUnit();
            setNomorDpa();
            getSisaSpd();
        @endif
        
        const tableRBA = $('.table-rba').DataTable({
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
            {data: 'Anggaran'},
            {data: 'Spd Sebelumnya'},
            {data: 'Nominal'},
            {data: 'Total'}
          ],
          columnDefs: [
              { width: 150, targets: 1 },
              { width: 500, targets: 2 },
              { width: 150, targets: 3 },
              { width: 150, targets: 4 },
              { width: 150, targets: 5 },
              { width: 150, targets: 6 },
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
            getRba221();
            getPejabatUnit();
            setNomorDpa();
            getSisaSpd();
            $('.table-rba tbody').empty();
        });

        $(".date").datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
          orientation: 'bottom',
        });
        $(".date").datepicker('update', '{{ date('Y-m-d') }}');

        $('#form-spd').on('submit', function (e) {
          e.preventDefault();
          var formData = $(this).serialize();
          $.ajax({
            type: "POST",
            url: "{{ route('admin.spd.save') }}",
            data: formData,
            beforeSend:function() {
              $("#buttonSubmit").prop('disabled', true);
            },
            success:function(response){
              iziToast.success({
                title: 'Sukses!',
                message: 'SPD berhasil disimpan',
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
          tableRBA.clear().draw();
          let rekening = []
          $('.table-rekening input:checked').each(function() {
            rekening.push({
              kode: $(this).closest('tr').attr('data-kode-kegiatan'),
              nama: $(this).closest('tr').attr('data-nama-kegiatan'),
              anggaran: $(this).closest('tr').attr('data-anggaran'),
              spdSebelumnya: $(this).closest('tr').attr('data-spd-sebelumnya'),
            });
          });

          let data = [];
          rekening.forEach(function (item) {
            data.push({
              '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>`,
              'Kode Kegiatan': `<input type="text" name="kodeSubKegiatan[]" class="form-control" value="${item.kode}" readonly>`,
              'Nama Kegiatan': `<input type="text" name="namaSubKegiatan[]" class="form-control" value="${item.nama}" readonly>`,
              'Anggaran': `<input type="text" name="anggaran[]" class="form-control money" readonly value="${rupiah(item.anggaran)}">`,
              'Spd Sebelumnya' : `<input type="text" class="form-control" readonly name="spd_sebelumnya[]" value="${rupiah(item.spdSebelumnya)}">`,
              'Nominal' : '<input type="text" class="form-control money" name="nominal[]" value="0" onkeyup="typingNominal(event)">',
              'Total' : `<input type="text" class="form-control money" readonly name="total_spd[]" value="0,00">`
            });
          });

          tableRBA.rows.add(data).draw();
          $('#akunModal').modal('hide');
          initMaskMoney();
        });

          // remove item
          $('.table-rba tbody').on('click', '.btn-remove', function () {
            $(this).closest('tr').remove();
          });
        });

      function getRba221(){
        $.ajax({
          type: "GET",
          url: "{{ route('admin.akun.rba221') }}",
          data: "unit_kerja="+$("#unit_kerja").val(),
          success:function(response) {
            let kegiatan = [...response.data];
            $('.table-rekening tbody').empty();
            kegiatan.forEach(function (item) {
              $('.table-rekening tbody').append(`
                <tr data-kode-kegiatan="${item.kodeSubKegiatan}" data-nama-kegiatan="${item.namaSubKegiatan}" data-anggaran="${item.total_nominal}" data-spd-sebelumnya="${item.total_spd}">
                  <td><input type="checkbox" name="rekening" value="${item.kodeSubKegiatan}"></td>
                  <td>${item.kodeSubKegiatan}</td>
                  <td>${item.namaSubKegiatan}</td>
                </tr>
              `);
            });
          }
        });
          
      }

      function getPejabatUnit(){
        var bendahara = $("#kuasa_bud");
        bendahara.empty();
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.pejabatunit.data') }}",
          data: "kode_unit_kerja="+$("#unit_kerja").val(),
          success:function(response){
            $.each(response.data, function() {
                bendahara.append($("<option />").val(this.id).text(this.jabatan.nama_jabatan + " - " + this.nama_pejabat));
            });
          }
        })

        var kepalaSkpd = $("#rekening_bendahara");
        kepalaSkpd.empty();
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.pejabatunit.data') }}",
          data: "kode_unit_kerja="+$("#unit_kerja").val(),
          success:function(response){
            $.each(response.data, function() {
                kepalaSkpd.append($("<option />").val(this.id).text(this.jabatan.nama_jabatan + " - " + this.nama_pejabat));
            });
          }
        })
      }

      

      function getSisaSpd(){
        $.ajax({
          type: "GET",
          url: "{{ route('admin.spd.getSisaSpd') }}",
          data: "unit_kerja="+$("#unit_kerja").val(),
          success:function(response){
            $("input[name=sisa_spd]").val(rupiah(response.data.toString()));
          }
        })
      }

      function setNomorDpa(){
        let unitKerja =  $("#unit_kerja").val() != '' ? $("#unit_kerja").val() : '00' ;
        let nomorDpaValue = unitKerja+'.00.00.5.2';
        let nomorDpa = $("#nomor_dpa");
        nomorDpa.val('');
        nomorDpa.val(nomorDpaValue);
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