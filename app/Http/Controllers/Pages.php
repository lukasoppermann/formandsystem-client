<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Pages;
use Illuminate\Http\Request;

class Pages extends Controller
{
    protected $pages;

    public function __construct(Pages $pages)
    {
        $this->pages = $pages;
    }

    public function show(Request $request, $value='')
    {
        return view('pages.page');
    }

}
