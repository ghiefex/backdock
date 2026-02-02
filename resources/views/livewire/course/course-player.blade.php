<div class="container-fluid py-4">
    <div class="row">
        {{-- Sidebar: Material List --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">{{ $course->title }}</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($materials as $material)
                        <button type="button" wire:click="selectMaterial({{ $material->id }})"
                            class="list-group-item list-group-item-action {{ $currentMaterial && $currentMaterial->id === $material->id ? 'active' : '' }} {{ $isLocked ? 'disabled' : '' }}">
                            <i class="bi bi-play-circle me-2"></i> {{ $material->title }}
                            @if($isLocked) <i class="bi bi-lock-fill float-end"></i> @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="col-md-9">
            @if($isLocked)
                {{-- PAYWALL --}}
                <div class="card text-center p-5 shadow-sm">
                    <div class="card-body">
                        <h2 class="display-4 text-primary"><i class="bi bi-shield-lock"></i></h2>
                        <h3>Konten Terkunci</h3>
                        <p class="lead">Silakan berlangganan untuk mengakses materi kursus ini.</p>
                        <hr class="my-4">
                        <p>Harga: <strong>Rp {{ number_format($course->price, 0, ',', '.') }}</strong></p>
                        {{-- Button could trigger a buy modal or redirect to payment --}}
                        <button class="btn btn-lg btn-success">Beli Sekarang</button>
                    </div>
                </div>
            @else

                {{-- PLAYER --}}
                @if($currentMaterial)
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            @if($currentMaterial->content_type === 'video')
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $currentMaterial->file_url }}" allowfullscreen></iframe>
                                </div>
                            @elseif($currentMaterial->content_type === 'text')
                                <div class="p-4">
                                    <h4>{{ $currentMaterial->title }}</h4>
                                    <div class="mt-3">
                                        {!! nl2br(e($currentMaterial->content_body)) !!}
                                    </div>
                                </div>
                            @else
                                <div class="p-5 text-center">
                                    <i class="bi bi-file-earmark-pdf display-1 text-danger"></i>
                                    <h4 class="mt-3">{{ $currentMaterial->title }}</h4>
                                    <a href="{{ $currentMaterial->file_url }}" target="_blank" class="btn btn-primary mt-2">Download
                                        / Buka</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">Pilih materi untuk memulai belajar.</div>
                @endif

            @endif
        </div>
    </div>
</div>