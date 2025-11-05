<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $slot_number
 * @property string|null $title
 * @property string|null $date
 * @property string|null $description
 * @property string|null $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail whereSlotNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NewsDetail extends Model
{
    use HasFactory;

    protected $table = 'news_details';
    protected $fillable = ['slot_number', 'title', 'date', 'description', 'image_path'];
}
