@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Verifikasi SP3B</h1>
      </div>

      <div class="section-body">
          <div class="row">

            <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.spp.create') }}">
              <i class="fas fa-plus"></i> Tambah
            </a>

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
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header">
                        <h4>Data SPP</h4>
                      </div>
                      <div class="card-body">
                        <form class="form-inline">
                          @if (auth()->user()->hasRole('Admin'))
                            <div class="form-group mb-2 mx-2">
                              <select name="unit_kerja" class="form-control">
                                <option value="">-- Semua Unit Kerja --</option>
                                @foreach ($unitKerja as $item)
                                  <option value="{{ $item->kode }}"
                                    {{ ($item->kode == request()->query('unit_kerja')) ? 'selected' : '' }}
                                    >{{ $item->nama_unit }}</option>
                                @endforeach
                              </select>
                            </div>
                          @endif

                          <div class="form-group mb-2 mx-2">
                            <input type="text" class="form-control date-filter" name="start_date" value="{{ request()->query('start_date') }}" placeholder="Tgl Mulai" autocomplete="off">
                          </div>
                          <div class="form-group mb-2 mx-2">
                            <input type="text" class="form-control date-filter" name="end_date" value="{{ request()->query('end_date') }}" placeholder="Tgl Sampai" autocomplete="off">
                          </div>
                          <button type="submit" class="btn btn-outline-primary mb-2 mx-2"><i class="fa fa-filter"></i> Filter</button>
                          <a href="{{ route('admin.verifikasispp.index') }}" class="btn btn-outline-danger mb-2"><i class="fa fa-reset"></i> Reset</a>
                        </form>

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Nomor</th>
                              <th>Tanggal</th>
                              <th>Unit Kerja</th>
                              <th>Triwulan</th>
                              <th>Pendapatan</th>
                              <th>Pengeluaran</th>
                              <th>Tanggal Verifikasi</th>
                              <th>Dibuat Pada</th>
                              @if (Auth::user()->hasRole('admin'))
                                <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($sp3b as $item)
                              <tr>
                                <td>{{ $item->nomor }}</td>
                                <td>{{ report_date($item->tanggal) }}</td>
                                <td>{{ $item->unitKerja->nama_unit }}</td>
                                <td>{{ $item->triwulan }}</td>
                                <td>{{ format_report($item->total_pendapatan) }}</td>
                                <td>{{ format_report($item->total_pengeluaran) }}</td>
                                <td>{!! $item->is_verified ? report_date($item->date_verified) : '<label class="badge badge-danger">Belum terverifikasi</label>' !!}</td>
                                <td>{{ $item->created_at->diffForHumans() }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                  <td>
                                      @if ($item->is_verified)
                                          <button class="btn btn-danger" onclick="showModalUnVerify({{ $item->id }}, '{{ $item->nomor }}')">Batalkan</button>
                                      @else
                                          <button class="btn btn-primary" onclick="showModalVerify({{ $item->id }}, '{{ $item->nomor }}')">Verifikasi</button>
                                      @endif
                                  </td>
                                @endif
                              </tr>
                            @endforeach
                          </tbody>
                          <thead>
                            <th colspan="4"></th>
                            <th>{{ format_report($totalAllPendapatan) }}</th>
                            <th>{{ format_report($totalAllPengeluaran) }}</th>
                            <th colspan="2"></th>
                          </thead>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalVerifikasi">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.sp3bp.verification') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Nomor SP3B</label>
              <input type="text" name="nomor_sp3b" class="form-control" value="{{ old('nomor_sp3b') }}" required>
            </div>
            <div class="form-group">
              <label id="label-tanggal">Tanggal Verifikasi SP3B</label>
              <input type="text" name="tanggal" class="form-control date" value="{{ date('Y-m-d') }}" required>
            </div>
            <input type="hidden" name="id" value="">
            <input type="hidden" name="status_verifikasi" value="">
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
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
    @if ($message = Session::get('success'))
        iziToast.success({
        title: 'Sukses!',
        message: '{{ $message }}',
        position: 'topRight'
      });
    @endif

   $('table').DataTable({
      paging: false,
      info: false,
      sort: false
  });
    $(".date").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        orientation: 'bottom',
    });
    $(".date").datepicker('update', '{{ date('Y-m-d') }}');
    $(".date-filter").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        orientation: 'bottom',
    });

    function showModalVerify(id, nomor) {
        $("input[name=nomor_sp3b]").val(nomor);
        $("input[name=id]").val(id);
        $("input[name=status_verifikasi]").val(1);
        $("#modalVerifikasi").modal('show');
        $("#label-tanggal").show();
        $(".date").show();
        $('.title').html('Verifikasi SPP');
    }

    function showModalUnVerify(id, nomor){
        $("input[name=nomor_sp3b]").val(nomor);
        $("input[name=id]").val(id);
        $("input[name=status_verifikasi]").val(0);
        $("#label-tanggal").hide();
        $(".date").hide();
        $("#modalVerifikasi").modal('show');
        $('.title').html('Batalkan Verifikasi SPP');
    }
</script>   
@endsection