<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autorent</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <!-- Style -->
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg mb-4">
    <div class="container">
        <a class="navbar-brand" href="/index.php">AUTORENT</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/register.php">Registreeri</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/login.php">Logi sisse</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/logout.php">Logi välja</a>
                </li>

            </ul>

            <form class="d-flex" role="search" method="get" action="/index.php">
                <input class="form-control me-2" type="search" placeholder="Search" name="otsi">
                <button class="btn btn-gold" type="submit">Otsi</button>
            </form>
        </div>
    </div>
</nav>