<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\AbstractApiService;
use Illuminate\Support\Collection;

class Pages extends AbstractApiService
{
    /**
     * active items
     *
     * @var Array
     */
    protected $active = [
        'path'      => NULL,
        'parts'     => [],
        'page'      => NULL,
    ];
    /**
     * all menus with pages & other includes
     *
     * @var Illuminate\Support\Collection
     */
    protected $menus = NULL;
    /**
     * constructor
     *
     * @method __construct
     *
     * @param  Request     $request
     */
    public function __construct(Request $request)
    {
        // get all menus
        $this->menus = $this->getMenus(array_slice(app('request')->segments(), -1)[0]);
        $footer = $this->getMenus(array_slice(app('request')->segments(), -1)[0], '[key]=footer-navigation');
        // only run in get requests
        if( app('request')->method() === 'GET' ){
            // get active path
            $this->active['path'] = '/'.trim(app('request')->path(),'/');
            // active parts
            $this->active['parts'] = app('request')->segments();
            // active item
            $this->active['page'] = $this->menus['active_page'] !== null ? $this->menus['active_page'] : $footer['active_page'];
            // active parameters
            $this->active['parameters'] = app('request')->query();
            // share active with views
            view()->share('active', $this->active);
        }
        // build & share menus
        foreach($this->menus['menus'] as $slug => $menu){
            $menu['pages'] = $menu['pages']->sortBy('position');
            view()->share('menu_'.$slug, view('layout.menu', $menu)->render());
            view()->share('menu_footer', $footer['menus']['footer']);

        }
    }
    /**
     * get active url parts
     *
     * @method active
     *
     * @param  string $part [description]
     *
     * @return mixed|false
     */
    public function active($part)
    {
        if(array_key_exists($part, $this->active)){
            return $this->active[$part];
        }
        return false;
    }
    /**
     * get pages as collection
     *
     * @method getPages
     *
     * @return Illuminate\Support\
     */
    public function getMenus($slug = NULL, $filter = '[key]=main-navigation')
    {
        // get pages via api
        $response = $this->api()->get('/collections?filter'.$filter);

        if(!isset($response['included'])){
            return;
        }
        $included = array_column($response['included'],NULL,'id');
        // index menu by slug
        $menus = $this->assemble($response['data'], $included)->keyBy(function($item) {
            return $item['slug'];
        // merge relationships
        })->map(function($menu){
            // index pages by slug
            $menu['relationships']['pages'] = $menu['relationships']['pages']->keyBy(function($item){
                return $item['slug'];
            })->sortBy('position');
            // merge relationships
            $menu = array_merge($menu, $menu['relationships']);
            unset($menu['relationships']);
            // return menu
            return $menu;
        });
        // get active item
        foreach($menus as $menu){
            if($menu['pages']->get($slug)){
                $active = $menu['pages']->get($slug);
            }
        }
        // assemble pages
        return [
            'menus'         => $menus,
            'active_page'   => isset($active) ? $active : NULL,
        ];
    }
    /**
     * turn api response into sensible collection
     *
     * @method assemble
     *
     * @param  Array           $items [description]
     * @param  Array           $included      [description]
     *
     * @return Illumniate\Support\Collection
     */
    protected function assemble($items, $included)
    {
        return collect($items)->map(function($item) use ($included){
            // get attributes & relationships
            return array_merge($item['attributes'],[
                'relationships' => $this->getRelationships($item['relationships'], $included)
            ]);
        });
    }
    /**
     * put relationship data into collection
     *
     * @method getRelationships
     *
     * @param  Array           $relationships [description]
     * @param  Array           $included      [description]
     *
     * @return Illumniate\Support\Collection
     */
    protected function getRelationships($relationships, $included)
    {
        foreach($relationships as $key => $rel){
            if(isset($rel['data']) && count($rel['data']) > 0){
                foreach(array_column($rel['data'], 'id') as $id){
                    $related[$key][] = $included[$id];
                }
                // grab relationships of relationships
                $related[$key] = $this->assemble($related[$key], $included);
            }
        }
        // return
        return isset($related) ? $related : new Collection([]);
    }
}
