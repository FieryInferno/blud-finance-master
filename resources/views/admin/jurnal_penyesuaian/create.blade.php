@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form action="" method="POST" id="form-jurnal-penyesuaian">
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
                    <h4>BUAT JURNAL PENYESUAIAN</h4>
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
                        <div class="col-md-4">
                          <label>Tanggal</label>
                          <input type="text" class="form-control date" name="tanggal" id="tanggal_spp" value="{{ date('Y-m-d') }}">
                        </div>
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
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="basis" id="kas" value="kas" checked>
                        <label class="form-check-label" for="radio1">
                          Basis Kas
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="basis" value="aktual">
                        <label class="form-check-label" for="radio2">
                          Basis Aktual
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card" style="min-height:400px">
                      
                      <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active show" id="data-jurnal-penyesuaian" data-toggle="tab" href="#data_jurnal_penyesuaian" role="tab" aria-controls="data-tbp" aria-selected="false">
                              Rincian Penyesuaian
                            </a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active show" id="data_jurnal_penyesuaian" role="tabpanel" aria-labelledby="data-jurnal-penyesuaian">
                            <div class="row">
                              <div class="col-md-12">
                                <button class="btn btn-primary btn-sm mb-3" type="button" data-toggle="modal" data-target="#akunModal">
                                    <i class="fas fa-plus"></i> Pilih Akun
                                </button>
                                <table class="table" id="table-jurnal-penyesuaian">
                                  <thead>
                                    <th></th>
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Kode Kegiatan</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                  </thead>
                                  <tbody>
                                  
                                  </tbody>
                                </table>
                              </div>
                           
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
                  <th>Kode Kegiatan</th>
                  <th>Nama Kegiatan</th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach ($akun as $item)
                  <tr class="{{ $item->is_parent ? 'table-primary' : '' }}" data-kode-akun="{{ $item->kode_akun }}" data-nama-akun="{{ $item->nama_akun }}">
                    <td>
                      @if (! $item->is_parent)
                          <input type="checkbox">
                      @endif
                    </td>
                    <td>{{ $item->kode_akun }}</td>
                    <td>{{ $item->nama_akun }}</td>
                  </tr>
                @endforeach --}}

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
      $(document).ready(function () {
        
        @if (auth()->user()->hasRole('Puskesmas'))
          getAkun();
        @endif

        const tableSaldoAwal = $('#table-jurnal-penyesuaian').DataTable({
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
            {data: 'Kode Kegiatan'},
            {data: 'Nama Kegiatan'},
            {data: 'Debet'},
            {data: 'Kredit'}
          ],
          columnDefs: [
              { width: 200, targets: 1 },
              { width: 400, targets: 2 },
              { width: 200, targets: 3 },
              { width: 400, targets: 4 },
              { width: 200, targets: 5 },
              { width: 200, targets: 6 }
          ],
          fixedColumns: true,
          display : true
        });

        $('input[name="penomoran_otomatis"]').click(function () {
          if($(this). prop("checked") == true){
            $('input[name=nomor]').val('');
            $('input[name=nomor]').prop('readonly', true);
          }else {
            $('input[name=nomor]').prop('readonly', false);
          }
        });

        $('input[name="basis"]').click(function () {
          $("#table-jurnal-penyesuaian tbody").html('');
          getAkun();
        });

        $('#unit_kerja').change(function (){
          $("#table-jurnal-penyesuaian tbody").html('');
          getAkun();
        });

        function getAkun(){
          var jenis = $('#kas').is(':checked') ? 'kas' : 'aktual';
          $.ajax({
            url: "{{ route('admin.jurnal_penyesuaian.akun') }}",
            type: "GET",
            data: "jenis="+jenis+"&unit_kerja="+$("#unit_kerja").val(),
            success:function(response){
              let data = response.data
                $('.table-rekening tbody').empty();
                data.forEach(function (item) {
                  $('.table-rekening tbody').append(`
                    <tr class="${item.is_parent ? 'table-primary' : ''}"
                      data-kode-akun="${item.kode_akun}"
                      data-nama-akun="${item.nama_akun}"
                      data-kode-kegiatan="${item.kode_kegiatan}"
                      data-nama-kegiatan="${item.nama_kegiatan}"
                      data-kegiatan-id="${item.kegiatan_id}">
                    <td>${!item.is_parent ? '<input type="checkbox"></td>' : ''}
                    <td>${item.kode_akun}</td>
                    <td>${item.nama_akun}</td>
                    <td>${item.kode_kegiatan}</td>
                    <td>${item.nama_kegiatan}</td>
                  </tr>`);
                });
            }
          });
        }

        $(".date").datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
          orientation: 'bottom',
        });
        $(".date").datepicker('update', '{{ date('Y-m-d') }}');

        $('#form-jurnal-penyesuaian').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: "POST",
          url: "{{ route('admin.jurnal_penyesuaian.save') }}",
          data: formData,
          beforeSend:function() {
            $("#buttonSubmit").prop('disabled', true);
          },
          success:function(response){
            iziToast.success({
              title: 'Sukses!',
              message: 'Data berhasil disimpan',
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
              kode: $(this).closest('tr').attr('data-kode-akun'),
              nama: $(this).closest('tr').attr('data-nama-akun'),
              kode_kegiatan: $(this).closest('tr').attr('data-kode-kegiatan'),
              nama_kegiatan: $(this).closest('tr').attr('data-nama-kegiatan'),
              kegiatan_id: $(this).closest('tr').attr('data-kegiatan-id'),
            });
          });

          let data = [];
          rekening.forEach(function (item) {
            let isExist = false;

            // prevent duplicate rows
            if ($('#table-jurnal-penyesuaian tbody tr').find('input[name="kode_akun[]"]').length) {
              $('#table-jurnal-penyesuaian tbody tr').each(function () {
                let kodeAkun = $(this).children('td').eq(1).find('input[name="kode_akun[]"]').val();

                if (kodeAkun == item.kode) {
                  isExist = true
                }
              });

              if (! isExist) {
                data.push({
                  '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>`,
                  'Kode Akun': `<input type="text" name="kode_akun[]" class="form-control" value="${item.kode}" readonly>`,
                  'Nama Akun': `<input type="text" name="nama_akun[]" class="form-control" value="${item.nama}" readonly>`,
                  'Kode Kegiatan': `<input type="text" name="kode_kegiatan[]" class="form-control" value="${item.kode_kegiatan}" readonly><input type="hidden" name="kegiatan_id[]" value="${item.kegiatan_id}">`,
                  'Nama Kegiatan': `<input type="text" name="nama_kegiatan[]" class="form-control" value="${item.nama_kegiatan}" readonly>`,
                  'Debet': '<input type="text" name="debet[]" class="form-control money" value="0">',
                  'Kredit': '<input type="text" name="kredit[]" class="form-control money" value="0">',
                });
              }
            } else {
              data.push({
                '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>`,
                'Kode Akun': `<input type="text" name="kode_akun[]" class="form-control" value="${item.kode}" readonly>`,
                'Nama Akun': `<input type="text" name="nama_akun[]" class="form-control" value="${item.nama}" readonly>`,
                'Kode Kegiatan': `<input type="text" name="kode_kegiatan[]" class="form-control" value="${item.kode_kegiatan}" readonly><input type="hidden" name="kegiatan_id[]" value="${item.kegiatan_id}">`,
                'Nama Kegiatan': `<input type="text" name="nama_kegiatan[]" class="form-control" value="${item.nama_kegiatan}" readonly>`,
                'Debet': '<input type="text" name="debet[]" class="form-control money" value="0">',
                'Kredit': '<input type="text" name="kredit[]" class="form-control money" value="0">',
              });
            }
          });

          tableSaldoAwal.rows.add(data).draw();
          $('#akunModal').modal('hide');
          initMaskMoney();
        });  
 
          // remove item
          $('#table-jurnal-penyesuaian tbody').on('click', '.btn-remove', function () {
            $(this).closest('tr').remove();
          });

          $('#buttonSubmit').click(function (event) {
            let jumlahDebet = 0;
            let jumlahKredit = 0;

            // check jumlah rekening
            let length = $('#table-jurnal-penyesuaian tbody tr').length;
            if (length <= 1) {
              iziToast.error({
                title: 'Gagal!',
                message: 'Minimal harus terdapat dua rekening',
                position: 'topRight'
              });
              event.preventDefault();
              return false;
            }

            $('#table-jurnal-penyesuaian tbody tr').each(function (index, element) {
              let debet = parseFloat($(element).children('td').find('input[name="debet[]"]').val().replace(/\./g, '').replace(',', '.')).toFixed(2)
              let kredit = parseFloat($(element).children('td').find('input[name="kredit[]"]').val().replace(/\./g, '').replace(',', '.')).toFixed(2)

              jumlahDebet += parseFloat(debet)
              jumlahKredit += parseFloat(kredit)
            });

            if (jumlahDebet != jumlahKredit) {
              iziToast.error({
                title: 'Gagal!',
                message: 'Debet dan Kredit tidak sesuai',
                position: 'topRight'
              });
              event.preventDefault();
              return false;
            }
          });
        });

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