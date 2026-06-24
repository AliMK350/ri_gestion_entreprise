@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Déclarer une Absence</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf<div class="card-body">
        <div class="form-group"><label>Date *</label><input type="date" name="date" class="form-control" required></div>
        <div class="form-group"><label>Motif</label><input type="text" name="reason" class="form-control"></div>
    </div><div class="card-footer"><button class="btn btn-primary">Enregistrer</button> <a href="{{ url('employe/absences') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
