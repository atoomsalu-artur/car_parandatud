<?php
session_start();

// 1. Kontrolli õigusi
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

include("../config.php");

$message = "";

// 2. Kui vorm on postitatud, sisesta andmed andmebaasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mark = trim($_POST["mark"]);
    $model = trim($_POST["model"]);
    $engine = trim($_POST["engine"]);
    $fuel = trim($_POST["fuel"]);
    $price = (int)$_POST["price"];
    $image = trim($_POST["image"]);
    $year = (int)$_POST["year"];
    $transmission = trim($_POST["transmission"]);
    $seats = (int)$_POST["seats"];
    $description = trim($_POST["description"]);
    $status = $_POST["status"];

    // Kasutame INSERT käsku uue auto loomiseks
    $stmt = mysqli_prepare($yhendus, "
        INSERT INTO cars (mark, model, engine, fuel, price, image, year, transmission, seats, description, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // "ssssisisiss" tähendab: string, string, string, string, int, string, int, string, int, string, string
    mysqli_stmt_bind_param(
        $stmt,
        "ssssisisiss",
        $mark,
        $model,
        $engine,
        $fuel,
        $price,
        $image,
        $year,
        $transmission,
        $seats,
        $description,
        $status
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: cars.php?success=added");
        exit;
    } else {
        $message = "Viga lisamisel: " . mysqli_error($yhendus);
    }
}

include("../header.php");
?>

<div class="container mt-5">

    <div class="admin-hero mb-4">
        <p class="hero-small">ADD NEW CAR</p>
        <h1>Lisa uus auto</h1>
        <p>Sisesta uue premium auto andmed süsteemi.</p>
    </div>

    <div class="admin-form-box">

        <?php if (!empty($message)) { ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php } ?>

        <form method="post">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Mark</label>
                    <input class="form-control auth-input" name="mark" placeholder="nt. BMW" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Mudel</label>
                    <input class="form-control auth-input" name="model" placeholder="nt. M5" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Mootor</label>
                    <input class="form-control auth-input" name="engine" placeholder="nt. 4.4 V8" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kütus</label>
                    <input class="form-control auth-input" name="fuel" placeholder="nt. Bensiin" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Hind €/päev</label>
                    <input class="form-control auth-input" name="price" type="number" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Aasta</label>
                    <input class="form-control auth-input" name="year" type="number" placeholder="2024" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Käigukast</label>
                    <input class="form-control auth-input" name="transmission" placeholder="nt. Automaat" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Istekohti</label>
                    <input class="form-control auth-input" name="seats" type="number" value="5" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Pildi URL</label>
                    <input class="form-control auth-input" name="image" placeholder="nt. images/auto.jpg" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Kirjeldus</label>
                    <textarea class="form-control auth-input" name="description" rows="4" required></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Staatus</label>
                    <select name="status" class="form-control auth-input">
                        <option value="vaba">vaba</option>
                        <option value="renditud">renditud</option>
                        <option value="hoolduses">hoolduses</option>
                    </select>
                </div>

            </div>

            <div class="admin-actions mt-4">
                <button type="submit" class="btn btn-gold">Lisa auto</button>
                <a href="cars.php" class="btn btn-outline-light">Tagasi</a>
            </div>
        </form>

    </div>
</div>

</body>
</html>