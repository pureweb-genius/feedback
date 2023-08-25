<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<!-- As a link -->
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">

        <a class="navbar-brand" href="http://localhost/feedback">Отзывы</a>


            <?php if ($_SESSION['admin'] ?? false): ?>
                <div class="d-flex">
                    <div class="me-3">Привет, Админ
                    <a href="logout" class="btn btn-primary">Выйти</a>
                    </div>
                </div>
            <?php endif; ?>
    </div>


</nav>

	<?php echo $content; ?>
</body>
</html>