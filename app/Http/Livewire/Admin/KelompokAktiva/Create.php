<?php

namespace App\Http\Livewire\Admin\KelompokAktiva;

use App\Models\Asset\KelompokAktiva;
use Livewire\Component;

class Create extends Component
{
    public $nama, $umur, $metode;

    protected $rules = [
        'nama' => 'required',
        'umur' => 'required|gt:0',
        'metode' => 'required',
    ];

    public function render()
    {
        return view('livewire.admin.kelompok-aktiva.create');
    }

    public function store()
    {
        $data = $this->validate();
        $data['umur'] = (int)$data['umur'];

        try {
            KelompokAktiva::create($data);
        } catch (\Throwable $th) {
            $this->emit('error', 'Data gagal disimpan');
        }

        $this->reset('nama', 'umur', 'metode');
        $this->emit('refresh', 'Data berhasil disimpan');
    }
}
