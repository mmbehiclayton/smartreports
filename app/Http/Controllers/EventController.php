<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function generatePDF()
    {
        $events = Event::all(); // Fetch all events

        //$pdf = Pdf::loadView('pdf.events', compact('events'));
        $pdf = Pdf::loadView('pdf.events', compact('events'))->setPaper('a4', 'landscape');

        return $pdf->stream('events.pdf'); // View in browser instead of download
    }
}
