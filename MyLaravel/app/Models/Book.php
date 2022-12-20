<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $with = ['category','author'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) { 
            $query->where('body','like','%'.$search.'%')
                    ->orWhere('title','like','%'.$search.'%')
                    ->orWhere('excerpt','like','%'.$search.'%')
                    ->orWhereRelation('author','name','like','%'.$search.'%')
                    ->orWhereRelation('category','name','like','%'.$search.'%')
                    ;
                    
        });
        
    }
    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function author() 
    {
        return $this->belongsTo(Author::class);
    }
}
