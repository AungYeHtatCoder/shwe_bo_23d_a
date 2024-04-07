<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Models\ThreeDigit\Lotto;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckForThreeDWinners implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $threedWinner;
    public function __construct($threedWinner)
    {
        $this->threedWinner = $threedWinner;
    }

     public function handle(): void
{
    // Check if today is a playing day
    $today = Carbon::today();
    $playDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    if (!in_array(strtolower(date('l')), $playDays)) {
        return; // Exit if it's not a playing day
    }

    // Convert prize_no to three_digit_id
    $three_digit_id = $this->threedWinner->prize_no === '00' ? 1 : intval($this->threedWinner->prize_no, 10) + 1;
    //Log::info('Three digit id: ' . gettype($three_digit_id) . ' - ' . $three_digit_id);

    $winningEntries = DB::table('lotto_three_digit_copy')
        ->join('lottos', 'lotto_three_digit_copy.lotto_id', '=', 'lottos.id')
        ->join('three_digits', 'lotto_three_digit_copy.three_digit_id', '=', 'three_digits.id')
        ->where('three_digits.id', $three_digit_id) // Use the calculated three_digit_id here
        ->where('lotto_three_digit_copy.prize_sent', 0)
        ->whereDate('lotto_three_digit_copy.created_at', $today)
        ->select('lotto_three_digit_copy.*') // Select all columns from pivot table
        ->get();

    // Loop through each winning entry and process them
    foreach ($winningEntries as $entry) {
        DB::transaction(function () use ($entry) {
            // Retrieve the lottery for this entry
            $lottery = Lotto::findOrFail($entry->lotto_id);
            $methodToUpdatePivot = 'threedDigits';

            // Update user's balance
            $user = $lottery->user;
            $user->balance += $entry->sub_amount * 600; // Update based on your prize calculation
            $user->save();

            // Update prize_sent in pivot
            $lottery->$methodToUpdatePivot()->updateExistingPivot($entry->three_digit_id, ['prize_sent' => 1]);
        });

        // Optionally log info about the processed entries
        // Log::info('Updated prize_sent for entry: ' . $entry->id);
    }
}
}