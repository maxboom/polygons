<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 */
class RefreshJob extends Model
{
    use HasFactory;

    public const STATUS_CREATED = 0;
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_FINISHED = 2;

    protected $appends = ['createdTs', 'sheduledForTs'];

    protected $hidden = ['id', 'created_at', 'updated_at', 'sheduled_for_ts'];

    protected $fillable = [
        'sheduled_for_ts',
        'status',
    ];

    public function getCreatedTsAttribute()
    {
        return $this->getAttribute('created_at')->getTimestamp();
    }

    public function getSheduledForTsAttribute()
    {
        return Carbon::parse($this->attributes['sheduled_for_ts'])->getTimestamp();
    }



}
