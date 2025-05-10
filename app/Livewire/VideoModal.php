<?php

namespace App\Livewire;

use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;

class VideoModal extends Component
{
    public $video;

    public function mount($video)
    {
        $this->video = $video;
    }

    #[On('show-video.{video.id}')]
    public function openModal()
    {
        Flux::modal('modal-video.' . $this->video->id)->show();
    }

    public function render()
    {
        return view('livewire.video-modal');
    }
}