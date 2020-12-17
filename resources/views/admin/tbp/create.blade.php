@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form action="{{ route('admin.tbp.store') }}" method="POST" id="form-tbp">
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
                    <h4>BUAT TBP</h4>
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
                          <label for="Nomor">Tanggal TBP</label>
                          <input type="text" class="form-control date" name="tanggal">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="Nomor">Tanggal STS</label>
                          <input type="text" class="form-control date" name="tanggal_sts">
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
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Rekening Bendahara</label>
                                <select name="rekening_bendahara" id="rekening_bendahara" class="form-control">
                                    <option value="">Pilih Rekening Bendahara</option>
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
                            <a class="nav-link  active show" id="home-tab" data-toggle="tab" href="#rincian_anggaran" role="tab" aria-controls="home" aria-selected="false">
                              Rincian TBP
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="data-tbp-tab" data-toggle="tab" href="#data_tbp" role="tab" aria-controls="data-tbp" aria-selected="false">
                              Data TBP
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="sumber-dana-tab" data-toggle="tab" href="#sumber_dana" role="tab" aria-controls="sumber-dana" aria-selected="false">
                              Sumber Dana
                            </a>
                          </li>
                          
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active show" id="rincian_anggaran" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary btn-sm mb-3" type="button" data-toggle="modal" data-target="#akunModal">
                                        <i class="fas fa-plus"></i> Pilih Rekening
                                    </button>
                                    <table class="table table-rba">
                                      <thead>
                                        <th></th>
                                        <th>Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Nominal TBP</th>
                                      </thead>
                                      <tbody>
                                      
                                      </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="data_tbp" role="tabpanel" aria-labelledby="data-tbp-tab">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Kepala SKPD</label>
                                        <select name="kepala_skpd" class="form-control" id="kepala_skpd">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Bendahara Penerima</label>
                                        <select name="bendahara_penerima" class="form-control" id="bendahara_penerima">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            </div>
                            <div class="tab-pane fade" id="sumber_dana" role="tabpanel" aria-labelledby="sumber-dana-tab">
                                <div class="row">
                                    <div class="col">
                                    <table class="table table-sumber-dana">
                                        <thead>
                                            <th>Kode Rekening</th>
                                            <th>Nama Rekening</th>
                                            <th>Sumber Dana</th>
                                            <th>Jumlah Total</th>
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

    </form>
  </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="akunModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Akun </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table table-rekening"  style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Kode Rekening</th>
                  <th>Nama Rekening</th>
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
      var sumberDanaSelected = []
      var sumberDanaOld = {!! $sumberDana !!}
      $(document).ready(function () {
        getAkunRba1();
        getRekeningBendahara();
        getPejabatUnit();

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
            {data: 'Kode Akun'},
            {data: 'Nama Akun'},
            {data: 'Nominal TBP'}
          ],
          columnDefs: [
              { width: 150, targets: 1 },
              { width: 300, targets: 2 },
              { width: 250, targets: 3 }
          ],
          fixedColumns: true,
          display : true
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
            getAkunRba1();
            getRekeningBendahara();
            getPejabatUnit();
        });

        $(".date").datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
          orientation: 'bottom',
        });
        $(".date").datepicker('update', '{{ date('Y-m-d') }}');

        $('#form-tbp').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: "POST",
          url: "{{ route('admin.tbp.save') }}",
          data: formData,
          beforeSend:function() {
            $("#buttonSubmit").prop('disabled', true);
          },
          success:function(response){
            console.log(response);
            iziToast.success({
              title: 'Sukses!',
              message: 'TBP berhasil disimpan',
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
              kode: $(this).closest('tr').attr('data-kode-akun'),
              nama: $(this).closest('tr').attr('data-nama-akun'),
            });
          });

          let data = [];
          rekening.forEach(function (item) {
            data.push({
              '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>`,
              'Kode Akun': `<input type="text" name="kode_akun[]" class="form-control" value="${item.kode}" readonly>`,
              'Nama Akun': `<input type="text" name="nama_akun[]" class="form-control" value="${item.nama}" readonly>`,
              'Nominal TBP': '<input type="text" name="tarif[]" class="form-control money" onkeyup="typingNominal(event)" value="0">'
            });
          });

          tableRBA.rows.add(data).draw();
          $('#akunModal').modal('hide');
          initMaskMoney();
        });

        $('#sumber-dana-tab').click(function () {
          $('.table-sumber-dana tbody').html('');

          let sumberDana = [];
          let total = 0;
          let rows = $('.table-rba tbody tr');
          rows.each(function () {
              let kodeRekening = $(this).children('td').eq(1).find('input').val();
              let namaRekening = $(this).children('td').eq(2).find('input').val();
              let nominalTBP = parseFloat(
                                $(this).children('td').eq(3).find('input').val()
                                .replace(/\./g, '')
                                .replace(',', '.')
                              ).toFixed(2);
                total += parseFloat(nominalTBP)
                sumberDana.push({
                  kodeRekening: kodeRekening,
                  namaRekening: namaRekening,
                  nominal: nominalTBP
                });
            });

              sumberDana.forEach(function (item) {
              $('.table-sumber-dana tbody').append(`
                <tr>
                  <td><input type="text" class="form-control" name="kode_rekening_sumber_dana[]" value="${item.kodeRekening}" readonly></td>
                  <td><input type="text" class="form-control" value="${item.namaRekening}" readonly></td>
                  <td>
                      <select class="form-control" name="sumber_dana[]">
                        ${sumberDanaOld.map(function (sumberdana) {
                          let checked = '';
                          for (let i = 0; i < sumberDanaSelected.length; i++) {
                            if (sumberDanaSelected[i].kode_akun == item.kodeRekening) {
                              if (sumberDanaSelected[i].sumber_dana_id == sumberdana.id) {
                                checked = 'selected'
                              }
                            }
                          }
                          return "<option value='"+sumberdana.id+"'"+checked+">"+sumberdana.nama_sumber_dana+"</option>";
                      }).join('')}
                      </select>
                  </td>
                  <td><input type="text" name="nominal[]" value="${formatCurrency(item.nominal)}" class="form-control" readonly></td>
                </tr>
              `);
            });

            $('#total-sumber-dana').text(`Rp. ${formatCurrency(total)}`);
          });

          // remove item
          $('.table-rba tbody').on('click', '.btn-remove', function () {
            $(this).closest('tr').remove();
          });
        });

        function getAkunRba1(){
        $.ajax({
          type: "GET",
          url: "{{ route('admin.akun.rba1') }}",
          data: "unit_kerja="+$("#unit_kerja").val(),
          success:function(response) {
            let rekening = [...response.akun];
            sumberDanaSelected = [...response.sumber_dana];
            $('.table-rekening tbody').empty();
            rekening.forEach(function (item) {
              $('.table-rekening tbody').append(`
                <tr data-kode-akun="${item.kode_akun}" data-nama-akun="${item.nama_akun}">
                  <td><input type="checkbox" name="rekening" value="${item.kode_akun}"></td>
                  <td>${item.kode_akun}</td>
                  <td>${item.nama_akun}</td>
                </tr>
              `);
            });
          }
        })
      }

      function getRekeningBendahara(){
        var dropdown = $("#rekening_bendahara");
        dropdown.empty();
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.rekeningbendahara.data') }}",
          data: "unit_kerja="+$("#unit_kerja").val()+"&jenis=penerimaan",
          success:function(response) {
            $.each(response, function() {
                dropdown.append($("<option />").val(this.id).text(this.kode_akun+" - "+this.nama_akun_bendahara));
            });
          }
        })
      }

      function getPejabatUnit(){
        var bendahara = $("#bendahara_penerima");
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

        var kepalaSkpd = $("#kepala_skpd");
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

      function typingNominal(event) {
        let tr = $(event.srcElement).closest('tr');
        let tarif = parseFloat($(event.srcElement).val().replace(/\./g, '').replace(',', '.')).toFixed(2);
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