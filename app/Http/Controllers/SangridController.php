<?php

namespace App\Http\Controllers;

class SangridController extends Controller
{
    public function index()
    {
        return view('sangrid', [
            "title" => "Sangrid CRUD"
        ]);
    }
}
