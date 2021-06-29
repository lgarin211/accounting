<div>
    @if ($isOpen)
        <div class="modal backdrop d-block text-left">
            <div class="modal-backdrop" style="background: rgba(0,0,0,.5); backdrop-filter: blur(1px);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Edit Subklasifikasi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                wire:click="$set('isOpen', false)">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form wire:submit.prevent="update">
                            <div class="modal-body">
                                <label>Nama Subklasifikasi: </label>
                                <div class="form-group">
                                    <input type="text" placeholder="Nama Subklasifikasi" wire:model="subklasifikasi.name"
                                        class="form-control @error('subklasifikasi.name') is-invalid @enderror" />
                                    @error('subklasifikasi.name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" data-dismiss="modal" class="btn btn-primary" style="width: 100px">
                                    <span wire:loading.remove wire:target="update">Save</span>
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
