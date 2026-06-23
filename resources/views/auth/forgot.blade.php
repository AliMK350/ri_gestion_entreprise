@extends('auth.auth-layout')

@section('auth_name')
    <div class="card-body">
        <h4 class="login-box-msg">Mot de passe oublié</h4>
        <p class="login-box-msg">Saisissez votre e-mail pour continuer</p>

        @include('_message')

        <form action="" method="post">
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

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Mot de passe oublié</button>
                </div>
            </div>
        </form>
        <hr />

        <p class="mb-1">
            <a href="{{ url('login') }}">Retour à la connexion</a>
        </p>

    </div>
    <!-- /.card-body -->
@endsection
