<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Pages as PagesService;
use Illuminate\Http\Request;

class Pages extends Controller
{
    protected $pages;

    public function __construct(PagesService $pages)
    {
        $this->pages = $pages;
    }

    public function show(Request $request)
    {
        return view('pages.page');
    }

}
