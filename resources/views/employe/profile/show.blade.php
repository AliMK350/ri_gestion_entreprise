@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Mon Profil</h1></div></section>
    <section class="content"><div class="container-fluid">
        @if($getRecord)
        <div class="card"><div class="card-body">
            <p><strong>Nom:</strong> {{ $getRecord->name }}</p>
            <p><strong>Email:</strong> {{ $getRecord->email }}</p>
            <p><strong>Téléphone:</strong> {{ $getRecord->phone }}</p>
            <p><strong>Poste:</strong> {{ $getRecord->position }}</p>
            <p><strong>Département:</strong> {{ $getRecord->department }}</p>
            <p><strong>Embauché le:</strong> {{ optional($getRecord->hired_at)->format('d/m/Y') }}</p>
        </div></div>
        @else
        <div class="alert alert-warning">Aucun profil employé n'est associé à votre compte. Contactez l'administrateur.</div>
        @endif
    </div></section>
</div>
@endsection
