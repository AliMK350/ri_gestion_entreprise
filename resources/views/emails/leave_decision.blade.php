@component('mail::message')
# Demande de congé

Bonjour,

Votre demande de congé du {{ $leave->start_date->format('d/m/Y') }} au {{ $leave->end_date->format('d/m/Y') }} a été {{ $status === 'approved' ? 'approuvée' : 'refusée' }}.

@if($status === 'approved')
Votre congé a bien été pris en compte dans votre solde.
@else
Vous pouvez soumettre une nouvelle demande si nécessaire.
@endif

Merci,
L'équipe RH
@endcomponent
