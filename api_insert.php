<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "soal");
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari App Inventor (pakai metode POST)
$name    = $_POST['name'] ?? '';
$score   = $_POST['score'] ?? 0;
$correct = $_POST['correct'] ?? 0;
$wrong   = $_POST['wrong'] ?? 0;

if ($name) {
  // Simpan ke tabel users
  $stmt = $conn->prepare("INSERT INTO users (name, score) VALUES (?, ?)");
  $stmt->bind_param("si", $name, $score);
  $stmt->execute();
  $user_id = $stmt->insert_id;
  $stmt->close();

  // Simpan ke tabel user_results
  $stmt2 = $conn->prepare("INSERT INTO user_results (user_id, correct_answers, wrong_answers) VALUES (?, ?, ?)");
  $stmt2->bind_param("iii", $user_id, $correct, $wrong);
  $stmt2->execute();
  $stmt2->close();

  echo "sukses";
} else {
  echo "gagal";
}

$conn->close();
?>
