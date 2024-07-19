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

    <div class="container">
        <div class="main-content">
            <div class="steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    <div>Appointment Details</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div>Patient's Info</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div>Completed Submission</div>
                </div>
            </div>

            <div id="requestSpeciality" class="form-group">
                <label for="speciality">Speciality</label>
                <select id="speciality" name="doctor-speciality" required>
                    <option value="">Select a Speciality</option>
                    <option value="cardiology">Cardiology</option>
                    <option value="neurology">Neurology</option>
                    <option value="orthopedics">Orthopedics</option>
                    <option value="urology">Urology</option>
                </select>
            </div>

            <div class="form-group">
                <label>Appointment Time</label>
                <div id="timeSlots" class="time-slots">
                    <!-- Time slots will be dynamically generated here -->
                </div>
            </div>

            <div class="form-section">
                <div class="form-group" id="doctor-choice-group">
                    <label>
                        <input class="form-control" type="radio" name="doctor-choice" value="recent" required> Recent Doctor
                    </label>
                    <label>
                        <input class="form-control" type="radio" name="doctor-choice" value="choose" required> Choose My Doctor
                    </label>
                </div>
                <div class="form-group" id="doctor-select-group">
                    <label for="doctor">Select Doctor</label>
                    <select id="doctor" name="doctor" disabled>
                        <option value="">Empty</option>
                    </select>
                    <div id="doctor-warning" class="warning" style="display: none; color: red;">
                        Please select both time and speciality first.
                    </div>
                </div>

                <div class="form-group" id="appointment-type-group">
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
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const timeSlotsContainer = document.getElementById('timeSlots');
        const specialitySelect = document.getElementById('speciality');
        const doctorSelect = document.getElementById('doctor');
        const doctorWarning = document.getElementById('doctor-warning');

        // Generate time slots
        for (let hour = 9; hour < 17; hour++) {
            const hourContainer = document.createElement('div');
            hourContainer.className = 'hour-container';
            hourContainer.id = `hour-container-${hour}`;

            const hourLabel = document.createElement('div');
            hourLabel.className = 'hour-label';
            hourLabel.id = `hour-label-${hour}`;
            
            const hourTime = document.createElement('div');
            hourTime.className = 'hour-time';
            
            const timeSpan = document.createElement('span');
            timeSpan.textContent = `${hour.toString().padStart(2, '0')}:00`;
            
            const hourAvailability = document.createElement('span');
            hourAvailability.className = 'hour-availability';
            hourAvailability.id = `hour-availability-${hour}`;
            hourAvailability.textContent = '(Available: 10)';
            
            hourTime.appendChild(timeSpan);
            hourTime.appendChild(hourAvailability);
            hourLabel.appendChild(hourTime);
            hourContainer.appendChild(hourLabel);

            const minuteSlots = document.createElement('div');
            minuteSlots.className = 'minute-slots';
            minuteSlots.id = `minute-slots-${hour}`;

            for (let minute = 0; minute < 60; minute += 5) {
                const timeSlot = document.createElement('label');
                timeSlot.className = 'time-slot';
                
                const formattedHour = hour.toString().padStart(2, '0');
                const formattedMinute = minute.toString().padStart(2, '0');
                const timeValue = `${formattedHour}:${formattedMinute}`;
                
                timeSlot.id = `time-slot-${timeValue.replace(':', '-')}`;

                timeSlot.innerHTML = `
                    <input type="radio" name="appointmentTime" value="${timeValue}">
                    <span>${formattedMinute}</span>
                `;

                minuteSlots.appendChild(timeSlot);
            }

            hourContainer.appendChild(minuteSlots);
            timeSlotsContainer.appendChild(hourContainer);
        }

        // Add event listeners
        document.querySelectorAll('.hour-label').forEach(label => {
            label.addEventListener('click', function() {
                this.classList.toggle('open');
                this.nextElementSibling.classList.toggle('open');
            });
        });

        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.addEventListener('click', function(e) {
                e.stopPropagation();
                document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
                updateDoctorSelectState();
            });
        });

        specialitySelect.addEventListener('change', function() {
            updateDoctorSelectState();
        });

        function updateDoctorSelectState() {
            const timeSelected = document.querySelector('input[name="appointmentTime"]:checked');
            const specialitySelected = specialitySelect.value !== '';

            if (timeSelected && specialitySelected) {
                doctorSelect.disabled = false;
                doctorWarning.style.display = 'none';
            } else {
                doctorSelect.disabled = true;
                doctorWarning.style.display = 'block';
            }
        }

        // Add event listener for the "Find A Doctor" button
        document.getElementById('find-doctor-btn').addEventListener('click', function() {
            // Here you can add logic to handle the form submission
            // For now, we'll just simulate a route change
            window.location.href = "{{route('checkAppointment')}}";
        });
    });
    </script>
</body>
</html>
