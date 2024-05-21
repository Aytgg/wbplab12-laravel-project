<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return view('index');
});

Route::post('/link', function () {
    return view('index2');
});

Route::get('/{shortLink}', function ($shortLink) {

    define("DBHOST", 'localhost');
    define("DBUSER", 'root');
    define("DBPW", '');
    define("DBNAME", 'urlshortener');

    $conn = null;
    $normalLink = null;

    try {
        $conn = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPW);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $res = $conn->query("SELECT * FROM urls WHERE new='". $shortLink ."';")->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "DB Connection failed: " . $e->getMessage();
    }


    if($res) {
        echo "Kısaltılmış link http://www.domain.com/ şeklinde olmadığından sayfaya yönlendirilme yapılamadı!";
        header('Location: '. $res['old']);
        die();
    }
    else
        echo "Sayfa bulunamadı!";
        echo "<br>";
        echo "<a href='" . $shortLink . "'>". $shortLink ."</a>";
});