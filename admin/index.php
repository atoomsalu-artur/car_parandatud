<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

include("../config.php");

$cars_count = mysqli_fetch_assoc(mysqli_query($yhendus, "SELECT COUNT(*) AS total FROM cars"))["total"];
$reservations_count = mysqli_fetch_assoc(mysqli_query($yhendus, "SELECT COUNT(*) AS total FROM reservations"))["total"];
$users_count = mysqli_fetch_assoc(mysqli_query($yhendus, "SELECT COUNT(*) AS total FROM users"))["total"];
$free_cars_count = mysqli_fetch_assoc(mysqli_query($yhendus, "SELECT COUNT(*) AS total FROM cars WHERE status='vaba'"))["total"];

include("../header.php");
?>

<div class="container mt-5">
    <div class="admin-hero">
        <p class="hero-small">ADMIN DASHBOARD</p>
        <h1>Admin paneel</h1>
        <p>Statistika, autod ja broneeringud ühest kohast.</p>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-md-3">
            <div class="stat-card">
                <span>🚗</span>
                <h2><?php echo $cars_count; ?></h2>
                <p>Autod kokku</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <span>📅</span>
                <h2><?php echo $reservations_count; ?></h2>
                <p>Broneeringud</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <span>👤</span>
                <h2><?php echo $users_count; ?></h2>
                <p>Kasutajad</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <span>✅</span>
                <h2><?php echo $free_cars_count; ?></h2>
                <p>Vabad autod</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-md-4">
            <a href="cars.php" class="admin-card">
                <div class="admin-icon">🚗</div>
                <h3>Halda autosid</h3>
                <p>Lisa, muuda ja kustuta autosid.</p>
            </a>
        </div>

        <div class="col-md-4">
            <a href="reservations.php" class="admin-card">
                <div class="admin-icon">📅</div>
                <h3>Halda broneeringuid</h3>
                <p>Vaata ja kontrolli broneeringuid.</p>
            </a>
        </div>

        <div class="col-md-4">
            <a href="../index.php" class="admin-card">
                <div class="admin-icon">🏠</div>
                <h3>Avaleht</h3>
                <p>Mine tagasi avalehele.</p>
            </a>
        </div>
    </div>
</div>

</body>
</html>