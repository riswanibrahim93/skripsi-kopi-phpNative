<!-- content -->
<div class="content">
  <div class="container">
    <div class="halaman">
      <!-- start navbar -->
      <nav class="panah" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);;" aria-label="breadcrumb">
        <ul class="breadcrumb">
          <li class="breadcrumb-item">
            Home
          </li>
          <li class="breadcrumb-item">
            Coffee
          </li>
          <li class="breadcrumb-item active">
            Roasted Bean
          </li>
        </ul>
      </nav>
      <!-- end navbar -->
    </div>
    <div class="judul">
      <h4>Kopi Pilihan Terbaik Untukmu</h4>
    </div>
    <div class="filter mt-3">
      <button type="button" class="btn filter" data-toggle="modal" data-target="#rekomendasi">Rekomendasi</button>
    </div>
    <!-- start card produk -->
    <div class="produk mt-4">
      <div id="card_produk">
        <div class="row" id="all_produk">
          <?php 
            $ketQuery = "SELECT * FROM `tabel_alternatif`";
            $executeSat = mysqli_query($koneksi, $ketQuery);
            while($tabel_alternatif=mysqli_fetch_array($executeSat)){
          ?>
            <div class="col-sm-3 mt-3">
              <div class="card" id="card" style="width: 18rem;" onclick="detail(<?php echo $tabel_alternatif['id'];?>)">
                <div class="all" id="all">
                  <img src="img/produk/<?php echo $tabel_alternatif['alternatif'];?>.jpg" class="card-img-top" alt="...">
                  <div class="card-body text-center mb-3">
                    <h6 class="card-title text-center font"><?php echo $tabel_alternatif['alternatif']; ?> 200g Kopi Arabica</h6>
                    <h6 class="card-text text-center font font-rp" id="harga">Rp 
                      <?php 
                        $harga = $tabel_alternatif['harga'];
                        $harga1 = substr($harga,0,strlen($harga)-3);
                        $harga2 = substr($harga,strlen($harga)-3);
                        echo $harga1.".".$harga2; 
                      ?>
                    </h6>
                    <a href="index.php?menu=detail&key=<?php echo $tabel_alternatif['id'];?>" class="btn button-tampil center">Tampilkan Produk</a>
                  </div>
                </div>
              </div>
            </div> 
          <?php
          } ?>
        </div>
      </div>
    </div>
    <!-- end card produk -->
  </div>
</div>
<!-- content -->

<!-- Modal -->
<div class="modal fade" id="rekomendasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center" id="exampleModalLabel">Rekomendasi Kopi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="flavor" class="form-label text-color">Flavor</label>
          <br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="flavor" id="flavor1">
            <label class="form-check-label" for="flavor1">1</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="flavor" id="flavor2">
            <label class="form-check-label" for="flavor2">2</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="flavor" id="flavor3">
            <label class="form-check-label" for="flavor3">3</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="flavor" id="flavor4">
            <label class="form-check-label" for="flavor4">4</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="flavor" id="flavor5">
            <label class="form-check-label" for="flavor5">5</label>
          </div>
        </div>
        <div class="mb-3">
          <label for="body" class="form-label text-color">Body</label>
          <br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="body" id="body1">
            <label class="form-check-label" for="body1">1</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="body" id="body2">
            <label class="form-check-label" for="body2">2</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="body" id="body3">
            <label class="form-check-label" for="body3">3</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="body" id="body4">
            <label class="form-check-label" for="body4">4</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="body" id="body5">
            <label class="form-check-label" for="body5">5</label>
          </div>
        </div>
        <div class="mb-3">
          <label for="sweetness" class="form-label text-color">Sweetness</label>
          <br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sweetness" id="sweetness1">
            <label class="form-check-label" for="sweetness1">1</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sweetness" id="sweetness2">
            <label class="form-check-label" for="sweetness2">2</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sweetness" id="sweetness3">
            <label class="form-check-label" for="sweetness3">3</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sweetness" id="sweetness4">
            <label class="form-check-label" for="sweetness4">4</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sweetness" id="sweetness5">
            <label class="form-check-label" for="sweetness5">5</label>
          </div>
        </div>
        <div class="mb-3">
          <label for="acidity" class="form-label text-color">Acidity</label>
          <br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="acidity" id="acidity1">
            <label class="form-check-label" for="acidity1">1</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="acidity" id="acidity2">
            <label class="form-check-label" for="acidity2">2</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="acidity" id="acidity3">
            <label class="form-check-label" for="acidity3">3</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="acidity" id="acidity4">
            <label class="form-check-label" for="acidity4">4</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="acidity" id="acidity5">
            <label class="form-check-label" for="acidity5">5</label>
          </div>
        </div>
        <div class="mb-3">
          <label for="after_taste" class="form-label text-color">After Taste</label>
          <br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="after_taste" id="after_taste1">
            <label class="form-check-label" for="after_taste1">1</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="after_taste" id="after_taste2">
            <label class="form-check-label" for="after_taste2">2</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="after_taste" id="after_taste3">
            <label class="form-check-label" for="after_taste3">3</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="after_taste" id="after_taste4">
            <label class="form-check-label" for="after_taste4">4</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="after_taste" id="after_taste5">
            <label class="form-check-label" for="after_taste5">5</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="index.php" class="button-reset">Reset</a>
        <button type="button" onclick="rekomendasi()" class="button-daftar" name="cari">Cari</button>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
