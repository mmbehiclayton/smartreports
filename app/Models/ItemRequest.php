<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use EightyNine\Approvals\Models\ApprovableModel;

class ItemRequest extends ApprovableModel
{
    use HasFactory;

    protected $fillable =[
        'department_id',
        'year_session_id',
        'term_id',
        'week_id',
        'item_name',
        'description',
        'estimate_cost',
        'remarks',
        'user_id',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function year_session(): BelongsTo
    {
        return $this->belongsTo(YearSession::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function recipients()
    {
        return $this->belongsToMany(User::class, 'request_user', 'item_request_id', 'user_id');
    }
}
