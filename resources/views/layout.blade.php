<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Administrator Dashboard</title>
</head>
<body>
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
                <a href="#" class="nav-link active">Dashboard</a>
                <a href="#" class="nav-link">Doctors</a>
                <a href="#" class="nav-link">Schedule</a>
                <a href="#" class="nav-link">Appointment</a>
                <a href="#" class="nav-link">Patients</a>
            </nav>
           
        </div>
        @yield('content')
    </div>
    
</body>
</html>
