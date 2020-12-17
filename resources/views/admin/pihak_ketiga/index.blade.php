@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-select.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Pihak Ketiga</h1>
      </div>

      <div class="section-body">
          <div class="row">
             
              <button class="btn btn-primary mb-4 ml-3" data-toggle="modal" data-target="#createModal">
                  <i class="fas fa-plus"></i> Tambah
              </button>
              

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
                        <h4>Data Pihak Ketiga</h4>
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

                          <button type="submit" class="btn btn-outline-primary mb-2 mx-2"><i class="fa fa-filter"></i> Filter</button>
                          <a href="{{ route('admin.pihak_ketiga.index') }}" class="btn btn-outline-danger mb-2"><i class="fa fa-reset"></i> Reset</a>
                        </form>

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th class="w-25">Kode</th>
                              <th>Unit Kerja</th>
                              <th>Nama</th>
                              <th>Nama Perusahaan</th>
                              <th>Alamat</th>
                              <th>Nama Bank</th>
                              <th>No. Rekening Bank</th>
                              <th>NPWP</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($pihak as $item)
                              <tr>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->unitKerja->nama_unit }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nama_perusahaan }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->nama_bank }}</td>
                                <td>{{ $item->no_rekening }}</td>
                                <td>{{ $item->npwp }}</td>
                                <td>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $item->id }}"
                                    data-kode="{{ $item->kode }}"
                                    data-unit-kerja="{{ $item->kode_unit_kerja }}"
                                    data-nama="{{ $item->nama }}"
                                    data-nama-perusahaan="{{ $item->nama_perusahaan }}"
                                    data-alamat="{{ $item->alamat }}"
                                    data-nama-bank="{{ $item->nama_bank }}"
                                    data-no-rekening="{{ $item->no_rekening }}"
                                    data-npwp="{{ $item->npwp }}">
                                    <i class="fas fa-edit"></i> Sunting
                                  </button>
                                  <button class="btn btn-sm btn-danger btn-delete"
                                    data-id="{{ $item->id }}">
                                    <i class="fas fa-trash"></i> Hapus
                                  </button>
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

{{-- create modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="createModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat Pihak Ketiga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.pihak_ketiga.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Kode</label>
              <input type="text" name="kode" class="form-control">
            </div>
            <div class="form-group">
              <label>Unit Kerja</label>
              <select name="kode_unit_kerja" class="form-control selectpicker" data-live-search="true" title="Pilih Unit Kerja">
                @foreach ($unitKerja as $item)
                  <option value="{{ $item->kode }}"
                    @if (auth()->user()->hasRole('Puskesmas'))
                        {{ (auth()->user()->kode_unit_kerja == $item->kode ? 'selected' : '') }}
                    @endif
                    >{{ $item->kode }} - {{ $item->nama_unit }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control">
            </div>
            <div class="form-group">
              <label>Nama Perusahaan</label>
              <input type="text" name="nama_perusahaan" class="form-control">
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input type="text" name="alamat" class="form-control">
            </div>
            <div class="form-group">
              <label>Nama Bank</label>
              <input type="text" name="nama_bank" class="form-control">
            </div>
            <div class="form-group">
              <label>No. Rekening Bank</label>
              <input type="number" name="no_rekening" class="form-control">
            </div>
            <div class="form-group">
              <label>NPWP</label>
              <input type="text" name="npwp" class="form-control">
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- edit modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sunting Pihak Ketiga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.pihak_ketiga.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
            <div class="form-group">
              <label>Kode</label>
              <input type="text" id="edit-kode" name="kode" class="form-control">
            </div>
            <div class="form-group">
              <label>Unit Kerja</label>
              <select name="kode_unit_kerja" id="edit-unit-kerja" class="form-control selectpicker" data-live-search="true" title="Pilih Unit Kerja">
                @foreach ($unitKerja as $item)
                  <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->nama_unit }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" id="edit-nama" name="nama" class="form-control">
            </div>
            <div class="form-group">
              <label>Nama Perusahaan</label>
              <input type="text" id="edit-nama-perusahaan" name="nama_perusahaan" class="form-control">
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input type="text" id="edit-alamat" name="alamat" class="form-control">
            </div>
            <div class="form-group">
              <label>Nama Bank</label>
              <input type="text" id="edit-nama-bank" name="nama_bank" class="form-control">
            </div>
            <div class="form-group">
              <label>No. Rekening Bank</label>
              <input type="text" id="edit-no-rekening" name="no_rekening" class="form-control">
            </div>
            <div class="form-group">
              <label>NPWP</label>
              <input type="text" id="edit-npwp" name="npwp" class="form-control">
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- form delete --}}
<form id="form-delete" action="{{ route('admin.pihak_ketiga.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
@endsection

@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
<script src="{{ asset('dashboard/js/bootstrap-select.min.js') }}"></script>
<script>
  $(document).ready(function () {
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
      scrollX : true
    });

    $('.selectpicker').selectpicker();

    // resize datatable search box
    $('.dataTables_filter input[type="search"]').css(
      {'width':'380px','display':'inline-block'}
    );

    $('.btn-edit').click(function () {
      const id = $(this).attr('data-id');
      const kode = $(this).attr('data-kode');
      const unitKerja = $(this).attr('data-unit-kerja');
      const nama = $(this).attr('data-nama');
      const namaPerusahaan = $(this).attr('data-nama-perusahaan');
      const alamat = $(this).attr('data-alamat');
      const namaBank = $(this).attr('data-nama-bank');
      const noRekening = $(this).attr('data-no-rekening');
      const npwp = $(this).attr('data-npwp');

      // auto select options
      $('#edit-unit-kerja.selectpicker').val(unitKerja);
      $('.selectpicker').selectpicker('refresh');

      $('#edit-id').val(id);
      $('#edit-kode').val(kode);
      $('#edit-unit-kerja').val(unitKerja);
      $('#edit-nama').val(nama);
      $('#edit-nama-perusahaan').val(namaPerusahaan);
      $('#edit-alamat').val(alamat);
      $('#edit-nama-bank').val(namaBank);
      $('#edit-no-rekening').val(noRekening);
      $('#edit-npwp').val(npwp);
    });

    $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });

    // reset state when edit modal is closed
    $('#editModal').on('hidden.bs.modal', function (e) {
      $('#edit-unit-kerja option[selected]').attr('selected', false);

      $('#edit-id').val('');
      $('#edit-kode').val('');
      $('#edit-nama').val('');
      $('#edit-nama-perusahaan').val('');
      $('#edit-alamat').val('');
      $('#edit-nama-bank').val('');
      $('#edit-no-rekening').val('');
      $('#edit-no-npwp').val('');
    });
  });
</script>
@endsection