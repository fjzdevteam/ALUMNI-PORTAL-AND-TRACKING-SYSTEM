<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $department_id
 * @property string|null $department_code
 * @property string $department_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $courses
 * @property-read int|null $courses_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|College newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|College newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|College query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|College whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|College whereDepartmentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|College whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|College whereDepartmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|College whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class College extends Model
{
    use HasFactory;

    protected $primaryKey = 'department_id';

    protected $table = 'colleges';

    protected $fillable = [
        'department_code',
        'department_name',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id');
    }
}
