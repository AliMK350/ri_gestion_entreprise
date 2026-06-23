@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notes</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_message')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Notes</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Élève</th>
                                        <th>Module</th>
                                        <th>Note /20</th>
                                        <th>Remarque</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notes as $note)
                                    <tr>
                                        <td>{{ $note->id }}</td>
                                        <td>{{ $note->student_name }}</td>
                                        <td>{{ $note->module_name }}</td>
                                        <td><strong>{{ $note->valeur }}</strong></td>
                                        <td>{{ $note->remarque }}</td>
                                        <td>
                                            <a href="{{ url('admin/notes/delete/'.$note->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette note?');">Supprimer</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
