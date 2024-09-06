@extends('layout')

@section('content')
<div class="container">
    <h1>Confirm Delete</h1>
    <p>Are you sure you want to delete Dr. {{ $doctor->name }}?</p>
    <form action="{{ route('deleteDoctor', ['id' => $doctor->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Confirm Delete</button>
        <a href="{{ route('doctorPage') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
