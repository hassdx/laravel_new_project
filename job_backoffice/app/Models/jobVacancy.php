<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class jobVacancy extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'job_vacancies';

    public $keyType = 'string';

    public $incrementing = false;

    public $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'jobCategoryId',
        'companyId',

    ];

    protected $dates = [
        'deleted_at',
    ];

    protected function casts()
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function jobCategory(){
        return $this->belongsTo(JobCategory::class, 'jobCategoryId', 'id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'companyId', 'id');
    }
    public function jobApplications(){
        return $this->hasMany(jobApplication::class, 'jobvacancyId', 'id');
    }


}
