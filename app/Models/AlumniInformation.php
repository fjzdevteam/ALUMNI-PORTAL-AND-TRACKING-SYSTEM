<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $suffix
 * @property string $sex
 * @property int|null $course_id
 * @property string $birthdate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AlumniBasicDetails|null $basicDetails
 * @property-read \App\Models\AlumniEducation|null $education
 * @property-read \App\Models\AlumniCurrentEmployment|null $employment
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniInformation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AlumniInformation extends Model
{
    use HasFactory;


    protected $table = 'alumni_information';


    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'sex',
        'course_id',
        'birthdate',
    ];


    // ✅ One alumnus has one basic details record
    public function basicDetails()
    {
        return $this->hasOne(AlumniBasicDetails::class, 'user_id', 'id');
    }


    // ✅ One alumnus has one education record
    public function education()
    {
        return $this->hasOne(AlumniEducation::class, 'user_id', 'id');
    }


    // ✅ One alumnus has one current employment record
    public function employment()
    {
        return $this->hasOne(AlumniCurrentEmployment::class, 'user_id', 'id');
    }
}
