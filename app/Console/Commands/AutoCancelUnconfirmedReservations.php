<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutoCancelUnconfirmedReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:auto-cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-cancel unconfirmed reservations daily at 7PM if no payment details provided';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        Log::info('Starting auto-cancellation of unconfirmed reservations...');

        DB::transaction(function () {
            $unconfirmedReservations = Reservation::where('payment_method', 'none')
                ->whereIn('status', ['pending', 'booked'])
                ->get();

            foreach ($unconfirmedReservations as $reservation) {
                $reservation->status = 'cancelled';
                $reservation->cancellation_reason = 'Auto-cancelled due to missing payment details';
                $reservation->cancellation_date = now();
                $reservation->auto_cancelled = true;
                $reservation->payment_status = 'unpaid';
                $reservation->save();
            }

            Log::info('Auto-cancelled '.$unconfirmedReservations->count().' reservations.');

            Log::info('Auto-cancelled reservations', [
                'count' => $unconfirmedReservations->count(),
                'timestamp' => now(),
            ]);
        });

        Log::info('Auto-cancellation process completed.');
    }
}
