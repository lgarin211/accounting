<?php

namespace App\Http\Livewire\Admin\KelompokAktiva;

use App\Models\Asset\KelompokAktiva;
use Livewire\Component;
use Livewire\WithPagination;

class Data extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'refresh', 'error', 'delete'
    ];

    public $search = null;

    public function render()
    {
        $search = $this->search;
        $kelompoks = KelompokAktiva::search($search)->latest()->paginate(5);

        return view('livewire.admin.kelompok-aktiva.data', compact('kelompoks'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function refresh(string $message)
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'title' => 'Success',
            'text' => $message,
        ]);

        $this->search = '';
    }

    public function error(string $message)
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'error',
            'title' => 'Error',
            'text' => $message,
        ]);

        $this->search = '';
    }

    public function deleteConfirm($id)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Apakah Anda yakin?',
            'text' => 'Anda tidak dapat memulihkan data ini!',
            'id' => $id
        ]);
    }

    public function delete(KelompokAktiva $kelompok)
    {
        try {
            $kelompok->delete();
            $this->refresh('Data berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Data gagal dihapus');
        }
    }
}
