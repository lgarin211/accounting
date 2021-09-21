<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="row">
        @livewire('admin.kelompok-aktiva.create')

        <div class="col-lg-8 col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Kelompok Aktiva</h4>
                        <h4 class="card-title" wire:loading.remove wire:target="search">
                            <span class="text-muted ml-1">{{ $kelompoks->count() }}</span>
                        </h4>
                        <span wire:loading wire:target="search" class="text-muted ml-1">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </span>
                    </div>
                    <input type="search" id="search" wire:model="search" class="form-control col-sm-5" placeholder="Search">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" @if($kelompoks->count() == 1) style="height: 100px" @endif>
                            <thead>
                                <tr>
                                    <th style="width: 1px;">#</th>
                                    <th>Kelompok</th>
                                    <th>Umur</th>
                                    <th>Metode</th>
                                    <th style="width: 1px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kelompoks as $kel)
                                    <tr>
                                        <td>{{ $loop->iteration + $kelompoks->firstItem() - 1 }}</td>
                                        <td>{{ $kel->nama }}</td>
                                        <td>{{ $kel->umur }} Tahun</td>
                                        <td>{{ $kel->metode }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                    <x-feathericon-more-vertical/>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void('edit');"
                                                        wire:click="$emit('edit', '{{ $kel->id }}')">
                                                        <x-feathericon-edit-2 />
                                                        <span class="ml-1">Edit</span>
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="javascript:void('delete');" 
                                                        wire:click="deleteConfirm({{ $kel->id }})">
                                                        <x-feathericon-trash />
                                                        <span class="ml-1">Delete</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" align="center">
                                            @if($search != null)
                                                Maaf, <b><i>"{{ $search }}"</i></b> tidak ditemukan.
                                            @else
                                                Data kosong.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <hr style="margin-top: -1px">
                        {{ $kelompoks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('admin.kelompok-aktiva.edit')
</div>
