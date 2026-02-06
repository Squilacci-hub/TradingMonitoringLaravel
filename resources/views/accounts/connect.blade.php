@extends('layouts.app')

@section('title', 'Associer un Compte Broker')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="panel">
            <div class="panel-header">
                <span>Configuration de la Synchronisation Automatique</span>
            </div>
            <div class="panel-body">
                <div
                    style="background: rgba(0, 189, 157, 0.05); border: 1px solid rgba(0, 189, 157, 0.2); padding: 15px; border-radius: 4px; margin-bottom: 25px;">
                    <h4 style="color: var(--accent-emerald); margin-top: 0; margin-bottom: 10px; font-size: 14px;">
                        <i class="fa-solid fa-circle-info"></i> Comment ça fonctionne ?
                    </h4>
                    <p style="font-size: 12px; color: var(--text-secondary); line-height: 1.5; margin: 0;">
                        Cette étape permet de préparer votre compte pour la synchronisation automatique (gratuite).
                        Une fois ces informations enregistrées, vous devrez installer notre script (EA) sur votre MetaTrader
                        pour que les trades remontent tout seuls.
                    </p>
                </div>

                <form action="{{ route('accounts.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="is_sync" value="1">

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Nom
                            de ce compte (ex: My Real Account)</label>
                        <input type="text" name="name" required
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none;"
                            placeholder="e.g. Exness Live 1">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div class="form-group">
                            <label
                                style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Plateforme</label>
                            <select name="platform"
                                style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none;">
                                <option value="MT4">MetaTrader 4</option>
                                <option value="MT5">MetaTrader 5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label
                                style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Numéro
                                de compte (Login)</label>
                            <input type="text" name="broker_login" required
                                style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none;"
                                placeholder="e.g. 12345678">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Serveur
                            du Broker</label>
                        <input type="text" name="broker_server" required
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none;"
                            placeholder="e.g. Exness-Real10">
                    </div>

                    <div class="form-group" style="margin-bottom: 25px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-secondary);">Mot
                            de passe Investor (ou Trading)</label>
                        <input type="password" name="broker_password" required
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 12px; border-radius: 4px; outline: none;"
                            placeholder="••••••••">
                        <p style="font-size: 10px; color: var(--text-secondary); margin-top: 5px; opacity: 0.6;">
                            <i class="fa-solid fa-lock"></i> Vos données sont stockées de manière sécurisée.
                        </p>
                    </div>

                    <button type="submit"
                        style="width: 100%; background: var(--accent-emerald); color: white; border: none; padding: 14px; border-radius: 4px; font-weight: 600; cursor: pointer; letter-spacing: 0.5px;">
                        ASSOCIER LE COMPTE & GÉNÉRER LA CLÉ
                    </button>

                    <a href="{{ route('dashboard') }}"
                        style="display: block; text-align: center; margin-top: 20px; font-size: 12px; color: var(--text-secondary); text-decoration: none;">
                        Annuler
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection