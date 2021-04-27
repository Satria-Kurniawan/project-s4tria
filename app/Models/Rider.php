<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;

    protected $table = "riders";
    protected $primaryKey = "id";
    protected $fillable = ['number', 'image', 'name', 'team'];

    public function post(){
        return $this->hasMany(Post::class);
    }
}
