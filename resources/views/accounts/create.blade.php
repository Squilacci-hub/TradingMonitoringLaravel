@extends('layouts.app')

@section('title', 'Nouveau Compte de Trading')

@section('content')
    <div style="max-width: 500px; margin: 0 auto;">
        <div class="panel">
            <div class="panel-header">
                <span>Créer un nouveau compte de trading</span>
            </div>
            <div class="panel-body">
                <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">
                    Ajoutez un compte pour séparer vos différentes stratégies ou brokers (ex: Exness, MyForexFunds, Compte
                    Démo).
                </p>

                <form action="{{ route('accounts.store') }}" method="POST">
                    @csrf

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Nom
                            du compte / Libellé</label>
                        <input type="text" name="name" required
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none;"
                            placeholder="e.g. Exness Real, FTMO Challenge...">
                    </div>

                    <button type="submit"
                        style="width: 100%; background: var(--accent-blue); color: white; border: none; padding: 12px; border-radius: 4px; font-weight: 600; cursor: pointer;">
                        CRÉER LE COMPTE
                    </button>

                    <a href="{{ route('dashboard') }}"
                        style="display: block; text-align: center; margin-top: 15px; font-size: 12px; color: var(--text-secondary); text-decoration: none;">
                        Annuler et retourner au Dashboard
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection