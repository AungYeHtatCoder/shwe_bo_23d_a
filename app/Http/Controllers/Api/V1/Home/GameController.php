<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin\Game;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class GameController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $games = Game::latest()->get();
        return $this->success($games);
    }
}
