<div class="col-md-4 col-12">
    {{-- The Master doesn't talk, he acts. --}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Buat Kelompok Baru</h4>
        </div>
        <div class="card-body">
            <form class="form form-horizontal" wire:submit.prevent="store">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="nama">Kelompok</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="nama" name="nama" wire:model="nama" 
                                    class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Kelompok" />
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="umur">Umur</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="umur" name="umur" wire:model="umur" onkeypress="onlyNumber(event)" 
                                    class="form-control @error('umur') is-invalid @enderror" placeholder="Umur" />
                                @error('umur')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="metode">Metode</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="metode" name="metode" wire:model="metode" 
                                    class="form-control @error('metode') is-invalid @enderror" placeholder="Metode" />
                                @error('metode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary" style="width: 100px"
                            wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">Submit</span>
                            <span wire:loading wire:target="store" class="mx-auto">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
