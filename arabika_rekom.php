<?php 

var_dump($_POST);
die;




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
          <li class="breadcrumb-item active">
            Roasted Bean
          </li>
        </ul>
      </nav>
    </div>
    <div class="judul">
      <h4>Kopi Pilihan Terbaik Untukmu</h4>
    </div>
    <div class="filter mt-3">
      <!-- <button type="button" class="btn filter" data-target="#dropdownFilter" aria-expanded="false"><img class="logo-loupe me-2" src="img/edit.png">Filter</button>
      <button type="button" class="btn filter" id="dropdownUrutkan" data-bs-toggle="dropdown" aria-expanded="false"><img class="logo-loupe me-2" src="img/sort.png">Urutkan</button>
      <button type="button" class="btn filter">Best Saller</button> -->
      <button type="button" class="btn filter" data-bs-toggle="modal" data-bs-target="#rekomendasi">Rekomendasi</button>
    </div>
    <div class="produk mt-4">
      <div class="row">
        <?php 
          if(isset($_POST['cari'])){
            
          }
        ?>
      </div>
    </div>
  </div>
</div>
<!-- content -->

<!-- Modal -->
<div class="modal fade" id="rekomendasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center" id="exampleModalLabel">Rekomendasi Kopi</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
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
          <a href="" class="button-reset">Reset</a>
          <button type="submit" class="button-daftar" name="cari">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

