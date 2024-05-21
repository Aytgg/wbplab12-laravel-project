<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener - WBP Lab12</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        @php
            define("DBHOST", 'localhost');
            define("DBUSER", 'root');
            define("DBPW", '');
            define("DBNAME", 'urlshortener');

            $conn = null;
            $shortened = null;

            try {
                $conn = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPW);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "DB Connection failed: " . $e->getMessage();
            }

            $res = $conn->query("SELECT * FROM urls WHERE old='". $_POST['url'] ."';")->fetch(PDO::FETCH_ASSOC);

            if($res)
                $shortened = $res['new'];
            else {
                $shortened = bin2hex(random_bytes($length = 16));

                $conn->query("INSERT INTO urls (`old`, `new`) VALUES ('". $_POST['url'] ."', '". $shortened ."');");
            }

            echo "Eski link: ". $_POST['url'];
            echo "<br>";
            echo "Yeni link: ". "localhost:8000/" . $shortened;
        @endphp
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>




