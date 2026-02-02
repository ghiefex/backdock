<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="row g-3">
            <div class="col-md-4">
                <input wire:model.live="search" type="text" class="form-control" placeholder="Cari User...">
            </div>
            <div class="col-md-3">
                <select wire:model.live="filterPath" class="form-select">
                    <option value="">Semua Jalur</option>
                    <option value="mandarin">Jalur Mandarin</option>
                    <option value="indonesia">Jalur Indonesia</option>
                </select>
            </div>
            <div class="col-md-3">
                <select wire:model.live="filterStatus" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="paid">Premium (Paid)</option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jalur</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            {{ $user->profile->full_name ?? 'N/A' }}
                            <br>
                            <small class="text-muted">{{ $user->profile->phone ?? '-' }}</small>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->learning_path == 'mandarin')
                                <span class="badge bg-danger rounded-pill">Mandarin</span>
                            @else
                                <span class="badge bg-info rounded-pill">Indonesia</span>
                            @endif
                        </td>
                        <td>
                            @if($user->transactions()->where('status', 'paid')->exists())
                                <span class="badge bg-success">Premium</span>
                            @else
                                <span class="badge bg-secondary">Free</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $users->links() }}
    </div>
</div>