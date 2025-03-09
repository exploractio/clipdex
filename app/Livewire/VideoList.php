<?php

namespace App\Livewire;

use App\Models\Video;
use Livewire\Component;
use Livewire\WithPagination;

class VideoList extends Component
{
    use WithPagination;

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
