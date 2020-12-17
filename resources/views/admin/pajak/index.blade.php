@extends('layouts.admin')

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Pajak</h1>
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
                        <h4>Data Pajak</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Kode Pajak</th>
                              <th>Nama Pajak</th>
                              <th>Akun</th>
                              <th>Nama Akun</th>
                              <th>Persen</th>
                              @if (Auth::user()->hasRole('admin'))
                                <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($pajak as $item)
                              <tr>
                                <td>{{ $item->kode_pajak }}</td>
                                <td>{{ $item->nama_pajak }}</td>
                                <td>{{ $item->akun->kode_akun }}</td>
                                <td>{{ $item->akun->nama_akun }}</td>
                                <td>{{ $item->persen }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                  <td>
                                    <button class="btn btn-sm btn-warning btn-edit"
                                      data-toggle="modal" data-target="#editModal"
                                      data-id="{{ $item->id }}"
                                      data-kode-pajak="{{ $item->kode_pajak }}"
                                      data-nama-pajak="{{ $item->nama_pajak }}"
                                      data-akun-id="{{ $item->akun_id }}"
                                      data-persen="{{ $item->persen }}">
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
        <h5 class="modal-title">Buat Pajak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.pajak.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Kode Pajak</label>
              <input type="text" name="kode_pajak" class="form-control" value="{{ old('kode_pajak') }}" required>
            </div>
            <div class="form-group">
              <label>Nama Pajak</label>
              <input type="text" name="nama_pajak" class="form-control" value="{{ old('nama_pajak') }}" required>
            </div>
            <div class="form-group">
              <label>Kode Akun</label>
              <select name="akun_id" class="form-control">
                <option value="">Pilih Akun</option>
                @foreach($akun as $item)
                  <option value="{{ $item->id }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Persen</label>
              <input type="text" name="persen" class="form-control" value="{{ old('persen', 0) }}">
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
        <h5 class="modal-title">Sunting Pajak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.pajak.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
          <div class="form-group">
            <label>Kode Pajak</label>
            <input type="text" name="kode_pajak" id="edit-kode-pajak" class="form-control" value="{{ old('kode_pajak') }}" required>
          </div>
          <div class="form-group">
            <label>Nama Pajak</label>
            <input type="text" name="nama_pajak" id="edit-nama-pajak" class="form-control" value="{{ old('nama_pajak') }}" required>
          </div>
          <div class="form-group">
            <label>Kode Akun</label>
            <select name="akun_id" id="edit-akun" class="form-control">
              <option value="">Pilih Akun</option>
              @foreach($akun as $item)
                <option value="{{ $item->id }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Persen</label>
            <input type="text" name="persen" id="edit-persen" class="form-control" value="{{ old('persen') }}" value="0">
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
<form id="form-delete" action="{{ route('admin.pajak.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    @if ($message = Session::get('success'))
        iziToast.success({
        title: 'Sukses!',
        message: '{{ $message }}',
        position: 'topRight'
      });
    @endif

    $('.btn-edit').click(function () {
      const id = $(this).attr('data-id');
      const kodePajak = $(this).attr('data-kode-pajak');
      const namaPajak = $(this).attr('data-nama-pajak');
      const persen = $(this).attr('data-persen');
      const akunId = $(this).attr('data-akun-id');

      $(`#edit-akun option[value="${akunId}"]`).attr('selected', true);

      $('#edit-id').val(id);
      $('#edit-kode-pajak').val(kodePajak);
      $('#edit-nama-pajak').val(namaPajak);
      $('#edit-persen').val(persen);
    });

    $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });
  });
</script>
@endsection