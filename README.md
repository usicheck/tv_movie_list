1) Для запуску проєкту, команди:
- docker-compose up -d --build

2) В "classes/DB.php" в $dns потрібно підставити свої значення для налаштування бази даних.

3) Для створення бази даних, таблиці і початкових записів, потрібно запустити через консоль "migrations/movie.sql"

4) Вся інформація по портах в docker-compose.yml