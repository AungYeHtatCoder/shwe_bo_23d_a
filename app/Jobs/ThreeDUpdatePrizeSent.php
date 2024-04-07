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

class ThreeDUpdatePrizeSent implements ShouldQueue
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

    public function handle()
{
     $today = Carbon::today();
    $playDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    if (!in_array(strtolower(date('l')), $playDays)) {
        return; // Exit if it's not a playing day
    }

    // Convert prize_no to three_digit_id
    $three_digit_id = $this->threedWinner->prize_no === '00' ? 1 : intval($this->threedWinner->prize_no, 10) + 1;

    $winningEntries = DB::table('lotto_three_digit_pivot')
        ->join('lottos', 'lotto_three_digit_pivot.lotto_id', '=', 'lottos.id')
        ->join('three_digits', 'lotto_three_digit_pivot.three_digit_id', '=', 'three_digits.id')
        ->where('three_digits.id', $three_digit_id) // Use the calculated three_digit_id here
        ->where('lotto_three_digit_pivot.prize_sent', 0)
        ->whereDate('lotto_three_digit_pivot.created_at', $today)
        ->select('lotto_three_digit_pivot.*') // Select all columns from pivot table
        ->get();

    // Loop through each winning entry and process them
    foreach ($winningEntries as $entry) {
        DB::transaction(function () use ($entry) {
            // Retrieve the lottery for this entry
            $lottery = Lotto::findOrFail($entry->lotto_id);
            $methodToUpdatePivot = 'DisplayThreeDigits';
            // Update prize_sent in pivot
            $lottery->$methodToUpdatePivot()->updateExistingPivot($entry->three_digit_id, ['prize_sent' => 1]);
        });

        // Optionally log info about the processed entries
        // Log::info('Updated prize_sent for entry: ' . $entry->id);
    }
}
}