@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Déclarer une Absence</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post" action="{{ route('employe.absences.store') }}" enctype="multipart/form-data">@csrf<div class="card-body">
        <div class="form-group"><label>Date *</label><input type="date" name="date" class="form-control" required></div>
        <div class="form-group"><label>Type d'absence</label><select name="half_day" class="form-control"><option value="">Journée complète</option><option value="morning">Demi-journée matin</option><option value="afternoon">Demi-journée après-midi</option></select></div>
        <div class="form-group"><label>Motif</label><input type="text" name="reason" class="form-control"></div>
        <div class="form-group"><label>Justificatif</label><input type="file" name="justification_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></div>
    </div><div class="card-footer"><button class="btn btn-primary">Enregistrer</button> <a href="{{ url('employe/absences') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
