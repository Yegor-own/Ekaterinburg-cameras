<?php
require_once "db.php"; 
$add = mysqli_fetch_assoc($cameras);
$errors = false;
$success = false;
$page_add = true;
if (isset($_POST['location1']) and isset($_POST['adres']) and isset($_POST['location2']) and isset($_POST['quantity']) and isset($_POST['ownr'])) {
    if ($_POST['location1'] != $add['location'] and $_POST['location2'] != $add['location2'] and $_POST['location1'] != '' and $_POST['location2'] != '') {
        if(mysqli_query($connection, "INSERT INTO `cameras` (`addres`, `location`, `location2`, `descr`, `owner`) VALUES ('".$_POST['adres']."','".$_POST['location1']."', '".$_POST['location2']."', '".$_POST['quantity']."', '".$_POST['ownr']."')")) {
            $success = true;
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }
    } else $errors = true;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить камеру</title>
    <script src="//code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>    
    <script src="//maps.google.com/maps/api/js?sensor=false"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<!-- TODO сверстать форму для добавления юзером новых камер -->

<body>
<?php require_once('navbar.php'); ?>    
<div class="container add border-secondary"><br><br>
    <?php
    if ($success) {
        echo '<p class="alert alert-success">Камера добавлена!!!</p>';
        $errors = false;
        $success = false;
    }
                
    elseif ($errors) {
        echo '<p class="alert alert-danger">Камера не добавлена!!!</p>';
        $errors = false;
        $success = false;
    }?>
    <form action="add_cameras.php" method="post">
        <div class="title">
            <h1>Добавить камеру</h1>
            <h5>Просто заполните форму</h5>
        </div><br>
        <div id="map" style="height: 600px;
                            cursor: pointer;"></div><br>
        <div class="form-group">
            <input type="text" name="adres" class="form-control" value="" placeholder="Автозаполнение">
            <p class="title">Количество камер</p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="quantity" id="Radios1" value="1" checked>
                <label class="form-check-label" for="Radios1">
                    1
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="quantity" id="Radios2" value="2">
                <label class="form-check-label" for="Radios2">
                    2
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="quantity" id="Radios3" value="3">
                <label class="form-check-label" for="Radios3">
                    3
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="owner">Владелец <span class="dadge badge-pill badge-warning">(необязательно)</span></label>
            <input name="ownr" type="text" class="form-control" id="owner" placeholder="Владелец">
        </div>
        <input type="hidden" name="location1" value="">
        <input type="hidden" name="location2" value="">
        <script type="text/javascript">
            let map = L.map('map').setView([56.8519000, 60.6122000], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
            let marker;
            map.on('click', function(e) {
                console.clear();
                if(marker) map.removeLayer(marker);
                position = e.latlng;
                let loc1 = e.latlng.lat;
                let loc2 = e.latlng.lng;
                marker = L.marker(e.latlng).addTo(map);
                $("input[name=location1]").val(loc1);
                $("input[name=location2]").val(loc2);
                let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address";
                let token = "9c9a6d48fabaaa617279d5fdb10ea468caf66c41";
                let query = { lat: loc1, lon: loc2, radius_meters: 80 };

                let options = {
                    method: "POST",
                    mode: "cors",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + token
                    },
                    body: JSON.stringify(query)
                }
                let adr;
                let ad = '';
                function adres (address) {
                    adr = address;
                    console.log(typeof adr);
                    let length = adr.length;
                    console.log(length);
                    let i = 0;
                    let write;
                    while (i != length) {
                        i++;
                        if (adr[i] == 'г') {
                            write = true;
                        }
                        if (write) {
                            if (adr[i] != '"') {
                                ad += adr[i];
                            }
                            else {break;}
                        }
                    }
                    $("input[name=adres]").val(ad);
                }
                fetch(url, options)
                .then(response => response.text())
                .then(result => adres(result))
                .catch(error => console.log("error", error));
            });
            // function setAdress(pos) { //TODO затесть
            //     $.get("http://maps.googleapis.com/maps/api/geocode/json?latlng=" + pos, function(data) {
            //     if(data.status == 'OK')
            //         let adres = data.results[1].formatted_address;
            //         $("input[name=adres]").val(adres);
            //     });
            // }
            // setAdress(position);
        </script>
        <button type="submit" class="btn btn-success">Подтвердить</button>
    </form><br><br>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>