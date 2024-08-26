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
            <a href="{{ route('scheduler') }}" class="nav-link">Schedule</a>
            <a href="{{ route('aboutUs') }}" class="nav-link">About Us</a>
            <a href="{{ route('contactUs') }}" class="nav-link">Contact Us</a>
            <a href="{{ route('F&Q') }}" class="nav-link">F&Q</a>
            <a href="{{ route('feedback') }}" class="nav-link">Feedback</a>
            <a href="{{ route('account') }}" class="nav-link">Account</a>
        </nav>
    </div>

    <div class="main-content">
        <h3 class="text-center">Feedback</h3>
        <form action="{{ route('feedback') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" class="form-control" placeholder="Your name..">
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Your last name..">
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Your E-mail..">
            </div>

            <div class="form-group">
                <label for="content">Any issue or problem</label>
                <textarea id="content" name="content" class="form-control" placeholder="Write something.." rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>

<style>
    .sidebar {
        width: 250px;
        background-color: #f8f9fa;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        padding: 20px;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .sidebar-nav a {
        display: block;
        padding: 10px;
        color: #333;
        text-decoration: none;
        margin-bottom: 10px;
    }

    .sidebar-nav a.active,
    .sidebar-nav a:hover {
        background-color: white;
        color: #fff;
    }

    .main-content {
        margin-left: 270px;
        padding: 20px;
    }

    .container {
        border-radius: 5px;
        background-color: #000;
        padding: 20px;
        color: #fff;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #2c2b2b;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 6px;
        resize: vertical;
    }

    .btn-success {
        background-color: #04AA6D;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        padding: 12px 20px;
    }

    .btn-success:hover {
        background-color: #45a049;
    }
</style>

@endsection
