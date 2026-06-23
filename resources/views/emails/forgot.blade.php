@component('mail::message')
    Bonjour {{ $user->name }},

    <p>Nous comprenons que cela puisse arriver.</p>

    @component('mail::button', ['url' => url('reset/' . $user->remember_token)])
        Réinitialiser votre mot de passe
    @endcomponent

    <p>Si vous rencontrez le moindre problème pour récupérer votre mot de passe, veuillez nous contacter.</p>

    Merci, <br>
    {{ config('app.name') }}
@endcomponent
