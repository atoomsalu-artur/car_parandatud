<?php
include("config.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (!empty($name) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($yhendus, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

        try {
            if (mysqli_stmt_execute($stmt)) {
                $message = "Registreerimine õnnestus!";
            }
        } catch (mysqli_sql_exception $e) {
            $message = "Selline e-post on juba kasutusel.";
        }
    } else {
        $message = "Palun täida kõik väljad.";
    }
}

include("header.php");
?>

<div class="container mt-5">
    <div class="auth-card mx-auto">
        <p class="hero-small">CREATE ACCOUNT</p>
        <h2 class="auth-title">Registreeri</h2>
        <p class="auth-text">Loo konto ja broneeri premium auto kiirelt.</p>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-info">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nimi</label>
                <input type="text" name="name" class="form-control auth-input" required>
            </div>

            <div class="mb-3">
                <label class="form-label">E-post</label>
                <input type="email" name="email" class="form-control auth-input" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Parool</label>
                <input type="password" name="password" class="form-control auth-input" required>
            </div>

            <button type="submit" class="btn btn-gold btn-lg w-100">
                Registreeri
            </button>
        </form>

        <p class="mt-4 auth-bottom">
            Konto olemas?
            <a href="login.php">Logi sisse</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>