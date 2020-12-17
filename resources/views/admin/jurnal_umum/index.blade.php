@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Jurnal Umum</h1>
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
                        <h4>Data Jurnal Umum</h4>
                      </div>
                      <div class="card-body">
                        @php
                            $tipe = [
                              'Jurnal Penyesuaian', 'Saldo Awal Neraca', 'Saldo Awal LO', 'SP2D', 'STS', 'Setor Pajak', 'Kontrapos'
                            ];
                        @endphp
                        <form class="form-inline">
                          <div class="form-group mb-2 mx-2">
                            <select name="tipe" class="form-control">
                              <option value="">-- Semua Tipe --</option>
                              @foreach ($tipe as $item)
                                <option value="{{ strtolower(str_replace(' ', '_', $item)) }}"
                                  {{ (strtolower(str_replace(' ', '_', $item)) == request()->query('tipe')) ? 'selected' : '' }}
                                >{{ $item }}</option>
                              @endforeach
                            </select>
                          </div>
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
                          <div class="form-group mb-2 mx-2">
                            <input type="text" class="form-control" name="kode_akun" value="{{ request()->query('kode_akun') }}" placeholder="Kode akun">
                          </div>
                          
                          <button type="submit" class="btn btn-outline-primary mb-2 mx-2"><i class="fa fa-filter"></i> Filter</button>
                          <a href="{{ route('admin.jurnal_umum.index') }}" class="btn btn-outline-danger mb-2"><i class="fa fa-reset"></i> Reset</a>
                        </form>

                        <table class="table table-bordered table-hover tableData">
                          <thead>
                            <tr>
                              <th>Tanggal</th>
                              <th>Tipe</th>
                              <th>Nomor</th>
                              <th>Unit Kerja</th>
                              <th>Kode Akun</th>
                              <th>Nama Akun</th>
                              <th>Debet</th>
                              <th>Kredit</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $totalDebet = 0;
                                $totalKredit = 0;
                            @endphp
                            @foreach ($jurnalPenyesuaian as $jp)
                                <tr>
                                  <td>{{ report_date($jp->jurnalPenyesuaian->tanggal) }}</td>
                                  <td>Jurnal Penyesuaian</td>
                                  <td>{{ $jp->nomorfix }}</td>
                                  <td>{{ $jp->jurnalPenyesuaian->unitKerja->nama_unit }}</td>
                                  <td>{{ $jp->akun->kode_akun }}</td>
                                  <td>{{ $jp->akun->nama_akun }}</td>
                                  <td>{{ format_report($jp->debet) }}</td>
                                  <td>{{ format_report($jp->kredit) }}</td>
                                </tr>
                                @php
                                    $totalDebet+=$jp->debet;
                                    $totalKredit+=$jp->kredit;
                                @endphp
                            @endforeach
                            @foreach ($saldoAwalLo as $lo)
                                <tr>
                                  <td>{{ report_date($lo->saldoAwal->tanggal) }}</td>
                                  <td>SALDO AWAL LO</td>
                                  <td>{{ $lo->nomorfix }}</td>
                                  <td>{{ $lo->saldoAwal->unitKerja->nama_unit }}</td>
                                  <td>{{ $lo->akun->kode_akun }}</td>
                                  <td>{{ $lo->akun->nama_akun }}</td>
                                  <td>{{ format_report($lo->debet) }}</td>
                                  <td>{{ format_report($lo->kredit) }}</td>
                                </tr>
                                @php
                                    $totalDebet+=$lo->debet;
                                    $totalKredit+=$lo->kredit;
                                @endphp
                            @endforeach

                            @foreach ($saldoAwalNeraca as $neraca)
                                <tr>
                                  <td>{{ report_date($neraca->saldoAwal->tanggal) }}</td>
                                  <td>SALDO AWAL NERACA</td>
                                  <td>{{ $neraca->nomorfix }}</td>
                                  <td>{{ $neraca->saldoAwal->unitKerja->nama_unit }}</td>
                                  <td>{{ $neraca->akun->kode_akun }}</td>
                                  <td>{{ $neraca->akun->nama_akun }}</td>
                                  <td>{{ format_report($neraca->debet) }}</td>
                                  <td>{{ format_report($neraca->kredit) }}</td>
                                </tr>
                                @php
                                    $totalDebet+=$neraca->debet;
                                    $totalKredit+=$neraca->kredit;
                                @endphp
                            @endforeach
                            @foreach ($allJurnalUmum as $jurnalUmum)
                                <tr>
                                  <td>{{ report_date($jurnalUmum['tanggal']) }}</td>
                                  <td>{{ $jurnalUmum['tipe'] }}</td>
                                  <td>{{ $jurnalUmum['nomor'] }}</td>
                                  <td>{{ $jurnalUmum['unit_kerja'] }}</td>
                                  <td>{{ $jurnalUmum['kode_map_akun'] }}</td>
                                  <td>{{ $jurnalUmum['nama_map_akun'] }}</td>
                                  <td>{{ $jurnalUmum['jenis'] == 'debet' ? format_report($jurnalUmum['nominal']) : format_report(0) }}</td>
                                  <td>{{ $jurnalUmum['jenis'] == 'kredit' ? format_report($jurnalUmum['nominal']) : format_report(0) }}</td>
                                </tr>
                                @php
                                    if ($jurnalUmum['jenis'] == 'debet'){
                                      $totalDebet += $jurnalUmum['nominal'];
                                    }else {
                                      $totalKredit += $jurnalUmum['nominal'];
                                    }
                                @endphp
                            @endforeach
                            
                          </tbody>
                        </table>
                        <table class="table">
                          <tr class="table-secondary">
                              <td>Total Debet</td>
                              <td>{{ format_report($totalDebet) }}</td>
                              <td>Total kredit</td>
                              <td>{{ format_report($totalKredit) }}</td>
                          </tr>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
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

    @if ($message = Session::get('error'))
        iziToast.error({
        title: 'Error!',
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
      scrollY: '100vh',
  });

</script>   
@endsection