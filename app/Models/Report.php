<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'user_id', 
        'category', 
        'subject', 
        'summary',
        'file_paths',
    ];

    protected $casts = [
        'file_paths' => 'array', // Cast the 'files' attribute to an array
    ];

    // Relationships

    /**
     * The user who created the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The users who are recipients of the report.
     */
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'report_user', 'report_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Comments associated with the report.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Attached files/documents for the report.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($report) {
            if (request()->hasFile('attachments')) {
                $filePaths = [];
                foreach (request()->file('attachments') as $file) {
                    $path = $file->store('attachments', 'public');
                    $filePaths[] = $path;
                }
                $report->update([
                    'file_paths' => $filePaths,
                ]);
            }
        });
    }


    
}
