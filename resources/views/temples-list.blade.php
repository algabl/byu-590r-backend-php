<div>
    <h1>Temples List</h1>
    <p>Here is the list of temples:</p>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Location</th>
                <th>Status</th>
                <th>Walk Score</th>
                <th>Bike Score</th>
                <th>Transit Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($temples as $temple)
                <tr>
                    <td>
                        @if ($temple->temple_image)
                            <img src="{{ $temple->temple_image }}" alt="{{ $temple->name }}">
                        @else
                            <p>No Image</p>
                        @endif
                    </td>
                    <td>{{ $temple->name }}</td>
                    <td>{{ $temple->location }}</td>
                    <td>{{ $temple->status }}</td>
                    <td>{{ $temple->walk_score }}</td>
                    <td>{{ $temple->bike_score }}</td>
                    <td>{{ $temple->transit_score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>If you have any questions, feel free to reach out!</p>
    <p>Best regards,</p>
    <p>Your Team</p>
    <p>Note: This is an automated message, please do not reply.</p>
    <p>For more information, visit our <a href="{{ url('/temples') }}">website</a>.</p>
</div>