@extends('layout')
@section('content')

<style>
        body, h1, h2, h3, p {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
        }

        .main {
            flex-grow: 1;
            padding: 20px;
        }

        .topbar {
            /* Your topbar styles */
        }

        .faq {
            max-width: 800px;
            margin: 0 auto;
            margin-bottom: 20px; 
        }

        .accordion {
            border: 1px solid #ccc;
            margin-top: 20px;
        }

        .card {
            border-bottom: 1px solid #ccc;
        }

        .card-header {
            background-color: #f5f5f5;
            padding: 10px;
            /* 添加 cursor: pointer; */
            cursor: pointer;
        }

        .card-content {
            padding: 10px;
            display: none;
        }

        .card.active .card-content {
            display: block;
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
        <a href="{{ route('homePatient') }}" class="nav-link ">Home</a>
            <a href="{{ route('aboutUs') }}" class="nav-link">About Us</a>
            <a href="{{ route('contactUs') }}" class="nav-link">Contact Us</a>
            <a href="{{ route('F&Q') }}" class="nav-link active">F&Q</a>
            <a href="{{ route('feedback') }}" class="nav-link">Feeback</a>
            <a href="{{ route('account') }}" class="nav-link">Account</a>
        </nav>
</div>
        <div class="date-container">
            <p class="date-label">Today's Date</p>
            <p class="date-value">{{ now()->format('Y-m-d') }}</p>
        </div>
    
    <br>
    <br>

  <div class="faq" style="margin-bottom: 10px;">

                <h2>Frequently Asked Questions (F&Q)</h2>
                <form action="{{route('F&Q')}}" method="post" enctype='multipart/form-data'>
         @csrf
         <br><br>

                <div class="accordion">
                    <div class="card" onclick="toggleCard(this)">
                        <div class="card-header">
                            <h3>what can i do in this system?
                            </h3>
                        </div>
                        <div class="card-content">
                            <p>booking appoinment,view report</p>
                        </div>
                    </div>

                    <div class="card" onclick="toggleCard(this)">
                        <div class="card-header">
                            <h3>how to book an appointment</h3>
                        </div>
                        <div class="card-content">
                            <p>click the make appointment button,then click add appointment.Next,fill in the information ,click book appointment button 

                            </p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <script>
                function toggleCard(card) {
                    card.classList.toggle('active');
                }
            </script>

            @endsection
  

