<?php

namespace App\Observers;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    /**
     * Handle the Report "created" event.
     */
    public function creating(Report $report)
    {
        // Temporary debug statement
        \Log::info('Creating report with user_id: ' . Auth::id());
        
        $report->user_id = Auth::id();
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        //
    }
}
