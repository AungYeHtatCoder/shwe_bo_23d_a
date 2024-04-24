<?php

namespace App\Http\Controllers\Api\V1\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TwoDResource;
use Illuminate\Support\Facades\Auth;
use App\Services\MorningRecordService;

class TwoDMorningRecordController extends Controller
{    
    protected $morningRecordService;

    public function __construct(MorningRecordService $morningRecordService)
    {
        $this->morningRecordService = $morningRecordService;
    }

    public function MorningRecord(Request $request)
    {
        try {
            $userId = Auth::user()->id;

            $userPlays = $this->morningRecordService->MorningPlays($userId);

            return response()->json(['data' => $userPlays, 'message' => 'User plays retrieved successfully']);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['message' => 'Error retrieving user plays: ' . $e->getMessage()], 500);
        }
    }
}