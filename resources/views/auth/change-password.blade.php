@extends('auth.auth-layout')

@section('auth_name')
    <div class="card-body">
        <p class="login-box-msg">Changez votre mot de passe provisoire</p>
        <div class="alert alert-info">Vous devez définir un nouveau mot de passe avant d'accéder à votre espace.</div>

        @include('_message')
        <form action="{{ route('password.update') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="password" name="current_password" class="form-control" required placeholder="Mot de passe provisoire">
                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
            </div>
            @error('current_password')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" required placeholder="Nouveau mot de passe">
                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-key"></span></div></div>
            </div>
            @error('password')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
            <div class="input-group mb-3">
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Confirmer le nouveau mot de passe">
                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-check"></span></div></div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Enregistrer le nouveau mot de passe</button>
        </form>
        <form action="{{ url('logout') }}" method="get" class="mt-2"><button type="submit" class="btn btn-link btn-block">Se déconnecter</button></form>
    </div>
@endsection
