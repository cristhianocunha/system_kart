<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Illuminate\Http\Request;

class IndexPage extends Controller
{
    public function index()
    {
        //
        $rankings = Ranking::query()->orderBy('pontos', 'desc')
            ->get();
        $cont = Ranking::query()->count();
        return view('index', compact('rankings'));
    }
}
