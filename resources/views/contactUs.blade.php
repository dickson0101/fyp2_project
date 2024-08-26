@extends('layout')

@section('content')
<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: Helvetica, Arial, sans-serif;
    }

    h1 {
        text-transform: uppercase;
        text-align: center;
        color: #666;
        font-weight: lighter;
    }

    .field {
        position: relative;
    }

    .field i {
        position: absolute;
        right: 10px;
        top: 10px;
        display: none;
    }

    form {
        width: 500px;
        margin: 0 auto;
    }

    input, button, textarea {
        position: relative;
        appearance: none;
        margin: 0;
        padding: 10px;
        font-size: 14px;
        margin-bottom: 10px;
        width: 100%;
        border: 1px solid #C7C7C7;
        background-color: #fafafa;
        transition: background-color 0.3s, border-color 0.4s;
    }

    textarea {
        height: 100px;
        resize: none;
    }

    button.contact {
        cursor: pointer;
        display: block;
        border: none;
        background-color: #666;
        color: #fff;
        height: 50px;
        line-height: 50px;
        padding: 0;
        transition: all 0.3s;
        position: relative;
    }

    button:hover {
        background-color: #555;
    }

    button:before,
    button:after {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        line-height: 50px;
        cursor: default;
    }

    button:after {
        top: -100%;
        content: attr(data-success);
        background: #7aca7c;
        color: #358337;
        transform-origin: 0% 100%;
        transform: rotateX(90deg);
    }

    button:before {
        top: 100%;
        background: #e96a6a;
        color: #a33a3a;
        content: attr(data-error);
        transform-origin: 0% 0%;
        transform: rotateX(-90deg);
    }

    button.submit-success {
        background: #aaa;
        transform-origin: 50% 100%;
        transform: rotateX(-90deg) translateY(100%);
    }

    button.submit-error {
        background: #aaa;
        transform-origin: 50% 0%;
        transform: rotateX(90deg) translateY(-100%);
    }

    .success {
        background-color: #EAFFF8;
    }

    .success + i {
        color: #1C9D39;
        display: block;
    }

    .error + i {
        color: #B82020;
        display: block;
    }

    .error {
        background-color: #FFF1FF;
    }

    .container {
        display: flex;
    }

    .sidebar {
        width: 250px;
        background-color: #f4f4f4;
        padding: 20px;
        position: fixed;
        height: 100%;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

   


    .date-container {
        margin-left: 270px;
        padding: 20px;
    }

    .date-label, .date-value {
        margin: 0;
    }

    .content {
        margin-left: 270px;
        padding: 20px;
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
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Log out</button>
        </form>
        <nav class="sidebar-nav">
            <a href="{{ route('homePatient') }}" class="nav-link">Home</a>
            <a href="{{ route('aboutUs') }}" class="nav-link">About Us</a>
            <a href="{{ route('contactUs') }}" class="nav-link active">Contact Us</a>
            <a href="{{ route('F&Q') }}" class="nav-link">F&Q</a>
            <a href="{{ route('feedback') }}" class="nav-link">Feedback</a>
            <a href="{{ route('scheduler') }}" class="nav-link">Account</a>
        </nav>
    </div>

    <div class="date-container">
        <p class="date-label">Today's Date</p>
        <p class="date-value">{{ now()->format('Y-m-d') }}</p>
    </div>

    <div class="content">
        <h1>Contact Us</h1>
        <form action="{{ route('contactUs') }}" method="POST" enctype='multipart/form-data'>
            @csrf
            <div class="field">
                <input type="text" id="name" name="name" placeholder="Your name..">
                <i></i>
            </div>

            <div class="field">
                <input type="text" id="email" name="email" placeholder="Your email..">
                <i></i>
            </div>

            <textarea id="description" name="description" placeholder="Your description.."></textarea>
            <button class="button.contact" data-error="Oops!, Something is wrong" data-success="Success, message sent">Submit</button>
        </form>
    </div>
</div>
@endsection
