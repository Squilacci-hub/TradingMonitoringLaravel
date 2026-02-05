@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
    <div class="auth-card">
        <div class="brand-logo">
            <i class="fa-brands fa-hive" style="color: var(--accent-blue);"></i> <!-- Changed to Blue -->
            <span>CRÉER UN COMPTE</span>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nom Complet</label>
                <input type="text" name="name" class="form-input" placeholder="Alex Trader" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Adresse Email</label>
                <input type="email" name="email" class="form-input" placeholder="trader@example.com" required>
            </div>

            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <div style="position: relative;">
                    <input type="password" name="password" class="form-input toggle-input" placeholder="••••••••" required>
                    <i class="fa-solid fa-eye toggle-password"
                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary);"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Confirmer le mot de passe</label>
                <div style="position: relative;">
                    <input type="password" name="password_confirmation" class="form-input toggle-input"
                        placeholder="••••••••" required>
                    <i class="fa-solid fa-eye toggle-password"
                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary);"></i>
                </div>
            </div>

            <button type="submit" class="btn-primary"> <!-- Default Blue Style -->
                Soumettre
            </button>
        </form>

        <div class="auth-footer">
            Déjà un compte ? <a href="{{ route('login') }}" style="color: var(--accent-blue);">Se connecter</a>
        </div>
    </div>
@endsection