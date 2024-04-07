<?php

namespace App\Http\Controllers\Api\V1\Home\TwoD;

use App\Http\Controllers\Controller;
use App\Models\TwoD\TwoDigit;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class TwoDController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $digits = TwoDigit::all();
        return $this->success($digits);
    }
}
