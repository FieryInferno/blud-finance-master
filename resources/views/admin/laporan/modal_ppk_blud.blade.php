  <div class="modal fade" tabindex="-1" role="dialog" id="lra">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Laporan Penjabaran Realisasi Anggaran BLUD</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form action="{{ route('report.ppk.lra') }}" method="POST">
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
              <select name="unit_kerja" class="form-control">
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
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="realisasiAnggaran">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Laporan Penjabaran Realisasi Anggaran BLUD</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form action="{{ route('report.ppk.penjabaran') }}" method="POST">
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
              <select name="unit_kerja" class="form-control">
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
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="operasional">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Laporan Operasional</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form action="{{ route('report.ppk.operasional') }}" method="POST">
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
              <select name="unit_kerja" class="form-control">
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
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="ekuitas">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Laporan Ekuitas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form action="{{ route('report.ppk.ekuitas') }}" method="POST">
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
              <select name="unit_kerja" class="form-control">
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
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="neraca">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Laporan Neraca</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form action="{{ route('report.ppk.neraca') }}" method="POST">
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
              <select name="unit_kerja" class="form-control">
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
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="sal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Perubahan SAL</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form action="{{ route('report.ppk.sal') }}" method="POST">
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
              <select name="unit_kerja" class="form-control">
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
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="arusKas">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Perubahan Arus Kas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form action="{{ route('report.ppk.aruskas') }}" method="POST">
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
              <select name="unit_kerja" class="form-control">
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
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
      </div>
    </div>
  </div>