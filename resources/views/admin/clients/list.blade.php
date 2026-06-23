@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestion des Clients</h1>
                    </div>
                    <div class="col-sm-6">
                        @if(Auth::user()->user_type == 1)
                        <div class="float-sm-right">
                            <a href="{{ url('admin/clients/add') }}" class="btn btn-primary"> Ajouter un nouveau Client</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Rechercher un Client</h3>
                    </div>
                    <form action="" method="get">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ Request::get('name') }}" placeholder="Nom du client">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="company_name"
                                        value="{{ Request::get('company_name') }}" placeholder="Entreprise">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="email"
                                        value="{{ Request::get('email') }}" placeholder="Email">
                                </div>
                                <div class="form-group col-md-3">
                                    <button class="btn btn-primary" type="submit"> Rechercher </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @include('_message')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><span class="font-weight-bold">Nombre Total de Clients :</span>
                                    {{ $getRecord->total() }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Entreprise</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            <th>Adresse</th>
                                            <th>Statut</th>
                                            <th>Créé par</th>
                                            <th>Date de création</th>
                                            @if(Auth::user()->user_type == 1)
                                            <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <p class="d-none">{{ $i = 0 }}</p>
                                        @forelse ($getRecord as $value)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->company_name }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>{{ $value->phone }}</td>
                                                <td>{{ $value->address }}</td>
                                                <td>
                                                    @if($value->status == 0)
                                                        <span class="badge badge-success">Actif</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactif</span>
                                                    @endif
                                                </td>
                                                <td>{{ $value->creator_name ?? 'Inconnu' }}</td>
                                                <td>{{ date('d/m/Y | H:i A', strtotime($value->created_at)) }}</td>
                                                @if(Auth::user()->user_type == 1)
                                                <td>
                                                    <a href="{{ url('admin/clients/edit/' . $value->id) }}"
                                                        class="btn btn-primary btn-sm"> Éditer</a>
                                                    <a href="{{ url('admin/clients/delete/' . $value->id) }}"
                                                        class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous supprimer ce client ?')"> Supprimer</a>
                                                </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Aucun client trouvé.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="float-left p-10">
                                    {{ $getRecord->links() }}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
