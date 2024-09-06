@extends('layout')

@section('content')
<div class="main-content">
    <div class="header">
        <a href="{{ route('homePatient') }}">
            <button class="btn btn-light">← Back</button>
        </a>
    </div>
    <h1>View Reports</h1>
    @if($reports->isEmpty())
        <p>You don't have any reports yet.</p>
    @else
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>Report Date</th>
                    <th>Download ZIP File</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->doctor_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($report->report_date)->format('Y-m-d') }}</td>
                        <td>
                           
                                <a href="{{ route('downloadReport', $report->id) }}">Download</a>
                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
