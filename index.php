<?php
session_start();

require_once __DIR__ . '/classes/Movie.php';
require_once __DIR__ . '/classes/DB.php';

$page = (int)($_GET['page'] ?? 1);
$moviesPerPage = 8;

$offset = 1 === $page ? 0 : ($page * $moviesPerPage) - $moviesPerPage;
$movieClass = new Movie();
$moviesCount = $movieClass->count_movies();
$maxPage = ceil($moviesCount / $moviesPerPage);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Homepage</title>

    <link href="css/movies.css" rel="stylesheet">
</head>
<body>
<header>
    <nav>
        <div>
            <a href='/add-movie-form.php' class="create-button">Create</a>
        </div>
    </nav>
</header>

<main>
    <div>
        <div class="movie-container">
            <?php
            $movies = Movie::getMoviesForPage($moviesPerPage, $offset);
            foreach ($movies as $movie):
                ?>
                <div class="movie-container">
                    <div class="movie">
                        <img src="<?php echo $movie->getImage(); ?>" alt="...">
                        <div>
                            <h5 class="movie-name">
                                <?php echo $movie->getName(); ?>
                            </h5>
                            <p class="release-date">
                                <?php echo $movie->getReleaseDate() . " — дата релізу"; ?>
                            </p>
                            <div>
                                <a href="movie.php?movieId=<?php echo $movie->getMovieId(); ?>"
                                   class="view-button">View</a>
                            </div>
                            <div>
                                <a href='/edit-movie-form.php?movieId= <?php echo $movie->getMovieId() ?>'
                                   class="edit-button">Edit</a>
                            </div>
                            <div>
                                <a href='controllers/delete-movie-controller.php?movieId= <?php echo $movie->getMovieId() ?>'
                                   class='delete-button'>Delete</a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>
</main>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $maxPage; ++$i): ?>
                        <li>
                            <a class="page-link" href="?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
</body>
</html>
