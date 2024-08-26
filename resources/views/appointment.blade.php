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

                <div id="requestSpeciality" class="form-group">
                    <label for="specialitys">Speciality</label>
                    <select id="specialitys" name="specialitys" >
                        <option value="">Select a Speciality</option>
                        <option value="cardiology">Cardiology</option>
                        <option value="neurology">Neurology</option>
                        <option value="orthopedics">Orthopedics</option>
                        <option value="urology">Urology</option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="search-container">
                        <label for="searchInput">Search:</label>
                        <input type="text" id="searchInput" placeholder="Enter doctor name or specialty">
                        <button type="button" id="searchButton">Search</button>
                    </div>

                        
<h3>choose the doctor</h3>
                    <div id="doctor-list" class="form-group">
                        @foreach ($doctors as $doctor)
                            <div class="doctor-card" data-doctor-id="{{ $doctor->id }}" data-specialty="{{ $doctor->specialist }}">
                                <img src="{{ url('images/'.$doctor->image) }}" alt="{{ $doctor->name }}">
                                <div class="doctor-info">
                                    <strong>{{ $doctor->name }}</strong><br>
                                    Specialist: {{ $doctor->specialist }}<br>
                                    Telephone: {{ $doctor->telephone }}<br>
                                    Language: {{ $doctor->language }}<br>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="date-time-section" style="display: none;">
                        <label for="appointmentDate">Select Date</label><br>
                        <input type="date" id="appointmentDate" name="appointmentDate" required><br>

                        <label for="timeSlots">Available Time Slots</label><br>
                        <div id="timeSlots" class="time-slots">
                            <!-- Time slots will be dynamically generated here -->
                        </div>
                    </div>

                    <input type="hidden" name="selectedTimeSlot" id="hiddenTimeSlot">


                    <div class="form-group" id="appointmentTypes">
                        <label>Appointment Type</label>
                        <label>
                            <input type="radio" name="appointment-type" value="online" checked> Online Appointment
                        </label>
                        <label>
                            <input type="radio" name="appointment-type" value="clinic"> Clinic Appointment
                        </label>
                    </div>

                    <a href="{{ route('successAppointment') }}"><button type="submit" class="btn btn-primary">Submit</button></a>
                </div>
            </div>
        </div>
    </form>

    <script>
