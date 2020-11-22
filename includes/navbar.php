<nav class="navbar navbar-expand-lg navbar-light" style="background-color: <?php echo $configuration['navbar_color']; ?>;">
    <a class="navbar-brand" href="/"><img src="<?php echo $configuration['img_url']; ?>" height="40px">   <?php echo $configuration['name']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if($page_home) echo 'active'; $page_home = false;?>">
                <a class="nav-link" href="/">Главная страница <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php if($page_add) echo 'active'; $page_add = false; ?>">
                <a class="nav-link" href="../includes/add_cameras.php">Добавить камеру</a>
            </li>
            <li class="nav-item <?php if($page_auth) echo 'active'; $page_auth = false; ?>">
                <a class="nav-link" href="../includes/divarication.php" tabindex="-1" aria-disabled="true">Администрация</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="../index.php" method="get">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Искать" aria-label="Search">
            <button class="btn btn-primary my-2 my-sm-0" type="submit">Поиск</button>
        </form>
    </div>
</nav>