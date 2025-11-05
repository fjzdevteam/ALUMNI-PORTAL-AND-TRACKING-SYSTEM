<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    protected $table = 'forum_categories';
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
    ];

    public function forums()
    {
        return $this->hasMany(Forum::class, 'category_id');
    }
}
