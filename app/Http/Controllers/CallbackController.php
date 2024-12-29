<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\PemesananPromo;
use App\Models\PemesananVideografi;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function midtransCallback(Request $request)
    {
        // Log request headers dan body untuk debugging
        Log::info('Request Headers:', $request->headers->all());
        Log::info('Request Body:', $request->all());

        // Mendapatkan data callback dari Midtrans
        $notification = json_decode($request->getContent(), true);

        if (!$notification) {
            Log::error('Invalid JSON payload');
            return response()->json(['message' => 'Invalid JSON payload'], 400);
        }

        // Ambil server key dari config
        $serverKey = config('midtrans.server_key'); // Pastikan server key sudah benar
        $signatureKey = $notification['signature_key']; // Signature yang diterima dari callback

        // Gabungkan data untuk membuat signature yang benar
        $dataToSign = $notification['order_id'] . $notification['status_code'] . $notification['gross_amount'] . $serverKey;

        // Buat tanda tangan menggunakan SHA512
        $expectedSignatureKey = hash('sha512', $dataToSign);

        // Log nilai signature untuk debugging
        Log::info('Received Signature Key: ' . $signatureKey);
        Log::info('Calculated Signature Key: ' . $expectedSignatureKey);

        // Cek apakah signature key yang diterima valid
        if ($signatureKey !== $expectedSignatureKey) {
            // Jika signature tidak valid, log kesalahan dan tidak memproses callback
            Log::error('Signature key tidak valid.');
            return response()->json(['message' => 'Invalid signature'], 403); // Untuk API
        }

        // Cek data callback lengkap
        if (!isset($notification['order_id']) || !isset($notification['transaction_status'])) {
            Log::error('Data callback tidak lengkap.');
            return response()->json(['message' => 'Data callback tidak lengkap'], 400);
        }

        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];

        // Temukan pemesanan umum atau pemesanan videografi berdasarkan order_id
        $pemesanan = Pemesanan::where('order_id', $orderId)->first();
        $pemesananVideografi = PemesananVideografi::where('order_id', $orderId)->first();
        $pemesananPromo = PemesananPromo::where('order_id', $orderId)->first();

        // Jika ditemukan pemesanan umum
        if ($pemesanan) {
            $this->updatePemesananStatus($pemesanan, $transactionStatus, $orderId);
        }

        // Jika ditemukan pemesanan videografi
        if ($pemesananVideografi) {
            $this->updatePemesananVideografiStatus($pemesananVideografi, $transactionStatus, $orderId);
        }

        // Jika ditemukan pemesanan promo
        if ($pemesananPromo) {
            $this->updatePemesananPromoStatus($pemesananPromo, $transactionStatus, $orderId);
        }

        // Jika tidak ditemukan order_id
        if (!$pemesanan && !$pemesananVideografi && !$pemesananPromo) {
            Log::error("Order ID tidak ditemukan: $orderId");
            return response()->json(['message' => 'Order ID tidak ditemukan'], 404);
        }

        // Kembalikan response dengan status sukses
        return response()->json(['message' => 'Pembayaran diproses dengan sukses'], 200);
    }

    /**
     * Update status pembayaran untuk pemesanan umum
     */
    private function updatePemesananStatus($pemesanan, $transactionStatus, $orderId)
    {
        if ($transactionStatus == 'settlement') {
            $pemesanan->update([
                'status_pembayaran' => 'dibayar',
                'status_pemesanan' => 'proses' // menunggu jadwal pelaksanaan
            ]);
            Log::info("Pembayaran berhasil untuk Order ID: $orderId");

        } elseif ($transactionStatus == 'pending') {
            $pemesanan->update([
                'status_pembayaran' => 'belum bayar' // status pemesanan menunggu pembayaran
            ]);
            Log::info("Pembayaran tertunda untuk Order ID: $orderId");

        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $pemesanan->update([
                'status_pembayaran' => 'gagal'
            ]);
            Log::info("Pembayaran gagal untuk Order ID: $orderId");
        }
    }

    /**
     * Update status pembayaran untuk pemesanan videografi
     */
    private function updatePemesananVideografiStatus($pemesananVideografi, $transactionStatus, $orderId)
    {
        if ($transactionStatus == 'settlement') {
            $pemesananVideografi->update([
                'status_pembayaran' => 'dibayar',
                'status_pemesanan' => 'proses' // menunggu jadwal pelaksanaan
            ]);
            Log::info("Pembayaran berhasil untuk Order ID: $orderId");

        } elseif ($transactionStatus == 'pending') {
            $pemesananVideografi->update([
                'status_pembayaran' => 'belum bayar' // status pemesanan menunggu pembayaran
            ]);
            Log::info("Pembayaran tertunda untuk Order ID: $orderId");

        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $pemesananVideografi->update([
                'status_pembayaran' => 'gagal'
            ]);
            Log::info("Pembayaran gagal untuk Order ID: $orderId");
        }
        
    }
    private function updatePemesananPromoStatus($pemesananPromo, $transactionStatus, $orderId)
    {
        if ($transactionStatus == 'settlement') {
            $pemesananPromo->update([
                'status_pembayaran' => 'dibayar',
                'status_pemesanan' => 'proses' // menunggu jadwal pelaksanaan
            ]);
            Log::info("Pembayaran berhasil untuk Order ID: $orderId");

        } elseif ($transactionStatus == 'pending') {
            $pemesananPromo->update([
                'status_pembayaran' => 'belum bayar' // status pemesanan menunggu pembayaran
            ]);
            Log::info("Pembayaran tertunda untuk Order ID: $orderId");

        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $pemesananPromo->update([
                'status_pembayaran' => 'gagal'
            ]);
            Log::info("Pembayaran gagal untuk Order ID: $orderId");
        }
    }
}
