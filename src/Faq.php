<?php

namespace Mixdinternet\Faqs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Venturecraft\Revisionable\RevisionableTrait;
use Carbon\Carbon;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;


class Faq extends Model implements SluggableInterface, StaplerableInterface
{
    use SoftDeletes, SluggableTrait, RevisionableTrait, EloquentTrait;

    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFieldNames = [
        'name' => 'nome'
        , 'star' => 'destaque'
        , 'description' => 'descrição'
        , 'order' => 'ordem'
    ];

    protected $revisionFormattedFields = [
        'star' => 'boolean:Não|Sim',
    ];

   
    protected $dates = ['deleted_at'];

    protected $fillable = ['status', 'star', 'name', 'description', 'order'];

    public function __construct(array $attributes = [])
    {
       parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();

        static::bootStapler();
    }

    public function setOrderAttribute($value)
    {
        $this->attributes['order'] = ($value) ? $value : null;
    }

    

    public function scopeSort($query, $fields = [])
    {
        if (count($fields) <= 0) {
            $fields = [
                'status' => 'asc'
                , 'star' => 'desc'
                , 'order' => 'asc'
                , 'name' => 'asc'
            ];
        }

        if (request()->has('field') && request()->has('sort')) {
            $fields = [request()->get('field') => request()->get('sort')];
        }

        foreach ($fields as $field => $order) {
            if ($field == 'order') {
                $query->orderByRaw('case when `order` is null then 1 else 0 end, `order` ' . $order);
            }
            else {
                $query->orderBy($field, $order);
            }
        }
    }

    public function scopeActive($query)
    {
        $query->where('status', 'active')->sort();
    }

    # revision
    public function identifiableName()
    {
        return $this->name;
    }
}