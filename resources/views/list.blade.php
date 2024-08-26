<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medications List</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
        }
        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
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

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="profile-pic"></div>
            <div>
                <h2 class="username">Administrator</h2>
                <p class="email">admin@edoc.com</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-light">Log out</button>
        </form>
        <nav class="sidebar-nav">
            <a href="{{ route('nursePage') }}" class="nav-link">Home</a>
            <a href="{{ route('doctorPage') }}" class="nav-link">Doctors</a>
            <a href="#" class="nav-link">Schedule</a>
            <a href="{{ route('showProduct') }}" class="nav-link">Medication</a>
            <a href="{{ route('account') }}" class="nav-link">Account</a>
        </nav>
    </div>

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

        @csrf

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
                                    <form action="{{ route('medications.destroy', $medication->id) }}" method="POST" onsubmit="return confirmDelete()">
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

        <form action="{{ route('checkout') }}" method="POST" class="text-center mt-4">
            @csrf
            <input type="hidden" name="total_amount" id="total_amount" value="{{ $totalAmount }}">
            <button type="submit" class="btn btn-success">Checkout</button>
        </form>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this medication?');
        }
    </script>

</body>
</html>
