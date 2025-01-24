<?php
session_start(); // Start sesji

$czyzalogowany = isset($_SESSION['UzytkownikID']);

// Dane do połączenia z bazą danych
$serwer = 'localhost';
$baza_danych = 'pizza3test';
$uzytkownik = 'root';
$haslo = '';

// Połączenie z bazą danych
$baza = mysqli_connect($serwer, $uzytkownik, $haslo, $baza_danych);
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="menu.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- NAGŁÓWEK -->
    <header class="p-3 text">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <img src="https://i.imgur.com/hUa9V6E.png" alt="Logo" class="Logo" style="width: 100px; height: auto;">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="menu.php" class="nav-link px-2 text-white">MENU</a></li>
          <li><a href="#" class="nav-link px-2 text-white">KOSZYK</a></li>
          <li><a href="mojekonto.php" class="nav-link px-2 text-white">MOJE KONTO</a></li>
        </ul>

       <!-- If na sprawdzenie czy wyswietlamy guziki --> 
    <?php if (!$czyzalogowany): ?>
        <a href="login.php" class="btn btn-outline-light me-2">Login</a>
        <a href="rejestracja.php" class="btn btn-warning">Sign-up</a>
        <?php endif; ?>
    </header>



    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        

        
      <?php 

        $sql = "SELECT * FROM Pizze";
        $result = $baza->query($sql);
        var_dump($result);
        foreach($result as $p) {
          $nazwa = $p["Nazwa"];
          echo '<div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
            <div class="card-body">
              <p class="card-text">' . $nazwa . '</p>
              <div class="d-flex justify-content-between align-items-center">
              </div>
            </div>
          </div>
        </div>
        ';
        var_dump($p);
        }
      ?>
        
        
      </div>
    </div>
</body>

<div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
            <div class="card-body">
              <p class="card-text">' . $nazwa . '</p>
              <div class="d-flex justify-content-between align-items-center">

              </div>
            </div>
          </div>
        </div>



</html>