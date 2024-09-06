@extends('layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

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
        <a href="{{ route('homeDoctor') }}" class="nav-link active">Home</a>
            <a href="{{ route('doctorAccount') }}" class="nav-link">account</a>
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
            <a href="{{route('select.patient')}}" class="card"> 
                <div>
                    <div class="cardName">Write Report</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="reader-outline"></ion-icon>
                </div>
            </a>

            <a href="{{route('video')}}">
               <div class="card">
                    <div class="cardName">video</div>
                <div class="iconBx">
                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                </div>
                </div>
            </a>

            <a href="{{route('reportView')}}">
               <div class="card">
                    <div class="cardName">manage report</div>
                <div class="iconBx">
                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                </div>
                </div>
            </a>
        </div>

        <div class="table-responsive">
            <h2>Patient Appointments</h2>
            @if($appointments->isEmpty())
                <p>No upcoming appointments.</p>
            @else
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Type</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            @php
                                $patientName = App\Models\User::find($appointment->patient_id)->name ?? 'N/A';
                            @endphp
                            <tr>
                                <td>{{ $patientName }}</td>
                                <td>{{ $appointment->appointmentDate }}</td>
                                <td>{{ json_decode($appointment->timeSlot)[0] ?? 'N/A' }}</td>
                                <td>{{ ucfirst($appointment->appointmentType) }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection