<?php 

include 'database/koneksi.php';

$notes = $_GET['notes'];
$notes = explode(",",$notes);

$input['flavor'] = $notes[0];
$input['body'] = $notes[1];
$input['sweetness'] = $notes[2];
$input['acidity'] = $notes[3]; 
$input['aftertaste'] = $notes[4];

// 1.	Menentukan bobot kepentingan kriteria
	$hasil_kusioner = [];
	$hasil_bobot = [];
	$total = 0;

	$ketQuery = "SELECT * FROM `tabel_kuisioner`";
	$executeSat = mysqli_query($koneksi, $ketQuery);

	// kriteria [flavor, body, sweetness, acidity, aftertaste]
	$k=0;
	while($tabel_kuisioner=mysqli_fetch_array($executeSat)){
		$hasil_kusioner[$k] = $tabel_kuisioner['nilai'];
		$total += $hasil_kusioner[$k];
		$k++;
	}

	for ($j=0; $j < $k; $j++) { 
		$hasil_bobot[$j] = $hasil_kusioner[$j]/$total;
	}

// 2.	Pembobotan kriteria setiap alternatif
	$hasil_alternatif = [];
	$hasil_pembobotan_alternatif = [];
	$pembobotan_alt = [];


	$ketQuery = "SELECT * FROM `tabel_alternatif`";
	$executeSat = mysqli_query($koneksi, $ketQuery);

	// alternatif
	$a=0;
	while($tabel_alternatif=mysqli_fetch_array($executeSat)){
		$hasil_alternatif[$a][0] = $tabel_alternatif['flavor']-$input['flavor'];
		$hasil_alternatif[$a][1] = $tabel_alternatif['body']-$input['body'];
		$hasil_alternatif[$a][2] = $tabel_alternatif['sweetness']-$input['sweetness'];
		$hasil_alternatif[$a][3] = $tabel_alternatif['acidity']-$input['acidity'];
		$hasil_alternatif[$a][4] = $tabel_alternatif['aftertaste']-$input['aftertaste'];
		$a++;
	}

	$all = 0;
	for ($i=0; $i < $a; $i++) { 
		for ($j=0; $j < $k; $j++) { 
			if($hasil_alternatif[$i][$j] == 0){
				$hasil_pembobotan_alternatif[$i][$j] = 4;
				$pembobotan_alt[$all] = 4;
			}
			else if($hasil_alternatif[$i][$j] == 1 || $hasil_alternatif[$i][$j] == -1){
				$hasil_pembobotan_alternatif[$i][$j] = 3;
				$pembobotan_alt[$all] = 3;
			}
			else if($hasil_alternatif[$i][$j] == 2 || $hasil_alternatif[$i][$j] == -2){
				$hasil_pembobotan_alternatif[$i][$j] = 2;
				$pembobotan_alt[$all] = 2;
			}
			else if($hasil_alternatif[$i][$j] == 3 || $hasil_alternatif[$i][$j] == -3){
				$hasil_pembobotan_alternatif[$i][$j] = 1;
				$pembobotan_alt[$all] = 1;
			}
			else if($hasil_alternatif[$i][$j] == 4 || $hasil_alternatif[$i][$j] == -4){
				$hasil_pembobotan_alternatif[$i][$j] = 0;
				$pembobotan_alt[$all] = 0;
			}
			$all++;
		}
	}


// 3.	Normalisasi & Nilai Preferensi
	$hasil_normalisasi = [];
	$hasil_nilai_preferensi = [];

	$max = max($pembobotan_alt);

	for ($i=0; $i < $a; $i++) { 
		$hasil_nilai_preferensi[$i]['nilai'] = 0;
		for ($j=0; $j < $k; $j++) { 
			$hasil_normalisasi[$i][$j] = $hasil_pembobotan_alternatif[$i][$j]/$max;
			$hasil_nilai_preferensi[$i]['index'] = $i;
			$hasil_nilai_preferensi[$i]['nilai'] += $hasil_normalisasi[$i][$j]*$hasil_bobot[$j];
		}
	}

	// 4. Perangkingan
	$keys = array_column($hasil_nilai_preferensi, 'nilai');
	array_multisort($keys, SORT_DESC, $hasil_nilai_preferensi);
  // var_dump($hasil_nilai_preferensi);
  // die;

	$rekomendasi = [];
	$index = [];
	$n_rekom = 3;
	for ($i=0; $i < $n_rekom; $i++) { 
		$index[$i] = $hasil_nilai_preferensi[$i]['index']+1;

		$ketQuery = "SELECT * FROM `tabel_alternatif` WHERE `id` = '$index[$i]'";
		$executeSat = mysqli_query($koneksi, $ketQuery);
		$tabel_alternatif=mysqli_fetch_array($executeSat);
		$rekomendasi[$i]=$tabel_alternatif;
	}

?>

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
          <li class="breadcrumb-item">
            <a class="breadcrumb-back" href="index.php" style="">Roasted Bean</a>
          </li>
          <li class="breadcrumb-item active">
            Rekomendasi
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
           	for ($i=0; $i < count($rekomendasi); $i++) { 
          ?>
            <div class="col-sm-3 mt-3">
              <div class="card" id="card" style="width: 18rem;" onclick="detail(<?php echo $rekomendasi[$i]['id'];?>)">
                <div class="all" id="all">
                  <img src="img/produk/<?php echo $rekomendasi[$i]['alternatif'];?>.jpg" class="card-img-top" alt="...">
                  <div class="card-body text-center mb-3">
                    <h6 class="card-title text-center font"><?php echo $rekomendasi[$i]['alternatif']; ?> 200g Kopi Arabica</h6>
                    <h6 class="card-text text-center font font-rp" id="harga">Rp 
                      <?php 
                        $harga = $rekomendasi[$i]['harga'];
                        $harga1 = substr($harga,0,strlen($harga)-3);
                        $harga2 = substr($harga,strlen($harga)-3);
                        echo $harga1.".".$harga2; 
                      ?>
                    </h6>
                    <!-- <h6 class="mb-4 mt-2 rating"><span><i class="fas fa-star bintang"></i> 4.9 <span class="ulasan">(12)</span></span></h6> -->
                    <a href="index.php?menu=detail&key=<?php echo $rekomendasi[$i]['id'];?>" class="btn button-tampil center">Tampilkan Produk</a>
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
<script type="text/javascript">