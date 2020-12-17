<!-- Modal bku bendahara penerimaan -->
  <div class="modal fade" tabindex="-1" role="dialog" id="bkuBendaharaPenerimaan">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">BKU Bendahara Penerimaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('report.bku_bendahara.store') }}" method="POST">
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

  <!-- Modal SPJ Fungsional -->
  <div class="modal fade" tabindex="-1" role="dialog" id="spjFungsional">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">SPJ Fungsional Bendahara Penerimaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('report.spj_fungsional.store') }}" method="POST">
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

  <!-- Modal Buku Rincian Objek -->
  <div class="modal fade" tabindex="-1" role="dialog" id="bukuRincianObjek">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buku Rincian Objek Penerimaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('report.buku_rincian.store') }}" method="POST">
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
              <select name="unit_kerja"id="unitKerjaBukuRincian" class="form-control" {{ (auth()->user()->hasRole('Puskesmas') ? 'readonly' : '') }}>
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
              <label for="">Kode Rekening</label>
              <select name="kode_rekening" id="kodeRekeningPenerimaan" class="form-control">
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

  <!-- Register TBP -->
  <div class="modal fade" tabindex="-1" role="dialog" id="registerTbp">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Register TBP</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('report.register_tbp_pdf.store') }}" method="POST">
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

  <!-- Modal Register STS-->
  <div class="modal fade" tabindex="-1" role="dialog" id="registerSts">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Register STS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('report.register_sts_pdf.store') }}" method="POST">
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