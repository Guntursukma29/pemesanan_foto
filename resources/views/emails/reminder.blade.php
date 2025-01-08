-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Pemesanan</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📸 Hai, {{ $data['name'] }}!</h1>
        </div>
        <p>Kami sangat senang mengingatkan bahwa pemesanan Anda telah dijadwalkan:</p>
        <div class="details">
            <p>✨ <strong>Paket:</strong> {{ $data['Paket'] }}</p>
            <p>📅 <strong>Tanggal:</strong> {{ $data['tanggal'] }}</p>
            <p>🕛 <strong>Jam:</strong> {{ $data['jam']  }}</p>
            <p>📍 <strong>Lokasi:</strong> {{ $data['tempat'] }}</p>
        </div>
        <p>Kami tidak sabar untuk bertemu Anda dan menciptakan momen tak terlupakan bersama! Harap pastikan untuk tiba tepat waktu agar semuanya berjalan lancar.</p>
        <div class="footer">
            🌟 <strong>Terima kasih telah mempercayakan momen spesial Anda kepada kami!</strong><br>
            <em>Sampai jumpa,</em><br>
            <strong>Tim Clicks Studio</strong>
        </div>
    </div>
</body>
</html>
