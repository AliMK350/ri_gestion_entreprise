@extends('auth.auth-layout')

@section('auth_name')
    <div class="card-body">
        <p class="login-box-msg">Connectez-vous pour démarrer votre session</p>

        @include('_message')

        <form action="{{ url('/login') }}" method="post">
            @csrf
            {{ csrf_field() }}
            <div class="input-group mb-3">
                <input type="email" class="form-control" required name="email" placeholder="E-mail">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" required name="password" placeholder="Mot de passe">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">
                            Se souvenir de moi
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="mb-1">
            <a href="{{ url('forgot-password') }}">J’ai oublié mon mot de passe</a>
        </p>

        @if (config('app.env') === 'local')
            <p class="mb-0 mt-3 text-muted small">
                Demo: <strong>admin@example.com</strong> / <strong>password</strong>
            </p>
        @endif

    </div>
    <!-- /.card-body -->
@endsection
