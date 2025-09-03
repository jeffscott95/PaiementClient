<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('login.css') }}">
</head>
<body>

<div class="login-card">
    <h3>Connexion</h3>

    @if($errors->any())
        <div class="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <!-- Nom d'utilisateur -->
        <label>Nom d’utilisateur</label>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>

        <!-- Numéro de téléphone avec drapeau et icône -->
        <label>Numéro de téléphone</label>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
            <span class="input-group-text">
                <img src="{{ asset('togo-flag.jpg') }}" alt="TG" style="width: 20px; height: 20px; border-radius: 50%; margin-right: 5px;">
                +228
            </span>
            <input type="number" name="phone" class="form-control" placeholder="Numéro de téléphone" maxlength="8" required>
        </div>

        <!-- Mot de passe -->
        <label>Mot de passe</label>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
      <div class="remember">
  <input type="checkbox" id="remember" name="remember">
  <label for="remember">Se souvenir de moi</label>
</div>

    </form>
</div>

</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const loginCard = document.querySelector(".login-card");
    const inputs = document.querySelectorAll("input");
    const button = document.querySelector("button");
    const alertBox = document.querySelector(".alert");

    // Animation d'apparition du formulaire
    loginCard.style.opacity = 0;
    loginCard.style.transform = "translateY(-20px)";
    setTimeout(() => {
        loginCard.style.transition = "all 0.6s ease";
        loginCard.style.opacity = 1;
        loginCard.style.transform = "translateY(0)";
    }, 200);

    // Animation au focus sur les champs
    inputs.forEach(input => {
        input.addEventListener("focus", () => {
            input.style.transition = "all 0.3s ease";
            input.style.transform = "scale(1.02)";
            input.style.boxShadow = "0 0 10px rgba(0, 123, 255, 0.4)";
        });

        input.addEventListener("blur", () => {
            input.style.transform = "scale(1)";
            input.style.boxShadow = "none";
        });
    });

    // Effet bouton au clic
    button.addEventListener("mousedown", () => {
        button.style.transform = "scale(0.95)";
    });
    button.addEventListener("mouseup", () => {
        button.style.transform = "scale(1)";
    });

    // Animation message d'erreur
    if (alertBox) {
        alertBox.style.opacity = 0;
        setTimeout(() => {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = 1;
        }, 300);
    }
});

</script>
</html>
