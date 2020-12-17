@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Prefix Penomoran</h1>
      </div>

      <div class="section-body">
          <div class="row">
            <button class="btn btn-primary mb-4 ml-3" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-info"></i> Petunjuk
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
                        <h4>Prefix Penomoran</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Formulir</th>
                              <th>Format Penomoran</th>
                              @if (Auth::user()->hasRole('admin'))
                                <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($prefixs as $item)
                              <tr>
                                <td>{{ $item->formulir }}</td>
                                <td>{{ $item->format_penomoran }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                  <td>
                                    <button class="btn btn-sm btn-warning btn-edit"
                                      data-toggle="modal" data-target="#editModal"
                                      data-id="{{ $item->id }}"
                                      data-formulir="{{ $item->formulir }}"
                                      data-format="{{ $item->format_penomoran }}">
                                      <i class="fas fa-edit"></i> Sunting
                                    </button>
                                  </td>
                                @endif
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
        <h5 class="modal-title">Petunjuk Format Penomoran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <h6 class="font-weight-bold">{nomor:#:AN}</h6>
          <p>Penomoran form diikuti jumlah digit. Bila <strong>:AN</strong> ditambahkan maka penomoran tidak memperhatikan variabel lainnya.</p>
          <h6 class="font-weight-bold">{skpd:#}</h6>
          <p>1. Kode SKPD 2. Kode SKPD Lengkap</p>
          <h6 class="font-weight-bold">{tipe}</h6>
          <p>Tipe Aktivitas</p>
          <h6 class="font-weight-bold">{tahun}</h6>
          <p>Tahun sesuai dengan tanggal pencatatan</p>
          <h6 class="font-weight-bold">{bulan}</h6>
          <p>Bulan sesuai dengan tanggal pencatatan</p>
          <h6 class="font-weight-bold">{triwulan}</h6>
          <p>Triwulan sesuai dengan tanggal pencatatan</p>
          <h6 class="font-weight-bold">{keperluan}</h6>
          <p>Keperluan Belanja</p>
          <h6 class="font-weight-bold">{beban}</h6>
          <p>Beban Belanja</p>
          <h6 class="font-weight-bold">{adm}</h6>
          <p>Kode Adminisitrasi</p>
          <h6 class="font-weight-bold">{spp}</h6>
          <p>Hanya berlaku untuk SPP/SPM/SP2D. Untuk belanja Gaji diisi 'GJ'. Selain itu diisi sesuai dengan keperluan</p>
          <h6 class="font-weight-bold">{unit_kerja}</h6>
          <p>Kode Unit Kerja</p>
        </div>
        <!-- <table class="table table-repsonsive">
          <tr>
          </tr>
        </table> -->
      </div>
    </div>
  </div>
</div>

{{-- edit modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sunting Prefix Penomoran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.prefix.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
          <div class="form-group">
            <label>Formulir</label>
            <input type="text" id="edit-formulir" name="formulir" class="form-control" value="{{ old('formulir') }}" required>
          </div>
          <div class="form-group">
            <label>Format Penomoran</label>
            <input type="text" id="edit-format" name="format" class="form-control" value="{{ old('format') }}" required>
          </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection

@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
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
      info: false
    });

    // resize datatable search box
    $('.dataTables_filter input[type="search"]').css(
      {'width':'380px','display':'inline-block'}
    );

    $('.btn-edit').click(function () {
      const id = $(this).attr('data-id');
      const formulir = $(this).attr('data-formulir');
      const format = $(this).attr('data-format');

      $('#edit-id').val(id);
      $('#edit-formulir').val(formulir);
      $('#edit-format').val(format);
    });

    // reset state when edit modal is closed
    $('#editModal').on('hidden.bs.modal', function (e) {
      $('#edit-id').val('');
      $('#edit-formulir').val('');
      $('#edit-format').val('');
    });
  });
</script>
@endsection