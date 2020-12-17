@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>SP3BP</h1>
      </div>
      <div class="section-body">
          <div class="row">
            <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.sp3bp.create') }}">
              <i class="fas fa-plus"></i> Tambah
            </a>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    <h4>Data SP3BP</h4>
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
                              <th>Triwulan</th>
                              <th>Total Pendapatan</th>
                              <th>Total Pengeluaran</th>
                              <th>Dibuat Pada</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($sp3b as $item)
                              <tr>
                                <td>{{ $item->nomor }}</td>
                                <td>{{ report_date($item->tanggal) }}</td>
                                <td>{{ $item->unitKerja->nama_unit }}</td>
                                <td>{{ $item->triwulan }}</td>
                                <th>{{ format_report($item->total_pendapatan) }}</th>
                                <th>{{ format_report($item->total_pengeluaran) }}</th>
                                <td>{{ $item->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.sp3bp.edit', $item->id) }}" class="btn btn-sm btn-warning btn-edit">
                                      <i class="fas fa-edit"></i>Edit
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete"
                                      data-id="{{ $item->id }}">
                                      <i class="fas fa-trash"></i> Hapus
                                    </button>
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-success"><i class="fa fa-file"></i> Cetak</button>
                                      <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                      </button>
                                      <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.sp3bp.reportsp3b', $item->id) }}">Cetak SP3B</a>
                                        @if ($item->is_verified)
                                              <a class="dropdown-item" href="{{ route('admin.sp3bp.reportsp2b', [$item->id, 'sp2b']) }}">Cetak SP2B</a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('admin.sp3bp.reportsptj', $item->id) }}">Cetak SPTJ</a>
                                      </div>
                                    </div>
                                </td>
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
<form id="form-delete" action="{{ route('admin.sp3bp.destroy') }}" class="d-none" method="POST">
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