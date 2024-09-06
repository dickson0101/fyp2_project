<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f8f9fa;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .profile {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e0e0e0;
            margin-right: 10px;
        }

        .profile-info h3 {
            margin: 0;
            font-size: 16px;
        }

        .profile-info p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .logout-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .nav-menu {
            list-style-type: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #007bff;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .main-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            display: flex;
            gap: 10px;
        }

        .search-bar input {
            padding: 5px 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 15px;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn-light {
            background-color: #f8f9fa;
            color: #007bff;
            border: 1px solid #007bff;
        }

        .date-display {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .add-new {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        .action-btn {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            padding: 0 5px;
        }

        .doctor-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .doctor-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 15px;
        }

        .table-container {
            max-height: 400px; /* Set maximum height */
            overflow-y: auto; /* Enable vertical scroll */
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }

        .doctor-button {
            background-color: yellow; /* Yellow background color */
            color: black; /* Black text color for better contrast */
            border: 1px solid #ccc; /* Optional: border to match existing style */
            padding: 10px 20px; /* Adjust padding as needed */
            border-radius: 5px; /* Optional: rounded corners */
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .doctor-button:hover {
            background-color: #f0e68c; /* Lighter yellow on hover */
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="profile">
            <div class="profile-pic"></div>
            <div class="profile-info">
            <h2 class="username">{{ Auth::user()->name }}</h2>
            <p class="email">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <form action="{{ route('logout2') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Log out</button>
        </form>
        
        <ul class="nav-menu">
        <a href="{{ route('nursePage') }}" class="nav-link">Home</a>
            <a href="{{ route('doctorPage') }}" class="nav-link active ">Doctors</a>
            <a href="{{ route('appointmentPage') }}" class="nav-link">Appointment</a>
           
            <a href="{{ route('account') }}" class="nav-link">Account</a>
        </ul>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="header">
                
                <div class="btn-toolbar">
                <a href="{{ route('homeDoctor') }}"> 
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        ← Back
                    </button></a>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                 
                <div class="date-container">
                <p class="date-label">Today's Date</p>
                <p class="date-value">{{ now()->format('Y-m-d') }}</p>
            </div>
                </div>
            </div>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h2>All Doctors</h2>
                <a href="{{ route('doctorAdd') }}" class="btn btn-primary">+ Add New</a>
            </div>

            <div class="table-container">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Doctor Name</th>
                            <th>Specialties</th>
                            <th>Telephone</th>
                            <th>Language</th>
                            <th>Events</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($doctors as $doctor)
                        <tr>
                            <td>
                                <div class="doctor-card" data-doctor-id="{{ $doctor->id }}">
                                    <img src="{{ url('images/'.$doctor->image) }}" alt="{{ $doctor->name }}">
                                </div>
                            </td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->specialist }}</td>
                            <td>{{ $doctor->telephone }}</td>
                            <td>{{ $doctor->language }}</td>
                            <td>
                                <a href="{{ route('doctorEdit', ['id' => $doctor->id]) }}" class="doctor-button">Edit</a>
                                <a href="{{ route('deleteDoctor', ['id' => $doctor->id]) }}" class="btn btn-danger btn-xs">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
