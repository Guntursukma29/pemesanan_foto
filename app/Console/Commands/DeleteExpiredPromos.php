<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promo;
use Carbon\Carbon;

class DeleteExpiredPromos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promo:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus promo yang telah berakhir';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        $expiredPromos = Promo::where('berakhir', '<', $today)->delete();

        $this->info($expiredPromos . ' promo telah dihapus.');
        return Command::SUCCESS;
    }
}
