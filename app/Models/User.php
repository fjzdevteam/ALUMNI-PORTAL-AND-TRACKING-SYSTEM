<?php


namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\AlumniEducation;


/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $suffix
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $role
 * @property string $status
 * @property string|null $image_path
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\AlumniBasicDetails|null $basicDetails
 * @property-read AlumniEducation|null $education
 * @property-read \App\Models\AlumniGraduateEducation|null $educationDoctoral
 * @property-read \App\Models\AlumniGraduateEducation|null $educationMasteral
 * @property-read \App\Models\AlumniCurrentEmployment|null $employment
 * @property-read \App\Models\AlumniFirstEmployment|null $firstEmployment
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AlumniPastEmployment> $pastEmployment
 * @property-read int|null $past_employment_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AlumniSkill> $skills
 * @property-read int|null $skills_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;


    protected $dates = ['deleted_at']; // optional but good practice


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'email',
        'email_verified_at',
        'role',
        'status',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function basicDetails()
    {
        return $this->hasOne(AlumniBasicDetails::class, 'user_id');
    }

    public function education()
    {
        return $this->hasOne(AlumniEducation::class, 'user_id', 'id');
    }

    public function educationMasteral()
    {
        return $this->hasOne(AlumniGraduateEducation::class, 'user_id', 'id')->where('level', 'masteral');
    }

    public function educationDoctoral()
    {
        return $this->hasOne(AlumniGraduateEducation::class, 'user_id', 'id')->where('level', 'doctoral');
    }

    public function firstEmployment()
    {
        return $this->hasOne(AlumniFirstEmployment::class, 'user_id');
    }

    public function currentEmployment()
    {
        return $this->hasOne(AlumniCurrentEmployment::class, 'user_id');
    }

    public function pastEmployment()
    {
        return $this->hasOne(AlumniPastEmployment::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function graduateEducation()
    {
        return $this->hasMany(AlumniGraduateEducation::class, 'user_id', 'id');
    }

    public function alumniDetail()
    {
        return $this->hasOne(AlumniBasicDetails::class, 'alumni_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'alumni_skill', 'user_id', 'skill_id');
    }

    public function forumPosts()
    {
        return $this->hasMany(Forum::class, 'user_id');
    }

    public function getFullNameAttribute()
    {
        $suffix = '';

        if ($this->suffix) {
            $normalized = strtolower(trim($this->suffix));

            $commonSuffixes = ['jr', 'sr', 'ii', 'iii', 'iv', 'v'];

            if (in_array($normalized, $commonSuffixes)) {
                $suffix = ' ' . strtoupper($normalized);
            } else {
                $suffix = ' ' . ucfirst($this->suffix);
            }
        }

        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}{$suffix}");
    }
}
