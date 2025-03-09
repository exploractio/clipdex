<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="mb-6">
                <a href="{{ route('videos.index') }}" class="text-blue-500 hover:text-blue-700">
                    &larr; Volver a la lista
                </a>
            </div>

            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-4">{{ $video->title }}</h1>
                <p class="text-gray-600">{{ $video->description }}</p>
            </div>

            <div class="aspect-w-16 aspect-h-9 mb-8">
                <video class="w-full rounded-lg shadow-lg" controls>
                    <source src="{{ Storage::url($video->file_path) }}" type="video/mp4">
                    Tu navegador no soporta el elemento video.
                </video>
            </div>

            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Subido el {{ $video->created_at->format('d/m/Y H:i') }}
                </div>
                
                <div class="space-x-4">
                    <button wire:click="delete"
                            onclick="return confirm('¿Estás seguro de que quieres eliminar este video?')"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Eliminar Video
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
