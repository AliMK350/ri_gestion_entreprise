@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Consultation du Personnel</h1></div></section>
    <section class="content"><div class="container-fluid">
        <div class="card"><div class="card-header"><h3>Employés ({{ $employees->count() }})</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>Nom</th><th>Email</th><th>Poste</th><th>Département</th></tr></thead><tbody>@foreach($employees as $e)<tr><td>{{ $e->name }}</td><td>{{ $e->email }}</td><td>{{ $e->position }}</td><td>{{ $e->department }}</td></tr>@endforeach</tbody></table></div></div>
        <div class="card"><div class="card-header"><h3>Stagiaires ({{ $interns->count() }})</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>Nom</th><th>Email</th><th>Département</th><th>Période</th></tr></thead><tbody>@foreach($interns as $i)<tr><td>{{ $i->name }}</td><td>{{ $i->email }}</td><td>{{ $i->department }}</td><td>{{ optional($i->started_at)->format('d/m/Y') }} — {{ optional($i->ended_at)->format('d/m/Y') }}</td></tr>@endforeach</tbody></table></div></div>
    </div></section>
</div>
@endsection
