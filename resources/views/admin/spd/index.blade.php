@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>SPD</h1>
      </div>

      <div class="section-body">
          <div class="row">

            <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.spd.create') }}">
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
                        <h4>Data SPD</h4>
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
                          <a href="{{ route('admin.spd.index') }}" class="btn btn-outline-danger mb-2"><i class="fa fa-reset"></i> Reset</a>
                        </form>

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Nomor</th>
                              <th>Tanggal</th>
                              <th>Unit Kerja</th>
                              <th>Nominal</th>
                              <th>Triwulan</th>
                              <th>Bulan Awal</th>
                              <th>Bulan Akhir</th>
                              <th>Dibuat Pada</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($spd as $item)
                              <tr>
                                  <th>{{ $item->nomorfix }}</th>
                                  <th>{{ report_date($item->tanggal) }}</th>
                                  <th>{{ $item->unitKerja->nama_unit }}</th>
                                  <th>{{ format_idr($item->total_nominal) }}</th>
                                  <th>{{ $item->triwulan }}</th>
                                  <th>{{ $item->bulan_awal }}</th>
                                  <th>{{ $item->bulan_akhir }}</th>
                                  <th>{{ $item->created_at->diffForHumans() }}</th>
                                  <th>
                                      <a href="{{ route('admin.spd.report', $item->id) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-file"></i>Cetak
                                      </a>
                                      <a href="{{ route('admin.spd.edit', $item->id) }}" class="btn btn-sm btn-warning btn-edit">
                                        <i class="fas fa-edit"></i>Edit
                                      </a>
                                      <button class="btn btn-sm btn-danger btn-delete"
                                        data-id="{{ $item->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                      </button>
                                  </th>
                                </tr>
                            @endforeach
                            <thead>
                              <tr>
                                <th>Total </th>
                                <th colspan="2"></th>
                                <th>{{ format_idr($totalAllSpd) }}</th>
                                <th colspan="5"></th>
                              </tr>
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
<form id="form-delete" action="{{ route('admin.spd.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
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
   $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });
</script>   
@endsection