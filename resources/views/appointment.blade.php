<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment</title>
    <link rel="stylesheet" href="{{ asset('css/appointment2.css') }}">
</head>
<body>
    <div class="header">
        <h1>Doctor Appointment</h1>
        <div class="breadcrumb">
            <a href="{{route('nursePage2')}}">HOME</a> >
            <a href="{{route('appointment')}}">FIND A DOCTOR</a> >
            <a href="{{route('appointment')}}">DOCTOR APPOINTMENT</a>
        </div>
    </div>

    <form action="{{ route('appointment') }}" method="get" enctype="multipart/form-data">
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

            <div id="requestSpeciality" class="form-group">
                <label for="specialitys">Speciality</label>
                <select id="specialitys" name="specialitys" required>
                    <option value="">Select a Speciality</option>
                    <option value="cardiology">Cardiology</option>
                    <option value="neurology">Neurology</option>
                    <option value="orthopedics">Orthopedics</option>
                    <option value="urology">Urology</option>
                </select>
            </div>

            <div class="form-group" id="doctor-choice-group">
                <label>
                    <input class="form-group" type="radio" name="doctor-choice" value="recent" required> Recent Doctor
                </label>
                <label>
                    <input class="form-group" type="radio" name="doctor-choice" value="choose" required> Choose My Doctor
                </label>
                <input class="form-control" type="text" id="doctors" name="doctors" placeholder="Doctor Name" style="display: none;">
            </div>

            <div class="form-group">
                <label for="appointmentDate">Select Appointment Date</label>
                <input type="date" id="appointmentDate" name="appointmentDate" required>
            </div>

            <div class="form-group">
                <label>Appointment Time</label>
                <div id="timeSlots" class="time-slots">
                    <?php
                    for ($hour = 9; $hour < 17; $hour++) {
                        for ($minute = 0; $minute < 60; $minute += 15) {
                            $formattedHour = str_pad($hour, 2, '0', STR_PAD_LEFT);
                            $formattedMinute = str_pad($minute, 2, '0', STR_PAD_LEFT);
                            $timeValue = "$formattedHour:$formattedMinute";
                            echo "
                                <label class='time-slot available' id='time-slot-".str_replace(':', '-', $timeValue)."'>
                                    <input type='radio' name='appointmentTime' value='$timeValue'>
                                    <span>$timeValue</span>
                                </label>
                            ";
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="form-group" id="appointmentTypes">
                <label>Appointment Type</label>
                <label>
                    <input type="radio" name="appointment-type" value="online" checked> Online Appointment
                </label>
                <label>
                    <input type="radio" name="appointment-type" value="clinic"> Clinic Appointment
                </label>
            </div>

            <button id="find-doctor-btn" class="next-button">Find A Doctor</button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const specialitySelect = document.getElementById('specialitys');
        const doctorInput = document.getElementById('doctors');
        const doctorChoiceRecent = document.querySelector('input[name="doctor-choice"][value="recent"]');
        const doctorChoiceChoose = document.querySelector('input[name="doctor-choice"][value="choose"]');
        const appointmentDate = document.getElementById('appointmentDate');

        // Set the minimum date to today
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const todayDate = `${yyyy}-${mm}-${dd}`;

        appointmentDate.setAttribute('min', todayDate);

        // Event listeners for time slots and speciality selection
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.addEventListener('click', function(e) {
                e.stopPropagation();
                if (!this.classList.contains('full')) {
                    document.querySelectorAll('.time-slot').forEach(s => {
                        s.classList.remove('selected');
                        if (!s.classList.contains('full')) {
                            s.classList.add('available');
                        }
                    });
                    this.classList.remove('available');
                    this.classList.add('selected');
                    this.querySelector('input[type="radio"]').checked = true;
                }
            });
        });

        specialitySelect.addEventListener('change', function() {
            updateDoctorSelectState();
        });

        appointmentDate.addEventListener('change', function() {
            updateTimeslots();
            updateDoctorSelectState();
        });

        function updateTimeslots() {
            const selectedDate = appointmentDate.value;
            simulateFullTimeSlots(selectedDate);
        }

        function simulateFullTimeSlots(selectedDate) {
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('full', 'selected');
                slot.classList.add('available');
            });

            const fullDates = ["2024-07-22", "2024-07-23", "2024-07-24", "2024-07-25", "2024-07-26"];
            if (fullDates.includes(selectedDate)) {
                document.querySelectorAll('.time-slot').forEach((slot, index) => {
                    if (index % 2 === 0) {
                        slot.classList.remove('available');
                        slot.classList.add('full');
                    }
                });
            }
        }

        doctorChoiceRecent.addEventListener('change', function() {
            if (this.checked) {
                doctorInput.style.display = 'none';
                doctorInput.value = '';
            }
        });

        doctorChoiceChoose.addEventListener('change', function() {
            if (this.checked) {
                doctorInput.style.display = 'block';
            }
        });

        document.getElementById('find-doctor-btn').addEventListener('click', function() {
            window.location.href = "{{route('successAppointment')}}";
        });

        updateTimeslots();
    });
    </script>
</body>
</html>
