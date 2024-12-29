<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Pemesanan</title>
</head>

<body>
    <h2>Halo {{ $data['name'] }},</h2>
    <p>Ini adalah pengingat mengenai pemesanan Anda yang akan datang:</p>

    <p><strong>Paket:</strong> {{ $data['Paket'] }}</p>
    <p><strong>Tanggal:</strong> {{ $data['tanggal'] }}</p>
    <p><strong>Jam:</strong> {{ $data['jam'] }}</p>
    <p><strong>Tempat:</strong> {{ $data['tempat'] }}</p>

    <p>Harap pastikan Anda tiba tepat waktu.</p>
    <p>Terima kasih atas kepercayaan Anda.</p>
</body>

</html>
