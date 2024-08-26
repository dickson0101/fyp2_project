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
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Log out</button>
        </form>
        <nav class="sidebar-nav">
        <a href="{{ route('nursePage') }}" class="nav-link">Home</a>
            <a href="{{ route('doctorPage') }}" class="nav-link ">Doctors</a>
            <a href="#" class="nav-link">Schedule</a>
            <a href="{{ route('showProduct') }}" class="nav-link ">Mediation</a>
            <a href="{{ route('medications.list') }}" class="nav-link active ">payment</a>
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

        <a href="{{route('medications.list')}}">
           <div class="card">
                <div class="cardName">payment</div>
            
            <div class="iconBx">
                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
            </div>
            </div>
        </a>

        <a href="{{route('showProduct')}}" class="card"> 
            <div>
                <div class="cardName">manage inventory</div>
            </div>
            <div class="iconBx">
                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
            </div>
        </a>
        

    
</div>
<div class="appointments-sessions-grid">
            <div class="appointments-box">
                <h3 class="box-title">Upcoming Appointments</h3>
                <p class="box-description">Here's quick access to upcoming appointments. More details are available in the Appointment section.</p>
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>Doctor Name</th>
                            <th>Appointment Date</th>
                            <th>Appointment Type</th>
                            <th>Time Slot</th>
                            <th>Speciality</th>
                        </tr>
                    </thead>
                    
                </table>
                <button class="show-all-button">Show all Appointments</button>
            </div>
            <div class="sessions-box">
                <h3 class="box-title">Upcoming Sessions until Next Friday</h3>
                <p class="box-description">Here's quick access to upcoming sessions scheduled until 7 days. Add, remove, and more features are available in the @Schedule section.</p>
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
</div>
@endsection