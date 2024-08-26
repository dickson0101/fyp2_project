@extends('layout')

@section('content')
<style>
    /* Add styles */
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    th {
        background-color: #f4f4f4;
    }
    td {
        height: 50px;
        vertical-align: top;
    }
    .booked {
        background-color: #ffcccc;
    }
</style>

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="container">
    
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="profile-pic"></div>
            <div>
                <h2 class="username">Administrator</h2>
                <p class="email">admin@edoc.com</p>
            </div>
        </div>
        <button class="logout-btn">Log out</button>
        <nav class="sidebar-nav">
            <a href="{{ route('nursePage') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('scheduler') }}" class="nav-link active">Schedule</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="date-container">
                <p class="date-label">Today's Date</p>
                <p class="date-value">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        @csrf
        
        <h1>Scheduler</h1>

        <div id="calendar"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
    const calendar = document.getElementById('calendar');
    const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const timeSlots = Array.from({length: 17}, (_, i) => {
        const hour = Math.floor(i / 2) + 9;
        const minute = (i % 2) * 30;
        return `${hour}:${minute.toString().padStart(2, '0')}`;
    }); // 9 AM to 5 PM in 30-minute increments

    // Create calendar header
    let html = '<table><thead><tr>';
    html += '<th>Time</th>';
    daysOfWeek.forEach(day => html += `<th>${day}</th>`);
    html += '</tr></thead><tbody>';

    // Create time slots
    timeSlots.forEach(timeSlot => {
        html += `<tr><td>${timeSlot}</td>`;
        daysOfWeek.forEach(() => {
            html += `<td></td>`;
        });
        html += '</tr>';
    });

    html += '</tbody></table>';
    calendar.innerHTML = html;

    // Populate calendar with data from database
    const appointments = @json($appointments); // Replace with your actual data
    const doctors = @json($doctors); // Replace with your actual data

    appointments.forEach(appointment => {
        const { appointment_date, time_slot, doctor_id } = appointment;
        const doctor = doctors.find(doc => doc.id === doctor_id);
        if (doctor) {
            const date = new Date(appointment_date);
            const dayIndex = date.getDay(); // Get day index (0 = Sunday)
            time_slot.forEach(slot => {
                const timeIndex = timeSlots.indexOf(slot);
                if (dayIndex >= 0 && timeIndex >= 0) {
                    const cell = calendar.querySelector(`tbody tr:nth-child(${timeIndex + 1}) td:nth-child(${dayIndex + 2})`);
                    if (cell) {
                        cell.innerHTML = `${doctor.name}<br>${doctor.specialist}`;
                        cell.classList.add('booked');
                    }
                }
            });
        }
    });
});

@endsection
