<?php
session_start();

require_once __DIR__ . '/classes/Movie.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Movie</title>
    <link href="css/movie-form.css" rel="stylesheet">
</head>

<body>
<header>
    <nav>
        <div>
            <a href='index.php'
               class='edit-button'>Back to list</a>
        </div>
    </nav>
</header>
<div>
    <div>
        <div>
            <form action="controllers/add-movie-controller.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="name">
                        Name of movie
                    </label>
                    <input type="text" class="fields" name="name" id="name" maxlength="100">
                    <br>
                    <?php if (isset($_SESSION['errors']['name'])) { ?>
                        <span style="color: red;"><?php echo $_SESSION['errors']['name']; ?></span>
                    <?php } ?>
                </div>

                <div>
                    <label for="image">
                        Movie Poster
                    </label>
                    <input type="file" class="fields" name="image" id="image" maxlength="300" required>
                    <br>
                    <?php if (isset($_SESSION['errors']['image'])) { ?>
                        <span style="color: red;"><?php echo $_SESSION['errors']['image']; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <label for="description">
                        Movie Description:
                    </label>
                    <textarea class="fields" name="description" id="description"></textarea>
                </div>
                <div>
                    <label for="releaseDate">
                        Release Date
                    </label>
                    <input type="date" class="fields" name="releaseDate" id="releaseDate" placeholder="YYYY-MM-DD" required>
                    <br>
                    <?php if (isset($_SESSION['errors']['releaseDate'])) { ?>
                        <span style="color: red;"><?php echo $_SESSION['errors']['releaseDate']; ?></span>
                    <?php }
                    $_SESSION['errors'] = []; ?>
                </div>
                <button type="submit" id="submit">
                    Add Movie
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
