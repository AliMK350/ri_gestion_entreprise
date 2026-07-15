@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Modifier le Stagiaire</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post" enctype="multipart/form-data">@csrf<div class="card-body">
        <div class="form-group"><label>Nom *</label><input type="text" name="name" class="form-control" required value="{{ $getRecord->name }}"></div>
        <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required value="{{ $getRecord->email }}"></div>
        <div class="form-group"><label>Téléphone</label><input type="text" name="phone" class="form-control" value="{{ $getRecord->phone }}"></div>
        <div class="form-group"><label>Département</label><input type="text" name="department" class="form-control" value="{{ $getRecord->department }}"></div>
        <div class="form-group"><label>CV (PDF / Word)</label><input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"></div>
        @if(!empty($getRecord->cv_path))<div class="form-group"><a href="{{ asset('storage/'.$getRecord->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Voir le CV actuel</a></div>@endif
        <div class="form-group"><label>Début</label><input type="date" name="started_at" class="form-control" value="{{ optional($getRecord->started_at)->format('Y-m-d') }}"></div>
        <div class="form-group"><label>Fin</label><input type="date" name="ended_at" class="form-control" value="{{ optional($getRecord->ended_at)->format('Y-m-d') }}"></div>
    </div><div class="card-footer"><button class="btn btn-primary">Mettre à jour</button> <a href="{{ url('admin/interns/list') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
