@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ajouter un Nouveau Client</h1>
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
                                        <label>Nom complet <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="name" required
                                            value="{{ old('name') }}" placeholder="Entrez le nom complet">
                                    </div>
                                    <div class="form-group">
                                        <label>Nom de l'entreprise</label>
                                        <input type="text" class="form-control" name="company_name"
                                            value="{{ old('company_name') }}" placeholder="Entrez le nom de l'entreprise">
                                    </div>
                                    <div class="form-group">
                                        <label>Email <span style="color: red;">*</span></label>
                                        <input type="email" class="form-control" name="email" required
                                            value="{{ old('email') }}" placeholder="Entrez l'email du client">
                                        <div style="color:red">{{ $errors->first('email') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Téléphone</label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ old('phone') }}" placeholder="Entrez le numéro de téléphone">
                                    </div>
                                    <div class="form-group">
                                        <label>Adresse</label>
                                        <textarea class="form-control" name="address" rows="3" placeholder="Entrez l'adresse">{{ old('address') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Statut <span style="color: red;">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Actif</option>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
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
