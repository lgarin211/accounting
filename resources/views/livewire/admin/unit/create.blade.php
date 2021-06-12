<div class="col-md-5 col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Unit Form</h4>
        </div>
        <div class="card-body">
            <form class="form form-horizontal" wire:submit.prevent="store">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="name">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="name" name="name" wire:model="name" 
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name" />
                                @error('name')
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
                                <label for="email-id">Description</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" wire:model="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Description"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9 offset-sm-3">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="status" name="status" wire:model="status"
                                    class="custom-control-input" value="1"/>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary" style="width: 100px">
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