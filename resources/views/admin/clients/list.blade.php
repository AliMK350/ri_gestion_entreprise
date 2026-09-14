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
                        @if(in_array(Auth::user()->user_type, [1, 4]))
                        <div class="float-sm-right">
                            <a href="{{ url('admin/clients/add') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Ajouter un nouveau Client
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-search"></i> Rechercher un Client</h3>
                    </div>
                    <form action="" method="get">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Type de Client</label>
                                    <select class="form-control" name="client_type">
                                        <option value="">Tous les types</option>
                                        <option value="entreprise" {{ Request::get('client_type') == 'entreprise' ? 'selected' : '' }}>Entreprise</option>
                                        <option value="personne" {{ Request::get('client_type') == 'personne' ? 'selected' : '' }}>Personne</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Nom du client</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ Request::get('name') }}" placeholder="Nom">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Entreprise</label>
                                    <input type="text" class="form-control" name="company_name"
                                        value="{{ Request::get('company_name') }}" placeholder="Entreprise">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Ville</label>
                                    <input type="text" class="form-control" name="city"
                                        value="{{ Request::get('city') }}" placeholder="Ville">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email"
                                        value="{{ Request::get('email') }}" placeholder="Email">
                                </div>
                                <div class="form-group col-md-2" style="margin-top: 32px;">
                                    <button class="btn btn-primary" type="submit"> Rechercher </button>
                                    <a href="{{ url('admin/clients/list') }}" class="btn btn-secondary">Réinitialiser</a>
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
                                            <th>Type</th>
                                            <th>Nom / Responsable</th>
                                            <th>Entreprise</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            <th>Ville</th>
                                            <th>Adresse</th>
                                            @if(in_array(Auth::user()->user_type, [1, 4]))
                                            <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <p class="d-none">{{ $i = 0 }}</p>
                                        @forelse ($getRecord as $value)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>
                                                    @if($value->client_type == 'personne')
                                                        <span class="badge badge-secondary" style="font-size: 0.9rem;">
                                                            <i class="fas fa-user"></i> Personne
                                                        </span>
                                                    @else
                                                        <span class="badge badge-info" style="font-size: 0.9rem;">
                                                            <i class="fas fa-building"></i> Entreprise
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->company_name ?? '-' }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>{{ $value->phone ?? '-' }}</td>
                                                <td>{{ $value->city ?? '-' }}</td>
                                                <td>{{ $value->address ?? '-' }}</td>
                                                @if(in_array(Auth::user()->user_type, [1, 4]))
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
                                                <td colspan="9" class="text-center">Aucun client trouvé.</td>
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
