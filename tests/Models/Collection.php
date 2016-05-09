<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends BaseModel
{
    use SoftDeletes;
    /**
     * If uuid is used instead of autoincementing id
     *
     * @var bool
     */
    protected $uuid = true;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
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
    protected $fillable = ['id','name','slug'];
    /**
     * The pages that belong to the collection.
     */
    public function pages()
    {
        return $this->relationshipTrashedFilter($this->morphToMany('Tests\Models\Page', 'pageable'));
    }
    /**
     * The collections that own this collection
     */
    public function ownedByPages()
    {
        return $this->relationshipTrashedFilter($this->morphedByMany('Tests\Models\Page', 'collectionable'));
    }
    /**
     * The collections owned by the collection
     */
    public function collections()
    {
        return $this->relationshipTrashedFilter($this->morphToMany('Tests\Models\Collection', 'collectionable'));
    }
    /**
     * The collections that own this collection
     */
    public function ownedByCollections()
    {
        return $this->relationshipTrashedFilter($this->morphedByMany('Tests\Models\Collection', 'collectionable'));
    }
    /**
     * The pages that belong to the collection.
     */
    public function fragments()
    {
        return $this->relationshipTrashedFilter($this->morphToMany('Tests\Models\Fragment', 'fragmentable'));
    }
    /**
     * The collections that own this collection
     */
    public function ownedByFragments()
    {
        return $this->relationshipTrashedFilter($this->morphedByMany('Tests\Models\Fragment', 'collectionable'));
    }
}
