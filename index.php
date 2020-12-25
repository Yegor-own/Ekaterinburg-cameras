<?php
require_once "includes/db.php";
$page_home = true;
$c = false;
if (isset($_GET['search']) and !empty($_GET['search'])) {
    while ($cam = mysqli_fetch_assoc($cameras)) {
        if ($cam['addres'] == $_GET['search']) {
            $c = true;
            $adres = $cam['addres'];
            $desc = $cam['descr'];
            $loc = $cam['location'];
            $loc2 = $cam['location2'];
        }
    }
}
$num_rows = mysqli_num_rows($cameras);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>TFind</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <style>
        html, body{
            height: 97%;
        }

        .container-fluid, .row, #map {
            height: 98%;
        }
    </style>
</head>

<body>
    <?php require('includes/navbar.php'); ?>
    <div class="container-fluid col-12">
        <br>
        <div class="row col-12">
            <div class="map col-12" id="map">
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <script>
        let map = L.map('map').setView([56.8519000, 60.6122000], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let counter = '<?php echo $num_rows; ?>';
        let i = 0;
    </script>
    <?php
    if ($c) { ?>
        <script>
            let loc = '<?php echo $loc; ?>'
            let loc2 = '<?php echo $loc2; ?>'
            let adres = '<?php echo $adres; ?>'
            let descr = '<?php echo $desc; ?>'
            L.marker([loc, loc2]).addTo(map)
                .bindPopup(adres + "<br><br>" + descr)
                .openPopup();
        </script>
    <?php } else {
        unset($cam);
        ?>
        <script>
        let loc
        let loc2
        let adres
        let descr
        let markers = new L.MarkerClusterGroup()
        </script>
        <?php
        while ($cam = mysqli_fetch_assoc($cameras)) {
            ?>
            <script>
            if (i != counter){
                i++
                loc = '<?php echo $cam['location']; ?>'
                loc2 = '<?php echo $cam['location2']; ?>'
                adres = '<?php echo $cam['addres']; ?>'
                descr = '<?php echo $cam['descr']; ?>'
                markers.addLayer(
                    L.marker([loc, loc2])
                        // .bindPopup(adres + "<br><br>" + descr)
                        // .openPopup()
                )
            }
            </script>
        <?php } ?>
        <script>
        map.addLayer(markers)
        </script>
    <?php
    }?>
</body>

</html>