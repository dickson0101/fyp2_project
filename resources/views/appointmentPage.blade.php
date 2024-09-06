<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medications List</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
        }
        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .main-content {
            margin-left: 250px; /* Adjust margin to account for the sidebar width */
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .date-container {
            text-align: right;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .text-center {
            text-align: center;
        }
        .add-new {
            text-align: right; /* Aligns the button to the right */
        }
        .add-new .btn {
            background-color: #007bff; /* Blue background color */
            color: white; /* White text color */
            border-color: #007bff; /* Matching border color */
        }
        .add-new .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #004085; /* Matching border color on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="profile-pic"></div>
                <div>
                    <h2 class="username">{{ Auth::user()->name }}</h2>
                    <p class="email">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('logout2') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Log out</button>
            </form>
            <nav class="sidebar-nav">
                <a href="{{ route('homePatient') }}" class="nav-link">Home</a>
                <a href="{{ route('doctorPage') }}" class="nav-link ">Doctors</a>
                <a href="{{ route('appointmentPage') }}" class="nav-link active">Appointment</a>
                <a href="{{ route('account') }}" class="nav-link">Account</a>
            </nav>
        </div>

        <div class="main-content">
            <div class="header">
                <a href="{{ route('homePatient') }}">
                    <button class="btn btn-light">← Back</button>
                </a>

                <div class="date-container">
                    <p class="date-label">Today's Date</p>
                    <p class="date-value">{{ now()->format('Y-m-d') }}</p>
                </div>
            </div>

            @csrf
            <h1>Appointments</h1>

            <div class="add-new">
                <a href="{{ route('appointment') }}" class="btn">+ Add New</a>
            </div>

            <h2>All Appointments ({{ $appointments->count() }})</h2><br>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Doctor Name</th>
                            <th>Appointment Date</th>
                            <th>Time Slot</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->doctor }}</td>
                            <td>{{ $appointment->appointmentDate }}</td>
                            <td>
                                @php
                                    // Decode timeSlot field
                                    $timeSlots = json_decode($appointment->timeSlot, true);
                                    // Check if it's an array before using implode
                                    if (is_array($timeSlots)) {
                                        echo implode(', ', $timeSlots);
                                    } else {
                                        echo 'N/A';
                                    }
                                @endphp
                            </td>
                            <td>{{ $appointment->appointmentType }}</td>
                            <td>
                                <!-- Edit button -->
                                <a href="{{ route('appointmentEdit', ['id' => $appointment->id]) }}" class="btn btn-warning btn-xs">Edit</a>
                                <br><br>
                                <!-- Delete button -->
                                <form action="{{ route('deleteAppointment', ['id' => $appointment->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
