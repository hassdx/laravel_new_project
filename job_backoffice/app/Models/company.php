<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class company extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'companies';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'address',
        'industry',
        'ownerid',
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
        return $this->belongsTo(User::class, 'ownerid', 'id');
    }

    public function jobvacancies(){
        return $this->hasMany(jobVacancy::class, 'categoryId', 'id');
    }

}

