@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Setup Jurnal </h1>
      </div>

      <div class="section-body">
          <div class="row">

            <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.setup_jurnal.create') }}">
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
                        <h4>Data Setup Jurnal </h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Kode Jurnal</th>
                              <th>Formulir</th>
                              <th>Deskripsi</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($setupJurnal as $item)
                                <tr>
                                  <td>{{ $item->kode_jurnal }}</td>
                                  <td>{{ strtoupper($item->formulir) }}</td>
                                  <td>{{ $item->keterangan }}</td>
                                  <td>
                                    <a href="{{ route('admin.setup_jurnal.edit', $item->id) }}" class="btn btn-sm btn-warning btn-edit">
                                      <i class="fas fa-edit"></i>Edit
                                    </a>
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
<form id="form-delete" action="{{ route('admin.setup_jurnal.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
@endsection
@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
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
      sort: false,
  });
   $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });
</script>   
@endsection