<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Illuminate\Http\Request;
use App\Http\Controllers\RankingController;
class IndexPage extends Controller
{
    public function index()
    {
        return (new RankingController)->show();
    }
}
