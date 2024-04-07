<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin\Bank;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BankController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $banks = Bank::all();
        return $this->success($banks);
    }
}
