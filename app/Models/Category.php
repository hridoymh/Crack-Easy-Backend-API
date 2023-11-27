<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'qid',
        'cat'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class,'qid');
    }
}
