<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $id
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereApplicationLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereDatePosted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereJobDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereJobType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereSalaryRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmittedJob whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubmittedJob extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'submitted_jobs';


    protected $fillable = [
        'user_id',
        'job_title',
        'industry_id',
        'company',
        'location',
        'job_type',
        'salary_range',
        'job_description',
        'status',
        'date_posted',
        'application_link',
    ];

    public function industry()
    {
        return $this->belongsTo(\App\Models\Industry::class, 'industry_id', 'industry_id');
    }
}
