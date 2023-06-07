<?php
require_once __DIR__ . '/DB.php';

class Movie
{
    private $movieId;
    private $name;
    private $description;
    private $releaseDate;
    private $image;

    public function __construct($movieId = "", $name = "", $description = "", $releaseDate = "", $image = "")
    {
        $this->movieId = $movieId;
        $this->name = $name;
        $this->description = $description;
        $this->releaseDate = $releaseDate;
        $this->image = $image;
    }

    public function getMovieId()
    {
        return $this->movieId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function getImage()
    {
        return $this->image;
    }

    public static function getMoviesForPage($moviesPerPage, $offset)
    {
        $db = DB::getConnection();

        $stmt = $db->prepare('SELECT * FROM `movies` LIMIT :moviesPerPage OFFSET :offset');
        $stmt->bindParam(':moviesPerPage', $moviesPerPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $movies = [];
        foreach ($rows as $row) {
            $movies[] = new Movie($row['movieId'], $row['name'], $row['description'], $row['releaseDate'], $row['image']);
        }
        return $movies;
    }

    public function count_movies(): int
    {
        $db = DB::getConnection();
        $statement = $db->prepare(
            'SELECT COUNT(*) AS movies_count FROM `movies`'
        );

        $statement->execute();

        return (int)$statement->fetch()['movies_count'];
    }

    public function getMovieById($movieId)
    {
        $db = DB::getConnection();

        $stmt = $db->prepare("SELECT * FROM `movies` WHERE `movieId`=:movieId");
        $stmt->bindParam(':movieId', $movieId);
        $stmt->execute();
        $movieById = $stmt->fetch();
        if (!empty($movieById)) {
            $movieById = new Movie($movieById['movieId'], $movieById['name'], $movieById['description'], $movieById['releaseDate'], $movieById['image']);
            return $movieById;
        } else {
            return $movieById = [];
        }
    }

    public function addMovie($movieData)
    {
        $db = DB::getConnection();

        $uploadDirectory = dirname(__DIR__) . '/storage';
        $unique_id = date("Y-m-d H:i:s");

        $uploadFilePath = $uploadDirectory . '/' . $unique_id . $movieData['image_name'];
        move_uploaded_file($movieData['image_tmp_name'], $uploadFilePath);
        $uploadFilePathBase = 'storage/' . $unique_id . $movieData['image_name'];


        $stmt = $db->prepare("INSERT INTO movies (name, description, releaseDate, image) VALUES (:name, :description, :releaseDate, :image)");
        $stmt->bindParam(':name', $movieData['name']);
        $stmt->bindParam(':description', $movieData['description']);
        $stmt->bindParam(':releaseDate', $movieData['releaseDate']);
        $stmt->bindParam(':image', $uploadFilePathBase);
        $stmt->execute();
    }

    public function updateMovie($updateMovieData)
    {

        $db = DB::getConnection();

        $stmt = $db->prepare('UPDATE `movies` SET `name`=:name, `image` =:image, `releaseDate` =:releaseDate,`description`=:description WHERE `movieId` =:movieId');

        $stmt->bindParam(':name', $updateMovieData['name']);
        $stmt->bindParam(':image', $updateMovieData['uploadFilePathBase']);
        $stmt->bindParam(':releaseDate', $updateMovieData['releaseDate']);
        $stmt->bindParam(':description', $updateMovieData['description']);
        $stmt->bindParam(':movieId', $updateMovieData['movieId']);
        $stmt->execute();
    }

    public function deleteMovie($movieId)
    {
        $db = DB::getConnection();

        $stmt = $db->prepare("SELECT * FROM `movies` WHERE `movieId`=:movieId");
        $stmt->bindParam(':movieId', $movieId);
        $stmt->execute();
        $movieById = $stmt->fetch();
        if (file_exists('/var/www/html/'.$movieById['image'])) {
            unlink('/var/www/html/' . $movieById['image']);
        }
        $stmt = $db->prepare('DELETE FROM `movies` WHERE `movieId`=:movieId');

        $stmt->bindParam(':movieId', $movieId);
        $stmt->execute();
    }

    public function validateMovieFields($name, $image, $releaseDate)
    {
        $errors = [];

        if (strlen($name) < 3) {
            $errors['name'] = "Name is too short (minimum is 3 characters)";
        } elseif (strlen($name) > 100) {
            $errors['name'] = "Name is too long (maximum is 100 characters)";
        }

        if (!isset($image)) {
            $errors['image'] = "Image is required.";
        } elseif (strlen($image) > 300) {
            $errors['image'] = "Name of image is too long (maximum is 300 characters)";
        }

        if ($releaseDate == null) {
            $errors['releaseDate'] = "Release date is required.";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $releaseDate)) {
            $errors['releaseDate'] = 'Invalid release date format. Please use the format yyyy-mm-dd.';
        }
        return $errors;
    }
}