<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Fragment extends BaseModel
{
    use SoftDeletes;
    /**
     * If uuid is used instead of autoincementing id
     *
     * @var bool
     */
    protected $uuid = true;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * Indicates if the model should force an auto-incrementeing id.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','type','name','data'];
    /**
     * The pages that belong to the fragment.
     */
    public function ownedByPages()
    {
        return $this->relationshipTrashedFilter($this->morphedByMany('Tests\Models\Page', 'fragmentable'));
    }
    /**
     * The fragments that belong to the fragment.
     */
    public function fragments()
    {
        return $this->relationshipTrashedFilter($this->morphToMany('Tests\Models\Fragment', 'fragmentable'));
    }
    /**
     * The fragments that belong to the fragment.
     */
    public function ownedByFragments()
    {
        return $this->relationshipTrashedFilter($this->morphedByMany('Tests\Models\Fragment', 'fragmentable'));
    }
    /**
     * The images that belong to the fragment.
     */
    public function images()
    {
        return $this->relationshipTrashedFilter($this->morphToMany('Tests\Models\Image', 'imageable'));
    }
    /**
     * The images that belong to the fragment.
     */
    public function collections()
    {
        return $this->relationshipTrashedFilter($this->morphToMany('Tests\Models\Collection', 'collectionable'));
    }
    /**
     * The fragments that belong to the fragment.
     */
    public function ownedByCollections()
    {
        return $this->relationshipTrashedFilter($this->morphedByMany('Tests\Models\Collection', 'fragmentable'));
    }
    /**
     * The fragments that belong to the fragment.
     */
    public function metadetails()
    {
        return $this->relationshipTrashedFilter($this->morphToMany('Tests\Models\Metadetail', 'metadetailable'));
    }
}
