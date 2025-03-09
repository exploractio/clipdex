<?php

namespace App\Livewire;

use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyVideos extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.my-videos', [
            'videos' => auth()->user()->videos()->latest()->paginate(12)
        ]);
    }

    public function delete(Video $video)
    {
        if (!$video->isOwnedBy(Auth::user())) {
            abort(403);
        }

        if (file_exists(storage_path('app/public/' . $video->file_path))) {
            unlink(storage_path('app/public/' . $video->file_path));
        }

        if ($video->thumbnail_path && file_exists(storage_path('app/public/' . $video->thumbnail_path))) {
            unlink(storage_path('app/public/' . $video->thumbnail_path));
        }

        $video->delete();
        session()->flash('message', 'Video eliminado con éxito.');
    }
}