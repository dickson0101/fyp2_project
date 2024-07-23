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
            <a href="{{ route('nursePage2') }}" class="nav-link ">Dashboard</a>
            <a href="#" class="nav-link active">Doctors</a>
            <a href="#" class="nav-link">Schedule</a>
            <a href="#" class="nav-link">Appointment</a>
            <a href="#" class="nav-link">Patients</a>
        </nav>
       
    </div>

<div class="main-content">
    <div class="header">
        <button class="btn btn-light">← Back</button>
        
        <div class="search-bar">
            <input type="text" placeholder="Search Doctor name or Email" class="search-input">
            <button class="search-button">Search</button>
        </div>
        <div class="date-container">
            <p class="date-label">Today's Date</p>
            <p class="date-value">{{ now()->format('Y-m-d') }}</p>
     </div>
    </div>

    @csrf
    
    <h1>Add New Doctor</h1>
    
    <div class="add-new">
        <button class="btn">+ Add New</button>
    </div>
    
    <h2>All Doctors (1)</h2>
    
    <table>
        <thead>
            <tr>
                <th>Doctor Name</th>
                <th>Email</th>
                <th>Specialties</th>
                <th>Events</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Test Doctor</td>
                <td>doctor@edoc.com</td>
                <td>Accident and emergen</td>
                <td>
                    <button class="action-btn">✏️ Edit</button>
                    <button class="action-btn">👁️ View</button>
                    <button class="action-btn">🗑️ Remove</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
