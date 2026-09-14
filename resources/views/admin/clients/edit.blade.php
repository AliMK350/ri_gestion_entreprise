@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Modifier le Client</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>Type de Client <span style="color: red;">*</span></label>
                                        <div class="d-flex align-items-center">
                                            <div class="custom-control custom-radio mr-4">
                                                <input class="custom-control-input" type="radio" id="typeEntreprise" name="client_type" value="entreprise" {{ old('client_type', $getRecord->client_type ?? 'entreprise') == 'entreprise' ? 'checked' : '' }} required>
                                                <label for="typeEntreprise" class="custom-control-label font-weight-bold">
                                                    <i class="fas fa-building text-info mr-1"></i> Entreprise
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="typePersonne" name="client_type" value="personne" {{ old('client_type', $getRecord->client_type) == 'personne' ? 'checked' : '' }} required>
                                                <label for="typePersonne" class="custom-control-label font-weight-bold">
                                                    <i class="fas fa-user text-secondary mr-1"></i> Personne (Particulier)
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Nom complet / Responsable <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="name" required
                                            value="{{ old('name', $getRecord->name) }}" placeholder="Entrez le nom du client ou du responsable">
                                    </div>

                                    <div class="form-group">
                                        <label>Nom de l'entreprise</label>
                                        <input type="text" class="form-control" name="company_name"
                                            value="{{ old('company_name', $getRecord->company_name) }}" placeholder="Entrez le nom de l'entreprise (si applicable)">
                                    </div>

                                    <div class="form-group">
                                        <label>Email <span style="color: red;">*</span></label>
                                        <input type="email" class="form-control" name="email" required
                                            value="{{ old('email', $getRecord->email) }}" placeholder="Entrez l'email du client">
                                        <div style="color:red">{{ $errors->first('email') }}</div>
                                    </div>

                                    <div class="form-group">
                                        <label>Téléphone</label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ old('phone', $getRecord->phone) }}" placeholder="Entrez le numéro de téléphone">
                                    </div>

                                    <div class="form-group">
                                        <label>Ville</label>
                                        <input type="text" class="form-control" name="city"
                                            value="{{ old('city', $getRecord->city) }}" placeholder="Entrez la ville">
                                    </div>

                                    <div class="form-group">
                                        <label>Adresse</label>
                                        <textarea class="form-control" name="address" rows="3" placeholder="Entrez l'adresse">{{ old('address', $getRecord->address) }}</textarea>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                    <a href="{{ url('admin/clients/list') }}" class="btn btn-default">Annuler</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
