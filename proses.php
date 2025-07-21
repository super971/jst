<?php
function mp_neuron($x1, $x2, $w1, $w2, $threshold) {
    $net = ($x1 * $w1) + ($x2 * $w2);
    $fnet = ($net >= $threshold) ? 1 : 0;
    return [$net, $fnet];
}

function expected_y($gate, $x1, $x2) {
    $result = [];
    for ($i = 0; $i < count($x1); $i++) {
        if ($gate == "AND") {
            $result[] = $x1[$i] && $x2[$i];
        } elseif ($gate == "OR") {
            $result[] = $x1[$i] || $x2[$i];
        } elseif ($gate == "NAND") {
            $result[] = !($x1[$i] && $x2[$i]) ? 1 : 0;
        }
    }
    return $result;
}

function cocok($expected, $actual) {
    for ($i = 0; $i < count($expected); $i++) {
        if ((int)$expected[$i] !== (int)$actual[$i]) {
            return false;
        }
    }
    return true;
}

$x1 = $_POST['x1'];
$x2 = $_POST['x2'];
$y  = $_POST['y'];
$w1 = $_POST['w1'];
$w2 = $_POST['w2'];
$threshold = $_POST['threshold'];

$net = [];
$fnet = [];

for ($i = 0; $i < count($x1); $i++) {
    list($n, $f) = mp_neuron($x1[$i], $x2[$i], $w1, $w2, $threshold);
    $net[] = $n;
    $fnet[] = $f;
}

$pesan = "Jaringan gagal memahami";

if (cocok(expected_y("AND", $x1, $x2), $y)) {
    $pesan = "Ini logika <strong>AND</strong> dan jaringan memahami";
} elseif (cocok(expected_y("OR", $x1, $x2), $y)) {
    $pesan = "Ini logika <strong>OR</strong> dan jaringan memahami";
} elseif (cocok(expected_y("NAND", $x1, $x2), $y)) {
    $pesan = "Ini logika <strong>NAND</strong> dan jaringan memahami";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Perhitungan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Hasil Perhitungan McCulloch-Pitts</h2>
    <p class="message"><?= $pesan ?></p>

    <table>
      <thead>
        <tr>
          <th>X1</th><th>X2</th><th>Y</th><th>NET</th><th>F-NET</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i = 0; $i < count($x1); $i++): ?>
        <tr>
          <td><?= $x1[$i] ?></td>
          <td><?= $x2[$i] ?></td>
          <td><?= $y[$i] ?></td>
          <td><?= $net[$i] ?></td>
          <td><?= $fnet[$i] ?></td>
        </tr>
        <?php endfor; ?>
      </tbody>
    </table>

    <div class="button-center">
      <a href="index.html" class="back-button">⬅ Kembali</a>
    </div>
  </div>
</body>
</html>
