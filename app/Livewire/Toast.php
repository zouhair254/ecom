<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{
    public string $message = '';
    public bool $show = false;

    #[On('toast')]
    public function showToast(string $message): void
    {
        $this->message = $message;
        $this->show = true;
    }

    public function dismiss(): void
    {
        $this->show = false;
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
