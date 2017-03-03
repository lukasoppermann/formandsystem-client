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
        $client = new \Contentful\Delivery\Client('d964331125b56d288c3cc7e8517fdd50227decc90f4b8e7c9a539358277a1df2', 'gpw1cuaxmyho');
        $query = new \Contentful\Delivery\Query;
        $query->setContentType('page')
            ->orderBy('fields.order');
        $entries = $client->getEntries($query);
        dd($entries);

        if(!Cache::has('page-'.$request->path())){
            $view = view('pages.page', [
                'anchors' => new Anchors()
            ])->render();
            Cache::forever('page-'.$request->path(),$view);
        }

        return view('layout.app', [
            'page' => Cache::get('page-'.$request->path())
        ]);
    }

}
