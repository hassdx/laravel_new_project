<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class jobApplication extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'job_applications';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'jobVacancyId',
        'userId',
        'resumeId',
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

    public function jobvacancies(){
        return $this->belongsTo(jobVacancy::class, 'jobvacancyId', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function resume(){
        return $this->belongsTo(Resume::class, 'resumeId', 'id');
    }

}
