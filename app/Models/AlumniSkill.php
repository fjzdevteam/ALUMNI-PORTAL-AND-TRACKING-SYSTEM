<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $user_id
 * @property int|null $skill_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Skill|null $skill
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill whereSkillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AlumniSkill withoutTrashed()
 * @mixin \Eloquent
 */

class AlumniSkill extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alumni_skill';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'skill_id',
        'created_at',
        'updated_at',
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
