<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CooperativeRequest extends Model
{
    protected $fillable = [
        'user_id',
        'cooperative_name',
        'cooperative_type',
        'initial_members',
        'objective',
        'address',
        'status',
        'reviewed_by',
        'review_note',
        'reviewed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}