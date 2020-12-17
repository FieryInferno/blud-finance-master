@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

    <form action="{{ route('admin.bast.update', $bast->id) }}" method="POST" id="form-tbp">
      @csrf
      @method('PUT')
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
                    <h4>SUNTING BUKTI TRANSAKSI</h4>
                  </div>
                  <div class="card-body">
                    <input type="hidden" class="form-control" name="id" value="{{ $bast->id }}">

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>Nomor</label>
                          <input type="text" class="form-control" name="nomor" value="{{ $bast->nomor }}">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-3">
                          <label>Nomor Kontrak</label>
                          <input type="text" class="form-control" name="nomor_kontrak" value="{{ $bast->no_kontrak }}">
                        </div>
                        <div class="col-sm-3">
                          <label>Tanggal Kontrak</label>
                          <input type="text" class="form-control date" name="tanggal_kontrak">
                        </div>
                        <div class="col-sm-3">
                          <label>Nominal Kontrak</label>
                        <input type="text" class="form-control money" name="nominal_kontrak" value="{{ format_report($bast->nominal) }}">
                        </div>
                        <div class="col-sm-3">
                          <label>Nominal Perolehan</label>
                          <input type="text" class="form-control money" name="nominal_perolehan" readonly>
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
                                          @else
                                            {{ ($bast->kode_unit_kerja == $item->kode ? 'selected' : '') }}
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
                                <label>Kegiatan</label>
                                <select name="kegiatan" id="kegiatan" class="form-control">
                                    <option value="">Pilih Kegiatan</option>
                                   
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                              <label>Pihak Ketiga</label>
                              <select name="pihak_ketiga" id="pihak_ketiga" class="form-control">
                                  <option value="">Pilih Pihak Ketiga</option>
                                  @foreach ($pihakKetiga as $item)
                                    <option value="{{ $item->id }}"
                                      {{ ($bast->pihak_ketiga_id == $item->id) ? 'selected' : '' }}>{{ $item->nama_perusahaan }}</option>
                                  @endforeach
                              </select>
                            </div>
                            <div class="col-sm-6">
                              <label>Pejabat Pembuat Komitmen</label>
                              <select name="pejabat_pembuat_komitmen" id="pejabat_pembuat_komitmen" class="form-control">
                                  <option value="">Pilih Pembuat Komitmen</option>
                                  @foreach ($pejabatUnit as $item)
                                    <option value="{{ $item->id }}"
                                      {{ ($bast->pembuat_komitmen == $item->id) ? 'selected' : '' }}>{{ $item->jabatan->nama_jabatan }} - {{ $item->nama_pejabat }}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                              <label>Nama Perusahaan</label>
                              <input type="text" class="form-control" name="nama_perusahaan">
                            </div>
                            <div class="col-sm-6">
                              <label>Pimpinan Perusahaan</label>
                              <input type="text" class="form-control" name="pimpinan_perusahaan">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                              <label>NPWP</label>
                              <input type="text" class="form-control" name="npwp" readonly>
                            </div>
                            <div class="col-sm-4">
                              <label>Nama Bank</label>
                              <input type="text" class="form-control" name="nama_bank" readonly>
                            </div>
                            <div class="col-sm-4">
                              <label>Rekening Bank</label>
                              <input type="text" class="form-control" name="rekening_bank" readonly>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card" style="min-height:400px">
                      
                      <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active show" id="data-pengadaan" data-toggle="tab" href="#rincianpengadaan" role="tab" aria-controls="data-tbp" aria-selected="false">
                              Rincian Pengadaan
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#penerimaanpemeriksaan" role="tab" aria-controls="home" aria-selected="false">
                              Penerimaan Pemeriksaan
                            </a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active show" id="rincianpengadaan" role="tabpanel" aria-labelledby="data-pengadaan">
                            <div class="row">
                              <div class="col">
                                <table class="table" id="table-rincian-pengadaan">
                                  <thead>
                                    <th></th>
                                    <th>Kode Akun</th>
                                    <th>Uraian</th>
                                    <th>Satuan</th>
                                    <th>Unit</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Bukti Transaksi</th>
                                    <th>Kondisi</th>
                                    <th>Nominal Kontrak</th>
                                    <th>Total BAST Lalu</th>
                                    <th>Sisa Kontrak</th>
                                    <th>Nominal Perolehan</th>
                                  </thead>
                                  <tbody>
                                    @foreach ($akun as $item)
                                      <tr class="text-dark table-primary">
                                        <td><button type="button" class="btn btn-add btn-sm btn-primary is-parent parent-item"><i class="fas fa-plus"></i></button></td>
                                        <td>{{ $item->kode_akun }}</td>
                                        <td>{{ $item->nama_akun }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                      </tr>

                                      @foreach ($bast->rincianPengadaan->where('kode_akun', $item->kode_akun) as $value)
                                        <tr class="text-dark">
                                          <td>
                                            <button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>
                                          </td>
                                          <td>
                                            <input type="text" name="kode_akun[]" class="form-control" value="{{ $value->kode_akun }}" readonly>
                                          </td>
                                          <td>
                                          <input type="text" name="uraian[]" class="form-control" value="{{ $value->uraian }}">
                                          </td>
                                          <td>
                                            <input type="text" name="satuan[]" class="form-control" value="{{ $value->satuan }}">
                                          </td>
                                          <td>
                                            <input type="text" name="unit[]" class="form-control" value="{{ $value->unit }}" onkeyup="typingUnit(event)">
                                          </td>
                                          <td>
                                            <input type="text" name="harga[]" class="form-control money" onkeyup="typingHarga(event)" value="{{ format_report($value->harga) }}">
                                          </td>
                                          <td>
                                            <input type="text" name="jumlah[]" class="form-control" value="{{ format_report($value->unit * $value->harga) }}" readonly>
                                          </td>
                                          <td>
                                            <input type="text" name="bukti_transaksi[]" class="form-control" value="{{ $value->bukti_transaksi }}">
                                          </td>
                                          <td>
                                            <input type="text" name="kondisi[]" class="form-control" value="{{ $value->kondisi }}">
                                          </td>
                                          <td>
                                            <input type="text" name="" class="form-control money" readonly>
                                          </td>
                                          <td>
                                            <input type="text" name="" class="form-control money" readonly>
                                          </td>
                                          <td>
                                            <input type="text" name="" class="form-control money" readonly>
                                          </td>
                                          <td>
                                            <input type="text" name="" class="form-control money" readonly>
                                          </td>
                                        </tr>
                                      @endforeach
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            
                            </div>

                            <div class="tab-pane fade" id="penerimaanpemeriksaan" role="tabpanel" aria-labelledby="home-tab">
                              <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <div class="row">
                                    <div class="col-sm-4">
                                      <label>Nomor Pemeriksaan</label>
                                      <input type="text" class="form-control" name="nomor_pemeriksaan" value="{{ $bast->no_pemeriksaan }}">
                                    </div>
                                    <div class="col-sm-4">
                                      <label>Tanggal Pemeriksaan</label>
                                      <input type="text" class="form-control date" name="tanggal_pemeriksaan">
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="row">
                                    <div class="col-sm-4">
                                      <label>Nomor Penerimaan</label>
                                      <input type="text" class="form-control" name="nomor_penerimaan" value="{{ $bast->no_penerimaan }}">
                                    </div>
                                    <div class="col-sm-4">
                                      <label>Tanggal Penerimaan</label>
                                      <input type="text" class="form-control date" name="tanggal_penerimaan">
                                    </div>
                                  </div>
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
      $(document).ready(function () {
       
        getDataPihakKetiga();
        initMaskMoney();
        getKegiatanRba221();
        $("#unit_kerja").change(function(){
          getPihakKetiga();
          getPejabatUnit();
        });

        $("#pihak_ketiga").change(function (){
          getDataPihakKetiga();
        });

        $("#kegiatan").change(function() {
          getKodeAkun();
        });

        var tableRincianPengadaan = $('#table-rincian-pengadaan').DataTable({
          createdRow: function( row, data, dataIndex ) {
            if ($(row).find('button').hasClass('is-parent')) {
              $(row).addClass('table-primary');
            }

            $(row).addClass('text-dark');
          },
          scrollX: true,
          scrollCollapse: true,
          paging: false,
          info: false,
          bFilter: false,
          ordering: false,
          columns:[
            {data: ''},
            {data: 'Kode Akun'},
            {data: 'Uraian'},
            {data: 'Satuan'},
            {data: 'Unit'},
            {data: 'Harga'},
            {data: 'Jumlah'},
            {data: 'Bukti Transaksi'},
            {data: 'Kondisi'},
            {data: 'Nominal Kontrak'},
            {data: 'Total BAST Lalu'},
            {data: 'Sisa Kontrak'},
            {data: 'Nominal Perolehan'},
          ],
          columnDefs: [
              { width: 150, targets: 1 },
              { width: 350, targets: 2 },
              { width: 200, targets: 3 },
              { width: 200, targets: 4 },
              { width: 200, targets: 5 },
              { width: 200, targets: 6 },
              { width: 200, targets: 7 },
              { width: 200, targets: 8 },
              { width: 200, targets: 9 },
              { width: 200, targets: 9 },
              { width: 200, targets: 9 },
              { width: 200, targets: 9 },
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
        $("input[name='tanggal_kontrak']").datepicker('update', '{{ $bast->tgl_kontrak }}');
        $("input[name='tanggal_pemeriksaan']").datepicker('update', '{{ $bast->tgl_pemeriksaan }}');
        $("input[name='tanggal_penerimaan']").datepicker('update', '{{ $bast->tgl_penerimaan }}');

        // add item
        $('#table-rincian-pengadaan tbody').on('click', '.btn-add', function () {
          let tr = $(this).closest('tr');
          let index = tableRincianPengadaan.row(tr).index();
          let kode = $(tr).children().eq(1).text();
          let element = `
              <tr class="text-dark">
                <td>
                  <button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>
                </td>
                <td>
                  <input type="text" name="kode_akun[]" class="form-control" value="${kode}" readonly>
                </td>
                <td>
                  <input type="text" name="uraian[]" class="form-control">
                </td>
                <td>
                  <input type="text" name="satuan[]" class="form-control">
                </td>
                <td>
                  <input type="text" name="unit[]" class="form-control" value="0" onkeyup="typingUnit(event)">
                </td>
                <td>
                  <input type="text" name="harga[]" class="form-control money" onkeyup="typingHarga(event)" value="0">
                </td>
                <td>
                  <input type="text" name="jumlah[]" class="form-control" readonly>
                </td>
                <td>
                  <input type="text" name="bukti_transaksi[]" class="form-control">
                </td>
                <td>
                  <input type="text" name="kondisi[]" class="form-control">
                </td>
                <td>
                  <input type="text" name="" class="form-control money" readonly>
                </td>
                <td>
                  <input type="text" name="" class="form-control money" readonly>
                </td>
                <td>
                  <input type="text" name="" class="form-control money" readonly>
                </td>
                <td>
                  <input type="text" name="" class="form-control money" readonly>
                </td>
              </tr>
            `;

          let rowParent = $(tr).nextAll('tr.table-primary').first();
          if (rowParent.length) {
            $(rowParent).before(element);
          } else {
            $('#table-rincian-pengadaan tbody').append(element);
          }

          initMaskMoney();
        });

          // remove item
          $('#table-rincian-pengadaan tbody').on('click', '.btn-remove', function () {
            $(this).closest('tr').remove();
          });

          function getKodeAkun(){
            $.ajax({
              type: "GET",
              url: "{{ route('admin.akun.kegiatan') }}",
              data: "unit_kerja="+$("#unit_kerja").val()+"&kegiatan="+$("#kegiatan").val(),
              success:function(response){
                tableRincianPengadaan.clear().draw();
                let data = [];
                response.data.forEach(function (item) {
                  data.push({
                    '': '<button type="button" class="btn btn-add btn-sm btn-primary is-parent parent-item"><i class="fas fa-plus"></i></button>',
                    'Kode Akun': item.kode_akun,
                    'Uraian': item.nama_akun,
                    'Satuan': '',
                    'Unit': '',
                    'Harga': '',
                    'Jumlah': '',
                    'Bukti Transaksi': '',
                    'Kondisi': '',
                    'Nominal Kontrak': '',
                    'Total BAST Lalu': '',
                    'Sisa Kontrak': '',
                    'Nominal Perolehan': ''
                  });
                });

                tableRincianPengadaan.rows.add(data).draw();
              }
            })
          }

          $('#form-tbp').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
              type: "PUT",
              url: "{{ route('admin.bast.update', $bast->id) }}",
              data: formData,
              beforeSend:function() {
                $("#buttonSubmit").prop('disabled', true);
              },
              success:function(response){
                iziToast.success({
                  title: 'Sukses!',
                  message: 'BAST berhasil disimpan',
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

      function getKegiatanRba221() {
        var id = {{ $bast->kegiatan_id }};
        var kegiatan = $("#kegiatan");
        kegiatan.empty();
        $.ajax({
          type: "GET",
          url: "{{ route('admin.akun.kegiatanrba221') }}",
          data: "unit_kerja="+$("#unit_kerja").val(),
          success:function(response) {
            kegiatan.append($("<option />").text('Pilih kegiatan'));
            $.each(response.data, function() {
                kegiatan.append($("<option />").val(this.id).text(this.kode + " - " + this.nama_kegiatan));
            });
             $("#kegiatan option[value="+id+"]").prop('selected', true);
          }
        })
      } 

      function getPihakKetiga() {
        var pihakKetiga = $("#pihak_ketiga");
        pihakKetiga.empty();
        $.ajax({
          type: "GET",
          url: "{{ route('admin.pihakketiga.data') }}",
          data: "unit_kerja="+$("#unit_kerja").val(),
          success:function(response) {
            pihakKetiga.append($("<option />").text('Pilih pihak ketiga'));
            $.each(response.data, function() {
                pihakKetiga.append($("<option />").val(this.id).text(this.nama_perusahaan));
            });
          }
        })
      }

      function getPejabatUnit(){
        var pejabat = $("#pejabat_pembuat_komitmen");
        pejabat.empty();
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.pejabatunit.data') }}",
          data: "kode_unit_kerja="+$("#unit_kerja").val(),
          success:function(response){
            pejabat.append($("<option />").text('Pilih pembuat komitmen'));
            $.each(response.data, function() {
                pejabat.append($("<option />").val(this.id).text(this.jabatan.nama_jabatan + " - " + this.nama_pejabat));
            });
          }
        })
      }

      function getDataPihakKetiga() {
        $.ajax({
          type: "GET",
          url: "{{ route('admin.pihakketiga.detail') }}",
          data: "id="+$("#pihak_ketiga").val(),
          success:function(response) {
            let pihakKetiga = response.data;
            $("input[name=nama_perusahaan]").val(pihakKetiga.nama_perusahaan);
            $("input[name=pimpinan_perusahaan]").val(pihakKetiga.nama);
            $("input[name=npwp]").val(pihakKetiga.npwp);
            $("input[name=nama_bank]").val(pihakKetiga.nama_bank);
            $("input[name=rekening_bank]").val(pihakKetiga.no_rekening);
          }
        })
      }

      function typingUnit(event) {
        let tr = $(event.srcElement).closest('tr');
        let unit = parseInt($(event.srcElement).val());
        let harga = parseFloat(
                      $(tr).children('td').find('input[name="harga[]"]').val()
                      .replace(/\./g, '').replace(',', '.')
                    ).toFixed(2);
        if (Number.isNaN(parseFloat(harga))) harga = 0;
        let jumlah = unit * parseFloat(harga);

        if (! Number.isInteger(unit)) {
          $(tr).children('td').find('input[name="jumlah[]"]').val(0)
          return;
        } else {
          $(tr).children('td').find('input[name="jumlah[]"]').val(formatCurrency(jumlah));
        }
      }

      function typingHarga(event) {
        let tr = $(event.srcElement).closest('tr');
        let harga = parseFloat($(event.srcElement).val().replace(/\./g, '').replace(',', '.')).toFixed(2);
        let unit = parseInt($(tr).children('td').find('input[name="unit[]"]').val());
        let jumlah = unit * parseFloat(harga);
        if (Number.isNaN(parseFloat(harga))) {
          $(tr).children('td').find('input[name="jumlah[]"]').val(0)
          return;
        } else {
          $(tr).children('td').find('input[name="jumlah[]"]').val(formatCurrency(jumlah));
        }
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