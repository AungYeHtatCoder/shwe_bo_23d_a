<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ThreeD\LottoThreeDigitCopy;

class ThreeDResetController extends Controller
{
     public function ThreeDReset()
    {
        LottoThreeDigitCopy::truncate();
        session()->flash('SuccessRequest', 'Successfully 3D Reset.');
    return redirect()->back()->with('message', 'Data reset successfully!');
    }
}