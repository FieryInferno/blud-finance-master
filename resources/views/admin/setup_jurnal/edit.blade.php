@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form method="POST" id="form-setupjurnal">
      @csrf
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
            
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Setup Jurnal BLUD</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="Nomor">Kode Jurnal</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="kode_jurnal" placeholder="Kode jurnal" value="{{ $setupJurnal->kode_jurnal }}">
                            </div>
                            
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Formulir</label>
                                <select name="formulir" class="form-control">
                                  <option value="" selected disabled>-- Pilih Formulir --</option>
                                  @foreach ($formulir as $item)
                                      <option value="{{ $item }}"
                                        {{ $item == $setupJurnal->formulir ? "selected" : '' }}
                                      >{{ strtoupper($item) }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" value="{{ $setupJurnal->keterangan }}">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card" style="min-height:400px">         
                  <div class="card-body">
                    <label>Entitas Akuntansi</label>
                    <div class="row">
                      <div class="col-md-6 table-responsive">
                        <div class="row my-2">
                          <div class="col-md-6">
                            <select name="tanggal_bud" class="form-control">
                              <option value="">Tanggal BKU</option>
                            </select>
                          </div>
                          <div class="col-md-6">
                            <label>Jurnal Anggaran</label>
                          </div>
                        </div>

                        <button id="add-jurnal-anggaran" type="button" class="btn btn-sm btn-primary mb-2"><i class="fas fa-plus"></i> Tambah</button>
                        <table class="table" id="table-jurnal-anggaran">
                          <thead>
                            <th></th>
                            <th>Elemen</th>
                            <th>D/K</th>
                            <th>Nominal</th>
                          </thead>
                          <tbody>
                            @foreach ($setupJurnal->anggaran as $anggaran)
                              <tr>
                                <td style="max-width:40px"><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="fas fa-minus"></i></button></td>
                                <td>
                                  <select name="rincian_anggaran[]" class="form-control">
                                    <option value="">Pilih Elemen</option>
                                    @foreach ($elemen as $key => $item)
                                        <option value="{{ $item }}"
                                          {{ $item == $anggaran->elemen_anggaran ? "selected" : "" }}
                                        > {{ str_replace('_', ' ', $item) }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td>
                                  <select name="jenis_anggaran[]" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    <option value="debet"
                                      {{ $anggaran->jenis_anggaran == "debet" ? "selected" : "" }}
                                    >Debet</option>
                                    <option value="kredit"
                                      {{ $anggaran->jenis_anggaran == "kredit" ? "selected" : "" }}
                                    >Kredit</option>
                                  </select>
                                </td>
                                <td>
                                  <select name="nominal_anggaran[]" class="form-control">
                                    <option value="">Pilih Nominal</option>
                                    @foreach ($nominal as $item)
                                        <option value="{{ $item }}"
                                          {{ $item == $anggaran->nominal_anggaran ? "selected" : "" }}
                                        >{{ strtoupper($item) }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>

                      <div class="col-md-6 table-responsive">
                        <div class="row my-2">
                          <div class="col-md-6">
                            <select name="tanggal_bud" class="form-control">
                              <option value="">Tanggal BKU</option>
                            </select>
                          </div>
                          <div class="col-md-6">
                            <label>Jurnal Finansial</label>
                          </div>
                        </div>

                        <button id="add-jurnal-finance" type="button" class="btn btn-sm btn-primary mb-2"><i class="fas fa-plus"></i> Tambah</button>
                        <table class="table" id="table-jurnal-finance">
                          <thead>
                            <th></th>
                            <th>Elemen</th>
                            <th>D/K</th>
                            <th>Nominal</th>
                          </thead>
                          <tbody>
                            @foreach ($setupJurnal->finansial as $finansial)
                              <tr>
                                <td style="max-width:40px"><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="fas fa-minus"></i></button></td>
                                <td>
                                  <select name="rincian_finansial[]" class="form-control">
                                    <option value="">Pilih Elemen</option>
                                    @foreach ($elemen as $key => $item)
                                        <option value="{{ $item }}"
                                          {{ $item == $finansial->elemen_finansial ? "selected" : "" }}
                                        >{{ str_replace('_', ' ', $item) }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td>
                                  <select name="jenis_finansial[]" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    <option value="debet"
                                      {{ $finansial->jenis_finansial == "debet" ? "selected" : "" }}
                                    >Debet</option>
                                    <option value="kredit"
                                      {{ $finansial->jenis_finansial == "kredit" ? "selected" : "" }}
                                    >Kredit</option>
                                  </select>
                                </td>
                                <td>
                                  <select name="nominal_finansial[]" class="form-control">
                                    <option value="">Pilih Nominal</option>
                                    @foreach ($nominal as $item)
                                        <option value="{{ $item }}"
                                          {{ $item == $finansial->nominal_finansial ? "selected" : "" }}
                                        >{{ strtoupper($item) }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <button type="submit" id="buttonSubmit" class="btn btn-primary mt-3">
                      <i class="fa fa-save"></i>
                      Simpan
                    </button>
                  </div>
                </div>
              </div>
          </div>
      </div>
    </form>
  </section>
</div>
@endsection
@section('js')
<script>
  $(document).ready(function () {
    var dataElemen = {!! json_encode($elemen) !!}
    var dataNominal = {!! json_encode($nominal) !!}

    $('#form-setupjurnal').on('submit', function (e) {
      e.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
        type: "PUT",
        url: "{{ route('admin.setup_jurnal.update', $setupJurnal->id) }}",
        data: formData,
        beforeSend:function() {
          $("#buttonSubmit").prop('disabled', true);
        },
        success:function(response){
          iziToast.success({
            title: 'Sukses!',
            message: 'Setup Jurnal berhasil disimpan',
            position: 'topRight',
            timeout: 2000,
            onClosed: function () {
              window.location.href = document.referrer
            }
          });
        },
        error:function (data, jqXHR) {
          let errors = [];
          let validationMessages = data.responseJSON.errors;
          for (var property in validationMessages) {
            if (validationMessages.hasOwnProperty(property)) {
              errors.push(validationMessages[property][0]);
            }
          }

          iziToast.error({
            title: 'Gagal!',
            message: errors.toString(),
            position: 'topRight'
          });

          $("#buttonSubmit").prop('disabled', false);
        }
      })
    });

    // add item jurnal anggaran
    $('#add-jurnal-anggaran').click(function () {
      $('#table-jurnal-anggaran tbody').append(`
        <tr>
          <td style="max-width:40px"><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="fas fa-minus"></i></button></td>
          <td>
            <select name="rincian_anggaran[]" class="form-control">
              <option value="">Pilih Elemen</option>
              ${dataElemen.map(function (item) {
                return "<option value='"+item+"'>"+item.replace('_', ' ')+"</option>";
              }).join('')}
            </select>
          </td>
          <td>
            <select name="jenis_anggaran[]" class="form-control">
              <option value="">Pilih Jenis</option>
              <option value="debet">Debet</option>
              <option value="kredit">Kredit</option>
            </select>
          </td>
          <td>
            <select name="nominal_anggaran[]" class="form-control">
              <option value="">Pilih Nominal</option>
              ${dataNominal.map(function (item) {
                return "<option value='"+item+"'>"+item.toUpperCase()+"</option>";
              }).join('')}
            </select>
          </td>
        </tr>
      `)
    });

    // remove item jurnal anggaran
    $('#table-jurnal-anggaran tbody').on('click', '.btn-remove', function () {
      $(this).closest('tr').remove();
    });

    // add item jurnal finance
    $('#add-jurnal-finance').click(function () {
      $('#table-jurnal-finance tbody').append(`
        <tr>
          <td style="max-width:40px"><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="fas fa-minus"></i></button></td>
          <td>
            <select name="rincian_finansial[]" class="form-control">
              <option value="">Pilih Elemen</option>
              ${dataElemen.map(function (item) {
                return "<option value='"+item+"'>"+item.replace('_', ' ')+"</option>";
              }).join('')}
            </select>
          </td>
          <td>
            <select name="jenis_finansial[]" class="form-control">
              <option value="">Pilih Jenis</option>
              <option value="debet">Debet</option>
              <option value="kredit">Kredit</option>
            </select>
          </td>
          <td>
            <select name="nominal_finansial[]" class="form-control">
              <option value="">Pilih Nominal</option>
              ${dataNominal.map(function (item) {
                return "<option value='"+item+"'>"+item.toUpperCase()+"</option>";
              }).join('')}
            </select>
          </td>
        </tr>
      `)
    });

    // remove item jurnal finance
    $('#table-jurnal-finance tbody').on('click', '.btn-remove', function () {
      $(this).closest('tr').remove();
    });
  });
</script>
@endsection