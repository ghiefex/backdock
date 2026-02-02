<div>
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Pendaftaran Siswa Baru - Step {{ $currentStep }}/4</h4>
            </div>
            <div class="card-body">

                {{-- Progress Bar --}}
                <div class="progress mb-4" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $currentStep * 25 }}%;"></div>
                </div>

                <form wire:submit.prevent="register">

                    {{-- STEP 1: Akun --}}
                    @if($currentStep == 1)
                        <h5 class="mb-3">Informasi Akun</h5>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" wire:model="email"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" wire:model="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" wire:model="password_confirmation" class="form-control">
                        </div>
                    @endif

                    {{-- STEP 2: Data Diri --}}
                    @if($currentStep == 2)
                        <h5 class="mb-3">Data Pribadi</h5>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" wire:model="full_name"
                                class="form-control @error('full_name') is-invalid @enderror">
                            @error('full_name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. HP / WhatsApp</label>
                            <input type="text" wire:model="phone" class="form-control @error('phone') is-invalid @enderror">
                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select wire:model="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">Pilih...</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                            @error('gender') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    {{-- STEP 3: Pilihan Jalur --}}
                    @if($currentStep == 3)
                        <h5 class="mb-3">Pilih Jalur Belajar</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card h-100 {{ $learning_path == 'mandarin' ? 'border-primary bg-light' : '' }}"
                                    wire:click="$set('learning_path', 'mandarin')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <h5>Belajar Mandarin</h5>
                                        <p class="small text-muted">Untuk Penutur Indonesia</p>
                                        @if($learning_path == 'mandarin') <i
                                        class="bi bi-check-circle-fill text-primary display-4"></i> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 {{ $learning_path == 'indonesia' ? 'border-primary bg-light' : '' }}"
                                    wire:click="$set('learning_path', 'indonesia')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <h5>Belajar Indonesia</h5>
                                        <p class="small text-muted">Untuk Penutur China (WNA)</p>
                                        @if($learning_path == 'indonesia') <i
                                        class="bi bi-check-circle-fill text-primary display-4"></i> @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('learning_path') <span class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                    @endif

                    {{-- STEP 4: Verifikasi --}}
                    @if($currentStep == 4)
                        <h5 class="mb-3">Verifikasi</h5>
                        <div class="alert alert-info">
                            Pastikan data Anda sudah benar. Silakan ceklis captcha di bawah ini (Simulasi).
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="captchaCheck" required>
                            <label class="form-check-label" for="captchaCheck">I am not a robot</label>
                        </div>
                    @endif

                    {{-- Navigation Buttons --}}
                    <div class="d-flex justify-content-between mt-4">
                        @if($currentStep > 1)
                            <button type="button" wire:click="previousStep" class="btn btn-secondary">Kembali</button>
                        @else
                            <div></div> {{-- Spacer --}}
                        @endif

                        @if($currentStep < 4)
                            <button type="button" wire:click="nextStep" class="btn btn-primary">Lanjut</button>
                        @else
                            <button type="submit" class="btn btn-success">Daftar Sekarang</button>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>