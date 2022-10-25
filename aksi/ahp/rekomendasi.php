<?php 

include 'database/koneksi.php';

$notes = $_GET['notes'];
$notes = explode(",",$notes);

$input['flavor'] = $notes[0];
$input['body'] = $notes[1];
$input['sweetness'] = $notes[2];
$input['acidity'] = $notes[3]; 
$input['aftertaste'] = $notes[4];


// Metode Supervised 
function supervised($bobot){
	if($bobot == 1){
		return 3;
	}
	else if($bobot == 2){
		return 5;
	}
	else if($bobot == 3){
		return 7;
	}
	else if($bobot == 4){
		return 9;
	}
	else if($bobot == -1){
		return 0.33;
	}
	else if($bobot == -2){
		return 0.2;
	}
	else if($bobot == -3){
		return 0.14;
	}
	else if($bobot == -4){
		return 0.11;
	}
	else if($bobot == 0){
		return 1;
	}
}

function AHP($data){
// Matriks perbandingan berpasangan
	$matriks = [];
	$jumlah = [];
	$n = count($data);

	for ($i=0; $i < $n; $i++) { 
		for ($j=0; $j < $n; $j++) { 
			$matriks[$i][$j] = $data[$i]-$data[$j];
			$matriks[$i][$j] = supervised($matriks[$i][$j]);
			// echo $matriks[$i][$j];
			// echo ",";
		}
		// echo "<br>";
	}

	// echo "<br>";
	for ($i=0; $i < $n; $i++) { 
		$jumlah[$i] = 0;
		for ($j=0; $j < $n; $j++) { 
			$jumlah[$i] += $matriks[$j][$i];
		}
		// echo $jumlah[$i].",";
	}


// Normalisasi & Priority Vektor
	$hasil_normalisasi = [];
	$priority_vektor = [];

	// baris(i)
	// kolom(j)
	for ($i=0; $i < $n; $i++) {
		$priority_vektor[$i] = 0; 
		for ($j=0; $j < $n; $j++) { 
			$hasil_normalisasi[$i][$j] = $matriks[$i][$j]/$jumlah[$j];
			$priority_vektor[$i] += $hasil_normalisasi[$i][$j];
			// echo $hasil_normalisasi[$i][$j];
			// echo " | ";
		}
		$priority_vektor[$i] = $priority_vektor[$i]/$n;
		// echo "    -> ".$priority_vektor[$i];
		// echo "<br>";
	}
	return $priority_vektor;
}


// Kriteria
	$hasil_kusioner = [];

	$ketQuery = "SELECT * FROM `tabel_kuisioner`";
	$executeSat = mysqli_query($koneksi, $ketQuery);

	// kriteria [flavor, body, sweetness, acidity, aftertaste]
	$k=0;
	while($tabel_kuisioner=mysqli_fetch_array($executeSat)){
		$hasil_kusioner[$k] = $tabel_kuisioner['nilai'];
		$k++;
	}

	$priority_kriteria = AHP($hasil_kusioner);

// Alternatif
	$alternatif = [];
	$hasil_pembobotan_alternatif = [];
	$alternatif_flavor = [];
	$alternatif_body = [];
	$alternatif_sweetness = [];
	$alternatif_acidity = [];
	$alternatif_aftertaste = [];

	$ketQuery = "SELECT * FROM `tabel_alternatif`";
	$executeSat = mysqli_query($koneksi, $ketQuery);

	$a=0;
	while($tabel_alternatif=mysqli_fetch_array($executeSat)){
		$alternatif[$a][0] = $tabel_alternatif['flavor']-$input['flavor'];
		$alternatif[$a][1] = $tabel_alternatif['body']-$input['body'];
		$alternatif[$a][2] = $tabel_alternatif['sweetness']-$input['sweetness'];
		$alternatif[$a][3] = $tabel_alternatif['acidity']-$input['acidity'];
		$alternatif[$a][4] = $tabel_alternatif['aftertaste']-$input['aftertaste'];
		$a++;
	}

	for ($i=0; $i < $a; $i++) { 
		for ($j=0; $j < $k; $j++) { 
			if($alternatif[$i][$j] == 0){
				 $hasil_pembobotan_alternatif[$i][$j] = 4;
			}
			else if($alternatif[$i][$j] == 1 || $alternatif[$i][$j] == -1){
				 $hasil_pembobotan_alternatif[$i][$j] = 3;
			}
			else if($alternatif[$i][$j] == 2 || $alternatif[$i][$j] == -2){
				 $hasil_pembobotan_alternatif[$i][$j] = 2;
			}
			else if($alternatif[$i][$j] == 3 || $alternatif[$i][$j] == -3){
				 $hasil_pembobotan_alternatif[$i][$j] = 1;
			}
			else if($alternatif[$i][$j] == 4 || $alternatif[$i][$j] == -4){
				 $hasil_pembobotan_alternatif[$i][$j] = 0;
			}
			// echo $hasil_pembobotan_alternatif[$i][$j];
			// echo " | ";			
		}
		// echo "<br>";
	}

	for ($i=0; $i < $a; $i++) { 
		$alternatif_flavor[$i] = $hasil_pembobotan_alternatif[$i][0];
		$alternatif_body[$i] = $hasil_pembobotan_alternatif[$i][1];
		$alternatif_sweetness[$i] = $hasil_pembobotan_alternatif[$i][2];
		$alternatif_acidity[$i] = $hasil_pembobotan_alternatif[$i][3];
		$alternatif_aftertaste[$i] = $hasil_pembobotan_alternatif[$i][4];
	}

	$hasil_priority_vektor = [];
	$hasil_priority_vektor[0] = AHP($alternatif_flavor);
	$hasil_priority_vektor[1] = AHP($alternatif_body);
	$hasil_priority_vektor[2] = AHP($alternatif_sweetness);
	$hasil_priority_vektor[3] = AHP($alternatif_acidity);
	$hasil_priority_vektor[4] = AHP($alternatif_aftertaste);

	$hasil_nilai_preferensi = [];
	for ($i=0; $i < $a; $i++) { 
		$hasil_nilai_preferensi[$i]['nilai'] = 0;
		for ($j=0; $j < $k; $j++) { 
			$hasil_nilai_preferensi[$i]['index'] = $i;
			$hasil_nilai_preferensi[$i]['nilai'] += $priority_kriteria[$j]*$hasil_priority_vektor[$j][$i];
			// echo $priority_kriteria[$j]." | ".$hasil_priority_vektor[$j][$i];
			// echo "<br>";
		}
		// echo "<br>";
		// echo $hasil_nilai_preferensi[$i];
		// echo "<br>";
		// echo "<br>";
	}

// 4. Perangkingan
	$keys = array_column($hasil_nilai_preferensi, 'nilai');
	array_multisort($keys, SORT_DESC, $hasil_nilai_preferensi);

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

// echo json_encode($rekomendasi);


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