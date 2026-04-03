<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'days',
        'reason',
        'attachment',
        'status',
        'approved_by',
        'approved_at',
    ];
}
