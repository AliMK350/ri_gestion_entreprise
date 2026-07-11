@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Demander un Congé</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="POST" action="{{ route('employe.leaves.store') }}">@csrf<div class="card-body">
        <div class="alert alert-info">Solde actuel : <strong>{{ $employee->leave_balance_days ?? 0 }} jour(s)</strong>. Les dimanches ne sont pas déduits du solde.</div>
        <div class="form-group"><label>Date début *</label><input type="date" name="start_date" class="form-control" required></div>
        <div class="form-group"><label>Date fin *</label><input type="date" name="end_date" class="form-control" required></div>
        <div class="form-group"><label>Type *</label><select name="type" class="form-control"><option value="vacation">Congé payé</option><option value="sick">Maladie</option><option value="personal">Personnel</option><option value="other">Autre</option></select></div>
        <div class="form-group"><label>Motif</label><textarea name="reason" class="form-control" rows="3"></textarea></div>
    </div><div class="card-footer"><button class="btn btn-primary">Envoyer la demande</button> <a href="{{ url('employe/absences') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
