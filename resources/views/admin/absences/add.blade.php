@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Déclarer une Absence</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf<div class="card-body">
        <div class="form-group"><label>Employé *</label><select name="employee_id" class="form-control" required><option value="">— Sélectionner —</option>@foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->name }} @if($e->user)— {{ $e->user->user_type == 2 ? 'Secrétaire' : ($e->user->user_type == 4 ? 'Gérant' : 'Employé') }}@endif</option>@endforeach</select></div>
        <div class="form-group"><label>Date *</label><input type="date" name="date" class="form-control" required></div>
        <div class="form-group"><label>Type d'absence</label><select name="half_day" class="form-control"><option value="">Journée complète</option><option value="morning">Demi-journée matin</option><option value="afternoon">Demi-journée après-midi</option></select></div>
        <p class="text-muted"><small>L'employé pourra ensuite ajouter le motif et le justificatif depuis son espace personnel.</small></p>
    </div><div class="card-footer"><button class="btn btn-primary">Enregistrer</button> <a href="{{ url('admin/absences/list') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
