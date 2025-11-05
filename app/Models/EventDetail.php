<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $event_id
 * @property string $event_title
 * @property int|null $event_type_id
 * @property string $event_date
 * @property string $event_time
 * @property string $location
 * @property string $event_description
 * @property string $status
 * @property string|null $rsvp_deadline
 * @property string|null $link
 * @property string $event_date_posted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventAttendee> $attendees
 * @property-read int|null $attendees_count
 * @property-read \App\Models\EventType|null $eventType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereEventDatePosted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereEventDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereEventTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereEventTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereEventTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereRsvpDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'event_id';

    protected $fillable = [
        'event_title',
        'event_type_id',
        'event_date',
        'event_time',
        'event_end_time',
        'location',
        'event_description',
        'status',
        'rsvp_deadline',
        'link',
        'event_date_posted'
    ];


    public function attendees()
    {
        return $this->hasMany(EventAttendee::class, 'event_id', 'event_id');
    }


    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type_id', 'event_type_id');
    }
}
