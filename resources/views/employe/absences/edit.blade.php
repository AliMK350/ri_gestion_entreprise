@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Justifier une absence</h1></div></section>
    <section class="content"><div class="container-fluid">
        <div class="alert alert-warning">
            Cette absence a été déclarée par l'administration le <strong>{{ $absence->date->format('d/m/Y') }}</strong>.
            Veuillez indiquer le motif et joindre un justificatif.
        </div>
        <div class="card card-primary">
            <form method="post" action="{{ route($personnelUrlPrefix.'.absences.update', $absence->id) }}" enctype="multipart/form-data">@csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" class="form-control" value="{{ $absence->date->format('d/m/Y') }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <input type="text" class="form-control" value="{{ $absence->half_day ? ($absence->half_day == 'morning' ? 'Demi-journée matin' : 'Demi-journée après-midi') : 'Journée complète' }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Motif *</label>
                        <input type="text" name="reason" class="form-control @error('reason') is-invalid @enderror" value="{{ old('reason', $absence->reason) }}" required>
                        @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Justificatif @if(empty($absence->justification_file))*@endif</label>
                        @if(!empty($absence->justification_file))
                            <div class="mb-2">
                                <a href="{{ asset('storage/'.$absence->justification_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">Voir le justificatif actuel</a>
                            </div>
                        @endif
                        <input type="file" name="justification_file" class="form-control @error('justification_file') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" @if(empty($absence->justification_file)) required @endif>
                        @error('justification_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Formats acceptés : PDF, JPG, PNG, DOC, DOCX (max 2 Mo)</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Envoyer</button>
                    <a href="{{ url($personnelUrlPrefix.'/absences') }}" class="btn btn-default">Annuler</a>
                </div>
            </form>
        </div>
    </div></section>
</div>
@endsection
