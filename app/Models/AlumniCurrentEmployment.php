<?php




namespace App\Models;




use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




/**
 * @property int $id
 * @property int $user_id
 * @property string|null $company_name
 * @property string|null $position_title
 * @property int|null $location_id
 * @property int|null $industry_id
 * @property string|null $job_type
 * @property string|null $start_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\AlumniInformation $alumni
 * @property-read \App\Models\Industry|null $industry
 * @property-read \App\Models\Location|null $location
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereJobType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment wherePositionTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniCurrentEmployment whereUserId($value)
 * @mixin \Eloquent
 */
class AlumniCurrentEmployment extends Model
{
    use HasFactory;




    protected $table = 'alumni_current_employment';
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
        'job_type',
        'start_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'industry_id');
    }


    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }
}
