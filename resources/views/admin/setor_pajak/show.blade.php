@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form action="" method="POST" id="form-tbp">
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
                    <h4>DETAIL SP2D</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="Nomor">Nomor</label>
                          <div class="row">
                            <div class="col-md-6">
                              <input type="text" class="form-control" name="nomor"  value="{{ $setorPajak->nomorfix }}" readonly>
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
                              <input type="text" readonly value="{{ $setorPajak->setorPajak->unitKerja->nama_unit }}" class="form-control">
                          </div>
                      </div>
                  </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>Nomor BAST</label>
                          <input type="text" class="form-control" value="{{ $setorPajak->setorPajak->bast->nomor }}" readonly>
                        </div>
                        <div class="col-md-3">
                          <label>Tanggal BAST</label>
                          <input type="text" class="form-control" name="tanggal_bast" value="{{ $setorPajak->setorPajak->bast->tgl_kontrak }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Sisa SPD Total</label>
                          <input type="text" class="form-control" name="sisa_spd_total" value="{{ $setorPajak->setorPajak->sisa_spd_total }}" readonly>
                        </div>
                        <div class="col-md-4">
                          <label>Sisa SPD Kegiatan Pengajuan</label>
                          <input type="text" class="form-control" name="sisa_spd_kegiatan" value="{{ $setorPajak->setorPajak->sisa_spd_kegiatan }}" readonly>
                        </div>
                        <div class="col-md-4">
                          <label>Sisa Kas</label>
                          <input type="text" class="form-control" name="sisa_kas" value="{{ $setorPajak->setorPajak->sisa_kas }}" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                            <label>Sisa Pagu Pengajuan</label>
                            <input type="text" class="form-control" name="sisa_pagu_pengajuan" value="{{ $setorPajak->setorPajak->sisa_pagu_pengajuan }}" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Keterangan</label>
                                <input readonly type="text" class="form-control" name="keterangan" value="{{ $setorPajak->setorPajak->keterangan }}">
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
                              Data SP2D
                            </a>
                          </li>
                         
                          <li class="nav-item">
                            <a class="nav-link" id="data-pajak-tab" data-toggle="tab" href="#data_pajak" role="tab" aria-controls="data-pajak" aria-selected="false">
                              Pajak / Potongan
                            </a>
                          </li>
                         
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active show" id="rincian_anggaran" role="tabpanel" aria-labelledby="home-tab">
                              <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      <label>Bendahara Pengeluaran</label>
                                      <input type="text" class="form-control" value="{{ $setorPajak->setorPajak->bendaharaPengeluaran->nama_pejabat }}">
                                    </div>
                                    <div class="form-group">
                                      <label>PPTK</label>
                                      <input type="text" class="form-control" value="{{ $setorPajak->setorPajak->pejabatPptk->nama_pejabat }}">
                                    </div>
                                    <div class="form-group">
                                      <label>Rekening Bendahara</label>
                                     
                                      <input type="text" class="form-control" value="{{ $setorPajak->setorPajak->rekeningBendahara->kode_akun }} - {{ $setorPajak->setorPajak->rekeningBendahara->nama_akun_bendahara }}">
                                    </div>
                                    <div class="form-group">
                                      <label>Pemimpin BLUD</label>
                                      <input type="text" class="form-control" value="{{ $setorPajak->setorPajak->pejabatPemimpinBlud->nama_pejabat }}">
                                    </div>                                    
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Pihak Ketiga</label>
                                      <select name="pihak_ketiga" class="form-control" id="pihak-ketiga">
                                        <option selected value="{{ $setorPajak->setorPajak->bast->pihak_ketiga_id }}">{{ $setorPajak->setorPajak->bast->pihakKetiga->nama_perusahaan }}</option>
                                        
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
                           
                            <div class="tab-pane fade" id="data_pajak" role="tabpanel" aria-labelledby="data-pajak-tab">
                              <div class="row">
                                <div class="col-md-12">
                                  
                                  <table class="table" id="table-pajak">
                                    <thead>
                                      <th></th>
                                      <th>Nama Pajak</th>
                                      <th>Kode Akun</th>
                                      <th>Nama Akun</th>
                                      <th>Nominal</th>
                                      <th>Informasi Billing</th>
                                    </thead>
                                    <tbody>
                                      @foreach ($setorPajak->setorPajak->referensiPajak as $item)
                                          <tr>
                                            <td></td>
                                            <td>{{ $item->pajak->nama_pajak }}</td>
                                            <td>{{ $item->pajak->akun->kode_akun }}</td>
                                            <td>{{ $item->pajak->akun->nama_akun }}</td>
                                            <td>{{ format_report($item->nominal) }}</td>
                                            <td><button type="button" class="btn btn-primary mb-4 ml-3" data-pajak-id="{{ $item->pajak->id }}" onclick="informationBilling(this)">Detail</button></td>
                                          </tr>
                                      @endforeach
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

    </form>
  </section>
</div>
@include('admin.sp2d.modal.informasiBilling');
@endsection
@section('js')
  <script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>
  <script>
      var sumberDanaSelected = []
      var billingData = []
      $(document).ready(function () {
        getDataPihakKetiga();
        getDataPajakBilling();
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
            {data: 'Informasi Billing'},
          ],
          columnDefs: [
              { width: 250, targets: 1 },
              { width: 250, targets: 2 },
              { width: 250, targets: 3 },
              { width: 250, targets: 4 },
              { width: 150, targets: 5 },
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
      })

      function informationBilling(e) {
        let element = $(e);
        let pajakId = element.data('pajak-id');
        $("#billingModal").modal('show');
        let components = '<div class="row">';
        for(let i = 1; i <= 5; i++) {
          let currentBilling = `billing[${pajakId}][${i}]`;
          let bill = '-';
          let row = billingData.find(item => item.name == currentBilling);
          if(row !== undefined) {
            bill = row.value || '';
          }
          
          components += `
            <div class="col-md-12">
              <div class="form-group">
                <label>No Billing ${i}</label>
                <h5>${bill}</h5>
              </div>
            </div>
          `;
        }
        components += '</div>';
        $("#billingModal .modal-body").html(components);
      }

      function getDataPajakBilling() {
        let bills = {!! json_encode($bills) !!};

        for (let [name, value] of Object.entries(bills)) {
          billingData.push({ name, value });
        }
      }

      function rupiah(angka) {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('') + ',00';
      }
  </script>
@endsection