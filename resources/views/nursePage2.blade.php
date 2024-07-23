@extends('layout')

@section('content')

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
            <a href="#" class="nav-link active">Dashboard</a>
            <a href="{{ route('doctorPage') }}" class="nav-link ">Doctors</a>
            <a href="#" class="nav-link">Schedule</a>
            <a href="#" class="nav-link">Appointment</a>
            <a href="#" class="nav-link">Patients</a>
        </nav>
       
    </div>


<div class="main-content">
    <div class="header">
        <div class="search-container">
            <input type="text" placeholder="Search Doctor name or Email" class="search-input">
            <button class="search-button">Search</button>
        </div>
        <div class="date-container">
            <p class="date-label">Today's Date</p>
            <p class="date-value">{{ now()->format('Y-m-d') }}</p>
        </div>
    </div>

    @csrf
    <div class="cardBox">
    <a href="{{route('appointment')}}" class="card"> 
        <div>
            <div class="cardName">Make Appointment</div>
        </div>
        <div class="iconBx">
            <ion-icon name="today-outline"></ion-icon>
        </div>
    </a>

        <a href="viewReport.html" class="card"> 
            <div>
                <div class="cardName">View Report</div>
            </div>
            <div class="iconBx">
                <ion-icon name="reader-outline"></ion-icon>
            </div>
        </a>

        <a href="{{route('payment')}}">
           <div class="card">
                <div class="cardName">payment</div>
            
            <div class="iconBx">
                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
            </div>
            </div>
        </a>

        <a href="inventory.html" class="card"> 
            <div>
                <div class="cardName">manage inventory</div>
            </div>
            <div class="iconBx">
                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
            </div>
        </a>

        <a href="approved.html" class="card"> 
            <div>
                <div class="cardName">Approve appointment</div>
            </div>
            <div class="iconBx">
                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
            </div>
        </a>
        

    
</div>

    <div class="appointments-sessions-grid">
        <div class="appointments-box">
            <h3 class="box-title">Upcoming Appointments until Next Friday</h3>
            <p class="box-description">Here's Quick access to Upcoming Appointments until 7 days<br>More details available in @Appointment section.</p>
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th>Appointment number</th>
                        <th>Patient name</th>
                        <th>Doctor</th>
                        <th>Session</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add table rows here if needed -->
                </tbody>
            </table>
            <button class="show-all-button">Show all Appointments</button>
        </div>
        <div class="sessions-box">
            <h3 class="box-title">Upcoming Sessions until Next Friday</h3>
            <p class="box-description">Here's Quick access to Upcoming Sessions that Scheduled until 7 days<br>Add,Remove and Many features available in @Schedule section.</p>
            <table class="sessions-table">
                <thead>
                    <tr>
                        <th>Session Title</th>
                        <th>Doctor</th>
                        <th>Scheduled Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add table rows here if needed -->
                </tbody>
            </table>
            <button class="show-all-button">Show all Sessions</button>
        </div>
    </div>
</div>
@endsection
