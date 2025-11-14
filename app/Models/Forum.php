<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $topic_title
 * @property int $category_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */

class Forum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'forums';
    protected $primaryKey = 'forum_id';

    protected $fillable = [
        'user_id',
        'topic_title',
        'category_id',
        'content',
    ];

    /**
     * A forum post belongs to one user (the author).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A forum post belongs to one category.
     */
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    /**
     * A forum post can have many comments.
     */
    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'forum_id');
    }
}
