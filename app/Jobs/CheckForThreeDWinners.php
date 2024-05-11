<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Models\ThreeDigit\Lotto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\ThreeDigit\LotteryThreeDigitPivot;

class CheckForThreeDWinners implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $three_d_winner;

    public function __construct($three_d_winner)
    {
        $this->three_d_winner = $three_d_winner;
    }

    public function handle()
    {
        Log::info('CheckFor3DWinners job started');

        $today = Carbon::today();
        
        // Get the correct bet digit from result number
        $result_number = $this->three_d_winner->result_number;

        // Retrieve winning entries where bet_digit matches result_number
        $winningEntries = LotteryThreeDigitPivot::where('bet_digit', $result_number)
        ->where('match_status', 'open')
        ->whereDate('created_at', $today)
        ->get();

    foreach ($winningEntries as $entry) {
        DB::transaction(function () use ($entry) {
            try {
                $lottery = Lotto::findOrFail($entry->lotto_id);
                if (!$lottery) {
                Log::error("Lotto entry not found for ID: {$entry->lotto_id}");
                return; // Skip this entry if not found
            }
                $user = $lottery->user;

                $prize = $entry->sub_amount * 600;
                $user->balance += $prize; // Correct, user is an Eloquent model
                $user->prize_balance += $prize;
                $user->save();

                // Now the entry is also an Eloquent model, so this works
                $entry->prize_sent = true;
                $entry->save();
            } catch (\Exception $e) {
                Log::error("Error during transaction for entry ID {$entry->id}: " . $e->getMessage());
                throw $e; // Ensure rollback if needed
            }
        });
    }


        Log::info("CheckFor3DWinners job completed.");
    }
}