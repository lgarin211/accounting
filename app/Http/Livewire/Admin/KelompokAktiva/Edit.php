<?php

namespace App\Http\Livewire\Admin\KelompokAktiva;

use App\Models\Asset\KelompokAktiva;
use Livewire\Component;

class Edit extends Component
{
    public $isOpen, $kelompok;

    protected $listeners = ['edit'];

    protected $rules = [
        'kelompok.nama' => 'required',
        'kelompok.umur' => 'required',
        'kelompok.metode' => 'required'
    ];

    public function render()
    {
        return view('livewire.admin.kelompok-aktiva.edit');
    }

    public function edit(KelompokAktiva $kelompok)
    {
        $this->isOpen = true;
        $this->kelompok = $kelompok;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();
        $this->kelompok->umur = (int)$this->kelompok->umur;

        try {
            $this->kelompok->save();
        } catch (\Exception $e) {
            $this->emit('error', 'Data gagal diedit');
        }

        $this->reset(['isOpen', 'kelompok']);
        $this->emit('refresh', 'Data berhasil diedit');
    }
}
