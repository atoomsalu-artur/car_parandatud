<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

include("../config.php");

$id = (int)$_GET["id"];

$stmt = mysqli_prepare($yhendus, "SELECT * FROM cars WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$car = mysqli_fetch_assoc($result);

if (!$car) {
    die("Auto ei leitud");
}

$message = "";

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

    $update = mysqli_prepare($yhendus, "
        UPDATE cars
        SET mark=?, model=?, engine=?, fuel=?, price=?, image=?, year=?, transmission=?, seats=?, description=?, status=?
        WHERE id=?
    ");

    mysqli_stmt_bind_param(
        $update,
        "ssssisisissi",
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
        $status,
        $id
    );

    if (mysqli_stmt_execute($update)) {
        header("Location: cars.php");
        exit;
    } else {
        $message = "Viga muutmisel.";
    }
}

include("../header.php");
?>

<div class="container mt-5">

    <div class="admin-hero mb-4">
        <p class="hero-small">EDIT CAR</p>
        <h1>Muuda autot</h1>
        <p>Uuenda auto andmeid ja staatust.</p>
    </div>

    <div class="admin-form-box">

        <?php if (!empty($message)) { ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php } ?>

        <form method="post">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Mark</label>
                    <input class="form-control auth-input" name="mark" value="<?php echo htmlspecialchars($car["mark"]); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Model</label>
                    <input class="form-control auth-input" name="model" value="<?php echo htmlspecialchars($car["model"]); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Mootor</label>
                    <input class="form-control auth-input" name="engine" value="<?php echo htmlspecialchars($car["engine"]); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kütus</label>
                    <input class="form-control auth-input" name="fuel" value="<?php echo htmlspecialchars($car["fuel"]); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Hind €/päev</label>
                    <input class="form-control auth-input" name="price" type="number" value="<?php echo htmlspecialchars($car["price"]); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Aasta</label>
                    <input class="form-control auth-input" name="year" type="number" value="<?php echo htmlspecialchars($car["year"]); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Käigukast</label>
                    <input class="form-control auth-input" name="transmission" value="<?php echo htmlspecialchars($car["transmission"]); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Istekohti</label>
                    <input class="form-control auth-input" name="seats" type="number" value="<?php echo htmlspecialchars($car["seats"]); ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Pildi URL</label>
                    <input class="form-control auth-input" name="image" value="<?php echo htmlspecialchars($car["image"]); ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Kirjeldus</label>
                    <textarea class="form-control auth-input" name="description" rows="4" required><?php echo htmlspecialchars($car["description"]); ?></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Staatus</label>
                    <select name="status" class="form-control auth-input">
                        <option value="vaba" <?php if ($car["status"] == "vaba") echo "selected"; ?>>vaba</option>
                        <option value="renditud" <?php if ($car["status"] == "renditud") echo "selected"; ?>>renditud</option>
                        <option value="hoolduses" <?php if ($car["status"] == "hoolduses") echo "selected"; ?>>hoolduses</option>
                    </select>
                </div>

            </div>

            <div class="admin-actions mt-4">
                <button class="btn btn-gold">Salvesta</button>
                <a href="cars.php" class="btn btn-outline-light">Tagasi</a>
            </div>
        </form>

    </div>
</div>

</body>
</html>