<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Files List</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .main-content {
            margin: 20px auto;
            padding: 20px;
            max-width: 800px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .date-container {
            text-align: right;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <a href="{{ route('nursePage') }}">
                <button class="btn btn-light">← Back</button>
            </a>
            <div class="date-container">
                <p class="date-label">Today's Date:</p>
                <p class="date-value">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        <h1 class="text-center">Report Files List</h1>

        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Report Date</th>
                        <th>File Path</th>
                        <th>Patient Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportFiles as $reportFile)
                        <tr>
                            <td>{{ $reportFile->doctor_name }}</td>
                            <td>{{ $reportFile->report_date->format('Y-m-d') }}</td>
                            <td>
                                @if($reportFile->file_exists)
                                    <a href="{{ route('downloadReport', $reportFile->id) }}">Download</a>
                                @else
                                    File not available
                                @endif
                            </td>
                            <td>{{ $reportFile->patient->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this report file?');
        }
    </script>

</body>
</html>
