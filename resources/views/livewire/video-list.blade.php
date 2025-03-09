<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Vídeos</h2>
                    <a href="{{ route('videos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Nuevo Vídeo
                    </a>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($videos as $video)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden relative group cursor-pointer" 
                             wire:key="{{ $video->id }}"
                             wire:click="showVideo({{ $video->id }})">
                            @if($video->thumbnail_path)
                                <div x-data="{ 
                                    muted: true,
                                    init() {
                                        let video = this.$refs.videoPlayer;
                                        video.muted = this.muted;
                                        this.$watch('muted', value => {
                                            video.muted = value;
                                        });
                                    }
                                }"
                                    @mouseenter="muted = false"
                                    @mouseleave="muted = true">
                                    <video 
                                        x-ref="videoPlayer"
                                        class="object-cover w-full h-full rounded-lg"
                                        loop
                                        autoplay
                                        playsinline>
                                        <source src="{{ Storage::url($video->thumbnail_path) }}" type="video/mp4">
                                    </video>

                                    <!-- Ícono del altavoz -->
                                    <div class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer"
                                         @click.stop="muted = !muted">
                                        <flux:icon.speaker-wave x-show="!muted" class="w-6 h-6 text-white drop-shadow-lg" />
                                        <flux:icon.speaker-x-mark x-show="muted" class="w-6 h-6 text-white drop-shadow-lg" />
                                    </div>
                                </div>
                            @else
                                <div class="bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $videos->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo oscuro -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     wire:click="closeModal"></div>

                <!-- Contenido del modal -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl sm:w-full">
                    <div class="absolute top-0 right-0 pt-4 pr-4">
                        <button type="button" 
                                wire:click="closeModal"
                                class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Cerrar</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    @if($selectedVideo)
                        <div class="p-6">
                            <div class="mb-8">
                                <h1 class="text-3xl font-bold mb-4">{{ $selectedVideo->title }}</h1>
                                <p class="text-gray-600">{{ $selectedVideo->description }}</p>
                            </div>

                            <div class="aspect-w-16 aspect-h-9 mb-8">
                                <video class="w-full rounded-lg shadow-lg" controls>
                                    <source src="{{ Storage::url($selectedVideo->file_path) }}" type="video/mp4">
                                    Tu navegador no soporta el elemento video.
                                </video>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-500">
                                    Subido el {{ $selectedVideo->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
