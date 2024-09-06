<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medication</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 400;
            text-align: center;
            border: 1px solid transparent;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .text-center {
            text-align: center;
        }
        .medication-row {
            margin-bottom: 15px;
        }
        .col-md-4 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Edit Medication</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('medications.update', $medication->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Patient Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $medication->name }}" readonly required>
            </div>

            <div class="medication-container">
                <div class="medication-row">
                    <div class="form-group">
                        <label for="medication">Medication:</label>
                        <select id="medication" name="medication" class="form-control" required>
                            <option value="">Select a medication</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->name }}" data-price="{{ $product->price }}"
                                    {{ $product->name == $medication->medication ? 'selected' : '' }}>
                                    {{ $product->name }} - 
                                    @if($product->stock > 0)
                                        Available in stock ({{ $product->stock }})
                                    @else
                                        Out of stock
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dosage:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <select id="tablets" name="tablets" class="form-control" required>
                                    <option value="">Number of Tablets</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ strpos($medication->dosage, $i . ' Tablet') !== false ? 'selected' : '' }}>
                                            {{ $i }} Tablet{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="frequency" name="frequency" class="form-control" required>
                                    <option value="">Times Daily</option>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}" {{ strpos($medication->dosage, $i . ' Time') !== false ? 'selected' : '' }}>
                                            {{ $i }} Time{{ $i > 1 ? 's' : '' }} Daily
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="meal_relation" name="meal_relation" class="form-control" required>
                                    <option value="">Before/After Food</option>
                                    <option value="before" {{ strpos($medication->dosage, 'before Eating') !== false ? 'selected' : '' }}>Before Eating</option>
                                    <option value="after" {{ strpos($medication->dosage, 'after Eating') !== false ? 'selected' : '' }}>After Eating</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" class="form-control" value="{{ $medication->price }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="date_added">Date Added:</label>
                        <input type="date" id="date_added" name="date_added" class="form-control" value="{{ $medication->date_added ? $medication->date_added->format('Y-m-d') : '' }}" required>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Medication</button>
                <a href="{{ route('medications.list') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const medicationSelect = document.getElementById('medication');
    const priceInput = document.getElementById('price');

    medicationSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        priceInput.value = selectedOption.getAttribute('data-price') || '';
    });
});
</script>

</body>
</html>