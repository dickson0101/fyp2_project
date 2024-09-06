@php
    $selectedUserId = request('patient_id');
    $showTable = !empty($selectedUserId) && $medications->isNotEmpty();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor List</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Your existing CSS here */
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <a href="{{ route('nursePage') }}">
                <button class="btn btn-light">← Back</button>
            </a>
            
            <form action="{{ route('nurseList') }}" method="GET" class="form-inline">
                <select name="patient_id" class="form-control mr-2">
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $selectedUserId == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Show Payment</button>
            </form>
        </div>
        
        <h2 class="text-center">Payment</h2>

        @if(empty($selectedUserId))
            <div class="alert alert-info text-center">
                Please select a user to see the payment details.
            </div>
        @elseif(!$showTable)
            <div class="alert alert-info text-center">
                No payments found for the selected user.
            </div>
        @else
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
                            $medicationsCollection = collect($medications);
                            $totalAmount = $medicationsCollection->sum('price');
                            $groupedMedications = $medicationsCollection->groupBy('name');
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

            <form action="{{ route('checkout') }}" method="POST" class="text-center mt-4">
                @csrf
                <input type="hidden" name="total_amount" id="total_amount" value="{{ $totalAmount }}">
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
        @endif

        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete this medication?');
            }
        </script>

    </div>

</body>
</html>