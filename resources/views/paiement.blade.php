{{-- resources/views/paiement.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paiement - Yas</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <style>
  /* ===== RESET GLOBAL ===== */
body, html {
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: Arial, sans-serif;
  color: white;
  text-align: center;
  background-color: #005db9ff;
  /* background: url("yas.png") no-repeat center center; */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

/* ===== BARRE SUPERIEURE ===== */
.top-bar {
  position: absolute;
  top: 15px;
  right: 20px;
  display: flex;
  align-items: center;
  gap: 15px;
}

.username {
  font-weight: bold;
  color: #FFD700;
  text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
}

.btn-logout {
  background: #c0392b;
  color: white;
  padding: 8px 15px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
}

.btn-logout:hover {
  background: #e74c3c;
}

/* ===== TITRE D'ACCUEIL ===== */
.welcome {
  font-size: 2.5rem;
  font-weight: bold;
  color: #fff;
  margin-bottom: 30px;
  text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
  animation: slideIn 2s ease-out forwards;
  opacity: 0;
}

@keyframes slideIn {
  0% { transform: translateX(-100%); opacity: 0; }
  100% { transform: translateX(0); opacity: 1; }
}

/* ===== BOUTON PAYER ===== */
.btn-pay {
  background-color: #004080;
  color: #FFD700;
  border: none;
  padding: 15px 35px;
  border-radius: 30px;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.4);
}

.btn-pay:hover {
  background-color: #0066cc;
  transform: scale(1.05);
}

.payment-form {
  display: none; /* caché au chargement */
  max-width: 650px;
  width: 95%;
  padding: 2.5rem;
  border-radius: 15px;
  background: #ffffff;
  color: #333;
  box-shadow: 0px 10px 35px rgba(0, 0, 0, 0.25);
  animation: fadeIn 0.6s ease-in-out;
  margin-top: 25px;
}


/* Titre */
.payment-form h3 {
  font-size: 1.8rem;
  font-weight: bold;
  color: #004080;
  text-align: center;
  margin-bottom: 1.5rem;
  border-bottom: 2px solid #004080;
  padding-bottom: 10px;
}

/* Labels */
.payment-form label {
  font-weight: 600;
  margin-bottom: 6px;
  display: block;
  color: #004080;
}

/* Champs */
.payment-form .form-control {
  border-radius: 10px;
  border: 1px solid #ccc;
  padding: 12px;
  transition: 0.3s;
}

.payment-form .form-control:focus {
  border-color: #004080;
  box-shadow: 0 0 10px rgba(0, 64, 128, 0.3);
}

/* Bouton payer */
.payment-form button[type="submit"] {
  background: #004080;
  border: none;
  border-radius: 10px;
  padding: 14px;
  font-size: 18px;
  font-weight: bold;
  transition: 0.3s;
}

.payment-form button[type="submit"]:hover {
  background: #0066cc;
  transform: scale(1.03);
}

/* Animation d'apparition */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-15px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}


/* ===== PIED DE PAGE ===== */
.footer {
  position: absolute;
  bottom: 20px;
  width: 100%;
  text-align: center;
  font-size: 14px;
  color: #fff;
  background: rgba(0, 64, 128, 0.7);
  padding: 10px;
}

.footer strong {
  color: #FFD700;
}

 </style>
</head>
<body>

  <!-- Barre utilisateur -->
  <div class="top-bar">
    <div class="username">Bienvenue {{ session('username') }} !</div>
    <a href="/logout" class="btn-logout">Déconnexion</a>
  </div>

  <!-- Message accueil -->
  <div class="welcome">✨ Bienvenue sur la plateforme de paiement SUISCO ✨</div>

  <!-- Bouton qui affiche le formulaire -->
  <button class="btn-pay" onclick="showForm()">Effectuer Paiement</button>

  <!-- Formulaire caché -->
  <div class="payment-form" id="paymentForm">
    <h3>Formulaire de Paiement</h3>
    <form id="paiementForm">
      @csrf
      <!-- Numéro Client TMoney -->
      <label>Numéro Client (Mixx by yas)</label>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
        <span class="input-group-text">
          <img src="{{ asset('togo-flag.jpg') }}" alt="TG" style="width: 20px; height: 20px; border-radius: 50%; margin-right: 5px;">
          +228
        </span>
        <input type="number" id="numeroClient" name="numeroClient" class="form-control" placeholder="Numéro de téléphone" maxlength="8" required>
      </div>

      <!-- Montant -->
      <label>Montant (FCFA)</label>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
        <input type="number" id="montant" name="montant" class="form-control" placeholder="Montant à payer" required>
        <span class="input-group-text">FCFA</span>
      </div>

      <!-- Bouton -->
      <button type="submit" class="btn btn-primary w-100">Payer</button>
    </form>
  </div>

  <!-- Infos entreprise -->
  <div class="footer">
    <p><strong>suisco Payment</strong> © 2025 - Tous droits réservés</p>
    <p>Adresse : Lomé, Togo | Contact : +228 99 99 89 99 | www.suisco.tg</p>
  </div>

  <script>
    function showForm() {
      document.getElementById('paymentForm').style.display = 'block';
  // cacher le bouton
  document.querySelector('.btn-pay').style.display = 'none';
 

    }

    document.getElementById('paiementForm').addEventListener('submit', async function(e) {
      e.preventDefault(); // Empêche le rechargement de la page

      const numeroClient = document.getElementById("numeroClient").value;
      const montant = document.getElementById("montant").value;
      const refCommande = "CMD" + Date.now();

      // Message d'attente
      Swal.fire({
        title: '🔎 Vérification de la transaction...',
        text: 'Merci de patienter',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading()
        }
      });

      try {
        const response = await fetch("http://127.0.0.1:8000/api/paiement", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ numeroClient, montant, refCommande })
        });

        const result = await response.json();

        // Fermer le loader
        Swal.close();

        // Afficher le statut selon le code
        switch(result.code) {
          case "2000":
            Swal.fire('En cours', 'Demande en cours de traitement', 'info');
            break;
          case "2002":
            Swal.fire('Succès', 'Transaction effectuée', 'success');
            break;
          case "5001":
            Swal.fire('Erreur', 'Temps d\'attente dépassé', 'error');
            break;
          default:
            Swal.fire('Info', 'Code inconnu : ' + result.code, 'question');
        }

      } catch(err) {
        Swal.fire('Erreur', 'Impossible de contacter le serveur', 'error');
        console.error(err);
      }
    });
  </script>
</body>
</html>
