<!DOCTYPE html>
<html>
<head>
    <title>Event List</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>MASJID AL-AMEEN ACADEMY - CALENDAR OF EVENTS | TERM 1 2025</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Active</th>
                <th>In-Charge</th>
                <th>Term</th>
                <th>Event Week</th>
                <th>Branch</th>
                <th>Assigned Classes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $index => $event)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->description }}</td>
                    <td>{{ $event->start_date }}</td>
                    <td>{{ $event->end_date }}</td>
                    <td>{{ $event->status }}</td>
                    <td>{{ $event->is_active ? 'Yes' : 'No' }}</td>
                    <td>{{ $event->in_charge }}</td>
                    <td>{{ $event->term }}</td>
                    <td>{{ $event->event_week }}</td>
                    <td>{{ $event->branch }}</td>
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
