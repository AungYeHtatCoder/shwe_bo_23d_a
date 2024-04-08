<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin\Banner;
use App\Models\Admin\BannerText;
use App\Models\Admin\Game;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $banners = Banner::latest()->get();
        $bannerText = BannerText::latest()->first();
        $games = Game::latest()->get();
        $user = auth()->user();
        return $this->success([
            'banners' => $banners,
            'bannerText' => $bannerText,
            'games' => $games,
            'user' => $user
        ]);
    }
}
