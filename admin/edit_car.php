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

<div class="container">
    <h2 class="mb-4">Muuda autot</h2>

    <?php if (!empty($message)) { ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php } ?>

    <form method="post">
        <input class="form-control mb-2" name="mark" value="<?php echo htmlspecialchars($car["mark"]); ?>" required>
        <input class="form-control mb-2" name="model" value="<?php echo htmlspecialchars($car["model"]); ?>" required>
        <input class="form-control mb-2" name="engine" value="<?php echo htmlspecialchars($car["engine"]); ?>" required>
        <input class="form-control mb-2" name="fuel" value="<?php echo htmlspecialchars($car["fuel"]); ?>" required>
        <input class="form-control mb-2" name="price" type="number" value="<?php echo htmlspecialchars($car["price"]); ?>" required>
        <input class="form-control mb-2" name="image" value="<?php echo htmlspecialchars($car["image"]); ?>" required>
        <input class="form-control mb-2" name="year" type="number" value="<?php echo htmlspecialchars($car["year"]); ?>" required>
        <input class="form-control mb-2" name="transmission" value="<?php echo htmlspecialchars($car["transmission"]); ?>" required>
        <input class="form-control mb-2" name="seats" type="number" value="<?php echo htmlspecialchars($car["seats"]); ?>" required>
        <input class="form-control mb-2" name="description" value="<?php echo htmlspecialchars($car["description"]); ?>" required>

        <select name="status" class="form-control mb-2">
            <option value="vaba" <?php if ($car["status"] == "vaba") echo "selected"; ?>>vaba</option>
            <option value="renditud" <?php if ($car["status"] == "renditud") echo "selected"; ?>>renditud</option>
            <option value="hoolduses" <?php if ($car["status"] == "hoolduses") echo "selected"; ?>>hoolduses</option>
        </select>

        <button class="btn btn-warning">Salvesta</button>
        <a href="cars.php" class="btn btn-secondary">Tagasi</a>
    </form>
</div>

</body>
</html>