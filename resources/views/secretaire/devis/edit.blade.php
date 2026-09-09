@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h1 class="m-0 text-dark"><i class="fas fa-edit text-primary mr-2"></i>Modifier le Devis {{ $getRecord->reference }}</h1>
                    <small class="text-muted">Modifiez les informations, les lignes d'articles et les conditions du devis</small>
                </div>
                <div>
                    <a href="{{ url('secretaire/devis/pdf/'.$getRecord->id) }}" class="btn btn-outline-danger mr-2" target="_blank"><i class="fas fa-file-pdf mr-1"></i> Télécharger PDF</a>
                    <a href="{{ url('secretaire/devis/list') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Retour</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_message')
            
            <form method="post" action="{{ url('secretaire/devis/edit/'.$getRecord->id) }}" id="quoteForm">
                @csrf
                
                <!-- Bloc Informations Générales -->
                <div class="card card-primary card-outline shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-info-circle mr-2"></i>Informations Générales</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="reference" class="font-weight-600">Numéro du devis <span class="text-danger">*</span></label>
                                <input type="text" name="reference" id="reference" class="form-control @error('reference') is-invalid @enderror" value="{{ old('reference', $getRecord->reference) }}" required>
                                @error('reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-3 form-group">
                                <label for="quote_date" class="font-weight-600">Date du devis <span class="text-danger">*</span></label>
                                <input type="date" name="quote_date" id="quote_date" class="form-control @error('quote_date') is-invalid @enderror" value="{{ old('quote_date', $getRecord->quote_date ?? date('Y-m-d')) }}" required>
                                @error('quote_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="seller_id" class="font-weight-600">Vendeur / Émetteur</label>
                                <select name="seller_id" id="seller_id" class="form-control select2">
                                    @foreach($sellers as $seller)
                                        <option value="{{ $seller->id }}" {{ old('seller_id', $getRecord->seller_id) == $seller->id ? 'selected' : '' }}>
                                            {{ $seller->name }} ({{ $seller->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="client_id" class="font-weight-600">Client <span class="text-danger">*</span></label>
                                <select name="client_id" id="client_id" class="form-control select2 @error('client_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner un client --</option>
                                    @foreach($clients as $c)
                                        <option value="{{ $c->id }}" {{ old('client_id', $getRecord->client_id) == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }} {{ $c->company_name ? '('.$c->company_name.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-3 form-group">
                                <label for="status" class="font-weight-600">Statut du devis <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="draft" {{ old('status', $getRecord->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                    <option value="sent" {{ old('status', $getRecord->status) == 'sent' ? 'selected' : '' }}>Envoyé</option>
                                    <option value="accepted" {{ old('status', $getRecord->status) == 'accepted' ? 'selected' : '' }}>Accepté</option>
                                    <option value="rejected" {{ old('status', $getRecord->status) == 'rejected' ? 'selected' : '' }}>Refusé</option>
                                </select>
                            </div>

                            <div class="col-md-9 form-group">
                                <label for="validity_date" class="font-weight-600">Délai de validité du devis</label>
                                <input type="text" name="validity_date" id="validity_date" class="form-control" value="{{ old('validity_date', $getRecord->validity_date) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bloc Lignes du Devis -->
                <div class="card card-primary card-outline shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-primary font-weight-bold mb-0"><i class="fas fa-list-ol mr-2"></i>Lignes du Devis</h3>
                        <button type="button" class="btn btn-sm btn-primary" id="btnAddItem"><i class="fas fa-plus mr-1"></i> Ajouter une ligne</button>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="itemsTable">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 25%;">Désignation <span class="text-danger">*</span></th>
                                    <th style="width: 20%;">Description</th>
                                    <th style="width: 10%;">Qté <span class="text-danger">*</span></th>
                                    <th style="width: 10%;">Unité</th>
                                    <th style="width: 12%;">Prix Unitaire HT <span class="text-danger">*</span></th>
                                    <th style="width: 9%;">TVA (%)</th>
                                    <th style="width: 11%;">Montant HT</th>
                                    <th style="width: 3%; text-align: center;"><i class="fas fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody id="itemsTableBody">
                                <!-- Dynamic Rows Inserted Here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-light text-right">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddItemFooter"><i class="fas fa-plus mr-1"></i> Ajouter une prestation</button>
                    </div>
                </div>

                <!-- Bloc Totaux & Conditions -->
                <div class="row">
                    <div class="col-md-7">
                        <div class="card card-secondary card-outline shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-file-contract mr-2"></i>Conditions & Observations</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="payment_conditions" class="font-weight-600">Conditions de paiement</label>
                                    <textarea name="payment_conditions" id="payment_conditions" class="form-control" rows="2">{{ old('payment_conditions', $getRecord->payment_conditions) }}</textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="notes" class="font-weight-600">Observations / Notes complémentaires</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $getRecord->notes) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card card-primary shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title font-weight-bold mb-0"><i class="fas fa-calculator mr-2"></i>Récapitulatif des Totaux</h3>
                            </div>
                            <div class="card-body p-3 bg-white">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted font-weight-600">Total Montant HT :</span>
                                    <span class="h5 font-weight-bold mb-0 text-dark" id="displayTotalHt">0.00 DH</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted font-weight-600">Total Montant TVA :</span>
                                    <span class="h5 font-weight-bold mb-0 text-info" id="displayTotalTva">0.00 DH</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2">
                                    <span class="h5 font-weight-bold text-primary mb-0">TOTAL TTC :</span>
                                    <span class="h4 font-weight-bold text-success mb-0" id="displayTotalTtc">0.00 DH</span>
                                </div>
                            </div>
                            <div class="card-footer bg-light d-flex justify-content-between">
                                <a href="{{ url('secretaire/devis/list') }}" class="btn btn-default">Annuler</a>
                                <button type="submit" class="btn btn-success btn-lg px-4"><i class="fas fa-save mr-1"></i> Mettre à jour</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>
</div>

<!-- JS Dynamic Rows Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = 0;
    const tbody = document.getElementById('itemsTableBody');

    const defaultUnits = ['Unité', 'Heure', 'Jour', 'Forfait', 'Mois'];
    const defaultTvas  = [20];

    const existingItems = @json($getRecord->items);

    function createRow(data = {}) {
        itemIndex++;
        const tr = document.createElement('tr');
        tr.id = `row-${itemIndex}`;
        
        const designation = data.designation || '';
        const description = data.description || '';
        const quantity    = data.quantity !== undefined ? data.quantity : 1;
        const unit        = data.unit || 'Unité';
        const unitPrice   = data.unit_price_ht !== undefined ? data.unit_price_ht : 0;
        const tvaRate     = data.tva_rate !== undefined ? data.tva_rate : 20;

        tr.innerHTML = `
            <td>
                <input type="text" name="items[${itemIndex}][designation]" class="form-control form-control-sm designation-input" placeholder="ex: Prestation" value="${designation}" required>
            </td>
            <td>
                <textarea name="items[${itemIndex}][description]" class="form-control form-control-sm" rows="1" placeholder="Détails...">${description}</textarea>
            </td>
            <td>
                <input type="number" step="0.01" min="0.01" name="items[${itemIndex}][quantity]" class="form-control form-control-sm qty-input" value="${quantity}" required>
            </td>
            <td>
                <select name="items[${itemIndex}][unit]" class="form-control form-control-sm">
                    ${defaultUnits.map(u => `<option value="${u}" ${u === unit ? 'selected' : ''}>${u}</option>`).join('')}
                </select>
            </td>
            <td>
                <input type="number" step="0.01" min="0" name="items[${itemIndex}][unit_price_ht]" class="form-control form-control-sm price-input" value="${unitPrice}" required>
            </td>
            <td>
                <select name="items[${itemIndex}][tva_rate]" class="form-control form-control-sm tva-input">
                    ${defaultTvas.map(t => `<option value="${t}" ${t == tvaRate ? 'selected' : ''}>${t}%</option>`).join('')}
                </select>
            </td>
            <td class="align-middle text-right font-weight-bold text-dark row-total-ht">
                0.00 DH
            </td>
            <td class="align-middle text-center">
                <button type="button" class="btn btn-xs btn-outline-danger btn-remove-row" title="Supprimer la ligne"><i class="fas fa-times"></i></button>
            </td>
        `;

        tbody.appendChild(tr);

        // Bind calculation events
        const qtyInput   = tr.querySelector('.qty-input');
        const priceInput = tr.querySelector('.price-input');
        const tvaInput   = tr.querySelector('.tva-input');
        const btnRemove  = tr.querySelector('.btn-remove-row');

        qtyInput.addEventListener('input', calculateTotals);
        priceInput.addEventListener('input', calculateTotals);
        tvaInput.addEventListener('change', calculateTotals);

        btnRemove.addEventListener('click', function () {
            if (tbody.children.length > 1) {
                tr.remove();
                calculateTotals();
            } else {
                alert('Le devis doit comporter au moins une ligne.');
            }
        });

        calculateTotals();
    }

    function calculateTotals() {
        let globalHt = 0;
        let globalTva = 0;

        const rows = tbody.querySelectorAll('tr');
        rows.forEach(tr => {
            const qty   = parseFloat(tr.querySelector('.qty-input').value) || 0;
            const price = parseFloat(tr.querySelector('.price-input').value) || 0;
            const tva   = parseFloat(tr.querySelector('.tva-input').value) || 0;

            const rowHt  = qty * price;
            const rowTva = rowHt * (tva / 100);

            tr.querySelector('.row-total-ht').textContent = rowHt.toFixed(2) + ' DH';

            globalHt  += rowHt;
            globalTva += rowTva;
        });

        const globalTtc = globalHt + globalTva;

        document.getElementById('displayTotalHt').textContent  = globalHt.toFixed(2) + ' DH';
        document.getElementById('displayTotalTva').textContent = globalTva.toFixed(2) + ' DH';
        document.getElementById('displayTotalTtc').textContent = globalTtc.toFixed(2) + ' DH';
    }

    document.getElementById('btnAddItem').addEventListener('click', () => createRow());
    document.getElementById('btnAddItemFooter').addEventListener('click', () => createRow());

    if (existingItems && existingItems.length > 0) {
        existingItems.forEach(item => createRow(item));
    } else {
        createRow();
    }
});
</script>
@endsection
