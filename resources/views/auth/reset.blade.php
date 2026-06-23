@extends('auth.auth-layout')

@section('auth_name')
    <div class="card-body">
        <h4 class="login-box-msg">Réinitialiser votre mot de passe</h4>
        <p class="login-box-msg">Saisissez votre nouveau mot de passe</p>

        @include('_message')

        <form action="" method="post">
            @csrf
            {{ csrf_field() }}
            <div class="input-group mb-3">
                <input type="password" class="form-control" required name="password" placeholder="Mot de passe">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" required name="cpassword" placeholder="Confirmer le mot de passe">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Réinitialiser le mot de passe</button>
                </div>
            </div>
        </form>

    </div>
    <!-- /.card-body -->
@endsection
