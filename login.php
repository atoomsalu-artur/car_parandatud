<?php
session_start();
include("config.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = strtolower(trim($_POST["email"]));
    $password = $_POST["password"];

    $stmt = mysqli_prepare($yhendus, "SELECT * FROM users WHERE LOWER(email) = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if (
        $user &&
        (
            password_verify($password, $user["password"]) ||
            $password === $user["password"]
        )
    ) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["role"] = $user["role"] ?? "user";

        if ($_SESSION["role"] === "admin") {
            header("Location: /admin/index.php");
        } else {
            header("Location: /index.php");
        }
        exit;
    } else {
        $message = "Vale e-post või parool.";
    }
}

include("header.php");
?>

<div class="container mt-5">
    <div class="auth-card mx-auto">
        <p class="hero-small">AUTORENT LOGIN</p>
        <h2 class="auth-title">Logi sisse</h2>
        <p class="auth-text">Sisene oma kontole ja broneeri premium auto.</p>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-danger">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">E-post</label>
                <input type="email" name="email" class="form-control auth-input" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Parool</label>
                <input type="password" name="password" class="form-control auth-input" required>
            </div>

            <button type="submit" class="btn btn-gold btn-lg w-100">
                Logi sisse
            </button>
        </form>

        <p class="mt-4 auth-bottom">
            Pole kontot?
            <a href="/register.php">Registreeri</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>