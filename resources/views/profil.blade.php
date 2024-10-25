@extends('layouts.template')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i> Edit Profil
                    </h4>
                </div>
                <div class="card-body p-5">
                    @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="alert-icon me-3">
                                <i class="fas fa-check-circle fs-4"></i>
                            </div>
                            <div class="alert-message flex-grow-1">
                                <strong>{{ session('status') }}</strong>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="position-relative">
                                @if($user->profile_image)
                                    <img src="{{ asset('photos/' . $user->profile_image) }}" 
                                         class="img-fluid rounded-circle shadow-lg" 
                                         style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #f8f9fa;"
                                         alt="Profile Image">
                                @else
                                    <img src="{{ asset('img/polinema-bw.png') }}" 
                                         class="img-fluid rounded-circle shadow-lg" 
                                         style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #f8f9fa;"
                                         alt="Default Profile Image">
                                @endif
                            </div>
                            <h5 class="mt-3">{{ $user->nama }}</h5>
                            <p class="text-muted">{{ $user->username }}</p>
                        </div>

                        <div class="col-md-8">
                            <form method="POST" action="{{ route('profil.update', $user->user_id) }}" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="username" class="form-label">{{ __('Username') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input id="username" type="text" 
                                               class="form-control @error('username') is-invalid @enderror" 
                                               name="username" 
                                               value="{{ old('username', $user->username) }}" 
                                               required 
                                               autocomplete="username" 
                                               placeholder="Masukkan username">
                                    </div>
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="nama" class="form-label">{{ __('Nama Lengkap') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <input id="nama" type="text" 
                                               class="form-control @error('nama') is-invalid @enderror" 
                                               name="nama" 
                                               value="{{ old('nama', $user->nama) }}" 
                                               required 
                                               autocomplete="nama" 
                                               placeholder="Masukkan nama lengkap">
                                    </div>
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="old_password" class="form-label">{{ __('Password Lama') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input id="old_password" type="password" 
                                               class="form-control @error('old_password') is-invalid @enderror" 
                                               name="old_password"
                                               autocomplete="old-password" 
                                               placeholder="Masukkan password lama">
                                    </div>
                                    @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">{{ __('Password Baru') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        <input id="password" type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               name="password"
                                               autocomplete="new-password" 
                                               placeholder="Masukkan password baru">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password-confirm" class="form-label">{{ __('Konfirmasi Password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        <input id="password-confirm" type="password" 
                                               class="form-control" 
                                               name="password_confirmation"
                                               autocomplete="new-password" 
                                               placeholder="Konfirmasi password baru">
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="profile_image" class="form-label">{{ __('Ganti Foto Profil') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-image"></i>
                                        </span>
                                        <input id="profile_image" type="file" 
                                               class="form-control @error('profile_image') is-invalid @enderror" 
                                               name="profile_image"
                                               accept="image/*">
                                    </div>
                                    @error('profile_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        File yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB.
                                    </small>
                                </div>

                                <div class="form-group mb-0 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>{{ __(' Update Profil') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Menangani alert dismissible
    var alertNode = document.querySelector('.alert');
    if(alertNode) {
        // Membuat instance alert Bootstrap
        var alert = new bootstrap.Alert(alertNode);
        
        // Menangani klik pada tombol close
        var closeButton = alertNode.querySelector('.btn-close');
        if(closeButton) {
            closeButton.addEventListener('click', function() {
                alert.close();
            });
        }
        
        // Auto close setelah 5 detik
        setTimeout(function() {
            alert.close();
        }, 5000);
    }
});
</script>
@endpush