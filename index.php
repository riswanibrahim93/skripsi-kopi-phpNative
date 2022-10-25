<?php 
  session_start();
  include 'database/koneksi.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <title>Otten Coffee</title>
  </head>
  <body>
    <div class="garis-atas">    
    </div>

    <div class="nav-bar">
      <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="container contain">
          <nav class="navbar navbar-white bg-white">
            <div class="row">
              <div class="col-sm-12">
                <ul class="nav justify-content-center">
                  <li class="nav-item">
                    <a class="nav-link me-5" href="#"><img class="logo-otten-1" src="img/logo-otten-coffee.png"></a>
                  </li>
                  <li class="nav-item item-search">
                    <div class="input-group search">
                      <span class="input-group-text search" id="basic-addon1"><img class="logo-loupe" src="img/loupe.png"></span>
                      <form action="index.php?menu=cari" method="POST">
                        <input type="text" name="cari" class="form-control search input" placeholder="Cari kopi, alat kopi..." aria-label="Username" aria-describedby="basic-addon1">
                      </form>
                    </div>
                  </li>
                </ul>
              </div>
            </div> 
            
          </nav>
        </div>
      </div>
    </div>

    <?php 
      if(isset($_GET['menu'])){
        $menu = $_GET['menu'];
        switch ($menu) {
          case ('detail');
            include('detail.php');
            break;
          case ('rekomendasi_ahp');
            include('aksi/ahp/rekomendasi.php');
            break;
          case ('rekomendasi_saw');
            include('aksi/saw/rekomendasi.php');
            break;
          case ('cari');
            include('cari.php');
            break;
        }
      }
      else{
        include 'arabika.php';
      }

    ?>

    <div class="footer mt-5">
      
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript">
      
      function rekomendasi(){
        // nilai notes flavor
        let flavor = 0;
        if(document.getElementById("flavor1").checked == true){
          flavor = 1;
        }
        else if(document.getElementById("flavor2").checked == true){
          flavor = 2;
        }
        else if(document.getElementById("flavor3").checked == true){
          flavor = 3;
        }
        else if(document.getElementById("flavor4").checked == true){
          flavor = 4;
        }
        else if(document.getElementById("flavor5").checked == true){
          flavor = 5;
        }

        // nilai notes body
        let body = 0;
        if(document.getElementById("body1").checked == true){
          body = 1;
        }
        else if(document.getElementById("body2").checked == true){
          body = 2;
        }
        else if(document.getElementById("body3").checked == true){
          body = 3;
        }
        else if(document.getElementById("body4").checked == true){
          body = 4;
        }
        else if(document.getElementById("body5").checked == true){
          body = 5;
        }

        // nilai notes sweetness
        let sweetness = 0;
        if(document.getElementById("sweetness1").checked == true){
          sweetness = 1;
        }
        else if(document.getElementById("sweetness2").checked == true){
          sweetness = 2;
        }
        else if(document.getElementById("sweetness3").checked == true){
          sweetness = 3;
        }
        else if(document.getElementById("sweetness4").checked == true){
          sweetness = 4;
        }
        else if(document.getElementById("sweetness5").checked == true){
          sweetness = 5;
        }

        // nilai notes acidity
        let acidity = 0;
        if(document.getElementById("acidity1").checked == true){
          acidity = 1;
        }
        else if(document.getElementById("acidity2").checked == true){
          acidity = 2;
        }
        else if(document.getElementById("acidity3").checked == true){
          acidity = 3;
        }
        else if(document.getElementById("acidity4").checked == true){
          acidity = 4;
        }
        else if(document.getElementById("acidity5").checked == true){
          acidity = 5;
        }

        // nilai notes after taste
        let after_taste = 0;
        if(document.getElementById("after_taste1").checked == true){
          after_taste = 1;
        }
        else if(document.getElementById("after_taste2").checked == true){
          after_taste = 2;
        }
        else if(document.getElementById("after_taste3").checked == true){
          after_taste = 3;
        }
        else if(document.getElementById("after_taste4").checked == true){
          after_taste = 4;
        }
        else if(document.getElementById("after_taste5").checked == true){
          after_taste = 5;
        }

        // menutup modal
        $('#rekomendasi .close').click();

        // redirect to halaman rekomendasi
        window.location.href = `index.php?menu=rekomendasi_ahp&notes=${flavor},${body},${sweetness},${acidity},${after_taste}`;
      }

      function detail(id){
        window.location.href = `index.php?menu=detail&key=${id}`;
      } 
    </script>
  </body>
</html>