<?php
include("config.php");
include("header.php");
?>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="hero-small">PREMIUM CAR RENTAL</p>
                <h1>Rendi auto stiilselt ja mugavalt</h1>
                <p class="hero-text">
                    Vali sobiv auto, broneeri kiiresti ja naudi sõitu.
                </p>

                <a href="#cars" class="btn btn-gold btn-lg mt-3">
                    Vaata autosid
                </a>
            </div>

            <div class="col-lg-6">
                <video class="hero-video" autoplay muted loop playsinline controls>
                    <source src="video/car.mp4" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
</section>
<!-- AUTOD -->
<div class="container mt-5" id="cars">
    <div class="row row-cols-1 row-cols-md-4 g-4">

<?php
$paring = "SELECT * FROM cars";
if (!empty($_GET["otsi"])) {
    $otsing = $_GET["otsi"];
    $paring .= " WHERE mark LIKE '%".$otsing."%'";
}
$paring .= " LIMIT 8";

$valjund = mysqli_query($yhendus, $paring);
while($rida = mysqli_fetch_assoc($valjund)){
?>

    <div class="col">
        <div class="card">
            <img src="https://loremflickr.com/400/250/<?php echo str_replace(' ','', $rida["mark"]); ?>" class="card-img-top">

            <div class="card-body">
                <h5 class="card-title">
                    <?php echo $rida["mark"]; ?> <?php echo $rida["model"]; ?>
                </h5>

                <p class="card-text">
                    Mootor: <?php echo $rida["engine"]; ?><br>
                    Kütus: <?php echo $rida["fuel"]; ?><br>
                    Hind: <?php echo $rida["price"]; ?>€/päev
                </p>

                <a href="single_car.php?id=<?php echo $rida["id"]; ?>" class="btn btn-gold w-100">
                    Rendi
                </a>
            </div>
        </div>
    </div>

<?php } ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>