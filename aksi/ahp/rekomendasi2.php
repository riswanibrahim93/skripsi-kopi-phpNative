<?php 

session_start();
include '../../database/koneksi.php';

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
		}
	}
	for ($i=0; $i < $n; $i++) { 
		$jumlah[$i] = 0;
		for ($j=0; $j < $n; $j++) { 
			$jumlah[$i] += $matriks[$j][$i];
		}
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
		}
		$priority_vektor[$i] = $priority_vektor[$i]/$n;
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
		}
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
		}
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

echo json_encode($rekomendasi);




?>