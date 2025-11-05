<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $rsvp_id
 * @property int $user_id
 * @property int|null $event_id
 * @property string $rsvp_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee whereRsvpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee whereRsvpStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendee whereUserId($value)
 * @mixin \Eloquent
 */


class EventAttendee extends Model
{
    use HasFactory;


    protected $table = 'event_attendees';
    protected $primaryKey = 'rsvp_id';
    protected $fillable = ['user_id', 'event_id', 'rsvp_status'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function event()
    {
        return $this->belongsTo(EventDetail::class, 'event_id', 'event_id');
    }
}
