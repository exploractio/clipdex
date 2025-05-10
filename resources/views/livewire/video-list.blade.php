<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Vídeos</h2>
                    <a href="{{ route('videos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Subir un clip
                    </a>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
                    @foreach($videos as $video)
                        <livewire:video-card :video="$video" :key="$video->id" />
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $videos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
