<?php

namespace App\Livewire;

use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateVideo extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $video;
    public $thumbnail;
    public $startTime = 0;
    public $tempVideoPath;
    public $processing = false;

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'nullable',
        'video' => 'required|file|mimetypes:video/mp4,video/quicktime|max:512000', // 500MB
        'startTime' => 'required|numeric|min:0'
    ];

    public function generateThumbnailGif($videoPath, $startTime)
    {
        $thumbnailPath = 'thumbnails/' . md5(time()) . '.gif';
        $fullVideoPath = storage_path('app/public/' . $videoPath);
        $fullThumbnailPath = storage_path('app/public/' . $thumbnailPath);

        // Crear el directorio si no existe
        if (!file_exists(dirname($fullThumbnailPath))) {
            mkdir(dirname($fullThumbnailPath), 0755, true);
        }

        // Formatear el tiempo de inicio en formato HH:MM:SS
        $startTimeFormatted = gmdate("H:i:s", $startTime);

        // Generar GIF de 3 segundos desde el punto aleatorio
        $command = "ffmpeg -ss {$startTimeFormatted} -t 3 -i {$fullVideoPath} -vf 'fps=10,scale=320:-1' -y {$fullThumbnailPath}";
        exec($command);

        return $thumbnailPath;
    }

    public function generateThumbnailVideo($videoPath, $startTime)
    {
        $thumbnailPath = 'thumbnails/' . md5(time()) . '.mp4';
        $fullVideoPath = storage_path('app/public/' . $videoPath);
        $fullThumbnailPath = storage_path('app/public/' . $thumbnailPath);

        // Crear el directorio si no existe
        if (!file_exists(dirname($fullThumbnailPath))) {
            mkdir(dirname($fullThumbnailPath), 0755, true);
        }

        $startTimeFormatted = gmdate("H:i:s", $startTime);

        // Obtener dimensiones del video original
        $ffprobeCommand = "ffprobe -v error -select_streams v:0 -show_entries stream=width,height -of csv=s=x:p=0 {$fullVideoPath}";
        $dimensions = exec($ffprobeCommand);
        list($width, $height) = explode('x', $dimensions);

        // Calcular nuevas dimensiones manteniendo el aspect ratio
        $maxWidth = 320;
        $scale = $maxWidth / $width;
        $newHeight = round($height * $scale / 2) * 2; // Asegurar número par

        // Generar video de 3 segundos en baja resolución
        $command = "ffmpeg -ss {$startTimeFormatted} -t 3 -i {$fullVideoPath} " .
                  "-vf 'scale={$maxWidth}:{$newHeight}' " . // Escalar manteniendo aspect ratio
                  "-c:v libx264 " . // Codec H.264
                  "-crf 28 " . // Calidad reducida
                  "-preset ultrafast " . // Codificación rápida
                  "-movflags +faststart " . // Reproducción más rápida
                  "-y {$fullThumbnailPath}";
        
        exec($command);

        return $thumbnailPath;
    }

    public function previewThumbnail()
    {
        if (!$this->tempVideoPath) {
            return;
        }

        $this->processing = true;
        $thumbnailPath = $this->generateThumbnailVideo($this->tempVideoPath, $this->startTime);
        $this->processing = false;

        return Storage::url($thumbnailPath);
    }

    public function save()
    {
        $this->validate();

        $videoPath = $this->video->store('videos', 'public');
        $thumbnailPath = $this->generateThumbnailVideo($videoPath, $this->startTime);

        Video::create([
            'title' => $this->title,
            'description' => $this->description,
            'file_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
            'user_id' => Auth::id()
        ]);

        session()->flash('message', 'Vídeo subido con éxito.');
        return redirect()->route('my.videos');
    }
}
