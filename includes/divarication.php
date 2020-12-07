<?php 
require_once ("db.php");
$auth = mysqli_fetch_assoc($admin);
$errors = false;
$page_auth = true;
$admin = false;
if (isset($_GET['auth-login']) and isset($_GET['auth-password'])) {
    if ($_GET['auth-login'] != $auth['login'] or $_GET['auth-password'] != $auth['password']) $errors = true;
}
if (isset($_FILES['file'])) {
	if (($_FILES and $_FILES['file']['error'] == UPLOAD_ERR_OK) and (	$_FILES['file']['type'] == 'image/png' or 
																		$_FILES['file']['type'] == 'image/jpg' or 
																		$_FILES['file']['type'] == 'image/jpeg'
																	)) {
        $_FILES['file']['name'] = 'favicon.png';
        move_uploaded_file($_FILES['file']['tmp_name'], 'favicon.png');
        $admin = true;
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
	} else echo '<script>
                    alert("Файл не загружен");
                </script>';
}
if (isset($_POST['name'])) {
    if (mysqli_query($connection, "UPDATE `settings` SET `name`='".$_POST['name']."'")) {
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

if (isset($_POST['color'])) {
    if (mysqli_query($connection, "UPDATE `settings` SET `navbar_color`='".$_POST['color']."'")) {
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмника</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
<?php require ('navbar.php'); ?><br><?php
    if (    (isset($_GET['auth-login']) and 
            isset($_GET['auth-password']) and 
            $_GET['auth-login'] == $auth['login'] and 
            $_GET['auth-password'] == $auth['password']) or $admin
        ) { ?>
            <div class="container">
                <div class="row">
                    <div class="col name border border-dark rounded m-2"><br>
                        <div class="title justify-content-centre">
                            <h2><?php echo $configuration['name']; ?></h2>
                        </div>
                        <div class="body">
                            <h5 >Название</h5>
                            <p>Изменить название?</p>
                            <p>Напишите новое</p>
                            <form action="#" method="POST">
                                <input type="text" name="name" value="">
                                <p></p>
                                <input class="btn btn-success" type="submit" value="Подтвердить" />
                            </form>
                            <p>Чтобы применить изменения перезагрузите страницу</p>
                        </div>
                    </div>
                    <div class="col color border border-dark rounded m-2"><br>
                        <h3>Цвет фона мненю навигации</h3>
                        
                        <div class="body">
                            <h5 >Цвет:</h5>
                            <div style="width: 100%; height: 20px; background-color: <?php echo $configuration['navbar_color']; ?>;"></div><br>
                            <p>Изменить цвет?</p>
                            <p>Выберите новый</p>
                            <form action="#" method="POST">
                                <input type="color" name="color" value="<?php echo $configuration['navbar_color']; ?>">
                                <input class="btn btn-success" type="submit" value="Подтвердить" />
                            </form>
                            <p>Чтобы применить изменения перезагрузите страницу</p>
                        </div>
                    </div>
                </div>
            </div>
        
    <?php }
    else {
        if ($errors) echo '<div class="alert alert-danger" role="alert"> Логин или пароль неверен!!! </div>';
        require_once('auth.php');
    }?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>