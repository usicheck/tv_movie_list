<?php
session_start();

$movieId = (int)$_GET['movieId'];
require_once __DIR__ . '/classes/Movie.php';
$movie = new Movie();
$movieForEdit = $movie->getMovieById($movieId);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Movie</title>
    <link rel="stylesheet" href="css/movie-form.css">
</head>
<body>
<header>
    <nav>
        <div>
            <a href='/movie.php?movieId= <?php echo $movieId ?>'
               class="edit-button">Back to movie</a>
        </div>
    </nav>
</header>
<div>
    <div>
        <div>
            <form action="controllers/edit-movie-controller.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="name">
                        Name of movie
                    </label>
                    <input type="text" name="name" id="name" class="fields" maxlength="100"
                           value="<?php echo $movieForEdit->getName(); ?>">
                    <br>
                    <?php if (isset($_SESSION['errors']['name'])) { ?>
                        <span style="color: red;"><?php echo $_SESSION['errors']['name']; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <label for="newImage">
                        Movie Poster
                    </label>
                    <input type="file" name="newImage" id="newImage" class="fields" maxlength="300">
                    <br>
                    <?php if (isset($_SESSION['errors']['image'])) { ?>
                        <span style="color: red;"><?php echo $_SESSION['errors']['image']; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <input type="hidden" name="oldImage" value="<?php echo $movieForEdit->getImage() ?>">
                    <input type="hidden" name="movieId" value="<?php echo $movieForEdit->getMovieId() ?>">
                </div>
                <div>
                    <label for="description">
                        Movie Description
                    </label>
                    <textarea class="fields" name="description" id="description" rows="5" cols="50"
                    ><?php echo $movieForEdit->getDescription(); ?></textarea>
                </div>

                <div>
                    <label for="releaseDate">
                        Release Date
                    </label>
                    <input type="date" name="releaseDate" id="releaseDate" class="fields"
                           value="<?php echo $movieForEdit->getReleaseDate(); ?>" required>
                    <br>
                    <?php if (isset($_SESSION['errors']['releaseDate'])) { ?>
                        <span style="color: red;"><?php echo $_SESSION['errors']['releaseDate']; ?></span>
                    <?php }
                    $_SESSION['errors'] = []; ?>
                </div>
                <button type="submit" id="submit">
                    Edit Movie
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>