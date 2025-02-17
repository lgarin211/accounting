<?php

namespace App\Http\Livewire\Admin\Akun;

use App\Models\Akun;
use Livewire\Component;

class Edit extends Component
{
    public $isOpen, $levels;
    public $akun;

    protected $listeners = ['edit'];

    protected $rules = [
        'akun.name' => 'required',
        'akun.subklasifikasi' => 'required',
        'akun.level' => 'required',
        'akun.saldo_awal' => 'required|numeric',
        'akun.kategori_asset' => 'string|in:Akumulasi Kendaraan,Akumulasi Gedung,Akumulasi Mesin dan Peralatan,Akumulasi Tanah'
    ];

    public function render()
    {
        return view('livewire.admin.akun.edit');
    }

    public function edit(Akun $akun)
    {
        $this->isOpen = true;
        $this->akun = $akun;
        $this->resetValidation();
    }

    public function mount()
    {
        $this->levels = Akun::getPossibleLevels();
    }

    public function update()
    {
        $this->validate(array_merge($this->rules, [
            'akun.level' => 'required|in:' . implode(',', $this->levels)
        ]));

        $this->akun->saldo_awal = (int)$this->akun->saldo_awal;

        try {
            $this->akun->save();
        } catch (\Exception $e) {
            $this->emit('error', 'Data gagal diedit');
        }

        $this->reset(['isOpen', 'akun']);
        $this->emit('refresh', 'Data berhasil diedit');
    }
}
