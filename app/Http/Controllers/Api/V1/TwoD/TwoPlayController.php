<?php

namespace App\Http\Controllers\Api\V1\TwoD;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TwoD\TwoDigit;
use App\Services\TwoDService;
use App\Traits\HttpResponses;
use App\Models\TwoD\HeadDigit;
use App\Models\TwoD\TwoDLimit;
use Illuminate\Http\JsonResponse;
use App\Models\Admin\LotteryMatch;
use App\Models\TwoD\CloseTwoDigit;
use App\Http\Controllers\Controller;
use App\Services\TwoDLotteryService;
use App\Http\Requests\TwoDPlayRequest;
use App\Models\TwoD\LotteryTwoDigitCopy;

class TwoPlayController extends Controller
{
    use HttpResponses;
    protected $lotteryService;

    public function __construct(TwoDLotteryService $lotteryService)
    {
        $this->middleware('auth'); // Ensure user is authenticated
        $this->lotteryService = $lotteryService;
    }
    public function index()
    {
        $digits = TwoDigit::all();
        $break = TwoDLimit::latest()->first()->two_d_limit;
        foreach($digits as $digit)
        {
            $totalAmount = LotteryTwoDigitCopy::where('two_digit_id', $digit->id)->sum('sub_amount');
            $remaining = $break-$totalAmount;
            $digit->remaining = $remaining;
        }
        $lottery_matches = LotteryMatch::where('id', 1)->whereNotNull('is_active')->first(['id', 'match_name', 'is_active']);
        return $this->success([
            'break' => $break,
            'two_digits' => $digits,
            'lottery_matches' => $lottery_matches
        ]);
    }

    public function play(TwoDPlayRequest $request, TwoDService $twoDService): JsonResponse
{
    //Log::info($request->all());

    // Retrieve the validated data from the request
    $totalAmount = $request->input('totalAmount');
    $amounts = $request->input('amounts');

    try {
        // Fetch all head digits not allowed
        $closedHeadDigits = HeadDigit::query()
            ->get(['digit_one', 'digit_two', 'digit_three'])
            ->flatMap(function ($item) {
                return [$item->digit_one, $item->digit_two, $item->digit_three];
            })
            ->unique()
            ->all();

        // return response()->json($closedHeadDigits);
        foreach ($amounts as $amount) {
            $headDigitOfSelected = substr(sprintf('%02d', $amount['num']), 0, 1); // Ensure 
            if (in_array($headDigitOfSelected, $closedHeadDigits)) {
                return response()->json(['message' => "ထိပ်ဂဏန်း '{$headDigitOfSelected}'  ကိုပိတ်ထားသောကြောင့် ကံစမ်း၍ မရနိုင်ပါ ၊ ကျေးဇူးပြု၍ ဂဏန်းပြန်ရွှေးချယ်ပါ။ "], 401);
            }
        }

        $closedTwoDigits = CloseTwoDigit::query()
            ->pluck('digit')
            ->map(function ($digit) {
                // Ensure formatting as a two-digit string
                return sprintf('%02d', $digit);
            })
            ->unique()
            ->filter()
            ->values()
            ->all();

        foreach ($request->input('amounts') as $amount) {
            $twoDigitOfSelected = sprintf('%02d', $amount['num']); // Ensure two-digit format
            if (in_array($twoDigitOfSelected, $closedTwoDigits)) {
                return response()->json(['message' => "2D -  '{$twoDigitOfSelected}'  ကိုပိတ်ထားသောကြောင့် ကံစမ်း၍ မရနိုင်ပါ ၊ ကျေးဇူးပြု၍ ဂဏန်းပြန်ရွှေးချယ်ပါ။ "], 401);
            }
        }

        // Pass the validated data to the TwoDService
        $result = $twoDService->play($totalAmount, $amounts);

        if ($result === "Insufficient funds.") {
            // Insufficient funds message
            return response()->json(['message' => "လက်ကျန်ငွေ မလုံလောက်ပါ။"], 401);
        } elseif (is_array($result)) {
            // Process exceeding limit message
            $digitStrings = collect($result)->map(function ($r) {
                return TwoDigit::find($r)->two_digit ?? 'Unknown';
            })->implode(",");
            
            $message = "{$digitStrings} ဂဏန်းမှာ သတ်မှတ် Limit ထက်ကျော်လွန်နေပါသည်။";
            return response()->json(['message' => $message], 401);
        }

        // If $result is neither "Insufficient funds." nor an array, assuming success.
        return $this->success($result);

    } catch (\Exception $e) {
        // In case of an exception, return an error response
        return response()->json(['success' => false, 'message' => $e->getMessage()], 401);
    }
    }

    public function playHistory(): JsonResponse
    {
        $userId = auth()->id();

        $history12pm = $this->lotteryService->getUserTwoDigits($userId, 'morning');
        $history4pm = $this->lotteryService->getUserTwoDigits($userId, 'evening');

        return response()->json([
            'history12pm' => $history12pm,
            'history4pm' => $history4pm,
        ]);
    }
    // for admin 
    public function playHistoryForAdmin(): JsonResponse
{
    // Example: Fetching history for all users
    $history12pm = $this->lotteryService->getAllUsersTwoDigits('morning');
    $history4pm = $this->lotteryService->getAllUsersTwoDigits('evening');

    return response()->json([
        'history12pm' => $history12pm,
        'history4pm' => $history4pm,
    ]);
}

    
    public function TwoDigitOnceMonthHistory()
    {
        $userId = auth()->id(); // Get logged in user's ID
        $twod_once_month_history = User::getUserOneMonthTwoDigits($userId);
        return $this->success([
            $twod_once_month_history
        ]);
    }
}