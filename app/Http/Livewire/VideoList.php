namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Video;

class VideoList extends Component
{
    public $selectedVideoId = null;
    
    protected $listeners = ['closeModal' => 'closeModal'];

    public function selectVideo($videoId)
    {
        $this->selectedVideoId = $videoId;
    }

    public function closeModal()
    {
        $this->selectedVideoId = null;
    }

    public function render()
    {
        return view('livewire.video-list', [
            'videos' => Video::latest()->paginate(12)
        ]);
    }
}