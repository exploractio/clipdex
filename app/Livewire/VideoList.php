<?php

namespace App\Livewire;

use App\Models\Video;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class VideoList extends Component
{
    use WithPagination;

    public $selectedVideo = null;

    public function showVideo($videoId)
    {
        $this->selectedVideo = Video::find($videoId);
        Flux::modal('modal-video')->show();
    }

    public function closeModal()
    {
        Flux::modal('modal-video')->close();
        $this->selectedVideo = null;
    }

    public function render()
    {
        return view('livewire.video-list', [
            'videos' => Video::latest()->paginate(12)
        ]);
    }

    public function delete($id)
    {
        $video = Video::findOrFail($id);
        
        // Eliminar archivo de vídeo
        if (file_exists(storage_path('app/public/' . $video->file_path))) {
            unlink(storage_path('app/public/' . $video->file_path));
        }
        
        // Eliminar thumbnail si existe
        if ($video->thumbnail_path && file_exists(storage_path('app/public/' . $video->thumbnail_path))) {
            unlink(storage_path('app/public/' . $video->thumbnail_path));
        }

        $video->delete();
        session()->flash('message', 'Vídeo eliminado con éxito.');
    }
}
