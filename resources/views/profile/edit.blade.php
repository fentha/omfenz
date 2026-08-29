@extends('layouts.admin')

@section('title', 'Profil Akun')
@section('page-title', 'Pengaturan Profil Admin')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">
        
        <!-- Profile Info Card -->
        <div class="col-12 col-lg-6">
            <div class="card card-custom border-0 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h6 class="fw-bold text-dark m-0"><i class="bi bi-person-circle text-primary me-2"></i>Informasi Profil</h6>
                    <small class="text-muted">Perbarui nama dan alamat email akun admin Anda</small>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                            <input id="name" name="name" type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label small fw-semibold text-secondary">Alamat Email</label>
                            <input id="email" name="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4 fw-semibold rounded-3">
                                <i class="bi bi-floppy me-1"></i> Simpan Profil
                            </button>

                            @if (session('status') === 'profile-updated')
                                <span class="text-success small fw-semibold">
                                    <i class="bi bi-check-circle me-1"></i>Tersimpan!
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="col-12 col-lg-6">
            <div class="card card-custom border-0 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h6 class="fw-bold text-dark m-0"><i class="bi bi-shield-lock text-primary me-2"></i>Ubah Password</h6>
                    <small class="text-muted">Pastikan akun Anda menggunakan password yang aman dan kuat</small>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="update_password_current_password" class="form-label small fw-semibold text-secondary">Password Saat Ini</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-control rounded-3 @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password" />
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="update_password_password" class="form-label small fw-semibold text-secondary">Password Baru</label>
                            <input id="update_password_password" name="password" type="password" class="form-control rounded-3 @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password" />
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="update_password_password_confirmation" class="form-label small fw-semibold text-secondary">Konfirmasi Password Baru</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control rounded-3 @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password" />
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4 fw-semibold rounded-3">
                                <i class="bi bi-key me-1"></i> Perbarui Password
                            </button>

                            @if (session('status') === 'password-updated')
                                <span class="text-success small fw-semibold">
                                    <i class="bi bi-check-circle me-1"></i>Password berhasil diperbarui!
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
