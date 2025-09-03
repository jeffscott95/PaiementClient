<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('login.css') }}">
</head>
<body>

<div class="login-card">
    <h3>Créer un compte</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <!-- Username -->
        <label>Nom d’utilisateur</label>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>

        <!-- Phone -->
        <label>Numéro de téléphone</label>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
            <span class="input-group-text">
                <img src="{{ asset('togo-flag.jpg') }}" alt="TG" style="width: 20px; height: 20px; border-radius: 50%; margin-right: 5px;">
                +228
            </span>
            <input type="number" name="phone" class="form-control" placeholder="Numéro de téléphone" maxlength="8" required>
        </div>

        <!-- Password -->
        <label>Mot de passe</label>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">S'inscrire</button>
    </form>

    <div class="mt-3 text-center">
        <a href="/login">Déjà un compte ? Se connecter</a>
    </div>
</div>

</body>
</html>
