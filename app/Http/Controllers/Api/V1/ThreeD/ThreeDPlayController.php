<?php

namespace App\Http\Controllers\Api\V1\ThreeD;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Services\LottoService;
use Illuminate\Http\JsonResponse;
use App\Models\Admin\LotteryMatch;
use App\Models\Admin\ThreeDDLimit;
use App\Models\ThreeD\ThreeDLimit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ThreeDigit\ThreeDigit;
use App\Models\ThreeDigit\ThreedClose;
use App\Http\Requests\ThreedPlayRequest;

class ThreeDPlayController extends Controller
{
    use HttpResponses;
    protected $lottoService;

    public function __construct(LottoService $lottoService)
    {
        $this->lottoService = $lottoService;
    }
    public function index()
    {
        $digits = ThreeDigit::all();
        $break = ThreeDLimit::latest()->first()->three_d_limit;
        foreach($digits as $digit){
            $totalAmount = DB::table('lotto_three_digit_copy')->where('three_digit_id', $digit->id)->sum('sub_amount');
            $break = ThreeDLimit::latest()->first()->three_d_limit;
            $remaining = $break-$totalAmount;
            $digit->remaining = $remaining;
        }
        $lottery_matches = LotteryMatch::where('id', 2)->whereNotNull('is_active')->first(['id', 'match_name', 'is_active']);
        return $this->success([
            'digits' => $digits,
            'break' => $break,
            'lottery_matches' => $lottery_matches
        ]);
    }

     public function play(ThreedPlayRequest $request): JsonResponse
    {
        //Log::info($request->all());
        $totalAmount = $request->input('totalAmount');
        $amounts = $request->input('amounts');

        // if($totalAmount > Auth::user()->balance){
        //     return response()->json(['success' => false, 'message' => 'လက်ကျန်ငွေ မလုံလောက်ပါ။'], 401);
        // }

        $closedTwoDigits = ThreedClose::query()
            ->pluck('digit')
            ->map(function ($digit) {
                // Ensure formatting as a two-digit string
                return sprintf('%03d', $digit);
            })
            ->unique()
            ->filter()
            ->values()
            ->all();

        foreach ($request->input('amounts') as $amount) {
            $twoDigitOfSelected = sprintf('%03d', $amount['num']); // Ensure two-digit format
            if (in_array($twoDigitOfSelected, $closedTwoDigits)) {
                return response()->json(['message' => "3D -  '{$twoDigitOfSelected}'  ကိုပိတ်ထားသောကြောင့် ကံစမ်း၍ မရနိုင်ပါ ၊ ကျေးဇူးပြု၍ ဂဏန်းပြန်ရွှေးချယ်ပါ။ "], 401);
            }
        }


        $result = $this->lottoService->play($totalAmount, $amounts);
        // return response()->json($result);
        if ($result == "Insufficient funds.") {
            $message = "လက်ကျန်ငွေ မလုံလောက်ပါ။";
        } elseif (is_array($result)) {
            // return response()->json($result);
            $digit = [];
            foreach($result as $k => $r){
                $digit[] = ThreeDigit::find($result[$k]+1)->three_digit;
            }
            // return response()->json($digit);
            $d = implode(",",$digit);
            // return response()->json($d);
            $message = $d." ဂဏန်းမှာ သတ်မှတ် Limit ထက်ကျော်လွန်နေပါသည်။";
        } else {
            return $this->success($result);
        }

        return response()->json(['message' => $message], 401);
    }

    // three once week history
     public function OnceWeekThreedigitHistoryConclude()
    {
        $userId = auth()->id(); // Get logged in user's ID
        $displayThreeDDigit = User::getAdminthreeDigitsHistoryApi($userId);
       // $three_limits = ThreeDDLimit::orderBy('id', 'desc')->first();
       return $this->success($displayThreeDDigit);
    }

     // three once week history
     public function OnceMonthThreedigitHistoryConclude()
    {
        $userId = auth()->id(); // Get logged in user's ID
        $displayThreeDDigit = User::getAdminthreeDigitsOneMonthHistoryApi($userId);
       // $three_limits = ThreeDDLimit::orderBy('id', 'desc')->first();
       return $this->success($displayThreeDDigit);
    }


    // three once month history
    public function OnceMonthThreeDHistory()
    {
        $userId = auth()->id(); // Get logged in user's ID
        $displayThreeDDigit = User::getUserOneMonthThreeDigits($userId);
        return $this->success($displayThreeDDigit);
    }
}