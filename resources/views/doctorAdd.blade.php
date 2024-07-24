<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

<style>
body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }
    .main-content {
        background-color: white;
        margin: 0;
        padding: 20px;
        border-radius: 5px;
        width: 100%;
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

    .field{
    position: relative;
}

form{
    width: 90%;
    margin: 0 auto;
}

.from-group,input{
    position: relative;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
    padding: 10px;
    font-size: 14px;
    margin-bottom: 10px;
    width: 100%;
    border: 1px solid #C7C7C7;
    background-color: #fafafa;
    
}


input:focus, textarea:focus, input:hover, textarea:hover{
    outline: none;
    border-color: #777;
}

.btn.doctor-button{
    display: block;
    border: none;
    background-color: #3b82f6;
    color: black ;
    position: relative;
    height: 50px;
    width: 105%;
    line-height: 50px;
    padding: 0;
   
    
}


</style>

</head>

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
            <a href="{{ route('nursePage2') }}" class="nav-link ">Dashboard</a>
            <a href="#" class="nav-link active">Doctors</a>
            <a href="#" class="nav-link">Schedule</a>
            <a href="#" class="nav-link">Appointment</a>
            <a href="#" class="nav-link">Patients</a>
        </nav>
       
    </div>

<div class="main-content">
    <div class="header">
        <button class="btn btn-light">← Back</button>
        
        <div class="date-container">
            <p class="date-label">Today's Date</p>
            <p class="date-value">{{ now()->format('Y-m-d') }}</p>
     </div>
    </div>
<body>
    
    <form action="{{ route('doctorAdd') }}" method="get" enctype="multipart/form-data">
    @csrf
    <h1>Add New Doctor</h1>
    <div class="form-group">
                    <label for="DoctorName">Doctor Name:</label>
                    <input class="form-control" type="text" id="DoctorName" name="DoctorName" required>
                </div>

                <div class="form-group">
                    <label for="DoctorImage">Image</label>
                    <input class="form-control" type="file" id="DoctorImage" name="DoctorImage">
                </div>


                <div class="form-group">
                    <label for="Certificate">Certificate</label>
                    <input class="form-control" type="text" id="Certificate" name="Certificate" required>
                </div>

                <div class="form-group">
                    <label for="Specialist">Specialist</label>
                    <input class="form-control" type="text" id="Specialist" name="Specialist" required>
                </div>

                <div class="form-group">
                    <label for="Telephone">Telephone Number:</label>
                    <input class="form-control" type="text" id="Telephone" name="Telephone" required>
                </div>

                <div class="form-group">
                    <label for="Language">Language</label>
                    <input class="form-control" type="text" id="Language" name="Language" required>
                </div>

                <div class="form-group">
                    <label for="ConsultationDate">Consultation Date:</label>
                    <input class="form-control" type="date" id="ConsultationDate" name="ConsultationDate" required>
                </div>

                <div class="form-group">
                    <label for="ConsultationTime">Consultation Time:</label>
                    <input class="form-control" type="time" id="ConsultationTime" name="ConsultationTime" required>
                </div>

                <button class="btn doctor-button" type="submit" >Add New</button>
            </form>

</body>
</html>