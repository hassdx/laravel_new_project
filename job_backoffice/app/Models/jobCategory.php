<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class jobCategory extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'job_categories';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
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
        return $this->hasMany(jobVacancy::class, 'categoryId', 'id');
    }

}
