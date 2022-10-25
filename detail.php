<?php 
  // var_dump($_GET);
  // die;
  $id = $_GET['key'];

  $ketQuery = "SELECT * FROM `tabel_alternatif` WHERE `id`='$id'";
  $tabel_alternatif = mysqli_fetch_array(mysqli_query($koneksi, $ketQuery));

  // var_dump($tabel_alternatif);
  // die;

?>
<!-- content -->
<div class="content">
  <div class="container">
    <div class="halaman">
      <nav class="panah" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);;" aria-label="breadcrumb">
        <ul class="breadcrumb">
          <li class="breadcrumb-item">
            Home
          </li>
          <li class="breadcrumb-item">
            Coffee
          </li>
          <li class="breadcrumb-item">
            <a href="index.php">Roasted Bean</a>
          </li>
          <li class="breadcrumb-item active">
            <?php echo $tabel_alternatif['alternatif']; ?>
          </li>
        </ul>
      </nav>
    </div>
    <div class="main mb-2">
      <div class="row">
        <div class="col-2 col-lg-1">
          <img src="img/produk/<?php echo $tabel_alternatif['alternatif']; ?>.jpg" onclick="gantiIMG('main')" class="thumbnail img-thumbnail mb-1">
          <img src="img/produk/<?php echo $tabel_alternatif['alternatif']; ?>2.jpg" onclick="gantiIMG('second')"class="thumbnail img-thumbnail mb-1">
        </div>
        <div class="col-10 col-lg-5">
          <img src="img/produk/<?php echo $tabel_alternatif['alternatif']; ?>.jpg" class="img-main rounded mx-auto d-block">
        </div>
        <div class="col-12 col-lg-6">
          <div class="title text-center">
            <h2><?php echo $tabel_alternatif['alternatif']; ?> 200g Kopi Arabica</h2>
            <h3 class="card-text text-center font-rp mt-4">Rp 
              <?php 
                $harga = $tabel_alternatif['harga'];
                $harga1 = substr($harga,0,strlen($harga)-3);
                $harga2 = substr($harga,strlen($harga)-3);
                echo $harga1.".".$harga2; 
              ?>
            </h3>
          </div>
          <hr>
          <h5>Ukuran Gilingan : <span class="font-second" id="gilingan">Pilih Ukuran Gilingan</span></h5>
          <button type="button" onclick="gilingan('Wholebean')" class="btn filter mb-3 me-2 ps-4 pe-4">Wholebean</button>
          <button type="button" onclick="gilingan('Fine')" class="btn filter mb-3 me-2 ps-4 pe-4">Fine</button>
          <button type="button" onclick="gilingan('Medium')" class="btn filter mb-3 me-2 ps-4 pe-4">Medium</button>
          <button type="button" onclick="gilingan('Medium Coarse')" class="btn filter mb-3 me-2 ps-4 pe-4">Medium Coarse</button>
          <button type="button" onclick="gilingan('Super Fine')" class="btn filter mb-3 me-2 ps-4 pe-4">Super Fine</button>
          <button type="button" onclick="gilingan('Medium Fine')" class="btn filter mb-3 me-2 ps-4 pe-4">Medium Fine</button>
          <button type="button" onclick="gilingan('Coarse')" class="btn filter mb-3 me-2 ps-4 pe-4">Coarse</button>
          <hr>
          <div class="row text-center">
            <div class="col-12 col-lg-4 inline">
              <div class="input-group mb-3 ms-4">
                <button class="btn btn-outline-success" type="button" onclick="keranjang('-')" id="button-addon1">-</button>
                <input class="text-center border border-success" type="text" id="jml" style="width: 10%" value="1">
                <button class="btn btn-outline-success" type="button" onclick="keranjang('+')" id="button-addon1">+</button>
              </div>
            </div>
            <div class="col-12 col-lg-8 mt-1">
              <a href="" class="btn button-keranjang center"><span><i class="fal fa-plus plus"></i>Tambahkan ke Keranjang</a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="info mb-2 mt-4">
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav nav-info">
              <li class="nav-item">
                <button type="button" id="info" onclick="collapse('info')" class="btn-collaps active me-2 ps-4 pe-4">Informasi Produk</button>
              </li>
              <li class="nav-item">
                <button type="button" id="desk" onclick="collapse('desk')" class="btn-collaps me-2 ps-4 pe-4">Deskripsi</button>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="img-desk">
        <img id="img-desk" src="img/info/<?php echo $tabel_alternatif['alternatif']; ?>.jpg">
      </div>
    </div>
    <hr>
    <div class="notes mb-2">
      <h3>Cupping Notes</h3>
      <div class="img-desk">
        <img id="img-notes" src="img/notes/<?php echo $tabel_alternatif['alternatif']; ?>.jpg">
      </div>
    </div>
  </div>
</div>
<!-- content -->


<script type="text/javascript">
  function gantiIMG(gambar){
    if(gambar == 'main'){
      $(".img-main").attr("src","img/produk/<?php echo $tabel_alternatif['alternatif']; ?>.jpg");
    }
    else if(gambar == 'second'){
      $(".img-main").attr("src","img/produk/<?php echo $tabel_alternatif['alternatif']; ?>2.jpg");
    }
  }
  function keranjang(operand){
    let jml = parseInt($('#jml').val());
    if(operand == '-'){
      if(jml > 1){
        jml -= 1;
        $('#jml').val(jml);
      }
    }
    else if(operand == '+'){
      jml += 1;
        $('#jml').val(jml);
    }
  }
  function collapse(kata){
    if(kata == 'info'){
      $('#info').addClass('active');
      $('#desk').removeClass('active');
      $("#img-desk").attr("src","img/info/Aceh Gayo Anaerob Natural.jpg");
    }
    else if(kata == 'desk'){
      $('#desk').addClass('active');
      $('#info').removeClass('active');
      $("#img-desk").attr("src","img/desk/Aceh Gayo Anaerob Natural.jpg");
    }
  }
  function gilingan(type){
    if(type == "Wholebean"){
      $('#gilingan').html("Wholebean");
    }
    else if(type == "Fine"){
      $('#gilingan').html("Fine");
    }
    else if(type == "Medium"){
      $('#gilingan').html("Medium");
    }
    else if(type == "Medium Coarse"){
      $('#gilingan').html("Medium Coarse");
    }
    else if(type == "Super Fine"){
      $('#gilingan').html("Super Fine");
    }
    else if(type == "Medium Fine"){
      $('#gilingan').html("Medium Fine");
    }
    else if(type == "Coarse"){
      $('#gilingan').html("Coarse");
    }
  }
</script>
