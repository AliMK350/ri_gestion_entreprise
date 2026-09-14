@component('mail::message')
# Nouvelle demande de document administratif

Bonjour,

{{ $documentRequest->employee->name ?? 'Un employé' }} a demandé le document suivant :

- Document : {{ $documentRequest->document_type }}
- Motif : {{ $documentRequest->reason ?: 'Aucune précision fournie' }}

Veuillez consulter la plateforme pour traiter cette demande.

Merci,
L'équipe RH
@endcomponent
