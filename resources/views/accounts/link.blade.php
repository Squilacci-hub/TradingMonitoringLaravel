@extends('layouts.app')

@section('title', 'Associer Compte Réel (MT5)')

@section('content')
    <div style="max-width: 500px; margin: 0 auto;">
        <div class="panel">
            <div class="panel-header">
                <span style="display: flex; align-items: center;">
                    <i class="fa-solid fa-link" style="color: var(--accent-emerald); margin-right: 10px;"></i>
                    Associer un compte Exness / MetaTrader 5
                </span>
            </div>
            <div class="panel-body">
                <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px; line-height: 1.5;">
                    Connectez-vous à votre compte de trading pour synchroniser automatiquement vos trades.
                    <br>
                    <span style="color: var(--accent-blue);">Note : MetaTrader 5 doit être installé sur votre Windows pour
                        que la synchronisation fonctionne.</span>
                </p>

                @if($errors->any())
                    <div
                        style="background: rgba(220, 53, 69, 0.1); border: 1px solid var(--accent-crimson); color: var(--accent-crimson); padding: 10px; border-radius: 4px; margin-bottom: 20px; font-size: 13px;">
                        <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('accounts.link.store') }}" method="POST">
                    @csrf

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Nom
                            du compte (Libellé)</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none; transition: border-color 0.2s;"
                            placeholder="e.g. Exness Real Personal">
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Serveur
                            de trading</label>
                        <input type="text" name="broker_server" required value="{{ old('broker_server') }}"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none;"
                            placeholder="e.g. Exness-MT5Real3">
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Numéro
                            de compte (Login)</label>
                        <input type="number" name="broker_login" required value="{{ old('broker_login') }}"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none;"
                            placeholder="12345678">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Mot
                            de passe de trading</label>
                        <input type="password" name="broker_password" required
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none;"
                            placeholder="********">
                    </div>

                    <button type="submit"
                        style="width: 100%; background: var(--accent-emerald); color: white; border: none; padding: 14px; border-radius: 4px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="fa-solid fa-shield-check"></i>
                        VÉRIFIER ET CONNECTER
                    </button>

                    <a href="{{ route('dashboard') }}"
                        style="display: block; text-align: center; margin-top: 15px; font-size: 12px; color: var(--text-secondary); text-decoration: none;">
                        Annuler
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection