<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userAnswer extends Model
{
    use HasFactory;
    protected $fillable = ['answer','question_id','user_id'];
    public function question(){
        return $this->belongsTo(question::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function reponses()
    {
        return $this->belongsToMany(reponse::class);
    }
}
