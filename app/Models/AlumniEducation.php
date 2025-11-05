<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $education_id
 * @property int $user_id
 * @property string|null $student_number
 * @property int|null $course_id
 * @property string|null $year_graduated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\AlumniInformation $alumni
 * @property-read \App\Models\Course|null $course
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation whereEducationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation whereStudentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation whereYearGraduated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniEducation withoutTrashed()
 * @mixin \Eloquent
 */
class AlumniEducation extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'alumni_education';
    protected $primaryKey = 'education_id';
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'user_id',
        'student_number',
        'course_id',
        'year_graduated',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
