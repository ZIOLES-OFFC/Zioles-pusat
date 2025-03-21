<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Otomatis Ambil Gambar</title>
</head>
<body>
  <h2>Gambar otomatis diambil saat halaman dibuka</h2>
  <video id="video" autoplay style="display:none;"></video>
  <canvas id="canvas" style="display:none;"></canvas>
  <img id="snapshot" alt="Hasil Foto" />

  <script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const snapshot = document.getElementById('snapshot');

    // Mulai kamera dan ambil gambar
    async function start() {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;

        video.onloadedmetadata = () => {
          // Tunggu sedikit supaya kamera benar-benar menyala
          setTimeout(() => {
            // Ambil snapshot
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/png');
            snapshot.src = imageData;

            // Matikan kamera
            stream.getTracks().forEach(track => track.stop());
          }, 1000);
        };
      } catch (err) {
        alert('Gagal mengakses kamera: ' + err.message);
      }
    }

    // Jalankan otomatis saat halaman dibuka
    window.onload = start;
  </script>
</body>
</html>
