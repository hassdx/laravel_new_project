<?php

namespace App\Models;

use Faker\Provider\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class jobVacancy extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'jobVacancies';

    public $keyType = 'string';

    public $incrementing = false;

    public $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'jobCategory',
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
    public function jobapplications(){
        return $this->hasMany(jobApplication::class, 'jobvacancyId', 'id');
    }


}
