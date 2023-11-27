<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Question extends Model
{
    use HasFactory;
    protected $with = ['categories'];

    protected $fillable = [
        'ownerid',
        'questionStatement',
        'a',
        'b',
        'c',
        'd',
        'ans'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class,'qid');
    }
}
