@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Setor Pajak</h1>
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
                        <h4>Data Setor Pajak</h4>
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
                          <a href="{{ route('admin.setor_pajak.index') }}" class="btn btn-outline-danger mb-2"><i class="fa fa-reset"></i> Reset</a>
                        </form>

                        @php
                            $totalNominal = 0;
                        @endphp

                        <table class="table tableData table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Nomor</th>
                              <th>Tanggal</th>
                              <th>Pajak</th>
                              <th>No SPP</th>
                              <th>Unit Kerja</th>
                              <th>Nominal</th>
                              <th>Nama Kegiatan</th>
                              <th>NTPN</th>
                              <th>NPWP</th>
                              <th>Keterangan</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($setorPajak as $item)
                                <tr>
                                  <td>{{ $item->nomorfix }}</td>
                                  <td>{{ report_date($item->setorPajak->tanggal) }}</td>
                                  <td>{{ $item->pajak->nama_pajak }}</td>
                                  <td>{{ $item->setorPajak->spp->nomorspp }}</td>
                                  <td>{{ $item->setorPajak->unitKerja->nama_unit }}</td>
                                  <td>{{ format_idr($item->nominal) }}</td>
                                  <td>{{ $item->setorPajak->bast->kegiatan->nama_kegiatan }}</td>
                                  <td>{{ $item->ntpn }}</td>
                                  <td>{{ $item->npwp }}</td>
                                  <td>
                                    {{ $item->is_information ? 'Pajak sebagai informasi' : '' }}
                                  </td>
                                  <td>
                                    <a href="{{ route('admin.setor_pajak.show', $item->id) }}" class="btn btn-primary">
                                      Detail
                                    </a>
                                    <button class="btn btn-warning" onclick="showModalPajak({{ $item->id }}, '{{ $item->nomorfix }}', '{{ $item->ntpn }}', '{{ $item->npwp }}')">Ubah</button>
                                  </td>
                                </tr>
                                @php
                                    $totalNominal += $item->nominal;
                                @endphp
                            @endforeach
                          </tbody>
                        </table>
                        <table class="table tableNominal">
                          <thead>
                            <th colspan="5">Total Nominal</th>
                            <th>{{ format_idr($totalNominal) }}</th>
                            <th colspan="4"></th>
                          </thead>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modalPajak">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title">Ubah Data Setor Pajak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.setor_pajak.update') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Nomor Pajak</label>
              <input type="text" name="nomor_pajak" class="form-control" readonly required>
            </div>
            <div class="form-group">
              <label id="label-tanggal">NTPN</label>
              <input type="text" name="ntpn" class="form-control" required>
            </div>

            <div class="form-group">
              <label id="label-tanggal">NPWP</label>
              <input type="text" name="npwp" class="form-control" required>
            </div>
            <input type="hidden" name="id" value="">
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

   $('.tableData').DataTable({
      paging: false,
      info: false,
      sort: false,
      scrollX: true,
      columnDefs: [
            { width: 100, targets: 0 },
            { width: 100, targets: 1 },
            { width: 100, targets: 2 },
            { width: 100, targets: 3 },
            { width: 100, targets: 4 },
            { width: 100, targets: 5 },
            { width: 250, targets: 6 },
            { width: 100, targets: 7 },
            { width: 100, targets: 8 }
        ],
      fixedColumns: true,
  });

   $('.tableNominal').DataTable({
      paging: false,
      info: false,
      sort: false,
      scrollX: true,
      searching: false,
      columnDefs: [
            { width: 100, targets: 0 },
            { width: 100, targets: 1 },
            { width: 100, targets: 2 },
            { width: 100, targets: 3 },
            { width: 100, targets: 4 },
            { width: 100, targets: 5 },
            { width: 250, targets: 6 },
            { width: 100, targets: 7 },
            { width: 100, targets: 8 }
        ],
      fixedColumns: true,
  });
  function showModalPajak(id, nomorPajak, ntpn, npwp){
    $("input[name=nomor_pajak]").val(nomorPajak);
    $("input[name=ntpn]").val(ntpn);
    $("input[name=npwp]").val(npwp);
    $("input[name=id]").val(id);
    $("#modalPajak").modal('show');
  }
</script>   
@endsection