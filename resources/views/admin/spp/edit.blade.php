@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form action="" method="POST" id="form-spp">
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
                    <h4>EDIT SPP</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="Nomor">Nomor</label>
                          <div class="row">
                            <div class="col-md-6">
                              <input type="text" class="form-control" name="nomor" value="{{ $spp->nomorfix }}" readonly>
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
                                        {{ $item->kode == $spp->kode_unit_kerja ? 'selected' : ''  }}
                                        >{{ $item->kode }} - {{ $item->nama_unit }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                  </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>Nomor Bukti Transaksi</label>
                          <select name="bast" class="form-control" id="bast">
                            <option value="">Pilih Nomor Bukti Transaksi</option>
                            @foreach ($bast as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $spp->bast_id ? "selected" : "" }}>
                                  {{ $item->nomor }} - {{ $item->kegiatan->nama_kegiatan }}
                                </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-3">
                          <label>Tanggal Bukti Transaksi</label>
                          <input type="text" class="form-control" name="tanggal_bast" value="{{ $spp->bast->tgl_kontrak }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Sisa SPD Total</label>
                          <input type="text" class="form-control" name="sisa_spd_total" value="{{ format_report($spp->sisa_spd_total) }}" readonly>
                        </div>
                        <div class="col-md-4">
                          <label>Sisa SPD Kegiatan Pengajuan</label>
                          <input type="text" class="form-control" name="sisa_spd_kegiatan" value="{{ format_report($spp->sisa_spd_kegiatan) }}" readonly>
                        </div>
                        <div class="col-md-4">
                          <label>Sisa Kas</label>
                          <input type="text" class="form-control" name="sisa_kas" value="{{ format_report($spp->sisa_kas) }}" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                            <label>Sisa Pagu Pengajuan</label>
                            <input type="text" class="form-control" name="sisa_pagu_pengajuan" value="{{ format_report($spp->sisa_pagu_pengajuan) }}" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" value="{{ $spp->keterangan }}">
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
                              Data SPP
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="data-tbp-tab" data-toggle="tab" href="#data_tbp" role="tab" aria-controls="data-tbp" aria-selected="false">
                              Referensi SPD
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="data-kegiatan-tab" data-toggle="tab" href="#data_kegiatan" role="tab" aria-controls="data-kegiatan" aria-selected="false">
                              Kegiatan
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="data-rincian-spp-tab" data-toggle="tab" href="#data_rincian_spp" role="tab" aria-controls="data-spp" aria-selected="false">
                              Rincian SPP
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="data-pajak-tab" data-toggle="tab" href="#data_pajak" role="tab" aria-controls="data-pajak" aria-selected="false">
                              Pajak / Potongan
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="data-sumberdana-tab" data-toggle="tab" href="#data_sumberdana" role="tab" aria-controls="data-sumberdana" aria-selected="false">
                              Sumber Dana
                            </a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active show" id="rincian_anggaran" role="tabpanel" aria-labelledby="home-tab">
                              <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      <label>Bendahara Pengeluaran</label>
                                      <select name="bendahara_pengeluaran" class="form-control" id="bendahara-pengeluaran">
                                        <option>Pilih Bendahara Pengeluaran</option>
                                        @foreach ($pejabatUnit as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $spp->bendahara_pengeluaran ? "selected" : '' }}>
                                              {{ $item->nama_pejabat }}
                                            </option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label>PPTK</label>
                                      <select name="pptk" class="form-control" id="pptk">
                                        <option>Pilih PPTK</option>
                                        @foreach ($pejabatUnit as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $spp->pptk ? "selected" : '' }}>
                                              {{ $item->nama_pejabat }}
                                            </option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label>Rekening Bendahara</label>
                                      <select name="akun_bendahara" class="form-control" id="rekening-bendahara">
                                        <option>Pilih Rekening Bendahara </option>
                                        @foreach ($rekeningBendahara as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $spp->akun_bendahara ? "selected" : '' }}>
                                              {{ $item->kode_akun }} - {{ $item->nama_akun_bendahara }}
                                            </option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label>Pemimpin BLUD</label>
                                      <select name="pemimpin_blud" class="form-control" id="peminpin_blud">
                                          <option value="">Pilih Pemimpin BLUD</option>
                                          @foreach ($pejabatUnit as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $spp->pemimpin_blud ? "selected" : '' }}>
                                              {{ $item->nama_pejabat }}
                                            </option>
                                        @endforeach
                                      </select>
                                    </div>                                    
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Pihak Ketiga</label>
                                      <select name="pihak_ketiga" class="form-control" id="pihak-ketiga">
                                        <option>Pilih Pihak Ketiga</option>
                                        @foreach ($pihakKetiga as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $spp->bast->pihak_ketiga_id ? "selected" : '' }}>
                                              {{ $item->nama_perusahaan }}
                                            </option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label>NPWP</label>
                                      <input type="text" class="form-control" name="npwp" readonly>
                                    </div>
                                    <div class="form-group">
                                      <label>Nama Bank</label>
                                      <input type="text" class="form-control" name="nama_bank" readonly>
                                    </div>
                                    <div class="form-group">
                                      <label>Rekening Bank</label>
                                      <input type="text" class="form-control" name="rekening_bank" readonly>
                                    </div>
                                    
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="data_tbp" role="tabpanel" aria-labelledby="data-tbp-tab">
                            <div class="row">
                              <div class="col-md-12">
                                <button class="btn btn-primary btn-sm mb-3" type="button" data-toggle="modal" data-target="#referensiSPDModal">
                                    <i class="fas fa-plus"></i> Pilih SPD
                                </button>
                                <table class="table" id="table-referensi-spd">
                                  <thead>
                                    <th>Nomor SPD</th>
                                    <th>SPD Tanggal</th>
                                    <th>Nominal</th>
                                  </thead>
                                  <tbody>
                                    @foreach ($spp->referensiSpd as $item)
                                        <tr>
                                          <input type="hidden" name="spd_id[]" value="{{ $item->spd_id }}">
                                          <td>{{ $item->spd->nomorfix }}</td>
                                          <td>{{ $item->spd->tanggal }}</td>
                                          <td>{{ format_report($item->spd->total) }}</td>
                                        </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                           
                            </div>
                            </div>
                            <div class="tab-pane fade" id="data_kegiatan" role="tabpanel" aria-labelledby="data-kegiatan-tab">
                            <div class="row">
                              <div class="col-md-12">
                                <table class="table" id="table-kegiatan">
                                  <thead>
                                    <th>Kode Kegiatan</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Nominal</th>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>{{ $spp->bast->kegiatan->kode_bidang }}.{{ $spp->bast->kegiatan->kode_program }}.{{ $spp->bast->kode_kegiatan }}</td>
                                      <td>{{ $spp->bast->kegiatan->nama_kegiatan }}</td>
                                      <td>{{ format_report($spp->nominal_sumber_dana) }} <input type="hidden" name="nominal_sumber_dana" value="{{ $spp->nominal_sumber_dana }}"> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            </div>
                            <div class="tab-pane fade" id="data_rincian_spp" role="tabpanel" aria-labelledby="data-rincian-spp-tab">
                            <div class="row">
                              <div class="col-md-12">
                                <table class="table" id="table-spp">
                                  <thead>
                                    <th>Kode Kegiatan</th>
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Nominal</th>
                                  </thead>
                                  <tbody>
                                    @foreach ($spp->bast->rincianPengadaan as $item)
                                        <tr>
                                          <td>{{ $spp->bast->kegiatan->kode_bidang }}.{{ $spp->bast->kegiatan->kode_program }}.{{ $spp->bast->kode_kegiatan }}</td>
                                          <td>{{ $item->kode_akun }}</td>
                                          <td>{{ $item->akun->nama_akun }}</td>
                                          <td>{{ format_report($item->unit * $item->harga) }}</td>
                                        </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            </div>
                            <div class="tab-pane fade" id="data_pajak" role="tabpanel" aria-labelledby="data-pajak-tab">
                              <div class="row">
                                <div class="col-md-12">
                                  <button class="btn btn-primary btn-sm mb-3" type="button" data-toggle="modal" data-target="#pajakModal">
                                      <i class="fas fa-plus"></i> Pilih Pajak
                                  </button>
                                  <table class="table" id="table-pajak">
                                    <thead>
                                      <th></th>
                                      <th>Nama Pajak</th>
                                      <th>Kode Akun</th>
                                      <th>Nama Akun</th>
                                      <th>Nominal</th>
                                      <th>Pungutan Pajak Informasi</th>
                                      <th>Informasi Billing</th>
                                    </thead>
                                    <tbody>
                                      @foreach ($spp->referensiPajak as $key => $item)
                                          <tr>
                                            <td><button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button></td>
                                            <td><input value="{{ $item->pajak->nama_pajak }}" class="form-control" readonly><input type="hidden" name="pajak_id[]" value="{{ $item->pajak->id }}"></td>
                                            <td><input value="{{ $item->pajak->akun->kode_akun }}" class="form-control" readonly></td>
                                            <td><input value="{{ $item->pajak->akun->nama_akun }}" class="form-control" readonly></td>
                                            <td><input type="text" name="nominal_pajak[]" class="form-control money" value="{{ $item->nominal }}"></td>
                                            <td><input type="checkbox" name="pungutan_pajak_informasi[{{ $key }}]"  {{ $item->is_information ? 'checked' : '' }}></td>
                                            <td>
                                              <button type="button" class="btn btn-primary mb-4 ml-3" data-pajak-id="{{ $item->pajak->id }}" onclick="informationBilling(this)"><i class="fas fa-plus"></i> Tambah</button>
                                              {{-- @foreach ($item->noBilling as $row)
                                                  {{ $row->no_billing }},
                                              @endforeach --}}
                                            </td>
                                          </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              </div>
                              <div class="tab-pane fade" id="data_sumberdana" role="tabpanel" aria-labelledby="data-sumberdana-tab">
                                <div class="row">
                                  <div class="col-md-12">
                                    <table class="table" id="table-sumberdana">
                                      <thead>
                                        <th>Kode Rekening</th>
                                        <th>Nama Rekening</th>
                                        <th>Sumber Dana</th>
                                        <th>Nominal</th>
                                      </thead>
                                      <tbody>
                                       @foreach ($spp->bast->rincianPengadaan as $item)
                                        <tr>
                                          <td>{{ $spp->bast->kegiatan->kode_bidang }}.{{ $spp->bast->kegiatan->kode_program }}.{{ $spp->bast->kode_kegiatan }}</td>
                                          <td>{{ $item->akun->nama_akun }}</td>
                                          <td><input type="text" name="sumber_dana[]" class="form-control" value="BLUD" readonly></td>
                                          <td>{{ format_report($item->unit * $item->harga) }}</td>
                                        </tr>
                                      @endforeach
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
                  <th>Kode Kegiatan</th>
                  <th>Nama Kegiatan</th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="referensiSPDModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih SPD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table" id="table-modal-referensi-spd" style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Nomor</th>
                  <th>Tanggal</th>
                  <th>Deskripsi</th>
                  <th>Nominal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($spd as $item)
                  <tr data-nomor="{{ $item->nomorfix }}" data-tanggal="{{ $item->tanggal }}" data-nominal="{{ $item->total_nominal }}" data-id="{{ $item->id }}">
                    <td><input type="checkbox"><input type="hidden" value="{{ $item->id }}"></td>
                    <td>{{ $item->nomorfix }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ format_report($item->total_nominal) }}</td>
                  </tr>
              @endforeach
              </tbody>
            </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="get-modal-spd">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="pajakModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Pajak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table" id="table-modal-pajak" style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Kode Pajak</th>
                  <th>Nama Pajak</th>
                  <th>Kode Akun</th>
                  <th>Nama Akun</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pajak as $item)    
                  <tr data-id="{{ $item->id }}" data-nama-pajak="{{ $item->nama_pajak }}"
                    data-kode-akun="{{ $item->akun->kode_akun }}" data-nama-akun="{{ $item->akun->nama_akun }}">
                    <td><input type="checkbox" {{ in_array($item->id, $selectedPajak) ? 'checked' : '' }}></td>
                    <td>{{ $item->kode_pajak }}</td>
                    <td>{{ $item->nama_pajak }}</td>
                    <td>{{ $item->akun->kode_akun }}</td>
                    <td>{{ $item->akun->nama_akun }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="get-modal-pajak">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@include('admin.spp.modal.informasiBilling');
@endsection
@section('js')
  <script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>
  <script>
      var sumberDanaSelected = []
      var billingData = []
      $(document).ready(function () {
        initMaskMoney();
        $('.money, input[name="nominal_pajak[]"]').each(function () {
          let value = $(this).val();
          $(this).attr('value', formatCurrency(value));
        });

        getDataPajakBilling();
        getDataPihakKetiga();
        getKegiatanBast();
        const tableRBA = $('.table-rba').DataTable({
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
              { width: 150, targets: 3 },
              { width: 150, targets: 4 },
              { width: 150, targets: 5 },
              { width: 150, targets: 6 },
          ],
          fixedColumns: true,
          display : true
        });

        const tableReferensiSPD = $('#table-referensi-spd').DataTable({
          scrollX: true,
          scrollCollapse: true,
          paging: false,
          info: false,
          bFilter: false,
          ordering: false,
          columns:[
            {data: 'Nomor SPD'},
            {data: 'Tanggal SPD'},
            {data: 'Nominal'}
          ],
          columnDefs: [
              { width: 400, targets: 0 },
              { width: 200, targets: 1 },
              { width: 200, targets: 2 },
          ],
          fixedColumns: true,
          display : true
        });

        const tablePajak = $('#table-pajak').DataTable({
          scrollX: true,
          scrollCollapse: true,
          paging: false,
          info: false,
          bFilter: false,
          ordering: false,
          columns:[
            {data: ''},
            {data: 'Nama Pajak'},
            {data: 'Kode Akun'},
            {data: 'Nama Akun'},
            {data: 'Nominal'},
            {data: 'Pungutan Pajak Informasi'},
            {data: 'Informasi Billing'},
          ],
          columnDefs: [
              { width: 250, targets: 1 },
              { width: 250, targets: 2 },
              { width: 250, targets: 3 },
              { width: 250, targets: 4 },
              { width: 250, targets: 5 },
              { width: 150, targets: 6 },
          ],
          fixedColumns: true,
          display : true
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
        });

        // remove item
        $('#table-pajak tbody').on('click', '.btn-remove', function () {
          $(this).closest('tr').remove();
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

            $("input[name=sisa_spd_total]").val(rupiah('0'));
            $("input[name=sisa_kas]").val(rupiah('0'));
            $("input[name=sisa_pagu_pengajuan]").val(rupiah('0'));
            $("input[name=sisa_spd_kegiatan]").val(rupiah('0'));
            $("input[name=tanggal_bast]").val('');

            getPejabatUnit();
            getBast();
            getRekeningBendahara();
            getPihakKetiga();
            getSpdUnitKerja();
        });

        $("#bast").change(function (){
          getPagu();
          getSpdKegiatanPengajuan();
          getKegiatanBast();
        });

        $("#pihak-ketiga").change(function (){
          getDataPihakKetiga();
        });

        $(".date").datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
          orientation: 'bottom',
        });
        $(".date").datepicker('update', '{{ $spp->tanggal }}');

        $('#form-spp').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        // console.log(formData);
        // console.log([...formData, ...billingData]);
        $.ajax({
          type: "PUT",
          url: "{{ route('admin.spp.update', $spp->id) }}",
          data: [...formData, ...billingData],
          beforeSend:function() {
            $("#buttonSubmit").prop('disabled', true);
          },
          success:function(response){
            // console.log(response);
            // $("#buttonSubmit").prop('disabled', false);
            iziToast.success({
              title: 'Sukses!',
              message: 'SPP berhasil disimpan',
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

          // event get modal spd
        $('#get-modal-spd').click(function () {
          tableReferensiSPD.clear().draw();
          let spd = []
          $('#table-modal-referensi-spd input:checked').each(function() {
            spd.push({
              id: $(this).closest('tr').attr('data-id'),
              nomor: $(this).closest('tr').attr('data-nomor'),
              tanggal: $(this).closest('tr').attr('data-tanggal'),
              nominal: $(this).closest('tr').attr('data-nominal'),
            });
          });

          let data = [];
          spd.forEach(function (item) {
            data.push({
              'Nomor SPD': `<input type="text" name="" class="form-control" value="${item.nomor}" readonly><input type="hidden" name="spd_id[]" value="${item.id}">`,
              'Tanggal SPD': `<input type="text" name="" class="form-control" value="${item.tanggal}" readonly>`,
              'Nominal': `<input type="text" name="" class="form-control money" value="${formatCurrency(item.nominal)}">`
            });
          });

          tableReferensiSPD.rows.add(data).draw();
          $('#referensiSPDModal').modal('hide');
          initMaskMoney();
        });

          // event get modal pajak
        $('#get-modal-pajak').click(function () {
          tablePajak.clear().draw();
          let pajak = []
          $('#table-modal-pajak input:checked').each(function() {
            pajak.push({
              id: $(this).closest('tr').attr('data-id'),
              namaPajak: $(this).closest('tr').attr('data-nama-pajak'),
              kodeAkun: $(this).closest('tr').attr('data-kode-akun'),
              namaAkun: $(this).closest('tr').attr('data-nama-akun'),
            });
          });

          let data = [];
          pajak.forEach(function (item, i) {
            data.push({
              '': `<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button><input type="hidden" name="pajak_id[]" value="${item.id}">`,
              'Nama Pajak': `<input type="text" name="" class="form-control" value="${item.namaPajak}" readonly>`,
              'Kode Akun': `<input type="text" name="" class="form-control" value="${item.kodeAkun}" readonly>`,
              'Nama Akun': `<input type="text" name="" class="form-control" value="${item.namaAkun}" readonly>`,
              'Nominal': `<input type="text" name="nominal_pajak[]" class="form-control money" value="0">`,
              'Pungutan Pajak Informasi': `<input type="checkbox" name="pungutan_pajak_informasi[${i}]">`,
              'Informasi Billing': `<button type="button" class="btn btn-primary mb-4 ml-3" data-pajak-id="${item.id}" onclick="informationBilling(this)"><i class="fas fa-plus"></i> Tambah</button>`,
            });
          });

          tablePajak.rows.add(data).draw();
          $('#pajakModal').modal('hide');
          initMaskMoney();
        });       
          // remove item
          $('.table-rba tbody, #table-pajak tbody').on('click', '.btn-remove', function () {
            $(this).closest('tr').remove();
          });
        });

        $("#billingModal button[type=button]").on('click', (e) => {
            e.preventDefault();
            var formData = $("#billingModal form").serializeArray();
            console.log(billingData);
            for(let i = 0; i < formData.length; i++) {
              let item = formData[i];
              let index = billingData.findIndex(billingItem => billingItem.name == item.name);
              if(index !== -1)
                billingData[index] = item;
            }
            
            $("#billingModal").modal('hide');
        });

        function informationBilling(e) {
          let element = $(e);
          let pajakId = element.data('pajak-id');
          $("#billingModal").modal('show');
          let components = '<div class="row">';
          for(let i = 1; i <= 5; i++) {
            let currentBilling = `billing[${pajakId}][${i}]`;
            let bill = '';
            if(billingData[pajakId] !== undefined) {
              let row = billingData.find(item => item.name == currentBilling);
              if(row !== undefined) {
                bill = row.value || '';
              }
            }
            components += `
              <div class="col-md-12">
                <div class="form-group">
                  <label>No Billing ${i}</label>
                  <input type="text" name="${currentBilling}" value="${bill}" class="form-control" minlength="8" autocomplete="off" />
                </div>
              </div>
            `;
          }
          components += '</div>';
          $("#billingModal .modal-body").html(components);
        }

      function getPejabatUnit(){
        var pemimpinblud = $("#peminpin_blud");
        pemimpinblud.empty();
        
        var bendahara = $("#bendahara-pengeluaran");
        bendahara.empty();
        
        var pptk = $("#pptk");
        pptk.empty();
        
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.pejabatunit.data') }}",
          data: "kode_unit_kerja="+$("#unit_kerja").val(),
          success:function(response){
            pemimpinblud.append($("<option />").text('Pilih Pemimpin BLUD'));
            bendahara.append($("<option />").text('Pilih Bendahara Pengeluaran'));
            pptk.append($("<option />").text('Pilih PPTK'));

            $.each(response.data, function() {
                pemimpinblud.append($("<option />").val(this.id).text(this.jabatan.nama_jabatan +' - '+ this.nama_pejabat));
                bendahara.append($("<option />").val(this.id).text(this.jabatan.nama_jabatan +' - '+ this.nama_pejabat));
                pptk.append($("<option />").val(this.id).text(this.jabatan.nama_jabatan +' - '+ this.nama_pejabat));
            });
          }
        })

      }

      function getBast(){
        var bast = $("#bast");
        bast.empty();
        $.ajax({
          type: "GET", 
          url: "{{ route('admin.bast.data') }}",
          data: "kode_unit_kerja="+$("#unit_kerja").val()+"&tanggal="+$("#tanggal_spp").val(),
          success:function(response){
            bast.append($("<option />").text("Pilih Bast"));
            $.each(response.data, function() {
                bast.append($("<option />").val(this.id).text(this.nomor+ ' - ' +this.kegiatan.nama_kegiatan));
            });
          }
        })
      }

      function getKegiatanBast(){
        $.ajax({
          type: "GET",
          url: "{{ route('admin.bast.kegiatan') }}",
          data: "bast_id="+$("#bast").val(),
          success:function(response){
            let data = response.data;
            
            $("#table-kegiatan tbody").html('');
            $("#table-spp tbody").html('');
            $("#table-sumberdana tbody").html('');
            if (parseInt(response.total_data) > 0){
              let kodeKegiatan = data.bast.kegiatan.kode_bidang+'.'+data.bast.kegiatan.kode_bidang+'.'+data.bast.kegiatan.kode;
              $("#pihak-ketiga").val(data.bast.pihak_ketiga_id);
              getDataPihakKetiga();
              $('#table-kegiatan tbody').append(`
                  <tr>
                    <td>${kodeKegiatan}</td>
                    <td>${data.bast.kegiatan.nama_kegiatan}</td>
                    <td>${formatCurrency(data.total)} <input type="hidden" name="nominal_sumber_dana" value="${data.total}"></td>
                  </tr>
              `);

              data.rincian.forEach(function (item){
                var nominal = parseInt(item.harga)*parseInt(item.unit);
                $('#table-spp tbody').append(`
                  <tr>
                    <td>${kodeKegiatan}</td>
                    <td>${item.kode_akun}</td>
                    <td>${item.akun.nama_akun}</td>
                    <td>${formatCurrency(nominal)}</td>
                  </tr>
                `);

                $('#table-sumberdana tbody').append(`
                  <tr>
                    <td>${item.kode_akun}</td>
                    <td>${item.akun.nama_akun}</td>
                    <td><input type="text" name="sumber_dana[]" class="form-control" value="BLUD" readonly></td>
                    <td>${formatCurrency(nominal)}</td>
                  </tr>
                `);
              })
            }
                
          }
        })
      }

      function getSpdUnitKerja(){
        $.ajax({
          type: "GET",
          url: "{{ route('admin.spd.data') }}",
          data: "kode_unit_kerja="+$("#unit_kerja").val(),
          success:function(response){
            $("#table-modal-referensi-spd tbody").html('');
            response.data.forEach(function (item){
              $('#table-modal-referensi-spd tbody').append(`
                <tr data-nomor="${item.nomorfix}" data-tanggal="${item.tanggal}" data-nominal="${item.total_nominal}" data-id="${item.id}">
                  <td><input type="checkbox"><input type="hidden" value="${item.id}"></td>
                  <td>${item.nomorfix}</td>
                  <td>${item.tanggal}</td>
                  <td>${item.keterangan}</td>
                  <td>${formatCurrency(item.total_nominal)}</td>
                </tr>
              `);
            });
          }
        });
      }

      function getPagu(){
        $.ajax({
          type: "GET",
          url: "{{ route('admin.spp.getpagu') }}",
          data: "kode_unit_kerja="+$("#unit_kerja").val(),
          success:function(response){
            let data = response.data;
            let spdTotal = data.spd_total;
            let sisaKas = data.sisa_kas;
            $("input[name=sisa_spd_total]").val(formatCurrency(spdTotal));
            $("input[name=sisa_kas]").val(formatCurrency(sisaKas));
           
          }
        })
      }

      function getSpdKegiatanPengajuan(){
        $.ajax({
          type: "GET",
          url: "{{ route('admin.spp.getkegiatanpengajuan') }}",
          data: "bast_id="+$("#bast").val(),
          success:function(response){
            let data = response.data;
            let sisaSpdKegiatan = data.sisa_spd_kegiatan;
            let sisaPaguPengajuan = data.sisa_pagu;

            $("input[name=sisa_spd_kegiatan]").val(formatCurrency(sisaSpdKegiatan));
            $("input[name=tanggal_bast]").val(data.tanggal_bast);
            if (parseInt(sisaPaguPengajuan) < 0){
              iziToast.error({
                title: 'Gagal!',
                message: 'Sisa pagu tidak mencukupi',
                position: 'topRight'
              });
              $("#buttonSubmit").prop('disabled', true);
            }else {
              $("#buttonSubmit").prop('disabled', false);
            }
            $("input[name=sisa_pagu_pengajuan]").val(formatCurrency(sisaPaguPengajuan));
            
          }
        })
      }

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

      function getPihakKetiga() {
        var pihakKetiga = $("#pihak-ketiga");
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

      function getDataPihakKetiga() {
        $.ajax({
          type: "GET",
          url: "{{ route('admin.pihakketiga.detail') }}",
          data: "id="+$("#pihak-ketiga").val(),
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

      function getDataPajakBilling() {
          let bills = {!! json_encode($bills) !!};

          for (let [name, value] of Object.entries(bills)) {
            billingData.push({ name, value });
          }
        }

      function typingNominal(event) {
        let tr = $(event.srcElement).closest('tr');
        let tarif = parseInt($(event.srcElement).val().replace(/,.*|[^0-9]/g, ''), 10);
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