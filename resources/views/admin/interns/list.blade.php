@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Stagiaires</h1></div><div class="col-sm-6"><div class="float-sm-right"><a href="{{ url('admin/interns/add') }}" class="btn btn-primary">Ajouter</a></div></div></div></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>#</th><th>Nom</th><th>Email</th><th>Département</th><th>Période</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $i => $v)<tr><td>{{ $getRecord->firstItem()+$i }}</td><td>{{ $v->name }}</td><td>{{ $v->email }}</td><td>{{ $v->department }}</td><td>{{ optional($v->started_at)->format('d/m/Y') }} — {{ optional($v->ended_at)->format('d/m/Y') }}</td><td><a href="{{ url('admin/interns/edit/'.$v->id) }}" class="btn btn-primary btn-sm">Éditer</a> @if($v->cv_path)<a href="{{ url('admin/interns/download-cv/'.$v->id) }}" class="btn btn-success btn-sm" title="Télécharger le CV"><i class="fas fa-download"></i> CV</a>@else<span class="badge badge-secondary" title="Aucun CV uploadé">Pas de CV</span>@endif <a href="{{ url('admin/interns/delete/'.$v->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a></td></tr>@empty<tr><td colspan="6" class="text-center">Aucun stagiaire.</td></tr>@endforelse
        </tbody></table>{{ $getRecord->links() }}</div></div>
    </div></section>
</div>
@endsection
