<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

include("../config.php");

if (isset($_GET["delete"])) {
    $id = (int)$_GET["delete"];

    $stmt = mysqli_prepare($yhendus, "DELETE FROM reservations WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("Location: reservations.php");
    exit;
}

$query = "
    SELECT 
        reservations.id,
        reservations.start_date,
        reservations.end_date,
        users.name AS user_name,
        users.email,
        cars.mark,
        cars.model
    FROM reservations
    LEFT JOIN users ON reservations.user_id = users.id
    LEFT JOIN cars ON reservations.car_id = cars.id
    ORDER BY reservations.id DESC
";

$result = mysqli_query($yhendus, $query);

include("../header.php");
?>

<div class="container mt-5">

    <div class="admin-hero mb-4">
        <p class="hero-small">ADMIN BOOKINGS</p>
        <h1>Broneeringute haldamine</h1>
        <p>Vaata ja kustuta klientide broneeringuid.</p>
    </div>

    <div class="admin-actions mb-4">
        <a href="index.php" class="btn btn-outline-light">Tagasi admin paneeli</a>
    </div>

    <div class="admin-table-box">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kasutaja</th>
                    <th>E-post</th>
                    <th>Auto</th>
                    <th>Algus</th>
                    <th>Lõpp</th>
                    <th>Tegevus</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td>#<?php echo $row["id"]; ?></td>
                        <td>
                            <strong>
                                <?php echo htmlspecialchars($row["user_name"] ?? "Puudub"); ?>
                            </strong>
                        </td>
                        <td><?php echo htmlspecialchars($row["email"] ?? "Puudub"); ?></td>
                        <td>
                            <?php echo htmlspecialchars(($row["mark"] ?? "") . " " . ($row["model"] ?? "")); ?>
                        </td>
                        <td>
                            <span class="date-badge">
                                <?php echo htmlspecialchars($row["start_date"]); ?>
                            </span>
                        </td>
                        <td>
                            <span class="date-badge">
                                <?php echo htmlspecialchars($row["end_date"]); ?>
                            </span>
                        </td>
                        <td>
                            <a href="reservations.php?delete=<?php echo $row["id"]; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Kas kustutada broneering?')">
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