<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Pages as PagesService;
use App\Services\Anchors;
use Illuminate\Http\Request;
use Cache;

class Pages extends Controller
{
    protected $pages;

    public function __construct(PagesService $pages)
    {
        $this->pages = $pages;
    }

    public function show(Request $request)
    {
        if(!Cache::has('page-'.$request->path())){
            $view = view('pages.page', [
                'anchors' => new Anchors()
            ])->render();
            Cache::forever('page-'.$request->path(),$view);
        }
        return Cache::get('page-'.$request->path());
    }

}
