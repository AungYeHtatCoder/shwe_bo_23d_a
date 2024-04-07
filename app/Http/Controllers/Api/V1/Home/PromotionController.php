<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin\Promotion;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);
        return $this->success($promotions);
    }
}
