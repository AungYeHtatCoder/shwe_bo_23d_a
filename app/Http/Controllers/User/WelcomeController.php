<?php

namespace App\Http\Controllers\User;

use App\Models\Admin\Game;
use App\Models\Admin\Banner;
use Illuminate\Http\Request;
use App\Models\Admin\Promotion;
use App\Models\Admin\BannerText;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WelcomeController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->take(3)->get();
        $games = Game::latest()->get();
        $marqueeText = BannerText::latest()->first();
        //$twoDigits = TwoDigit::all();
        // $client = new Client();

        // try {
        //     $response = $client->request('GET', 'https://api.thaistock2d.com/live');
        //     $data = json_decode($response->getBody(), true);
        // } catch (RequestException $e) {
        //     // Log the error or inform the user
        //     $data = []; // or provide a default value
        // }
        // if (request()->ajax()) {
        //     return response()->json($data);
        // }

        return view('welcome', compact('banners', 'games', 'marqueeText'));
    }
    public function promo()
    {
        $promotions = Promotion::latest()->get();
        return view('frontend.pages.promotion', compact('promotions'));
    }

    //promotionDetail
    public function promotionDetail($id)
    {
        $promotion = Promotion::find($id);
        return view('frontend.pages.promotion-detail', compact('promotion'));
    }
}