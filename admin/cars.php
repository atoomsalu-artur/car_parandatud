<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

include("../config.php");

if (isset($_GET["delete"])) {
    $id = (int)$_GET["delete"];

    $stmt = mysqli_prepare($yhendus, "DELETE FROM cars WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("Location: cars.php");
    exit;
}

$result = mysqli_query($yhendus, "SELECT * FROM cars ORDER BY id DESC");

include("../header.php");
?>

<div class="container mt-5">

    <div class="admin-hero mb-4">
        <p class="hero-small">ADMIN CARS</p>
        <h1>Autode haldamine</h1>
        <p>Lisa, muuda ja kustuta rendiautosid.</p>
    </div>

    <div class="admin-actions mb-4">
        <a href="add_car.php" class="btn btn-gold">+ Lisa auto</a>
        <a href="index.php" class="btn btn-outline-light">Tagasi admin paneeli</a>
    </div>

    <div class="admin-table-box">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mark</th>
                    <th>Mootor</th>
                    <th>Kütus</th>
                    <th>Hind</th>
                    <th>Tegevused</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($car = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td>#<?php echo $car["id"]; ?></td>
                        <td>
                            <strong>
                                <?php echo htmlspecialchars($car["mark"]); ?>
                                <?php echo htmlspecialchars($car["model"] ?? ""); ?>
                            </strong>
                        </td>
                        <td><?php echo htmlspecialchars($car["engine"]); ?></td>
                        <td><?php echo htmlspecialchars($car["fuel"]); ?></td>
                        <td>
                            <span class="price-badge">
                                <?php echo htmlspecialchars($car["price"]); ?> €/päev
                            </span>
                        </td>
                        <td>
                            <a href="edit_car.php?id=<?php echo $car["id"]; ?>" class="btn btn-sm btn-warning">
                                Muuda
                            </a>

                            <a href="cars.php?delete=<?php echo $car["id"]; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Kas oled kindel?')">
                                Kustuta
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>