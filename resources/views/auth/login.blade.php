@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
    <div class="auth-card">
        <div class="brand-logo">
            <i class="fa-brands fa-hive" style="color: var(--accent-blue);"></i>
            <span>TRADEMASTER</span>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Adresse Email</label>
                <input type="email" name="email" class="form-input" placeholder="trader@example.com" required autofocus
                    value="{{ old('email') }}">
                @error('email')
                    <div
                        style="color: var(--accent-crimson); font-size: 12px; margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <div style="position: relative;">
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required
                        id="passwordInput">
                    <i class="fa-solid fa-eye" id="togglePassword"
                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary);"></i>
                </div>
            </div>

            <div
                style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 12px; color: var(--text-secondary);">
                <label style="display: flex; items-center; gap: 8px;">
                    <input type="checkbox" name="remember" style="accent-color: var(--accent-blue);"> Se souvenir de moi
                </label>
                <a href="#" style="color: var(--text-secondary); text-decoration: none;">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-primary">
                Se connecter <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i>
            </button>
        </form>

        <div class="auth-footer">
            Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
        </div>
    </div>
@endsection