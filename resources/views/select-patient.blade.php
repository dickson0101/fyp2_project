@extends('layout')

@section('content')
    <h1>Select a Patient</h1>

    <form action="{{ route('store.selected.patient') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="patient_id">Select a patient:</label>
            <select id="patient_id" name="patient_id" class="form-control" required>
                <option value="">Select a patient</option>
                @foreach($usersWithAppointments as $patient)
                    <option value="{{ $patient->id }}" {{ $selectedPatientId == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        @if($selectedPatientId)
            <div class="form-group">
                <label for="time_slot">Select a time slot:</label>
                <select id="time_slot" name="time_slot" class="form-control">
                    <option value="">Select a time slot</option>
                    @foreach($timeSlots as $timeSlot)
                        <option value="{{ $timeSlot }}" {{ $selectedTimeSlot == $timeSlot ? 'selected' : '' }}>
                            {{ $timeSlot }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        
        <button type="submit" class="btn btn-primary">Select</button>
    </form>

    @if($filteredAppointments->isNotEmpty())
        <h2>Patient Details</h2>
        @foreach($filteredAppointments as $appointment)
            <p>
                <strong>Name:</strong> {{ $appointment->patient->name }}<br>
                <strong>Appointment Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointmentDate)->format('Y-m-d') }}<br>
                <strong>Time Slot:</strong> {{ $appointment->timeSlot }}<br>
            </p>
        @endforeach
    @else
        @if($selectedPatientId)
            <p>No appointments found for the selected patient and time slot.</p>
        @endif
    @endif
@endsection
