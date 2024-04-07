<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin\Banner;
use App\Models\Admin\BannerText;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $banners = Banner::latest()->get();
        return $this->success($banners);
    }

    public function bannerText()
    {
        $text = BannerText::latest()->first();
        return $this->success($text);
    }
}
