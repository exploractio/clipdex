<?php

namespace App\Livewire;

use App\Models\Video;
use Livewire\Component;

class ShowVideo extends Component
{
    public Video $video;

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function render()
    {
        return view('livewire.show-video');
    }

    public function delete()
    {
        if (file_exists(storage_path('app/public/' . $this->video->file_path))) {
            unlink(storage_path('app/public/' . $this->video->file_path));
        }

        if ($this->video->thumbnail_path && file_exists(storage_path('app/public/' . $this->video->thumbnail_path))) {
            unlink(storage_path('app/public/' . $this->video->thumbnail_path));
        }

        $this->video->delete();

        session()->flash('message', 'Vídeo eliminado con éxito.');
        return redirect()->route('videos.index');
    }
}
