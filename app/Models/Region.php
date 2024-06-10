<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 */
class Region extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'geom' => 'array',
    ];

    protected $fillable = [
        'name',
        'geom',
        'job_id',
    ];

    public function job()
    {
        return $this->belongsTo(RefreshJob::class);
    }
}
