@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Register STS <h1>
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
                <form action="{{ route('report.register_sts.store') }}" method="POST" id="form-spd">
                @csrf
                  <div class="card">
                      <div class="card-header">
                        <h4>Register STS</h4>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label>Pilih Unit Kerja</label>
                          <select name="kode_unit_kerja" class="form-control">
                            @foreach ($unitKerja as $item)
                                <option value="{{ $item->kode }}">{{ $item->nama_unit }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Tanggal Awal</label>
                          <input type="text" class="form-control date" name="tanggal_awal">
                        </div>

                        <div class="form-group">
                          <label for="">Tanggal Akhir</label>
                          <input type="text" class="form-control date" name="tanggal_akhir">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">Cetak</button>
                        </div>
                      </div>
                  </div>
                </form>
              </div>
          </div>
      </div>
  </section>
</div>

@endsection
@section('js')
  <script src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>
  <script>
    $(document).ready(function () {        
     $(".date").datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
          orientation: 'bottom',
        });
      $(".date").datepicker('update', '{{ date('Y-m-d') }}');
    });

  </script>
@endsection