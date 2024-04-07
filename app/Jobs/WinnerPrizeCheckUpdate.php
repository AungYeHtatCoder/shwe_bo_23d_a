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

class WinnerPrizeCheckUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $prize;

    public function __construct($prize)
    {
        $this->prize = $prize;
    }

    public function handle(): void
    {
        if (!$this->isPlayingDay()) {
            return;
        }

        // Process winning entries directly for prize_one
        $this->processWinningEntries((string) $this->prize->prize_one);
        Log::info($this->prize->prize_one);
        // Process winning entries directly for prize_two
        $this->processWinningEntries((string) $this->prize->prize_two);
        Log::info($this->prize->prize_two);
    }

    protected function isPlayingDay(): bool
    {
        $playDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return in_array(Carbon::now()->englishDayOfWeek, $playDays);
    }

    protected function processWinningEntries($prizeNumber)
    {
        $today = Carbon::today();

        $winningEntries = DB::table('lotto_three_digit_pivot')
            ->join('lottos', 'lotto_three_digit_pivot.lotto_id', '=', 'lottos.id')
            ->where('lotto_three_digit_pivot.bet_digit', $prizeNumber)
            ->where('lotto_three_digit_pivot.prize_sent', 0)
            ->whereDate('lotto_three_digit_pivot.created_at', $today)
            ->select('lotto_three_digit_pivot.*')
            ->get();

        foreach ($winningEntries as $entry) {
            DB::transaction(function () use ($entry) {
                $lottery = Lotto::findOrFail($entry->lotto_id);
                // $user = $lottery->user;
                // $user->balance += $entry->sub_amount * 10; // Adjust based on your prize calculation
                // $user->save();

                // Update the `prize_sent` flag
                $lottery->Prizes()->updateExistingPivot($entry->three_digit_id, ['prize_sent' => 3]);
            });
        }
    }
}