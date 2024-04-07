<?php

namespace App\Http\Controllers\Api\V1\Home\ThreeD;

use App\Http\Controllers\Controller;
use App\Models\ThreeDigit\ThreeDigit;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ThreeDController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $digits = ThreeDigit::paginate(100);
        return $this->success($digits);
    }
}
