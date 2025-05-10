<flux:modal name="modal-video.{{ $video->id }}" class="md:w-96">
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl sm:w-full">
        <div class="p-6">
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-4">{{ $video->title }}</h1>
                <p class="text-gray-600">{{ $video->description }}</p>
            </div>

            <div wire:ignore class="aspect-w-16 aspect-h-9 mb-8">
                <video class="w-full rounded-lg shadow-lg" controls>
                    <source src="{{ Storage::url($video->file_path) }}" type="video/mp4">
                    Tu navegador no soporta el elemento video.
                </video>
            </div>

            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Subido el {{ $video->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>
</flux:modal>