document.addEventListener('DOMContentLoaded', function() {

    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const doctorList = document.getElementById('doctor-list');
    const originalDoctors = Array.from(doctorList.querySelectorAll('.doctor-card'));
    const specialitySelect = document.getElementById('specialitys');
    const dateTimeSection = document.getElementById('date-time-section');
    const timeSlotsContainer = document.getElementById('timeSlots');
    const appointmentDate = document.getElementById('appointmentDate');
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'selectedTimeSlot';
    document.querySelector('form').appendChild(hiddenInput);

    appointmentDate.addEventListener('change', function() {
    const doctorId = document.querySelector('.doctor-card.selected')?.dataset.doctorId;
    const selectedDate = this.value;
    if (doctorId && selectedDate) {
        fetchDoctorTimes(doctorId, selectedDate).then(unavailableTimes => {
            generateTimeSlots(unavailableTimes);
        });
    } else {
        generateTimeSlots([]);
    }
});

    function filterDoctors() {
        const selectedSpeciality = specialitySelect.value.toLowerCase();
        originalDoctors.forEach(doctor => {
            const doctorSpeciality = doctor.dataset.specialty.toLowerCase();
            if (selectedSpeciality === "" || doctorSpeciality === selectedSpeciality) {
                doctor.style.display = '';
            } else {
                doctor.style.display = 'none';
            }
        });
    }

    specialitySelect.addEventListener('change', filterDoctors);

    appointmentDate.addEventListener('change', function() {
        const doctorId = document.querySelector('.doctor-card.selected')?.dataset.doctorId;
        const selectedDate = this.value;
        if (doctorId && selectedDate) {
            fetchDoctorTimes(doctorId, selectedDate).then(unavailableTimes => {
                generateTimeSlots(unavailableTimes);
            });
        } else {
            generateTimeSlots([]);
        }
    });

    function fetchDoctorTimes(doctorId, date) {
    return fetch(`/get-doctor-times/${doctorId}?date=${encodeURIComponent(date)}`)
        .then(response => response.json())
        .then(data => {
            console.log('Fetched data:', data);

            // 确保 appointmentTimes 和 unavailableTimes 是数组
            if (!Array.isArray(data.appointmentTimes)) {
                console.error('appointmentTimes is not an array:', data.appointmentTimes);
                data.appointmentTimes = []; // 默认空数组
            }
            if (!Array.isArray(data.unavailableTimes)) {
                console.error('unavailableTimes is not an array:', data.unavailableTimes);
                data.unavailableTimes = []; // 默认空数组
            }

            // 合并两个数组
            const unavailableTimes = [...data.unavailableTimes, ...data.appointmentTimes];
            return unavailableTimes;
        })
        .catch(error => {
            console.error('Error fetching doctor times:', error);
            return [];
        });
}


function getUnavailableTimes(datesAndTimes, selectedDate) {
        const unavailableTimes = [];
        for (const entry of datesAndTimes) {
            if (entry.date === selectedDate) {
                unavailableTimes.push(...entry.timeSlots);
            }
        }
        return unavailableTimes;
    }


    function generateTimeSlots(unavailableTimes) {
    timeSlotsContainer.innerHTML = ''; // 清空现有时间槽

    // 遍历从 09:00 到 16:30 的时间槽
    for (let hour = 9; hour < 17; hour++) {
        for (let minute = 0; minute < 60; minute += 30) {
            const formattedHour = hour.toString().padStart(2, '0');
            const formattedMinute = minute.toString().padStart(2, '0');
            const timeValue = `${formattedHour}:${formattedMinute}`;

            const timeSlot = document.createElement('div');
            timeSlot.className = 'time-slot';
            timeSlot.textContent = timeValue;

            // 检查时间槽是否在不可用时间数组中
            if (unavailableTimes.includes(timeValue)) {
                timeSlot.classList.add('full'); // 使用 full 类来表示不可用的时间槽
                timeSlot.onclick = function() {
                    // 对不可用时间槽不做任何操作
                };
            } else {
                timeSlot.classList.add('available'); // 使用 available 类来表示可用的时间槽
                timeSlot.onclick = function() {
                    // 移除已选择的时间槽
                    document.querySelectorAll('.time-slot.selected').forEach(slot => {
                        slot.classList.remove('selected');
                    });
                    // 为当前点击的时间槽添加选中类
                    this.classList.add('selected');
                    updateHiddenInput();
                };
            }

            timeSlotsContainer.appendChild(timeSlot);
        }
    }
}


function updateHiddenInput() {
    const selectedSlot = timeSlotsContainer.querySelector('.time-slot.selected');
    hiddenInput.value = selectedSlot ? JSON.stringify([selectedSlot.textContent]) : '[]';
}



    doctorList.addEventListener('click', function(e) {
        const doctorCard = e.target.closest('.doctor-card');
        if (doctorCard) {
            doctorList.querySelectorAll('.doctor-card').forEach(card => card.classList.remove('selected'));
            doctorCard.classList.add('selected');

            const id = doctorCard.dataset.doctorId;
            const selectedDate = appointmentDate.value;
            if (selectedDate) {
                fetchDoctorTimes(id)
                    .then(doctorTimes => {
                        const unavailableTimes = getUnavailableTimes(doctorTimes, selectedDate);
                        generateTimeSlots(unavailableTimes);
                    });
            }

            dateTimeSection.style.display = 'block';
        }
    });



    document.querySelectorAll('.doctor-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.doctor-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            dateTimeSection.style.display = 'block';
            const doctorId = this.dataset.doctorId;
            const selectedDate = appointmentDate.value;
            if (doctorId && selectedDate) {
                fetchDoctorTimes(doctorId, selectedDate).then(unavailableTimes => {
                    generateTimeSlots(unavailableTimes);
                });
            }
        });
    });

    searchButton.addEventListener('click', function() {
        const searchTerm = searchInput.value.toLowerCase();
        originalDoctors.forEach(doctor => {
            const doctorName = doctor.querySelector('.doctor-info strong').textContent.toLowerCase();
            const doctorSpeciality = doctor.dataset.specialty.toLowerCase();
            if (doctorName.includes(searchTerm) || doctorSpeciality.includes(searchTerm)) {
                doctor.style.display = '';
            } else {
                doctor.style.display = 'none';
            }
        });
    });


const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const todayDate = `${yyyy}-${mm}-${dd}`;
    appointmentDate.setAttribute('min', todayDate);
});
</script>

</body>
</html>
