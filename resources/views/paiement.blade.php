<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paiement - Yas</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<!-- C:\wamp64\bin\php\php8.3.14\extras\ssl -->
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: Arial, sans-serif;
      background: url("yas.png") no-repeat center center ;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
    }

    /* Barre utilisateur */
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

    /* Message de bienvenue */
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

    /* Bouton principal */
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

    /* Formulaire caché */
    .payment-form {
      display: none;
      background: rgba(255,255,255,0.95);
      color: #333;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0px 8px 20px rgba(0,0,0,0.3);
      text-align: left;
      width: 380px;
      margin-top: 20px;
      animation: fadeIn 0.8s ease;
    }
    .payment-form h3 {
      text-align: center;
      margin-bottom: 1rem;
      color: #004080;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }

    /* Footer */
    .footer {
      position: absolute;
      bottom: 20px;
      text-align: center;
      width: 100%;
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
  <div class="welcome">✨ Bienvenue sur la plateforme de paiement Yas ✨</div>

  <!-- Bouton qui affiche le formulaire -->
  <button class="btn-pay" onclick="showForm()">Effectuer Paiement</button>

  <!-- Formulaire caché -->
  <div class="payment-form" id="paymentForm">
    <h3>Formulaire de Paiement</h3>
    <form action="/paiement" method="POST">
      @csrf
      <!-- Numéro Client TMoney -->
      <label>Numéro Client (TMoney)</label>
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
    <p><strong>Yas Payment</strong> © 2025 - Tous droits réservés</p>
    <p>Adresse : Lomé, Togo | Contact : +228 90 00 00 00 | Email : support@yas.tg</p>
  </div>

  <script>
    function showForm() {
      document.getElementById('paymentForm').style.display = 'block';
    }


    async function effectuerPaiement() {
  const numeroClient = document.getElementById("numeroClient").value;
  const montant = document.getElementById("montant").value;
  const refCommande = "CMD" + Date.now();

  const response = await fetch("http://127.0.0.1:8000/api/paiement", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      numeroClient: numeroClient,
      montant: montant,
      refCommande: refCommande
    })
  });

  const result = await response.json();
  console.log(result);
  alert("Réponse API: " + JSON.stringify(result));
}

  </script>
</body>
</html>  