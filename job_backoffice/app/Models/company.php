<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class company extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'companies';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'ownerId',
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

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId', 'id');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'companyId', 'id'); 
    }

    public function jobApplications()
    {
        return $this->hasManyThrough(JobApplication::class, JobVacancy::class, 'companyId', 'id'); 
    }
}
