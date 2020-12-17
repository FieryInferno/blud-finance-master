@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Laporan</h1>
      </div>

      <div class="section-body">
          <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="col-md-12 my-2 mt-4">
                      <div class="row">
                        <div class="col-12 col-sm-12 col-md-4">
                          <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active show" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">Bendahara Penerimaan BLUD</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">Bendahara Pengeluaran BLUD</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab" aria-controls="contact" aria-selected="false">PPK BLUD</a>
                            </li>
                          </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8" style="width:100%">
                          <div class="tab-content no-padding" id="myTab2Content">
                            <div class="tab-pane fade active show" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                              <div class="section-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="activities">

                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#bkuBendaharaPenerimaan">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            BKU Bendahara Penerimaan
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#spjFungsional">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            SPJ Fungsional Bendahara Penerimaan
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#bukuRincianObjek">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Buku Rincian Objek Penerimaan
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#registerTbp">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Register TBP
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#registerSts">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Register STS
                                          </p>
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                            <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">

                              <div class="section-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="activities">

                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#bkuBendaharaBlud">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            BKU Bendahara Pengeluaran
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#spjFungsionalPengeluaran">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            SPJ Fungsional Bendahara Pengeluaran
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity"  style="cursor:pointer" data-toggle="modal" data-target="#bukuRincianObjekPengeluaran">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Buku Rincian Objek Pengeluaran
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#bukuPajak">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Buku Pajak
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity"  style="cursor:pointer" data-toggle="modal" data-target="#registerBendaharaPengeluaran" >
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Register SPP / SPM / SP2D
                                          </p>
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                            <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
                              <div class="section-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="activities">

                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#realisasiAnggaran">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Laporan Penjabaran Realisasi Anggaran BLUD
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Buku Besar
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#lra">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Laporan Realisasi Anggaran (LRA)
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#operasional">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Laporan Operasional (LO)
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#ekuitas">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Laporan Perubahan Ekuitas (LPE)
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#neraca">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Neraca
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#sal">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Laporan Perubahan SAL
                                          </p>
                                        </div>
                                      </div>
                                      <div class="activity" style="cursor:pointer" data-toggle="modal" data-target="#arusKas">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                          <i class="fas fa-download"></i>
                                        </div>
                                        <div class="activity-detail bg-light w-100">
                                          <p>
                                            Laporan Arus Kas
                                          </p>
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
                </div>
            </div>
          </div>
      </div>
  </section>
</div>

@include('admin.laporan.modal_bendahara_penerimaan')
@include('admin.laporan.modal_bendahara_pengeluaran')
@include('admin.laporan.modal_ppk_blud')

@endsection
@section('js')
  <script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    @if ($message = Session::get('success'))
        iziToast.success({
        title: 'Sukses!',
        message: '{{ $message }}',
        position: 'topRight'
      });
    @endif
    $(".date").datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight: true,
      orientation: 'bottom',
    });
    $(".date").datepicker('update', '{{ date('Y-m-d') }}');
    $(document).ready(function (){
      @if (auth()->user()->hasRole('Puskesmas'))
        getKegiatan();
        getRincianAkunPenerimaan();
      @endif

      $("#unitKerjaBukuRincian").change(function (){
        getRincianAkunPenerimaan();
      })

      $("#unitKerjaBrop").change(function(){
        getKegiatan();
      })
      

      $("#kegiatanBrop").change(function(){
        getRincianAkun();
      })
    })

    function getKegiatan() {
      $.ajax({
          url: "{{ route('admin.rincianakun.rba221') }}",
          type: "GET",
          data: "unit_kerja="+$("#unitKerjaBrop").val()+"&kegiatan=1",
          success:function(response){
            $("#kegiatanBrop").empty();
            $("#kegiatanBrop").append($('<option>').val('').text("Pilih Kegiatan"));
            response.data.forEach( function (item){
              $("#kegiatanBrop").append($('<option>').val(item.map_kegiatan_id).text(item.kode_kegiatan+" - "+item.nama_kegiatan));
            })
          }
        })
    }

    function getRincianAkun() {
        $.ajax({
          url: "{{ route('admin.rincianakun.rba221') }}",
          type: "GET",
          data: "unit_kerja="+$("#unitKerjaBrop").val()+"&map_kegiatan="+$("#kegiatanBrop").val(),
          success:function(response){
            $("#kodeRekening").empty();
            $("#kodeRekening").append($('<option>').val('').text("Pilih Kode Rekening"));
            response.data.forEach( function (item){
              $("#kodeRekening").append($('<option>').val(item.kode_akun).text(item.kode_akun+" - "+item.nama_akun));
            })
          }
        })
    }

    function getRincianAkunPenerimaan() {
        $.ajax({
          url: "{{ route('admin.rincianakun.rba1') }}",
          type: "GET",
          data: "unit_kerja="+$("#unitKerjaBukuRincian").val(),
          success:function(response){
            $("#kodeRekeningPenerimaan").empty();
            $("#kodeRekeningPenerimaan").append($('<option>').val('').text("Pilih Kode Rekening"));
            response.data.forEach( function (item){
              $("#kodeRekeningPenerimaan").append($('<option>').val(item.kode_akun).text(item.kode_akun+" - "+item.nama_akun));
            })
          }
        })
    }
    
</script>   
@endsection