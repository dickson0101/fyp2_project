<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Edit Doctor</title>
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
        .radio-group {
            display: flex;
            flex-direction: column;
        }
        .radio-group label {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    
        <div class="main-content">
            <div class="header">
                <a href="{{ route('doctorPage') }}"> 
                    <button class="btn btn-light">← Back</button>
                </a>
                <div class="date-container">
                    <p class="date-label">Today's Date</p>
                    <p class="date-value" id="currentDate"></p>
                </div>
            </div>
            <form id="doctorForm" action="{{ route('doctorUpdate', $doctor->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <h1>Edit Doctor</h1>
                <div class="form-group">
                    <label for="DoctorName">Doctor Name:</label>
                    <input class="form-control" type="text" id="DoctorName" name="DoctorName" required value="{{ $doctor->name }}">
                </div>
                <div class="form-group">
                    <label for="DoctorEmail">Email:</label>
                    <input class="form-control" type="email" id="DoctorEmail" name="DoctorEmail" required value="{{ $doctor->email }}">
                </div>
                <div class="form-group">
                    <label for="DoctorPassword">Password:</label>
                    <input class="form-control" type="password" id="DoctorPassword" name="DoctorPassword">
                    <small>Leave blank if you don't want to change the password.</small>
                </div>
                <div class="form-group">
                    <img src="{{ asset('images/'.$doctor->image) }}" alt="Doctor Image" width="200" height="200" class="img-fluid"><br>
                    <label for="DoctorImage">Image</label>
                    <input class="form-control" type="file" id="DoctorImage" name="DoctorImage" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="Certificate">Certificate</label>
                    <input class="form-control" type="text" id="Certificate" name="Certificate" required value="{{ $doctor->certificate }}">
                </div>
                <div class="form-group">
                    <label for="Specialist">Specialist</label>
                    <input class="form-control" type="text" id="Specialist" name="Specialist" required value="{{ $doctor->specialist }}">
                </div>
                <div class="form-group">
                    <label for="Telephone">Telephone Number:</label>
                    <input class="form-control" type="number" id="Telephone" name="Telephone" required value="{{ $doctor->telephone }}">
                    <p id="telephoneError" style="color: red; display: none;">Telephone number must be exactly 11 digits.</p>
                </div>
                <div class="form-group">
                    <label>Language</label>
                    <div class="radio-group">
                        @php
                            $languages = explode(', ', $doctor->language);
                        @endphp
                        <label><input type="checkbox" name="Language[]" value="Chinese" {{ in_array('Chinese', $languages) ? 'checked' : '' }}> Chinese</label>
                        <label><input type="checkbox" name="Language[]" value="Tamil" {{ in_array('Tamil', $languages) ? 'checked' : '' }}> Tamil</label>
                        <label><input type="checkbox" name="Language[]" value="Bahasa Melayu" {{ in_array('Bahasa Melayu', $languages) ? 'checked' : '' }}> Bahasa Melayu</label>
                        <label><input type="checkbox" name="Language[]" value="Other" {{ in_array('Other', $languages) ? 'checked' : '' }}> Other</label>
                    </div>
                </div>
                
                <div id="dateTimeContainers">
                    <!-- Date-Time containers will be generated here -->
                </div>
                <input type="hidden" name="datesAndTimes" id="datesAndTimes">
                <button type="button" id="addDate" class="btn btn-secondary">Add Another Date</button>
                <button class="btn doctor-button" type="submit">Update</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateTimeContainers = document.getElementById('dateTimeContainers');
            const addDateButton = document.getElementById('addDate');
            const hiddenInput = document.getElementById('datesAndTimes');
            const doctorDatesAndTimes = @json($doctor->datesAndTimes);
            const telephoneInput = document.getElementById('Telephone');
            const telephoneError = document.getElementById('telephoneError');

            function generateTimeSlots(container, selectedSlots = []) {
                const timeSlotsContainer = container.querySelector('.time-slots');
                timeSlotsContainer.innerHTML = ''; // Clear existing time slots
                for (let hour = 9; hour < 18; hour++) { // 9 AM to 5 PM
                    for (let minute = 0; minute < 60; minute += 30) {
                        const formattedHour = hour.toString().padStart(2, '0');
                        const formattedMinute = minute.toString().padStart(2, '0');
                        const timeValue = `${formattedHour}:${formattedMinute}`;
                        
                        const timeSlot = document.createElement('div');
                        timeSlot.className = 'time-slot';
                        timeSlot.textContent = timeValue;

                        timeSlot.onclick = function() {
                            this.classList.toggle('selected');
                            updateHiddenInput();
                        };

                        if (selectedSlots.includes(timeValue)) {
                            timeSlot.classList.add('selected');
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

            function setMinDate() {
                const today = new Date().toISOString().split('T')[0];
                document.querySelectorAll('input[name="consultation_dates[]"]').forEach(input => {
                    input.setAttribute('min', today);
                });
            }

            function loadExistingData() {
                doctorDatesAndTimes.forEach(data => {
                    const newContainer = document.createElement('div');
                    newContainer.className = 'date-time-container';
                    newContainer.innerHTML = `
                        <div class="form-group">
                            <label for="ConsultationDate">Consultation Date:</label>
                            <input class="form-control" type="date" name="consultation_dates[]" required value="${data.date}">
                        </div>
                        <div class="form-group">
                            <label>Available Time Slots:</label>
                            <div class="time-slots"></div>
                        </div>
                    `;
                    dateTimeContainers.appendChild(newContainer);
                    generateTimeSlots(newContainer, data.timeSlots);
                });
            }

            addDateButton.onclick = function() {
                const newContainer = document.createElement('div');
                newContainer.className = 'date-time-container';
                newContainer.innerHTML = `
                    <div class="form-group">
                        <label for="ConsultationDate">Consultation Date:</label>
                        <input class="form-control" type="date" name="consultation_dates[]" required>
                    </div>
                    <div class="form-group">
                        <label>Available Time Slots:</label>
                        <div class="time-slots"></div>
                    </div>
                `;
                dateTimeContainers.appendChild(newContainer);
                generateTimeSlots(newContainer);
                setMinDate(); // Update the min date for the new date input
            };

            // Initial setup
            loadExistingData();
            setMinDate(); // Set the min date for existing date inputs

            // Add client-side validation for passwords and telephone
            document.getElementById('doctorForm').addEventListener('submit', function(event) {
                const password = document.getElementById('DoctorPassword').value;
                if (password && (password.length < 8 || !/\d/.test(password) || !/[a-zA-Z]/.test(password))) {
                    alert('Password must be at least 8 characters long and include both letters and numbers.');
                    event.preventDefault(); // Prevent form submission
                }

                // Validate telephone number length
                if (telephoneInput.value.length !== 11) {
                    event.preventDefault();
                    telephoneError.style.display = 'block';
                    telephoneInput.focus();
                } else {
                    telephoneError.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>