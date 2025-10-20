<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Jadoo | Travel Agency Landing Page UI</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="assets/css/theme.css" rel="stylesheet" />

  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <?php define ('aktif', TRUE);?>      <?php include("menu.php");?>
      <?php include("travel.php");?>

      <!-- section begin -->
      <?php include("category.php");?>
      <!-- section close -->
      <!-- ============================================-->

      <!-- <section> begin ============================-->
      <?php include("topdestination.php");?>
      <!-- <section> close ============================-->
      <!-- ============================================-->


      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <?php include("booking.php");?>
      <!-- <section> close ============================-->
      <!-- ============================================-->




      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <?php include("testimoni.php");?>
      <!-- <section> close ============================-->
      <!-- ============================================-->
      <br> <br> <br> <br>

      <h1 style="text-align: center; font-size: 50px; color: #ff5733;">OUTPUT UAS</h1>

      <br> <br>
      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <?php include("no3UAS.php");?>
      <!-- <section> close ============================-->
      <!-- ============================================-->
      <br><br>
      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <?php include("no2UAS.php");?>
      <!-- <section> close ============================-->
      <!-- ============================================-->
      <br><br>
      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <?php include("no1UAS.php");?>
      <!-- <section> close ============================-->
      <!-- ============================================-->

      <div class="py-5 text-center">
        <p class="mb-0 text-secondary fs--1 fw-medium">All rights reserved@jadoo.co </p>
      </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->




    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="vendors/@popperjs/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="assets/js/theme.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Volkhov:wght@700&amp;display=swap" rel="stylesheet">
  </body>

</html>