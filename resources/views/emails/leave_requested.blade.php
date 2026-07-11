@component('mail::message')
# Nouvelle demande de congé

Bonjour,

Une nouvelle demande de congé a été soumise par {{ $leave->employee->name ?? 'un employé' }}.

- Période : du {{ $leave->start_date->format('d/m/Y') }} au {{ $leave->end_date->format('d/m/Y') }}
- Type : {{ $leave->type }}
- Motif : {{ $leave->reason ?: 'Aucun motif fourni' }}

Veuillez consulter la plateforme pour approuver ou refuser cette demande.

Merci,
L'équipe RH
@endcomponent
