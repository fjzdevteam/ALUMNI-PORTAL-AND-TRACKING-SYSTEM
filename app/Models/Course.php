<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $course_id
 * @property int|null $department_id
 * @property string|null $course_code
 * @property string $course_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AlumniEducation> $alumniEducations
 * @property-read int|null $alumni_educations_count
 * @property-read \App\Models\College|null $college
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCourseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCourseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'course_id';

    protected $table = 'courses';

    protected $fillable = [
        'department_id',
        'course_code',
        'course_name',
    ];


    public function college()
    {
        return $this->belongsTo(College::class, 'department_id', 'department_id');
    }

    public function alumniEducations()
    {
        return $this->hasMany(AlumniEducation::class, 'course_id');
    }
}
