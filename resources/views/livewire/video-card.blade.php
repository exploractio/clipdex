<div>
    <div class="mb-4 bg-white rounded-lg shadow-md overflow-hidden relative group cursor-pointer"
         wire:click="$dispatch('show-video.{{ $video->id }}')">
        @if($video->thumbnail_path)
            <div wire:ignore>
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
                    <div class="relative">
                        <video
                            x-ref="videoPlayer"
                            class="w-full rounded-lg"
                            loop
                            autoplay
                            playsinline>
                            <source src="{{ Storage::url($video->thumbnail_path) }}" type="video/mp4">
                        </video>
    
                        <div class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer"
                             @click.stop="muted = !muted">
                            <flux:icon.speaker-wave x-show="!muted" class="w-6 h-6 text-white drop-shadow-lg" />
                            <flux:icon.speaker-x-mark x-show="muted" class="w-6 h-6 text-white drop-shadow-lg" />
                        </div>
                    </div>
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
    
    <livewire:video-modal :video="$video" />
</div>