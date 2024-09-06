@extends('layout')

@section('content')
    <!-- Include Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
            <a href="{{ route('homePatient') }}" class="nav-link active">Home</a>
            <a href="{{ route('aboutUs') }}" class="nav-link">About Us</a>
            <a href="{{ route('contactUs') }}" class="nav-link">Contact Us</a>
            <a href="{{ route('F&Q') }}" class="nav-link">F&Q</a>
            <a href="{{ route('feedback') }}" class="nav-link">Feedback</a>
            <a href="{{ route('account') }}" class="nav-link">Account</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="date-container">
                <p class="date-label">Today's Date</p>
                <p class="date-value">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        <div class="cardBox">
            <a href="{{ route('appointmentPage') }}" class="card">
                <div>
                    <div class="cardName">Make Appointment</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="today-outline"></ion-icon>
                </div>
            </a>

            <a href="{{ route('patient.view.reports') }}" class="card">
                <div>
                    <div class="cardName">View Report</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="document-text-outline"></ion-icon>
                </div>
            </a>

        
        </div>

        <!-- Display Appointment Information -->
        <div class="table-responsive">
            <h2>Your Appointments</h2>
            @if($appointments->isEmpty())
                <p>You have no upcoming appointments.</p>
            @else
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->doctor }}</td>
                                <td>{{ $appointment->appointmentDate }}</td>
                                <td>{{ json_decode($appointment->timeSlot)[0] ?? 'N/A' }}</td>
                                <td>{{ ucfirst($appointment->appointmentType) }}</td>
                                <td>
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
            @endif
        </div>
    </div>
</div>
@endsection
