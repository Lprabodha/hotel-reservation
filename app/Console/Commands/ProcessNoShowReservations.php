<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessNoShowReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:no-show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create bills for no-show reservations and generate daily occupancy/revenue report';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Processing no-show reservations and generating report...');

        $yesterday = Carbon::yesterday();

        DB::transaction(function () use ($yesterday) {

            $toMarkNoShow = Reservation::whereIn('status', ['pending', 'booked'])
                ->whereDate('check_in_date', $yesterday)
                ->whereNotNull('card_number')
                ->get();

            foreach ($toMarkNoShow as $reservation) {
                $reservation->status = 'no_show';
                $reservation->save();
            }

            $noShowReservations = Reservation::where('status', 'no_show')
                ->whereDate('check_in_date', $yesterday)
                ->where('no_show_billed', 0)
                ->get();

            foreach ($noShowReservations as $reservation) {
                Bill::create([
                    'reservation_id' => $reservation->id,
                    'room_charges' => $reservation->total_price,
                    'extra_charges' => 0,
                    'discount' => 0,
                    'taxes' => 0,
                    'total_amount' => $reservation->total_price,
                    'status' => 'unpaid',
                ]);

                $reservation->no_show_billed = 1;
                $reservation->payment_status = 'failed';
                $reservation->save();
            }
        });

        Log::info('No-show reservation processing completed.');
    }
}
