@extends('layout')
@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }
    .main-content {
        background-color: white;
        margin: 0;
        padding: 20px;
        border-radius: 5px;
        width: 100%;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .search-bar {
        display: flex;
        gap: 10px;
    }
    .search-bar input {
        padding: 5px 10px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }
    .btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 15px;
        cursor: pointer;
        border-radius: 3px;
    }
    .btn-light {
        background-color: #f8f9fa;
        color: #007bff;
        border: 1px solid #007bff;
    }
    .date-display {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    h1 {
        margin-bottom: 10px;
    }
    .add-new {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
    th {
        background-color: #f8f9fa;
    }
    .action-btn {
        background: none;
        border: none;
        color: #007bff;
        cursor: pointer;
        padding: 0 5px;
    }
    .doctor-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    .doctor-card img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 15px;
    }
    .table-container {
        max-height: 400px; /* Set maximum height */
        overflow-y: auto; /* Enable vertical scroll */
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }

    .doctor-button {
        background-color: yellow; /* Yellow background color */
        color: black; /* Black text color for better contrast */
        border: 1px solid #ccc; /* Optional: border to match existing style */
        padding: 10px 20px; /* Adjust padding as needed */
        border-radius: 5px; /* Optional: rounded corners */
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .doctor-button:hover {
        background-color: #f0e68c; /* Lighter yellow on hover */
    }
</style>

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
            <a href="#" class="nav-link active">Doctors</a>
            <a href="#" class="nav-link">Schedule</a>
            <a href="#" class="nav-link">Appointment</a>
            <a href="#" class="nav-link">Patients</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <a href="{{ route('nursePage') }}">
                <button class="btn btn-light">← Back</button>
            </a>

            <div class="search-bar">
                <input type="text" placeholder="Search Doctor name or Email" class="search-input">
                <a href="{{ route('searchDoctor') }}" class="btn btn-light">Search</a>
            </div>
            <div class="date-container">
                <p class="date-label">Today's Date</p>
                <p class="date-value">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        @csrf

        <h1>Add New Doctor</h1>

        <div class="add-new">
            <a href="{{ route('doctorAdd') }}" class="btn">+ Add New</a>
        </div>

        <h2>All Doctors ({{ $doctors->count() }})</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Doctor Name</th>
                        <th>Specialties</th>
                        <th>Telephone</th>
                        <th>Language</th>
                        <th>Events</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr>
                            <td>
                                <div class="doctor-card" data-doctor-id="{{ $doctor->id }}">
                                    <img src="{{ url('images/'.$doctor->image) }}" alt="{{ $doctor->name }}">
                                </div>
                            </td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->specialist }}</td>
                            <td>{{ $doctor->telephone }}</td>
                            <td>{{ $doctor->language }}</td>
                            <td>
                                <a href="{{ route('doctorEdit', ['id' => $doctor->id]) }}" class="doctor-button">Edit</a>
                                <br><br>
                                <a href="{{ route('deleteDoctor', ['id' => $doctor->id]) }}" class="btn btn-danger btn-xs">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
