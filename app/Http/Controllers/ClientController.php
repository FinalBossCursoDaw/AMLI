<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientController extends Controller
{
    public function count()
    {
        $count = Client::where('actiu', 1)->count();
        return response()->json(['total' => $count]);
    }
}