@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Rekening Bendahara</h1>
      </div>

      <div class="section-body">
          <div class="row">
              @if (Auth::user()->hasRole('admin'))
              <button class="btn btn-primary mb-4 ml-3" data-toggle="modal" data-target="#createModal">
                  <i class="fas fa-plus"></i> Tambah
              </button>
              @endif

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
                        <h4>Data Rekening Bendahara</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Unit Kerja</th>
                              <th>Jenis</th>
                              <th>Nama Akun Bendahara</th>
                              <th>Kode Akun</th>
                              <th>Nama Akun</th>
                              <th>Nama Bank</th>
                              <th>No. Rekening Bank</th>
                              @if (Auth::user()->hasRole('admin'))
                                <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($bendahara as $item)
                              <tr>
                                <td>{{ $item->kode_unit_kerja }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->nama_akun_bendahara }}</td>
                                <td>{{ $item->kode_akun }}</td>
                                <td>{{ $item->akun->nama_akun }}</td>
                                <td>{{ $item->nama_bank }}</td>
                                <td>{{ $item->rekening_bank }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                <td>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $item->id }}"
                                    data-unit-kerja="{{ $item->kode_unit_kerja }}"
                                    data-jenis="{{ $item->jenis }}"
                                    data-nama-akun-bendahara="{{ $item->nama_akun_bendahara }}"
                                    data-kode-akun="{{ $item->kode_akun }}"
                                    data-nama-bank="{{ $item->nama_bank }}"
                                    data-rekening-bank="{{ $item->rekening_bank }}">
                                    <i class="fas fa-edit"></i> Sunting
                                  </button>
                                  <button class="btn btn-sm btn-danger btn-delete"
                                    data-id="{{ $item->id }}">
                                    <i class="fas fa-trash"></i> Hapus
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
        <h5 class="modal-title">Buat Rekening Bendahara</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.rekening_bendahara.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Unit Kerja</label>
              <select name="kode_unit_kerja" class="form-control">
                <option value="" selected disabled>-- Pilih Unit Kerja --</option>
                @foreach ($unitKerja as $item)
                  <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->nama_unit }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Jenis</label>
              <select name="jenis" class="form-control">
                <option value="" selected disabled>-- Pilih Jenis --</option>
                <option value="penerimaan">Penerimaan</option>
                <option value="pengeluaran">Pengeluaran</option>
              </select>
            </div>
            <div class="form-group">
              <label>Nama Akun Bendahara</label>
              <input type="text" name="nama_akun_bendahara" class="form-control" value="{{ old('nama_akun_bendahara') }}" required>
            </div>
            <div class="form-group">
              <label>Kode Akun</label>
              <select name="kode_akun" class="form-control">
                <option value="" selected disabled>-- Pilih Akun --</option>
                @foreach ($sortedAkun as $item)
                  <option value="{{ $item->kode_akun }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Nama Bank</label>
              <select name="nama_bank" class="form-control">
                <option value="" selected disabled>-- Pilih Bank --</option>
                <option value="bank jatim">Bank Jatim</option>
                <option value="tunai">Tunai</option>
              </select>
            </div>
            <div class="form-group">
              <label>No. Rekening Bank</label>
              <input type="text" name="rekening_bank" class="form-control" value="{{ old('rekening_bank') }}" required>
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
        <h5 class="modal-title">Sunting Bidang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.rekening_bendahara.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
          <div class="form-group">
              <label>Unit Kerja</label>
              <select name="kode_unit_kerja" id="edit-unit-kerja" class="form-control">
                <option value="" selected disabled>-- Pilih Unit Kerja --</option>
                @foreach ($unitKerja as $item)
                  <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->nama_unit }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Jenis</label>
              <select name="jenis" id="edit-jenis" class="form-control">
                <option value="" selected disabled>-- Pilih Jenis --</option>
                <option value="penerimaan">Penerimaan</option>
                <option value="pengeluaran">Pengeluaran</option>
              </select>
            </div>
            <div class="form-group">
              <label>Nama Akun Bendahara</label>
              <input type="text" id="edit-nama-akun-bendahara" name="nama_akun_bendahara" class="form-control" value="{{ old('nama_akun_bendahara') }}" required>
            </div>
            <div class="form-group">
              <label>Kode Akun</label>
              <select name="kode_akun" id="edit-kode-akun" class="form-control">
                <option value="" selected disabled>-- Pilih Akun --</option>
                @foreach ($sortedAkun as $item)
                  <option value="{{ $item->kode_akun }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Nama Bank</label>
              <select name="nama_bank" id="edit-nama-bank" class="form-control">
                <option value="" selected disabled>-- Pilih Bank --</option>
                <option value="bank jatim">Bank Jatim</option>
                <option value="tunai">Tunai</option>
              </select>
            </div>
            <div class="form-group">
              <label>No. Rekening Bank</label>
              <input type="text" id="edit-rekening-bank" name="rekening_bank" class="form-control" value="{{ old('rekening_bank') }}" required>
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
<form id="form-delete" action="{{ route('admin.rekening_bendahara.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
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
      const unitKerja = $(this).attr('data-unit-kerja');
      const jenis = $(this).attr('data-jenis');
      const namaAkunBendahara = $(this).attr('data-nama-akun-bendahara');
      const kodeAkun = $(this).attr('data-kode-akun');
      const namaBank = $(this).attr('data-nama-bank');
      const rekeningBank = $(this).attr('data-rekening-bank');

      // auto select options
      $(`#edit-unit-kerja option[value="${unitKerja}"]`).attr('selected', true)
      $(`#edit-jenis option[value="${jenis}"]`).attr('selected', true)
      $(`#edit-kode-akun option[value="${kodeAkun}"]`).attr('selected', true)

      $('#edit-id').val(id);
      $('#edit-nama-akun-bendahara').val(namaAkunBendahara);
      $('#edit-nama-bank').val(namaBank);
      $('#edit-rekening-bank').val(rekeningBank);
    });

    $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });

    // reset state when edit modal is closed
    $('#editModal').on('hidden.bs.modal', function (e) {
      $('#edit-fungsi option[selected]').attr('selected', false);
      $('#edit-urusan option[selected]').attr('selected', false);

      $('#edit-id').val('');
      $('#edit-kode').val('');
      $('#edit-nama').val('');
    });
  });
</script>
@endsection