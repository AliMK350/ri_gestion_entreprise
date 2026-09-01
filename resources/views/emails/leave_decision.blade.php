@component('mail::message')
# Demande de congé

Bonjour,

Votre demande de congé du {{ $leave->start_date->format('d/m/Y') }} au {{ $leave->end_date->format('d/m/Y') }} a été {{ $status === 'approved' ? 'approuvée' : ($status === 'rejected' ? 'refusée' : 'annulée') }}.

@if($status === 'approved')
Votre congé a bien été pris en compte dans votre solde.
@elseif($status === 'cancelled')
Les jours de congé associés ont bien été remis à votre solde disponible.
@else
Vous pouvez soumettre une nouvelle demande si nécessaire.
@endif

Merci,
L'équipe RH
@endcomponent
