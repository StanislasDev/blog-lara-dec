<?php

namespace App\Livewire;

use Livewire\Component;

class Posts extends Component
{
    public $showModalForm = false;

    public function showCreatePostModal()
    {
        $this->showModalForm = true;
    }
    public function render()
    {
        return view('livewire.posts');
    }
}
