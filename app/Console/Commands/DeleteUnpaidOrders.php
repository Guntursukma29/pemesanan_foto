<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pemesanan;
use Carbon\Carbon;

class DeleteUnpaidOrders extends Command
{
    /**
     * Nama dan deskripsi command.
     */
    protected $signature = 'orders:delete-unpaid';
    protected $description = 'Hapus pesanan yang tidak dibayar dalam 10 menit';

    /**
     * Jalankan perintah.
     */
    public function handle()
    {
        // Cari pesanan yang tidak dibayar dan dibuat lebih dari 10 menit yang lalu
        $unpaidOrders = Pemesanan::where('status_pembayaran', 'belum bayar')
            ->where('created_at', '<', Carbon::now()->subMinutes(10))
            ->get();

        foreach ($unpaidOrders as $order) {
            $order->delete(); // Hapus pesanan
            $this->info("Pesanan dengan ID {$order->id} telah dihapus.");
        }

        return 0;
    }
}
