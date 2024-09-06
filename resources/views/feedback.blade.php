@extends('layout')

@section('content')
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
            <a href="{{ route('F&Q') }}" class="nav-link">F&Q</a>
            <a href="{{ route('feedback') }}" class="nav-link active">Feedback</a>
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
    body, h1, h2, h3, p {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
    }

    .container {
        display: flex;
        min-height: 100vh;
        padding: 20px;
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

    .sidebar-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .sidebar-nav a {
        display: block;
        padding: 10px;

        text-decoration: none;
        margin-bottom: 10px;
    }

    .sidebar-nav a.active,
    .sidebar-nav a:hover {
        background-color: #007bff;
        color: white;
        border-radius: 4px;
    }

    .main-content {
        margin-left: 270px; /* Adjusted to make space for the sidebar */
        padding: 20px;
        
    }

    .container {
        border-radius: 5px;
        color: #fff;
    }

    .form-group {
        margin-bottom: 15px;
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
