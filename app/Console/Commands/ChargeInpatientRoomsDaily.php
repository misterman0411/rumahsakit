<?php

namespace App\Console\Commands;

use App\Models\InpatientAdmission;
use App\Models\InpatientCharge;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ChargeInpatientRoomsDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inpatient:charge-rooms-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charge daily room rates for all active inpatient admissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting daily room charges...');

        $activeAdmissions = InpatientAdmission::where('status', 'admitted')->get();
        
        if ($activeAdmissions->isEmpty()) {
            $this->info('No active admissions found.');
            return 0;
        }

        $chargedCount = 0;
        $today = Carbon::today();

        foreach ($activeAdmissions as $admission) {
            // Check if already charged today
            $existingCharge = InpatientCharge::where('inpatient_admission_id', $admission->id)
                ->where('charge_type', 'room')
                ->whereDate('charge_date', $today)
                ->exists();

            if ($existingCharge) {
                $this->warn("Admission {$admission->admission_number} already charged today. Skipping...");
                continue;
            }

            // Create room charge
            InpatientCharge::create([
                'inpatient_admission_id' => $admission->id,
                'charge_date' => $today,
                'charge_type' => 'room',
                'description' => "Room {$admission->room->room_number} - Day {$admission->length_of_stay}",
                'quantity' => 1,
                'unit_price' => $admission->room->daily_rate,
                'charged_by' => null, // System generated
            ]);

            $chargedCount++;
            $this->info("Charged admission {$admission->admission_number}: {$admission->room->room_number} - Rp " . number_format($admission->room->daily_rate, 0, ',', '.'));
        }

        $this->info("✅ Successfully charged {$chargedCount} admission(s)");

        return 0;
    }
}

