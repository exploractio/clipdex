<?php

namespace App\Livewire;

use Livewire\Component;

class VideoCard extends Component
{
    public $video;

    public function mount($video)
    {
        $this->video = $video;
    }

    public function render()
    {
        return view('livewire.video-card');
    }
}