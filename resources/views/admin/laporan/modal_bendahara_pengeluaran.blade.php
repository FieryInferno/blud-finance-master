<!-- Modal Bku Bendahara BLUD -->
<div class="modal fade" tabindex="-1" role="dialog" id="bkuBendaharaBlud">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">BKU Bendahara Pengeluaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('report.bku.pengeluaran') }}" method="POST">
        @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>Tanggal Pelaporan</label>
              <input type="text" name="tanggal_pelaporan" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Tanggal Awal</label>
              <input type="text" name="tanggal_awal" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Tanggal Akhir</label>
              <input type="text" name="tanggal_akhir" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Unit Kerja</label>
              <select name="unit_kerja"  class="form-control" {{ (auth()->user()->hasRole('Puskesmas') ? 'readonly' : '') }}>
                  <option value="">Pilih Unit Kerja</option>
                  @foreach ($unitKerja as $item)
                      <option value="{{ $item->kode }}"
                        @if (auth()->user()->hasRole('Puskesmas'))
                          {{ (auth()->user()->kode_unit_kerja == $item->kode ? 'selected' : '') }}
                        @endif
                        >{{ $item->kode }} - {{ $item->nama_unit }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Cetak</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- Modal spj fungsional bendahara pengeluaran -->
<div class="modal fade" tabindex="-1" role="dialog" id="spjFungsionalPengeluaran">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">SPJ Fungsional Bendahara Pengeluaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('report.spj.pengeluaran') }}" method="POST">
      @csrf
        <div class="modal-body">
          <div class="form-group">
            <label>Tanggal Pelaporan</label>
            <input type="text" name="tanggal_pelaporan" class="form-control date" required>
          </div>
          <div class="form-group">
            <label>Tanggal Awal</label>
            <input type="text" name="tanggal_awal" class="form-control date" required>
          </div>
          <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="text" name="tanggal_akhir" class="form-control date" required>
          </div>
          <div class="form-group">
            <label>Unit Kerja</label>
            <select name="unit_kerja" class="form-control" {{ (auth()->user()->hasRole('Puskesmas') ? 'readonly' : '') }}>
                <option value="">Pilih Unit Kerja</option>
                @foreach ($unitKerja as $item)
                    <option value="{{ $item->kode }}"
                      @if (auth()->user()->hasRole('Puskesmas'))
                        {{ (auth()->user()->kode_unit_kerja == $item->kode ? 'selected' : '') }}
                      @endif
                      >{{ $item->kode }} - {{ $item->nama_unit }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Cetak</button>
        </div>
      </form>
    </div>
  </div>
</div>

  <!-- Register TBP -->
  <div class="modal fade" tabindex="-1" role="dialog" id="registerBendaharaPengeluaran">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Register SPP / SPM / SP2D</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('report.registerbendahara.pengeluaran') }}" method="POST">
        @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>Tanggal Pelaporan</label>
              <input type="text" name="tanggal_pelaporan" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Tanggal Awal</label>
              <input type="text" name="tanggal_awal" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Tanggal Akhir</label>
              <input type="text" name="tanggal_akhir" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Unit Kerja</label>
              <select name="unit_kerja" id="unit_kerja" class="form-control" {{ (auth()->user()->hasRole('Puskesmas') ? 'readonly' : '') }}>
                  <option value="">Pilih Unit Kerja</option>
                  @foreach ($unitKerja as $item)
                      <option value="{{ $item->kode }}"
                        @if (auth()->user()->hasRole('Puskesmas'))
                          {{ (auth()->user()->kode_unit_kerja == $item->kode ? 'selected' : '') }}
                        @endif
                        >{{ $item->kode }} - {{ $item->nama_unit }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Cetak</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="bukuRincianObjekPengeluaran">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buku Rincian Objek Pengeluaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('report.brop.pengeluaran') }}" method="POST">
        @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>Tanggal Pelaporan</label>
              <input type="text" name="tanggal_pelaporan" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Tanggal Awal</label>
              <input type="text" name="tanggal_awal" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Tanggal Akhir</label>
              <input type="text" name="tanggal_akhir" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Unit Kerja</label>
              <select id="unitKerjaBrop" name="unit_kerja" class="form-control" {{ (auth()->user()->hasRole('Puskesmas') ? 'readonly' : '') }}>
                  <option value="">Pilih Unit Kerja</option>
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
              <label for="">Kegiatan</label>
              <select name="map_kegiatan" id="kegiatanBrop" class="form-control">
                <option value="">Pilih Kegiatan</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Kode Rekening</label>
              <select name="kode_rekening" id="kodeRekening" class="form-control">
                <option value="">Pilih Kode Rekening</option>
              </select>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Cetak</button>
          </div>
        </form>
      </div>
    </div>
  </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="bukuPajak">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buku Pajak</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('report.buku.pajak') }}" method="POST">
        @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>Tanggal Pelaporan</label>
              <input type="text" name="tanggal_pelaporan" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Tanggal Awal</label>
              <input type="text" name="tanggal_awal" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Tanggal Akhir</label>
              <input type="text" name="tanggal_akhir" class="form-control date" required>
            </div>
            <div class="form-group">
              <label>Unit Kerja</label>
              <select name="unit_kerja" id="unit_kerja" class="form-control" {{ (auth()->user()->hasRole('Puskesmas') ? 'readonly' : '') }}>
                  <option value="">Pilih Unit Kerja</option>
                  @foreach ($unitKerja as $item)
                      <option value="{{ $item->kode }}"
                        @if (auth()->user()->hasRole('Puskesmas'))
                          {{ (auth()->user()->kode_unit_kerja == $item->kode ? 'selected' : '') }}
                        @endif
                        >{{ $item->kode }} - {{ $item->nama_unit }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Cetak</button>
          </div>
        </form>
      </div>
    </div>
  </div>