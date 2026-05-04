<?php
session_start();
include("config.php");
include("header.php");

if (!isset($_GET["id"])) {
    die("Auto puudub");
}

$id = $_GET["id"];

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

    if (!isset($_SESSION["user_id"])) {
        $message = "Palun logi sisse!";
    } else {
        $start = $_POST["start_date"];
        $end = $_POST["end_date"];
        $user_id = $_SESSION["user_id"];

        $check = mysqli_prepare($yhendus, "
            SELECT COUNT(*) as total 
            FROM reservations 
            WHERE car_id = ? 
            AND start_date <= ? 
            AND end_date >= ?
        ");
        mysqli_stmt_bind_param($check, "iss", $id, $end, $start);
        mysqli_stmt_execute($check);
        $res = mysqli_stmt_get_result($check);
        $row = mysqli_fetch_assoc($res);

        if ($row["total"] > 0) {
            $message = "See auto on juba selleks ajaks broneeritud!";
        } else {
            $insert = mysqli_prepare($yhendus, "
                INSERT INTO reservations (user_id, car_id, start_date, end_date)
                VALUES (?, ?, ?, ?)
            ");
            mysqli_stmt_bind_param($insert, "iiss", $user_id, $id, $start, $end);

            if (mysqli_stmt_execute($insert)) {
                $message = "Broneering tehtud!";
            } else {
                $message = "Viga!";
            }
        }
    }
}
?>

<div class="container mt-5">
    <div class="luxury-detail">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <img src="https://loremflickr.com/800/500/<?php echo str_replace(' ','', $car["mark"]); ?>"
                     class="detail-car-img"
                     alt="<?php echo $car["mark"]; ?>">
            </div>

            <div class="col-lg-6">
                <p class="hero-small">PREMIUM RENTAL</p>

                <h1 class="detail-title">
                    <?php echo $car["mark"]; ?> <?php echo $car["model"]; ?>
                </h1>

                <div class="detail-info">
                    <p><strong>Mootor:</strong> <?php echo $car["engine"]; ?></p>
                    <p><strong>Kütus:</strong> <?php echo $car["fuel"]; ?></p>
                    <p><strong>Hind:</strong> <?php echo $car["price"]; ?> €/päev</p>
                </div>

                <?php if (!empty($message)) { ?>
                    <div class="alert alert-info mt-3">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>

                <form method="post" class="booking-form mt-4">
                    <div class="mb-3">
                        <label class="form-label">Alguskuupäev</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lõppkuupäev</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100">
                        Broneeri kohe
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>