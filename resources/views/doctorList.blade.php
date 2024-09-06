<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor List</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .main-content {
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .text-center {
            text-align: center;
        }
        .btn-light {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .card {
            margin: 20px auto;
            max-width: 600px;
            pointer-events: none; /* Disables clicking */
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.25rem;
        }
        .card-body {
            background-color: #f8f9fa;
        }
        .card-footer {
            text-align: right;
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <a href="{{ route('pdf.index') }}">
                <button class="btn btn-light">← Back</button>
            </a>
            
            <div class="date-container">
                <p class="date-label">Today's Date:</p>
                <p class="date-value">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>
        
        

        <h1 class="text-center">Medications List</h1>
        <div class="text-center mb-3">
            <a href="{{ route('medications.create') }}" class="btn btn-primary">Add New Medication</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Medication</th>
                        <th>Price</th>
                        <th>Dosage</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = $medications->sum('price');
                        $groupedMedications = $medications->groupBy('name');
                    @endphp
                    @foreach($groupedMedications as $name => $patientMedications)
                        @foreach($patientMedications as $index => $medication)
                            <tr>
                                @if($index === 0)
                                    <td rowspan="{{ $patientMedications->count() }}">{{ $name }}</td>
                                @endif
                                <td>{{ $medication->medication }}</td>
                                <td>{{ $medication->price }}</td>
                                <td>{{ $medication->dosage }}</td>
                                <td>{{ $medication->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('medications.edit', $medication->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('medications.destroy', $medication->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('homeDoctor') }}" class="btn btn-success">Go to Home Doctor</a>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this medication?');
        }
    </script>

</body>
</html>
