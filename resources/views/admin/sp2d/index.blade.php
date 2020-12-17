@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>SP2D <h1>
      </div>

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
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header">
                        <h4>Data SP2D</h4>
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
                            <input type="text" class="form-control date" name="start_date" value="{{ request()->query('start_date') }}" placeholder="Tgl Mulai" autocomplete="off">
                          </div>
                          <div class="form-group mb-2 mx-2">
                            <input type="text" class="form-control date" name="end_date" value="{{ request()->query('end_date') }}" placeholder="Tgl Sampai" autocomplete="off">
                          </div>
                          <button type="submit" class="btn btn-outline-primary mb-2 mx-2"><i class="fa fa-filter"></i> Filter</button>
                          <a href="{{ route('admin.sp2d.index') }}" class="btn btn-outline-danger mb-2"><i class="fa fa-reset"></i> Reset</a>
                        </form>

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Nomor</th>
                              <th>Tanggal</th>
                              <th>Unit Kerja</th>
                              <th>Nominal</th>
                              <th>Nama Kegiatan</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $totalSp2d = 0;
                            @endphp
                            @foreach ($sp2d as $item)
                                <tr>
                                  <td>{{ $item->nomorfix }}</td>
                                  <td>{{ report_date($item->tanggal) }}</td>
                                  <td>{{ $item->unitKerja->nama_unit }}</td>
                                  <td>{{ format_idr($item->nominal_sumber_dana) }}</td>
                                  <td>{{ $item->bast->kegiatan->nama_kegiatan }}</td>
                                  <td>
                                    <a href="{{ route('admin.sp2d.show', $item->id) }}" class="btn btn-primary">
                                      <i class="fas fa-plus"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.sp2d.report', $item->id) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-file"></i> Cetak
                                      </a>
                                  </td>
                                </tr>
                                @php
                                    $totalSp2d += $item->nominal_sumber_dana;
                                @endphp
                            @endforeach
                            <thead>
                              <th>Total</th>
                              <th colspan="2"></th>
                              <th>{{ format_idr($totalSp2d) }}</th>
                              <th colspan="2"></th>
                            </thead>
                          </tbody>
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
      <form action="{{ route('admin.verifikasispp.update') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Nomor SPP</label>
              <input type="text" name="nomor_spp" class="form-control" value="{{ old('nomor_spp') }}" required>
            </div>
            <div class="form-group">
              <label id="label-tanggal">Tanggal Verifikasi SPP</label>
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

    $(".date").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        orientation: 'bottom',
    });

   $('table').DataTable({
      paging: false,
      info: false,
      sort: false
  });

</script>   
@endsection