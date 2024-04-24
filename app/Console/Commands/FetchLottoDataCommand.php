<?php
namespace App\Console\Commands;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ThreeD\ThreeDGame;
use App\Models\ThreeD\ThreeDPrize;
use App\Models\ThreeD\PrizeNumber;

class FetchLottoDataCommand extends Command
{
    protected $signature = 'lotto:fetch';
    protected $description = 'Fetch and store the latest lotto results.';

    public function handle()
    {
        Carbon::setLocale('th'); // Ensure Thai locale for date parsing

        // Define Thai to English month mapping
        $thaiMonthMap = [
            'มกราคม' => 'January',
            'กุมภาพันธ์' => 'February',
            'มีนาคม' => 'March',
            'เมษายน' => 'April',
            'พฤษภาคม' => 'May',
            'มิถุนายน' => 'June',
            'กรกฎาคม' => 'July',
            'สิงหาคม' => 'August',
            'กันยายน' => 'September',
            'ตุลาคม' => 'October',
            'พฤศจิกายน' => 'November',
            'ธันวาคม' => 'December',
        ];

        // Fetch data from the API
        $response = Http::get('https://lotto.api.rayriffy.com/latest');

        if ($response->ok()) {
            $data = $response->json();

            if ($data['status'] == 'success') {
                $lottoData = $data['response'];

                $dateString = $lottoData['date']; // Original Thai date string

                // Replace Thai month names with English equivalents
                foreach ($thaiMonthMap as $thai => $english) {
                    $dateString = str_replace($thai, $english, $dateString);
                }

                // Attempt to parse the corrected date
                try {
                    $resultDate = Carbon::createFromFormat('d F Y', $dateString)->format('Y-m-d');
                } catch (InvalidFormatException $e) {
                    $this->error("Invalid date format: " . $dateString);
                    return;
                }

                // Create a new ThreeDGame record
                $game = ThreeDGame::create([
                    'result_date' => $resultDate,
                    'result_time' => now()->toTimeString(),
                    'status' => 'closed',
                    'endpoint' => $lottoData['endpoint'],
                ]);

                // Create prizes and prize numbers
                foreach ($lottoData['prizes'] as $prizeData) {
                    $prize = ThreeDPrize::create([
                        'name' => $prizeData['name'],
                        'reward' => $prizeData['reward'],
                        'amount' => $prizeData['amount'],
                        'three_d_game_id' => $game->id, // Ensure correct foreign key
                    ]);

                    foreach ($prizeData['number'] as $number) {
                        PrizeNumber::create([
                            'three_d_prize_id' => $prize->id, // Corrected foreign key reference
                            'number' => $number,
                        ]);
                    }
                }

                $this->info('Lotto data stored successfully.');
            } else {
                $this->error('Error fetching lotto data from the API.');
            }
        } else {
            $this->error('API request failed.');
        }
    }
}