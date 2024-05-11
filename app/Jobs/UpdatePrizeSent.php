<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Lottery;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdatePrizeSent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $twodWiner;

    public function __construct($twodWiner)
    {
        $this->twodWiner = $twodWiner;
    }

   public function handle()
{
    //\Log::info('Job started for TwodWiner with prize_no: ' . $this->twodWiner->prize_no);

    $today = Carbon::today();
    //\Log::info("Today's date: " . $today->toDateString());

    if ($this->twodWiner->session !== 'evening') {
      //  \Log::info('This TwodWiner is not for the evening session, exiting.');
        return;
    }

    // Convert prize_no to two_digit_id
    $two_digit_id = $this->twodWiner->prize_no === '00' ? 1 : intval($this->twodWiner->prize_no, 10) + 1;

    $winningEntries = DB::table('lottery_two_digit_copy')
        ->join('lotteries', 'lottery_two_digit_copy.lottery_id', '=', 'lotteries.id')
        ->where('lottery_two_digit_copy.two_digit_id', $two_digit_id) // Use the calculated two_digit_id
        ->where('lottery_two_digit_copy.prize_sent', false)
        ->whereDate('lottery_two_digit_copy.created_at', $today)
        ->select('lottery_two_digit_copy.*')
        ->get();

    // if ($winningEntries->isEmpty()) {
    //     \Log::info('No winning entries found.');
    // } else {
    //     \Log::info('Processing ' . $winningEntries->count() . ' winning entries.');
    // }

    foreach ($winningEntries as $entry) {
        DB::transaction(function () use ($entry) {
            $lottery = Lottery::findOrFail($entry->lottery_id);
            // Update prize_sent to true for the winning entry
            $lottery->twoDigits()->updateExistingPivot($entry->two_digit_id, ['prize_sent' => true]);
        });
    }
}



}