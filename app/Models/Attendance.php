<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_session_id',
        'term_id',
        'week_id',
        'class_id',
        'stream_id',
        'total_boys',
        'total_girls',
    ];

    protected $table = 'attendances';

    public function yearSession(): BelongsTo
    {
        return $this->belongsTo(YearSession::class);
    }

    /**
     * Get the term that owns the attendance.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Get the week that owns the attendance.
     */
    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }

    
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function streams()
    {
        return $this->belongsTo(Stream::class, 'stream_id');
    }
    

    
}
