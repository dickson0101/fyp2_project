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
            
                <a href="{{ route('nursePage') }}" class="nav-link active">Home</a>
                <a href="{{ route('doctorPage') }}" class="nav-link">Doctors</a>
                <a href="{{ route('appointmentPage') }}" class="nav-link">Appointment</a>
            
            
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

            <a href="{{ route('nurseReport') }}" class="card"> 
                <div>
                    <div class="cardName">View Report</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="reader-outline"></ion-icon>
                </div>
            </a>

            
                <a href="{{ route('nurseList') }}" class="card"> 
                    <div>
                        <div class="cardName">Payment</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
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

        <a href="{{route('doctorPage')}}" class="card"> 
            <div>
                <div class="cardName">manage doctor</div>
            </div>
            <div class="iconBx">
                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
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
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                           @php
                                $patientName = App\Models\User::find($appointment->patient_id)->name ?? 'N/A';
                            @endphp
                            <tr>
                                <td>{{ $patientName }}</td>
                            <td>{{$appointment->doctor}}</td>
                                <td>{{ $appointment->appointmentDate }}</td>
                                <td>{{ json_decode($appointment->timeSlot)[0] ?? 'N/A' }}</td>
                                <td>{{ ucfirst($appointment->appointmentType) }}</td>
                                <td>
                                    <a href="{{ route('appointmentEdit', ['id' => $appointment->id]) }}" class="btn btn-warning btn-xs">Edit</a>
                                    <form action="{{ route('deleteAppointment', ['id' => $appointment->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">Delete</button>
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
