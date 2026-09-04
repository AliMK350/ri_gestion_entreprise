@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Demander un Congé</h1>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @include('_message')

            @php
                $hasMinSeniority = $employee ? $employee->hasMinimumSeniority(6) : false;
                $seniorityText = $employee ? $employee->seniority_formatted : 'Non renseignée';
            @endphp

            @if(!$hasMinSeniority)
                <div class="alert alert-warning border-left shadow-sm p-3 mb-4" style="border-left: 5px solid #f39c12 !important; background-color: #fff8e1; color: #7e5109; border-radius: 8px;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x mr-3 text-warning"></i>
                        <div>
                            <h5 class="alert-heading font-weight-bold mb-1"><i class="fas fa-lock mr-1"></i> Restriction d'ancienneté (Moins de 6 mois)</h5>
                            <p class="mb-0">
                                Votre ancienneté actuelle est de <strong>{{ $seniorityText }}</strong>. Les employés de moins de 6 mois n'ont <strong>pas le droit</strong> de demander de congés normaux (congé payé).
                                Seuls les <strong>cas spéciaux</strong> (décès, mariage, maladie, ou cas exceptionnel avec justificatif) sont autorisés.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Formulaire de demande de congé</h3>
                </div>
                <form id="leaveRequestForm" method="POST" action="{{ route($personnelUrlPrefix.'.leaves.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-info-circle mr-2 fa-lg"></i>
                            <div>
                                Solde de congé actuel : <strong>{{ number_format($employee->leave_balance_days ?? 0, 2) }} jour(s)</strong>.
                                <small class="d-block text-muted">(Le solde s'accrémente de 1.5 jours par mois d'ancienneté et se réinitialise tous les 2 ans).</small>
                            </div>
                        </div>

                        <div id="jsLeaveErrorAlert" class="alert alert-danger d-none" role="alert">
                            <i class="fas fa-ban mr-1"></i> <span id="jsLeaveErrorText"></span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date début *</label>
                                    <input type="date" name="start_date" class="form-control" required value="{{ old('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date fin *</label>
                                    <input type="date" name="end_date" class="form-control" required value="{{ old('end_date') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Type de congé *</label>
                            <select name="type" id="leaveTypeSelect" class="form-control" required>
                                <option value="vacation" @if(!$hasMinSeniority) disabled @endif @if(old('type') == 'vacation') selected @endif>
                                    Congé payé (Normal) @if(!$hasMinSeniority) — [Non autorisé : < 6 mois d'ancienneté] @endif
                                </option>
                                <option value="sick" @if(old('type') == 'sick' || !$hasMinSeniority) selected @endif>Maladie (Cas spécial)</option>
                                <option value="death" @if(old('type') == 'death') selected @endif>Décès (Cas spécial)</option>
                                <option value="marriage" @if(old('type') == 'marriage') selected @endif>Mariage (Cas spécial)</option>
                                <option value="personal" @if(old('type') == 'personal') selected @endif>Personnel (Cas très spécial avec justificatif)</option>
                                <option value="other" @if(old('type') == 'other') selected @endif>Autre (Cas très spécial avec justificatif)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Motif / Explication</label>
                            <textarea name="reason" id="leaveReason" class="form-control" rows="3" placeholder="Saisissez le motif de votre demande (obligatoire avec fichier pour cas exceptionnel)...">{{ old('reason') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Justificatif (Document / Pièce jointe)</label>
                            <input type="file" name="justification_file" id="justificationFile" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <small class="form-text text-muted">Requis pour les demandes exceptionnelles si ancienneté < 6 mois.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="btnSubmitLeave" class="btn btn-primary px-4"><i class="fas fa-paper-plane mr-1"></i> Envoyer la demande</button>
                        <a href="{{ url($personnelUrlPrefix.'/absences') }}" class="btn btn-default">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Modal Avertissement Ancienneté -->
<div class="modal fade" id="seniorityRestrictionModal" tabindex="-1" role="dialog" aria-labelledby="seniorityModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold" id="seniorityModalTitle">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Demande de congé non autorisée
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <p class="mb-2"><strong>Vous disposez de moins de 6 mois d'ancienneté ({{ $seniorityText }}).</strong></p>
                <p class="text-danger font-weight-bold">
                    Vous n'avez pas le droit de demander de congé normal (Congé payé).
                </p>
                <hr>
                <p class="mb-0 text-muted">
                    Seuls les <strong>cas spéciaux</strong> (décès, mariage, maladie) ou un cas exceptionnel dûment motivé avec un fichier justificatif sont autorisés. Veuillez modifier le type de votre demande.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Compris</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var hasMinSeniority = {{ $hasMinSeniority ? 'true' : 'false' }};
    var form = document.getElementById('leaveRequestForm');
    var leaveTypeSelect = document.getElementById('leaveTypeSelect');
    var errorAlert = document.getElementById('jsLeaveErrorAlert');
    var errorText = document.getElementById('jsLeaveErrorText');

    function checkSeniorityRestriction() {
        if (!hasMinSeniority && leaveTypeSelect.value === 'vacation') {
            showRestrictionError("Vous avez moins de 6 mois d'ancienneté. La demande de congé payé (normal) est interdite.");
            return false;
        }
        hideRestrictionError();
        return true;
    }

    function showRestrictionError(msg) {
        errorText.textContent = msg;
        errorAlert.classList.remove('d-none');
        if (typeof $ !== 'undefined' && $('#seniorityRestrictionModal').length) {
            $('#seniorityRestrictionModal').modal('show');
        } else {
            alert("RÈGLE D'ANCIENNETÉ (< 6 MOIS) :\n\n" + msg + "\n\nSeuls les cas spéciaux (décès, mariage, maladie ou exception avec justificatif) sont autorisés.");
        }
    }

    function hideRestrictionError() {
        errorAlert.classList.add('d-none');
    }

    leaveTypeSelect.addEventListener('change', function() {
        if (!hasMinSeniority && this.value === 'vacation') {
            checkSeniorityRestriction();
        } else {
            hideRestrictionError();
        }
    });

    form.addEventListener('submit', function(e) {
        if (!hasMinSeniority && leaveTypeSelect.value === 'vacation') {
            e.preventDefault();
            checkSeniorityRestriction();
            return false;
        }
    });
});
</script>
@endsection
