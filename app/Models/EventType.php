<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $event_type_id
 * @property string $event_type_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventType whereEventTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventType whereEventTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventType whereUpdatedAt($value)
 * @mixin \Eloquent
 */


class EventType extends Model
{
    use HasFactory;

    protected $table = 'event_types';
    protected $primaryKey = 'event_type_id';
    protected $fillable = ['event_type_name'];
}
