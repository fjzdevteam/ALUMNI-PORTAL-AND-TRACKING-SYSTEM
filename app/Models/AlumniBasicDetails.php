<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; // ✅ add this
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;


/**
 * @property int $alumni_id
 * @property int $user_id
 * @property string $employment_status
 * @property string $birthdate
 * @property string $sex
 * @property string|null $civil_status
 * @property string|null $mobile_number
 * @property string|null $address
 * @property string|null $about
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\AlumniInformation $alumni
 * @property-read mixed $age
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereAlumniId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereEmploymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniBasicDetails withoutTrashed()
 * @mixin \Eloquent
 */
class AlumniBasicDetails extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'alumni_basic_details';
    protected $primaryKey = 'alumni_id';
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'user_id',
        'employment_status',
        'birthdate',
        'sex',
        'civil_status',
        'mobile_number',
        'address',
        'about',
    ];


    // Belongs to one alumni record
    public function alumni()
    {
        return $this->belongsTo(AlumniInformation::class, 'user_id', 'id');
    }


    // ✅ Belongs to one user (to get email)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getAgeAttribute()
    {
        return $this->birthdate ? Carbon::parse($this->birthdate)->age : null;
    }
}
