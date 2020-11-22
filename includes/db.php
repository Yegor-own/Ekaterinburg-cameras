<?php


$connection = mysqli_connect('localhost','id15081011_admin','ryGRIgrJh(AA_[3q','id15081011_ekb_cameras');

if(mysqli_connect_errno()){
    echo 'Connection invalid!!!</br>';
    echo mysqli_connect_error();
    exit();
}
$admin = mysqli_query($connection, "SELECT * FROM `admin`");
$cameras = mysqli_query($connection, "SELECT * FROM `cameras`");
$settings = mysqli_query($connection, "SELECT * FROM `settings`");
$conf = mysqli_fetch_assoc($settings);
$configuration = array(
    'name' => $conf['name'],
    'img_url' => $conf['img_url'],
    'navbar_color' => $conf['navbar_color'],
    'icon_url' => $conf['icon_url']
); //ffa60c