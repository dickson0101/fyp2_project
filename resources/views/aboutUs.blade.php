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
        <a href="{{ route('homePatient') }}" class="nav-link">Home</a>
            <a href="{{ route('aboutUs') }}" class="nav-link active">About Us</a>
            <a href="{{ route('contactUs') }}" class="nav-link">Contact Us</a>
            <a href="{{ route('F&Q') }}" class="nav-link">F&Q</a>
            <a href="{{ route('feedback') }}" class="nav-link">Feeback</a>
            <a href="{{ route('account') }}" class="nav-link">Account</a>
        </nav>
        
        <div class="date-container">
            <p class="date-label">Today's Date</p>
            <p class="date-value">{{ now()->format('Y-m-d') }}</p>
        </div>
    </div>
    <br>
    <br>
    <br>

    <div class="container-fluid background_bg" style="color: white;">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6 form-container" style="margin-top: 30px;">
                
                <form action="{{route('aboutUs')}}" method="post" enctype='multipart/form-data'>
                    @csrf

                    <h6 style="font-size: 2em;color: black; text-align: center;" class="card-title">About us</h6><br><br>
                             </h6><br>
                             <div style="font-size: 1em; color: black; text-align: center;">
                             This medical system is a web-based system that allows users to
                                     schedule medical appointments online. <br><br>
                                     We use an iterative model to develop this medical system.  <br><br>
                                     There are five subsystems in the system.Firstly, there is the account information management system, <br><br>
                                      which is used to manage the information of all users and doctor. <br><br>
                                     Secondly, there is the patient case  management system, which allows doctors to create patient case content and prescribe 
                                      medications. <br><br>
                                       Thirdly, there is the appointment system, where users can schedule appointments. The fourth subsystem is the <br><br>
                                      payment management system, which allows users to pay for appointment fees. Finally, there is the medication management system,<br><br>
                                       where doctors and nurses can manage their medications.
        
        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
