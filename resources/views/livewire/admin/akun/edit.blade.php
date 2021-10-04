<div>
    @if ($isOpen)
    <div class="modal backdrop d-block text-left">
        <div class="modal-backdrop" style="background: rgba(0,0,0,.5); backdrop-filter: blur(1px);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Akun</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="$set('isOpen', false)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="update">
                        <div class="modal-body">
                            <label>Nama Akun: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama Akun" wire:model="akun.name"
                                    wire:loading.attr="disabled" wire:target="update"
                                    class="form-control @error('akun.name') is-invalid @enderror" />
                                @error('akun.name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <label>Subklasifikasi: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Subklasifikasi" wire:model="akun.subklasifikasi"
                                    wire:loading.attr="disabled" wire:target="update"
                                    class="form-control @error('akun.subklasifikasi') is-invalid @enderror" />
                                @error('akun.subklasifikasi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <label>Level: </label>
                            <div class="form-group">
                                <select wire:model="akun.level" wire:loading.attr="disabled" wire:target="update"
                                    class="form-control @error('akun.level') is-invalid @enderror">
                                    <option value="">-- Pilih Level --</option>
                                    @foreach($levels as $level)
                                    <option value="{{ $level }}" {{ $level == $akun->level ? 'selected' : ''}}>
                                        {{ $level }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('akun.level')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <label>Saldo Awal: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Saldo Awal" wire:model="akun.saldo_awal"
                                    wire:loading.attr="disabled" wire:target="update"
                                    onkeypress="onlyNumber(event, true)"
                                    class="form-control @error('akun.saldo_awal') is-invalid @enderror" />
                                @error('akun.saldo_awal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <label>Kategori Asset: </label>
                            <div class="form-group">
                                <select id="kategori_asset"
                                    wire:model="akun.kategori_asset" wire:loading.attr="disabled" wire:target="update"
                                    class="form-control @error('akun.kategori_asset') is-invalid @enderror">
                                    <option>-- Pilih Kategori Asset --</option>
                                    <option {{ $akun->kategori_asset == 'Akumulasi Kendaraan' ? 'selected' : ''}} value="Akumulasi Kendaraan">Akumulasi kendaraan</option>
                                    <option {{ $akun->kategori_asset == 'Akumulasi Gedung' ? 'selected' : ''}} value="Akumulasi Gedung">Akumulasi gedung</option>
                                    <option {{ $akun->kategori_asset == 'Akumulasi Mesin dan Peralatan' ? 'selected' : ''}} value="Akumulasi Mesin dan Peralatan">Akumulasi mesin dan peralatan</option>
                                    <option {{ $akun->kategori_asset == 'Akumulasi Tanah' ? 'selected' : ''}} value="Akumulasi Tanah">Akumulasi tanah</option>
                                </select>
                                @error('akun.saldo_awal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" data-dismiss="modal" class="btn btn-primary" style="width: 100px"
                                wire:loading.attr="disabled" wire:target="update">
                                <span wire:loading.remove wire:target="update">Simpan</span>
                                <span wire:loading wire:target="update" class="mx-auto">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
