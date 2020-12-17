@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Saldo Awal LO <h1>
      </div>

      <div class="section-body">
          <div class="row">

             <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.saldo_lo.create') }}">
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
                        <h4>Data Saldo Awal LO</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Nomor</th>
                              <th>Tanggal</th>
                              <th>Unit Kerja</th>
                              <th>Keterangan</th>
                              <th>Debet</th>
                              <th>Kredit</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($saldoAwal as $item)
                                <tr>
                                    <td>{{ $item->nomorfix }}</td>
                                    <td>{{ report_date($item->tanggal) }}</td>
                                    <td>{{ $item->unitKerja->nama_unit }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ format_report($item->debet) }}</td>
                                    <td>{{ format_report($item->kredit) }}</td>
                                    <td>
                                      <a href="{{ route('admin.saldo_lo.edit', $item->id) }}" class="btn btn-sm btn-warning btn-edit">
                                        <i class="fas fa-edit"></i>Edit
                                      </a>
                                      <button class="btn btn-sm btn-danger btn-delete"
                                        data-id="{{ $item->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                      </button>
                                    </td>
                                </tr>
                            @endforeach
                            <thead>
                              <th>Total</th>
                              <th colspan="3"></th>
                              <th>{{ format_report($totalDebet) }}</th>
                              <th>{{ format_report($totalKredit) }}</th>
                              <th></th>
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
<form id="form-delete" action="{{ route('admin.saldo_lo.destroy') }}" class="d-none" method="POST">
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