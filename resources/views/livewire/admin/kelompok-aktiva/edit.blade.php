<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    @if ($isOpen)
        <div class="modal backdrop d-block text-left">
            <div class="modal-backdrop" style="background: rgba(0,0,0,.5); backdrop-filter: blur(1px);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Edit Kelompok</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                wire:click="$set('isOpen', false)">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form wire:submit.prevent="update">
                            <div class="modal-body">
                                <label>Kelompok</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Nama Kelompok" wire:model="kelompok.nama"
                                        class="form-control @error('kelompok.nama') is-invalid @enderror" />
                                    @error('kelompok.nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label>Umur</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Umur" wire:model="kelompok.umur"
                                        class="form-control @error('kelompok.umur') is-invalid @enderror" />
                                    @error('kelompok.umur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label>Metode</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Metode" wire:model="kelompok.metode"
                                        class="form-control @error('kelompok.metode') is-invalid @enderror" />
                                    @error('kelompok.metode')
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
