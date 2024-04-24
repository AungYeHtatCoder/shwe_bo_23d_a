<?php

namespace App\Http\Controllers\Api\V1\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\EveningRecordService;
use App\Services\MorningRecordService;

class TwoDEveningRecordController extends Controller
{
    protected $eveningRecordService;

    public function __construct(EveningRecordService $eveningRecordService)
    {
        $this->eveningRecordService = $eveningRecordService;
    }

    public function EveningRecord(Request $request)
    {
        try {
            $userId = Auth::user()->id;

            $userPlays = $this->eveningRecordService->EveningPlays($userId);

            return response()->json(['data' => $userPlays, 'message' => 'User plays evening data retrieved successfully']);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['message' => 'Error retrieving user plays: ' . $e->getMessage()], 500);
        }
    }
}