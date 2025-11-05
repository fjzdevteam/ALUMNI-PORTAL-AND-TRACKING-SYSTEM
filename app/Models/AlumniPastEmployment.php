<?php




namespace App\Models;




use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;




/**
 * @property int $id
 * @property int $user_id
 * @property string|null $company_name
 * @property string|null $position_title
 * @property int|null $location_id
 * @property int|null $industry_id
 * @property string|null $job_type
 * @property string|null $inclusive_years
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Industry|null $industry
 * @property-read \App\Models\Location|null $location
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereInclusiveYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereJobType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment wherePositionTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniPastEmployment withoutTrashed()
 * @mixin \Eloquent
 */
class AlumniPastEmployment extends Model
{
    use HasFactory, SoftDeletes;




    protected $table = 'alumni_past_employment';




    protected $primaryKey = 'id'; // or whatever your PK column is


    protected $fillable = [
        'user_id',
        'company_name',
        'position_title',
        'location_id',
        'industry_id',
        'job_type',
        'inclusive_years',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function industry()
    {
        return $this->belongsTo(\App\Models\Industry::class, 'industry_id', 'industry_id');
    }

    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id', 'location_id');
    }
}
