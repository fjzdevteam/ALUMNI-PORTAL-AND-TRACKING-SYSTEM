<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $job_id
 * @property string $job_title
 * @property int|null $industry_id
 * @property string $company
 * @property string $location
 * @property string $job_type
 * @property string|null $salary_range
 * @property string|null $job_description
 * @property string $status
 * @property string $date_posted
 * @property string|null $application_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Industry|null $industry
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Skill> $skills
 * @property-read int|null $skills_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereApplicationLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereDatePosted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereJobDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereJobType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereSalaryRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class JobDetail extends Model
{
    use HasFactory;


    protected $primaryKey = 'job_id';
    protected $table = 'job_details';


    protected $fillable = [
        'job_title',
        'industry_id',
        'company',
        'location',
        'job_type',
        'salary_range',
        'job_description',
        'status',
        'date_posted',
        'application_link'
    ];


    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'industry_id');
    }


    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill', 'job_id', 'skill_id');
    }
}
