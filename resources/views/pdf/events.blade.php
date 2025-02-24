<!DOCTYPE html>
<html>
<head>
    <title>Calendar of Events</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: auto; /* Auto-adjust column widths */
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left; /* Align text to the left */
            vertical-align: top; /* Align content to the top */
        }
        th {
            background-color: #f2f2f2;
            white-space: nowrap; /* Prevents headers from wrapping */
        }
        td {
            word-wrap: break-word; /* Ensures long text wraps */
        }
    </style>
</head>
<body>
    <h2>MASJID AL-AMEEN ACADEMY - CALENDAR OF EVENTS | TERM 1 2025</h2>
    <h3>GRADE 6 & 9 CALENDER OF EVENTS</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Term</th>
                <th>Week</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>In-Charge</th>
                <th>Classes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $index => $event)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $event->term->name ?? 'N/A' }}</td>
                    <td>{{ $event->week->name }}</td>
                    <td>{{ $event->week->start_date ?? 'N/A' }}</td>
                    <td>{{ $event->week->end_date ?? 'N/A' }}</td>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->event_date }}</td>
                    <td>{{ $event->in_charge }}</td>
                    <td>
                        @if ($event->classes->isNotEmpty())
                            {{ $event->classes->pluck('name')->join(', ') }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
