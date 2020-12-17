@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>SPP</h1>
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

                        <table class="table table-bordered table-hover table-responsive">
                          <thead>
                            <tr>
                              <th>Nomor</th>
                              <th>Tanggal</th>
                              <th>Unit Kerja</th>
                              <th>Status</th>
                              <th>Nominal</th>
                              <th>Nama Kegiatan</th>
                              <th>Tanggal Verifikasi</th>
                              {{-- <th>No Billing</th> --}}
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($spp as $item)
                                <tr>
                                  <td>{{ $item->nomorfix }}</td>
                                  <td>{{ report_date($item->tanggal) }}</td>
                                  <td>{{ $item->unitKerja->nama_unit }}</td>
                                  <td>{!! $item->is_verified ? '<div class="badge badge-success">Diterima</div>' : '<div class="badge badge-danger">Belum terverifikasi</div>' !!}</td>
                                  <td>{{ format_idr($item->nominal_sumber_dana) }}</td>
                                  <td>{{ $item->bast->kegiatan->nama_kegiatan }}</td>
                                  <th>{{ $item->is_verified ? report_date($item->date_verified) : '-' }}</th>
                                  {{-- <th>{{ $item->is_verified ? $item->no_billing : '' }}</th> --}}
                                  <td>
                                    @if ($item->is_verified)
                                        <button class="btn btn-danger" onclick="showModalUnVerify({{ $item->id }}, '{{ $item->nomorfix }}')">Batalkan</button>
                                    @else
                                        <button class="btn btn-primary" onclick="showModalVerify({{ $item->id }}, '{{ $item->nomorfix }}', '{{ $item->tanggal }}')">Verifikasi</button>
                                    @endif
                                  </td>
                                </tr>
                            @endforeach
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
              <input type="text" name="nomor_spp" class="form-control" value="{{ old('nomor_spp') }}">
            </div>
            <div class="form-group">
              <label id="label-tanggal">Tanggal Verifikasi SPP</label>
              <input type="text" name="tanggal" id="tgl" class="form-control date" value="">
            </div>
            {{-- <div class="form-group">
              <label>No Billing</label>
              <input type="text" name="no_billing" class="form-control" min="8">
            </div> --}}
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
    $(".date-filter").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        orientation: 'bottom',
    });

    function showModalVerify(id, nomor, tanggal) {
        $("input[name=nomor_spp]").val(nomor);
        $("input[name=id]").val(id);
        $("input[name=status_verifikasi]").val(1);
        $(".date").datepicker('update', tanggal);
        $("#modalVerifikasi").modal('show');
        $("#label-tanggal").show();
        $(".date").show();
        $('.title').html('Verifikasi SPP');
    }

    function showModalUnVerify(id, nomor){
        $("input[name=nomor_spp]").val(nomor);
        $("input[name=id]").val(id);
        $("input[name=status_verifikasi]").val(0);
        $("#label-tanggal").hide();
        $(".date").hide();
        $("#modalVerifikasi").modal('show');
        $('.title').html('Batalkan Verifikasi SPP');
    }
</script>   
@endsection