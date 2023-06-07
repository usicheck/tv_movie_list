<?php
session_start();

require_once __DIR__ . '/classes/Movie.php';
require_once __DIR__ . '/classes/DB.php';

if ('GET' !== $_SERVER['REQUEST_METHOD']) {
    exit('Method is Not Allowed.');
}

$movieId = (int)$_GET['movieId'];

$movie = new Movie();
$movieById = $movie->getMovieById($movieId);

if (empty($movieById)) {
    echo 'Фільму з таким id нема.';
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie view</title>
    <link rel="stylesheet" href="css/movie-show.css">
</head>

<body>
<header>
    <nav>
        <div>
            <a href='index.php'
               class='edit-button'>Back to list</a>
        </div>
        <div>
            <a href='/edit-movie-form.php?movieId= <?php echo $movieId ?>'
               class="edit-button">Edit</a>
        </div>
        <div>
            <a href='controllers/delete-movie-controller.php?movieId= <?php echo $movieId ?>'
               class='delete-button'>Delete</a>
        </div>
    </nav>
</header>

<main>
    <div class="container">
        <div>
            <h2><?php echo $movieById->getName(); ?></h2>
            <p><strong><?php echo 'ID фільму: ' ?> </strong> <?php echo $movieById->getMovieId(); ?>
            </p>
            <img src="<?php echo $movieById->getImage(); ?>" class="movie-poster" alt="...">
            <h3><strong> <?php echo 'Дата релізу: '; ?> </strong>
                <?php echo $movieById->getReleaseDate(); ?> </h3>
            <p><strong><?php echo 'Опис фільму: '; ?> </strong> <?php echo $movieById->getDescription(); ?>
            </p>
        </div>
    </div>

</main>

</body>
</html>
