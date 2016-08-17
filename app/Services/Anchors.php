<?php

namespace App\Services;

class Anchors
{

    protected $anchors;

    public function add($anchor)
    {
        $this->anchors[str_slug($anchor)] = $anchor;
    }

    public function get()
    {
        return view('pages.anchors', [
            'anchors' => $this->anchors
        ])->render();
    }
}
