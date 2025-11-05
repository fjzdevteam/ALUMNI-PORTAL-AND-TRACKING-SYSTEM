<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


/**
 * @property int $graduate_id
 * @property int $user_id
 * @property string|null $level
 * @property string|null $degree_title
 * @property string|null $school
 * @property string|null $inclusive_years
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation whereDegreeTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation whereGraduateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation whereInclusiveYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniGraduateEducation whereUserId($value)
 * @mixin \Eloquent
 */
class AlumniGraduateEducation extends Model
{
    protected $table = 'alumni_graduate_education';
    protected $primaryKey = 'graduate_id';


    protected $fillable = [
        'user_id',
        'level',
        'degree_title',
        'school',
        'inclusive_years',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
