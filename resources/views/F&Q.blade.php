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

    .sidebar {
        width: 250px;
        background-color: #f8f9fa;
        height: 100vh;
        padding: 20px;
        position: fixed;
        top: 0;
        left: 0;
    }

    .main {
        margin-left: 250px; /* Adjust based on sidebar width */
        padding: 20px;
        flex-grow: 1;
    }

    .topbar {
        /* Your topbar styles */
    }

    .date-container {
        text-align: right;
        margin-bottom: 20px;
    }

    .faq {
        max-width: 800px;
        margin: 0 auto;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .accordion {
        border: 1px solid #ccc;
    }

    .card {
        border-bottom: 1px solid #ccc;
        cursor: pointer;
        outline: none; /* Remove default outline */
    }

    .card-header {
        background-color: #f5f5f5;
        padding: 10px;
    }

    .card-content {
        padding: 10px;
        display: none;
    }

    .card.active .card-content {
        display: block;
    }

    .card:focus {
        outline: none; /* Remove focus outline */
    }

    .logout-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
    }

    .logout-btn:hover {
        background-color: #0056b3;
    }
</style>


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
            <a href="{{ route('homePatient') }}" class="nav-link">Home</a>
            <a href="{{ route('aboutUs') }}" class="nav-link">About Us</a>
            <a href="{{ route('contactUs') }}" class="nav-link">Contact Us</a>
            <a href="{{ route('F&Q') }}" class="nav-link active">F&Q</a>
            <a href="{{ route('feedback') }}" class="nav-link">Feedback</a>
            <a href="{{ route('account') }}" class="nav-link">Account</a>
        </nav>
    </div>

    <div class="main">
        <div class="date-container">
            <p class="date-label">Today's Date</p>
            <p class="date-value">{{ now()->format('Y-m-d') }}</p>
        </div>

        <div class="faq">
            <h2>Frequently Asked Questions (F&Q)</h2>
            <form action="{{ route('F&Q') }}" method="post" enctype='multipart/form-data'>
                @csrf
                <div class="accordion">
                    <div class="card" onclick="toggleCard(this)">
                        <div class="card-header">
                            <h3>What can I do in this system?</h3>
                        </div>
                        <div class="card-content">
                            <p>Booking appointments, viewing reports.</p>
                        </div>
                    </div>

                    <div class="card" onclick="toggleCard(this)">
                        <div class="card-header">
                            <h3>How to book an appointment?</h3>
                        </div>
                        <div class="card-content">
                            <p>Click the "Make Appointment" button, then click "Add Appointment". Next, fill in the information and click the "Book Appointment" button.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleCard(card) {
        card.classList.toggle('active');
    }
</script>

@endsection
