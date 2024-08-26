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
        <a href="{{ route('homeDoctor') }}" class="nav-link active">Home</a>
            
            <a href="#" class="nav-link">Schedule</a>

            
            
            
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
    

        <a href="{{route('pdf.index')}}" class="card"> 
            <div>
                <div class="cardName">Write Report</div>
            </div>
            <div class="iconBx">
                <ion-icon name="reader-outline"></ion-icon>
            </div>
        </a>

        <a href="{{route('videoindex')}}">
           <div class="card">
                <div class="cardName">video</div>
            
            <div class="iconBx">
                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
            </div>
            </div>
        </a>

        <a href="{{route('medications.list')}}">
           <div class="card">
                <div class="cardName">Add Medication</div>
            
            <div class="iconBx">
                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
            </div>
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
                    <tbody>
                        
                    </tbody>
                </table>
                <button class="show-all-button">Show all Appointments</button>
            </div>
           
        </div>
    </div>
</div>
@endsection