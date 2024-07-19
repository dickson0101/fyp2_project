<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .header {
            background-image: url('https://via.placeholder.com/1500x200');
            background-size: cover;
            color: white;
            padding: 20px;
            text-align: left;
        }
        .breadcrumb {
            font-size: 14px;
            margin-top: 10px;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
        }
        .main-content {
            width: 100%;
        }
        .form-content {
            display: flex;
            justify-content: space-between;
        }
        .steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .step {
            width: 30%;
            text-align: center;
        }
        .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #ccc;
            color: white;
            line-height: 30px;
            margin-bottom: 10px;
        }
        .step.active .step-number {
            background-color: #007bff;
        }
        .form-section {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="radio"] {
            margin-right: 5px;
        }
        .form-group select, .form-group input[type="date"] {
            width: 100%;
            padding: 5px;
        }

        .field{
            position: relative;
        }

        form{
            width: 100%;
        }

        input, button, textarea{
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
            -webkit-transition: background-color .3s, border-color .4s;
            -moz-transition: background-color .3s, border-color .4s;
            -o-transition: background-color .3s, border-color .4s;
            transition: background-color .3s, border-color .4s;
        }

        .name-fields, .address-fields, .location-fields {
            display: flex;
            justify-content: space-between;
        }

        .name-fields .form-group, .address-fields .form-group, .location-fields .form-group {
            width: 48%;
        }

        .info-column {
            width: 48%;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }

        .button {
            background-color: #d4a017;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Doctor Appointment</h1>
        <div class="breadcrumb">HOME > FIND A DOCTOR > DOCTOR APPOINTMENT</div>
    </div>
    <div class="container">
        <div class="main-content">
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div>Appointment Details</div>
                </div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <div>Patient's Info</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div>Completed Submission</div>
                </div>
            </div>
            <form>
                <div class="form-content">
                    <div class="info-column">
                        <div class="form-section">
                            <h2>Patient Information:</h2>
                            <div class="name-fields">
                                <div class="form-group">
                                    <label for="firstName">First Name:</label>
                                    <input class="form-control" type="text" id="firstName" name="firstName" required value="">
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name:</label>
                                    <input class="form-control" type="text" id="lastName" name="lastName" required value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nric">NRIC:</label>
                                <input class="form-control" type="text" id="nric" name="nric" required value="">
                            </div>
                            <div class="form-group">
                                <label for="address1">Address Line 1:</label>
                                <input class="form-control" type="text" id="address1" name="address1" required value="">
                            </div>
                            <div class="form-group">
                                <label for="address2">Address Line 2:</label>
                                <input class="form-control" type="text" id="address2" name="address2" required value="">
                            </div>
                            <div class="location-fields">
                                <div class="form-group">
                                    <label for="city">City:</label>
                                    <input class="form-control" type="text" id="city" name="city" required value="">
                                </div>
                                <div class="form-group">
                                    <label for="postcode">Postcode:</label>
                                    <input class="form-control" type="text" id="postcode" name="postcode" required value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="allergyMedicines">Allergy medicines:</label>
                                <input class="form-control" type="text" id="allergyMedicines" name="allergyMedicines" required value="">
                            </div>
                        </div>
                    </div>
                    <div class="info-column">
                        <div class="form-section">
                            <h2>Doctor Information:</h2>
                            <div class="form-group">
                                <label for="doctorName">Doctor Name:</label>
                                <input class="form-control" type="text" id="doctorName" name="doctorName" required value="">
                            </div>
                            <div class="form-group">
                                <label for="speciality">Speciality:</label>
                                <input class="form-control" type="text" id="speciality" name="speciality" required value="">
                            </div>
                            <div class="form-group">
                                <label for="appointmentDate">Appointment Date:</label>
                                <input type="date" id="appointmentDate" name="appointmentDate" required>
                            </div>
                            <div class="form-group">
                                <label>Appointment Type:</label>
                                
                                <input class="form-control" type="text" id="doctorName" name="doctorName" required value="">
                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-container">
                    <button class="button" type="submit"><a href="{{route('successAppointment')}}">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
