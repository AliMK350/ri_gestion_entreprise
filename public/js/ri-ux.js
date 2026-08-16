/* ===========================================================
   Ri Communication — UX ENHANCEMENTS
   Script purement additif : n'altère aucune logique métier,
   ne modifie ni requêtes ni formulaires. Améliore uniquement
   la présentation (icônes, animations, confirmations, toasts).
   =========================================================== */
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    injectButtonIcons();
    compactTableActionButtons();
    animateTableRows();
    markEmptyStates();
    setupRipple();
    setupConfirmModal();
    convertFlashToToasts();
    setupSubmitLoading();
  });

  /* ---------------------------------------------------------
     1) Auto-injection d'icônes FontAwesome sur les boutons
        en fonction du texte (aucune modif des vues nécessaire)
  --------------------------------------------------------- */
  function injectButtonIcons() {
    var rules = [
      [/ajouter|nouveau|nouvelle|cr[ée]er/i, "fa-plus"],
      [/supprimer|delete/i, "fa-trash"],
      [/[ée]diter|modifier|justifier/i, "fa-pen"],
      [/rechercher|search/i, "fa-search"],
      [/enregistrer|sauvegarder|mettre à jour|update|soumettre|submit|envoyer.*demande|envoyer/i, "fa-save"],
      [/valider|approuver|accepter/i, "fa-check"],
      [/refuser|rejeter|reject/i, "fa-times"],
      [/annuler|cancel|fermer/i, "fa-ban"],
      [/retour|back/i, "fa-arrow-left"],
      [/voir le cv|cv/i, "fa-file-alt"],
      [/voir|afficher|d[ée]tail|historique/i, "fa-eye"],
      [/t[ée]l[ée]charger|download|export|pdf/i, "fa-download"],
      [/imprimer|print/i, "fa-print"],
      [/se connecter|connexion|login/i, "fa-sign-in-alt"],
      [/d[ée]connexion|logout/i, "fa-sign-out-alt"],
      [/mot de passe oubli[ée]|r[ée]initialiser/i, "fa-key"],
      [/d[ée]clarer|demander/i, "fa-paper-plane"]
    ];

    document.querySelectorAll(".btn").forEach(function (btn) {
      if (btn.querySelector("i, svg")) return; // déjà une icône
      var label = (btn.textContent || "").trim();
      if (!label) return;
      for (var i = 0; i < rules.length; i++) {
        if (rules[i][0].test(label)) {
          var icon = document.createElement("i");
          icon.className = "fas " + rules[i][1];
          btn.insertBefore(icon, btn.firstChild);
          break;
        }
      }
    });
  }

  /* ---------------------------------------------------------
     2) Animation d'entrée décalée pour les lignes de tableau
  --------------------------------------------------------- */
  function animateTableRows() {
    document.querySelectorAll("table.table tbody tr").forEach(function (row, idx) {
      row.classList.add("ri-stagger");
      row.style.animationDelay = Math.min(idx * 30, 400) + "ms";
    });
  }

  /* ---------------------------------------------------------
     2b) Compacte les boutons d'action dans les tableaux
         (Éditer / Supprimer / Voir...) en pastilles icône-seule
         avec info-bulle, pour éviter le débordement / retour
         à la ligne dans des colonnes "Actions" étroites.
  --------------------------------------------------------- */
  function compactTableActionButtons() {
    document.querySelectorAll("table.table td").forEach(function (td) {
      var btns = td.querySelectorAll(".btn");
      if (!btns.length) return;

      td.classList.add("ri-actions-cell");

      var group = document.createElement("div");
      group.className = "ri-actions-group";
      td.insertBefore(group, td.firstChild);

      btns.forEach(function (btn) {
        var label = (btn.textContent || "").trim();
        if (label) {
          btn.setAttribute("data-tooltip", label);
          btn.setAttribute("aria-label", label);
          var icon = btn.querySelector("i");
          var textNode = null;
          btn.childNodes.forEach(function (n) {
            if (n.nodeType === 3 && n.textContent.trim()) textNode = n;
          });
          if (textNode) {
            var span = document.createElement("span");
            span.className = "ri-btn-label";
            span.textContent = textNode.textContent;
            textNode.parentNode.replaceChild(span, textNode);
          }
        }
        btn.classList.add("ri-icon-btn");

        // IMPORTANT: some row actions (e.g. Approuver/Refuser) are a
        // <button> living inside its own <form>. Moving the bare button
        // out of that form would silently break its submit behaviour
        // (a submit button only submits the form it is a descendant of).
        // So when that's the case, move the whole <form> instead — the
        // button stays inside it, submission keeps working — and let
        // the form render inline via CSS (display: contents).
        var parentForm = btn.closest("form");
        var moveTarget = btn;
        if (parentForm && td.contains(parentForm)) {
          parentForm.classList.add("ri-inline-form");
          moveTarget = parentForm;
        }
        group.appendChild(moveTarget);
      });
    });
  }


  function markEmptyStates() {
    document.querySelectorAll("table.table tbody td").forEach(function (td) {
      var text = (td.textContent || "").trim();
      if (td.hasAttribute("colspan") && /aucun|aucune/i.test(text)) {
        td.classList.add("ri-empty-state-cell");
        td.innerHTML =
          '<div class="ri-empty-state">' +
          '<i class="fas fa-inbox"></i>' +
          "<span>" + text + "</span>" +
          "</div>";
      }
    });
  }

  /* ---------------------------------------------------------
     4) Effet ripple au clic sur les boutons
  --------------------------------------------------------- */
  function setupRipple() {
    document.addEventListener("click", function (e) {
      var btn = e.target.closest(".btn");
      if (!btn) return;
      var rect = btn.getBoundingClientRect();
      var span = document.createElement("span");
      var size = Math.max(rect.width, rect.height);
      span.className = "ri-ripple";
      span.style.width = span.style.height = size + "px";
      span.style.left = (e.clientX - rect.left - size / 2) + "px";
      span.style.top = (e.clientY - rect.top - size / 2) + "px";
      btn.appendChild(span);
      setTimeout(function () { span.remove(); }, 550);
    });
  }

  /* ---------------------------------------------------------
     5) Remplacement des confirm() natifs par une modale stylée
        Intercepte les liens/boutons onclick="return confirm('...')"
        AVANT qu'ils ne s'exécutent (phase de capture), sans
        toucher aux fichiers blade existants.
  --------------------------------------------------------- */
  var modalOverlay, modalBox, modalTitle, modalText, modalYes, modalNo;

  function buildModal() {
    modalOverlay = document.createElement("div");
    modalOverlay.className = "ri-modal-overlay";
    modalOverlay.innerHTML =
      '<div class="ri-modal-box">' +
      '<div class="ri-modal-icon"><i class="fas fa-exclamation-triangle"></i></div>' +
      '<div class="ri-modal-title">Confirmation requise</div>' +
      '<div class="ri-modal-text" id="riModalText"></div>' +
      '<div class="ri-modal-actions">' +
      '<button type="button" class="btn btn-secondary" id="riModalCancel"><i class="fas fa-ban"></i> Annuler</button>' +
      '<button type="button" class="btn btn-danger" id="riModalConfirm"><i class="fas fa-check"></i> Confirmer</button>' +
      "</div></div>";
    document.body.appendChild(modalOverlay);
    modalText = modalOverlay.querySelector("#riModalText");
    modalYes = modalOverlay.querySelector("#riModalConfirm");
    modalNo = modalOverlay.querySelector("#riModalCancel");

    modalOverlay.addEventListener("click", function (e) {
      if (e.target === modalOverlay) closeModal();
    });
    modalNo.addEventListener("click", closeModal);
  }

  function openModal(message, onConfirm) {
    if (!modalOverlay) buildModal();
    modalText.textContent = message;
    modalOverlay.classList.add("ri-open");

    var confirmHandler = function () {
      closeModal();
      onConfirm();
    };
    modalYes.onclick = confirmHandler;

    function escHandler(e) {
      if (e.key === "Escape") closeModal();
    }
    document.addEventListener("keydown", escHandler, { once: true });
  }

  function closeModal() {
    if (modalOverlay) modalOverlay.classList.remove("ri-open");
  }

  function setupConfirmModal() {
    document.addEventListener(
      "click",
      function (e) {
        var trigger = e.target.closest('[onclick*="confirm("]');
        if (!trigger) return;

        var onclickAttr = trigger.getAttribute("onclick") || "";
        var match = onclickAttr.match(/confirm\((['"])([\s\S]*?)\1\)/);
        var message = match ? match[2] : "Confirmer cette action ?";

        e.preventDefault();
        e.stopImmediatePropagation();

        openModal(message, function () {
          if (trigger.tagName === "A" && trigger.getAttribute("href")) {
            window.location.href = trigger.getAttribute("href");
          } else if (trigger.form) {
            trigger.form.submit();
          } else if (trigger.closest("form")) {
            trigger.closest("form").submit();
          }
        });
      },
      true
    );
  }

  /* ---------------------------------------------------------
     6) Transformation des alertes Laravel (session flash) en
        toasts discrets, avec icône + auto-dismiss
  --------------------------------------------------------- */
  function convertFlashToToasts() {
    var alerts = document.querySelectorAll(
      ".content-wrapper .alert, .content .alert"
    );
    if (!alerts.length) return;

    var container = document.createElement("div");
    container.className = "ri-toast-container";
    document.body.appendChild(container);

    var iconMap = {
      "alert-success": ["fa-check-circle", "ri-toast-success"],
      "alert-danger": ["fa-times-circle", "ri-toast-danger"],
      "alert-warning": ["fa-exclamation-circle", "ri-toast-warning"],
      "alert-info": ["fa-info-circle", "ri-toast-info"],
      "alert-primary": ["fa-info-circle", "ri-toast-info"],
      "alert-secondary": ["fa-info-circle", "ri-toast-info"],
      "alert-light": ["fa-info-circle", "ri-toast-info"]
    };

    alerts.forEach(function (alert) {
      var type = "alert-info";
      for (var cls in iconMap) {
        if (alert.classList.contains(cls)) { type = cls; break; }
      }
      var iconClass = iconMap[type][0];
      var toastClass = iconMap[type][1];

      var toast = document.createElement("div");
      toast.className = "ri-toast " + toastClass;
      toast.innerHTML =
        '<i class="fas ' + iconClass + ' ri-toast-icon"></i>' +
        '<div class="ri-toast-body">' + alert.innerHTML.replace(/×|<button[^>]*>[\s\S]*?<\/button>/gi, "") + "</div>" +
        '<button type="button" class="ri-toast-close">&times;</button>' +
        '<div class="ri-toast-progress"></div>';

      container.appendChild(toast);
      alert.classList.add("ri-toast-source");

      var timer = setTimeout(function () { dismissToast(toast); }, 5000);
      toast.querySelector(".ri-toast-close").addEventListener("click", function () {
        clearTimeout(timer);
        dismissToast(toast);
      });
    });

    function dismissToast(toast) {
      toast.classList.add("ri-toast-out");
      setTimeout(function () { toast.remove(); }, 350);
    }
  }

  /* ---------------------------------------------------------
     7) Petit état de chargement sur les boutons submit
  --------------------------------------------------------- */
  function setupSubmitLoading() {
    document.querySelectorAll("form").forEach(function (form) {
      form.addEventListener("submit", function () {
        if (form.dataset.noRiLoading) return;
        var submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn && !submitBtn.classList.contains("ri-loading")) {
          submitBtn.classList.add("ri-loading");
        }
      });
    });
  }
})();
