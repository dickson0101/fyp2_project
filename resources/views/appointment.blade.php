<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment</title>
    <link rel="stylesheet" href="{{ asset('css/appointment2.css') }}">
    <style>
        .time-slots {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .time-slot {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .time-slot:hover {
            background-color: #e9ecef;
        }
        .time-slot.selected {
            background-color: #007bff;
            color: white;
        }
        .time-slot.full {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .date-time-container {
            margin-bottom: 20px;
        }
        .date-time-container .date-label {
            font-weight: bold;
        }
        .doctor-card {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .doctor-card img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .doctor-card.selected {
            border-color: #007bff;
            background-color: #e9ecef;
        }

        #doctor-list-container {
        max-height: 400px; /* Adjust height as needed */
        overflow-y: auto;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
    }

    #doctor-list {
    max-height: 400px; /* Set the max height to control the height of the container */
    overflow-y: auto;  /* Enable vertical scrolling */
    border: 1px solid #ddd; /* Optional: add a border for visual clarity */
    padding: 10px; /* Optional: add padding for better appearance */
}

 #searchInput, #doctorName {
            width: 100%; /* Extend the width of search and doctor name input */
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-container label {
            font-weight: bold;
        }


        .hidden {
    display: none; /* Hide the element from view */
}

    </style>
</head>
<body>
    <div class="header">
        <h1>Doctor Appointment</h1>
        <div class="breadcrumb">
            <a href="{{ route('nursePage') }}">HOME</a> >
            <a href="{{ route('appointment') }}">FIND A DOCTOR</a> >
            <a href="{{ route('appointment') }}">DOCTOR APPOINTMENT</a>
        </div>
    </div>

    <form action="{{ route('appointment') }}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="container">
            <div class="main-content">
                <div class="steps">
                    <div class="step active">
                        <div class="step-number">1</div>
                        <div>Appointment Details</div>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">2</div>
                        <div>Completed Submission</div>
                    </div>
                </div>

                <h3>Search Doctor</h3>
                

                <div class="form-group">
    <div class="search-container">
        <label for="searchInput">Search:</label>
        <input type="text" id="searchInput" placeholder="Enter doctor name or specialty">
        <button type="button" id="searchButton">Search</button>
    </div>

    <h3>Choose the Doctor</h3>
<div id="doctor-list"> <!-- Updated ID here -->
@foreach ($doctors as $doctor)
    @foreach ($appointments as $appointment)
        <div class="doctor-card" 
             data-doctor-id="{{ $doctor->id }}" 
             data-user-doctor-id="{{ $appointment->doctor_id }}">
            <img src="{{ url('images/'.$doctor->image) }}" alt="{{ $doctor->name }}">
            <div class="doctor-info">
                <strong>{{ $doctor->name }}</strong><br>
                Specialist: {{ $doctor->specialist }}<br>
                Telephone: {{ $doctor->telephone }}<br>
                Language: {{ $doctor->language }}<br>
            </div>
        </div>
    @endforeach
@endforeach
</div>

</div>

                <div class="form-group">
                        <label for="doctorName">Doctor Name</label><br>
                        <input type="text" id="doctorName" name="doctorName" readonly required>
                    </div>

                    <div id="dateTimeContainers">
                        <div class="date-time-container">
                            <div class="form-group">
                                <label for="ConsultationDate">Consultation Date:</label>
                                <input class="form-control" type="date" name="consultation_dates[]" required>
                            </div>

                            <div class="form-group">
                                <label>Available Time Slots:</label>
                                <div class="time-slots">
                                    <!-- Time slots will be dynamically generated here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="appointmentDT" id="appointmentDT">

                    <div class="form-group" id="appointmentType">
                        <label>Appointment Type</label>
                        <label>
                            <input type="radio" name="appointmentType" value="online" checked> Online Appointment
                        </label>
                        <label>
                            <input type="radio" name="appointmentType" value="clinic"> Clinic Appointment
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    const doctorList = document.getElementById('doctor-list'); // Updated ID
    const doctorNameInput = document.getElementById('doctorName');
    const appointmentDates = document.querySelectorAll('input[name="consultation_dates[]"]');
    const timeSlotsContainer = document.querySelector('.time-slots');
    const hiddenInput = document.getElementById('appointmentDT');
    const dateTimeSection = document.getElementById('dateTimeContainers');
    let currentDoctorId = null;
    let userDoctorId = null; // This should be fetched from appointments table

    dateTimeSection.style.display = 'none';

   


    document.getElementById('searchButton').addEventListener('click', function() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    [...doctorList.children].forEach(doctor => {
        const doctorName = doctor.querySelector('.doctor-info strong').textContent.toLowerCase();
        const doctorSpeciality = doctor.dataset.speciality ? doctor.dataset.speciality.toLowerCase() : ''; // Add a check here

        doctor.style.display = doctorName.includes(searchTerm) || doctorSpeciality.includes(searchTerm) ? '' : 'none';
    });
});


    doctorList.addEventListener('click', function(e) {
        const doctorCard = e.target.closest('.doctor-card');
        if (doctorCard) {
            doctorList.querySelectorAll('.doctor-card').forEach(card => card.classList.remove('selected'));
            doctorCard.classList.add('selected');

            doctorNameInput.value = doctorCard.querySelector('.doctor-info strong').textContent;
            currentDoctorId = doctorCard.dataset.doctorId;
            userDoctorId = doctorCard.dataset.userDoctorId; // Ensure this value is correctly set for appointments

            // Check the value of userDoctorId for debugging
            console.log('Selected User Doctor ID:', userDoctorId); // Debugging line

            dateTimeSection.style.display = 'block';

            appointmentDates.forEach(dateInput => {
                dateInput.addEventListener('change', function() {
                    const selectedDate = this.value;
                    if (selectedDate) {
                        fetchDoctorTimes(userDoctorId, selectedDate).then(unavailableTimes => {
                            generateTimeSlots(unavailableTimes);
                        });
                    }
                });

                // Trigger change event if the date is already set
                if (dateInput.value) {
                    dateInput.dispatchEvent(new Event('change'));
                }
            });
        }
    });

    function fetchDoctorTimes(userDoctorId, date) {
        console.log(`Fetching times for User Doctor ID: ${userDoctorId} on Date: ${date}`); // Debugging line

        return Promise.all([
            fetch(`/get-doctor-unavailable-times/${currentDoctorId}?date=${encodeURIComponent(date)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Unavailable Times Response:', data); // Debugging line
                    return data.unavailableTimes || [];
                }),
            fetch(`/get-doctor-appointments-times/${userDoctorId}?date=${encodeURIComponent(date)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Appointment Times Response:', data); // Debugging line
                    return data.appointmentTimes || [];
                })
        ])
        .then(([unavailableTimes, appointmentTimes]) => {
            console.log('Combined Times:', [...unavailableTimes, ...appointmentTimes]); // Debugging line
            return [...unavailableTimes, ...appointmentTimes];
        })
        .catch(err => {
            console.error('Error fetching times:', err); // Error handling
            return [];
        });
    }

    function generateTimeSlots(unavailableTimes) {
        timeSlotsContainer.innerHTML = '';
        for (let hour = 9; hour < 18; hour++) { // Adjusted to 6 PM
            for (let minute = 0; minute < 60; minute += 30) {
                const formattedHour = hour.toString().padStart(2, '0');
                const formattedMinute = minute.toString().padStart(2, '0');
                const timeValue = `${formattedHour}:${formattedMinute}`;
                const timeSlot = document.createElement('div');
                timeSlot.className = 'time-slot';
                timeSlot.textContent = timeValue;

                if (unavailableTimes.includes(timeValue)) {
                    timeSlot.classList.add('full');
                } else {
                    timeSlot.classList.add('available');
                    timeSlot.addEventListener('click', function() {
                        document.querySelectorAll('.time-slot.selected').forEach(slot => slot.classList.remove('selected'));
                        this.classList.add('selected');
                        updateHiddenInput();
                    });
                }

                timeSlotsContainer.appendChild(timeSlot);
            }
        }
    }

    function updateHiddenInput() {
        const containers = document.querySelectorAll('.date-time-container');
        const result = Array.from(containers).map(container => {
            const dateInput = container.querySelector('input[name="consultation_dates[]"]').value;
            const selectedSlots = Array.from(container.querySelectorAll('.time-slot.selected'))
                .map(slot => slot.textContent);

            return {
                date: dateInput,
                timeSlots: selectedSlots
            };
        });

        hiddenInput.value = JSON.stringify(result);
    }

    const today = new Date().toISOString().split('T')[0];
    appointmentDates.forEach(dateInput => {
        dateInput.setAttribute('min', today);
    });
});

</script>
</body>
</html>
