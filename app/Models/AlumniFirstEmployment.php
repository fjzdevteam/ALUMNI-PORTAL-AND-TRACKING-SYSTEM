<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $user_id
 * @property string|null $company_name
 * @property string|null $position_title
 * @property int|null $location_id
 * @property int|null $industry_id
 * @property string|null $job_alignment
 * @property string|null $job_type
 * @property string|null $waiting_period
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Industry|null $industry
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereJobAlignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereJobType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment wherePositionTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment whereWaitingPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniFirstEmployment withoutTrashed()
 * @mixin \Eloquent
 */
class AlumniFirstEmployment extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'alumni_first_employment';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $fillable = [
        'user_id',
        'company_name',
        'position_title',
        'location_id',
        'industry_id',
        'job_alignment',
        'job_type',
        'waiting_period',
        'start_date',
        'end_date',
    ];


    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'industry_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
