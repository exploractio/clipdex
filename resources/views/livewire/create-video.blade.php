<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-6">Subir Nuevo Video</h2>

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Título
                        </label>
                        <input type="text" wire:model="title" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Descripción
                        </label>
                        <textarea wire:model="description" 
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                  rows="4"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4" 
                        x-data="{ 
                            uploading: false, 
                            progress: 0,
                            preview: null,
                            showPreview: false,
                            videoElement: null,
                            initVideo() {
                                this.$watch('showPreview', value => {
                                    if (value) {
                                        this.$nextTick(() => {
                                            this.videoElement = this.$refs.previewVideo;
                                        });
                                    }
                                });
                            }
                        }"
                        x-init="initVideo()"
                        x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false; showPreview = true"
                        x-on:livewire-upload-cancel="uploading = false"
                        x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Vídeo
                        </label>
                        
                        <input type="file" 
                               wire:model="video" 
                               accept="video/*"
                               x-ref="video"
                               x-on:change="
                                   const file = $refs.video.files[0];
                                   if (file) {
                                       preview = URL.createObjectURL(file);
                                   }
                               "
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        
                        @error('video') 
                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror

                        <!-- Barra de progreso -->
                        <div x-show="uploading" class="mt-4">
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-2">
                                <span x-text="`Subiendo... ${progress}%`"></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" x-bind:style="`width: ${progress}%`"></div>
                            </div>
                        </div>

                        <!-- Previsualización del video y selector de tiempo -->
                        <div x-show="showPreview" class="mt-4">
                            <h3 class="text-lg font-semibold mb-2">Selecciona el momento para la miniatura:</h3>
                            <div class="aspect-w-16 aspect-h-9 mb-4">
                                <video 
                                    x-ref="previewVideo"
                                    x-bind:src="preview" 
                                    controls 
                                    class="rounded-lg shadow-lg w-full">
                                    Tu navegador no soporta el elemento video.
                                </video>
                            </div>

                            <div class="flex items-center space-x-4">
                                <button type="button"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        x-on:click="$wire.set('startTime', Math.floor(videoElement.currentTime))">
                                    Usar este momento
                                </button>
                                <span x-text="'Tiempo actual: ' + (videoElement ? Math.floor(videoElement.currentTime) : 0) + 's'"></span>
                            </div>

                            <!-- Previsualización de la miniatura -->
                            @if($processing)
                                <div class="mt-4">
                                    <p class="text-blue-600">Generando miniatura...</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Subir
                        </button>
                        <a href="{{ route('videos.index') }}" 
                           class="text-gray-600 hover:text-gray-800">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
