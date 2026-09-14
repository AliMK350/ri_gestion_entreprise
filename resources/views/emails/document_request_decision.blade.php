@component('mail::message')
# Mise à jour de votre demande

Bonjour {{ $documentRequest->employee->name ?? '' }},

Votre demande de **{{ $documentRequest->document_type }}** a été **{{ $status === 'approved' ? 'acceptée' : 'refusée' }}**.

@if($documentRequest->admin_response)
Réponse du directeur :

{{ $documentRequest->admin_response }}
@endif

Vous pouvez consulter le détail de vos demandes depuis votre espace employé.

Merci,
L'équipe RH
@endcomponent
