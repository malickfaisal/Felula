<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'title', 
        'content',
        'featured_image',
    ]; 
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
