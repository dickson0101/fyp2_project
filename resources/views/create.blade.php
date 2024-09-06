<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Medication</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-container {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .text-center {
            text-align: center;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding-right: 15px;
            padding-left: 15px;
        }
        .remove-medication {
            cursor: pointer;
            color: #dc3545;
            font-size: 16px;
            border: none;
            background: none;
        }
        .remove-medication:hover {
            text-decoration: underline;
        }
        #name {
            pointer-events: none; /* Makes the field non-clickable */
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="text-center">Add New Medication</h1>
        
        <div class="form-container">
            <form action="{{ route('medications.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="patientName">Patient Name</label>
                    <input type="text" class="form-control" id="patientName" name="name" value="{{ $patient_name }}" readonly required>
                </div>
                
                <div class="medication-container">
                    <div class="medication-row">
                        <div class="form-group">
                            <label for="medication">Medication:</label>
                            <select class="form-control medication-select" name="medication[]" required>
                                <option value="">Select a medication</option>
                                @foreach ($medications as $medication)
                                    <option value="{{ $medication->name }}" data-price="{{ $medication->price }}">
                                        {{ $medication->name }} - 
                                        @if($medication->stock > 0)
                                            Available in stock ({{ $medication->stock }})
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
                                    <select name="tablets[]" class="form-control" required>
                                        <option value="">Number of Tablets</option>
                                        <option value="1">1 Tablet</option>
                                        <option value="2">2 Tablets</option>
                                        <option value="3">3 Tablets</option>
                                        <option value="4">4 Tablets</option>
                                        <option value="5">5 Tablets</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="frequency[]" class="form-control" required>
                                        <option value="">Times Daily</option>
                                        <option value="1">1 Time Daily</option>
                                        <option value="2">2 Times Daily</option>
                                        <option value="3">3 Times Daily</option>
                                        <option value="4">4 Times Daily</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="meal_relation[]" class="form-control" required>
                                        <option value="">Before/After Food</option>
                                        <option value="before">Before Eating</option>
                                        <option value="after">After Eating</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="dosage[]">
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" class="form-control price" name="price[]" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date_added">Date Added:</label>
                            <input type="date" name="date_added[]" class="form-control" readonly required>
                        </div>
                        <button type="button" class="remove-medication">Remove</button>
                    </div>
                </div>
                <br>

                <div class="form-group text-center">
                    <button type="button" class="btn btn-primary add-medication">Add Another Medication</button>
                </div>
                
                <br>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Add Medication</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set the default value of the date input to today's date
        const dateInputs = document.querySelectorAll('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];
        dateInputs.forEach(input => {
            input.value = today;
        });

        // Combine dosage information into a single string
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const medications = document.querySelectorAll('.medication-select');
            const tablets = document.querySelectorAll('select[name="tablets[]"]');
            const frequency = document.querySelectorAll('select[name="frequency[]"]');
            const mealRelation = document.querySelectorAll('select[name="meal_relation[]"]');
            const dosages = [];
            for (let i = 0; i < Math.min(5, medications.length); i++) {
                const dosage = `${tablets[i].value} Tablet, ${frequency[i].value} Time Daily, ${mealRelation[i].value} Eating`;
                dosages.push(dosage);
            }
            const dosageInputs = document.querySelectorAll('input[name="dosage[]"]');
            dosageInputs.forEach((input, index) => {
                input.value = dosages[index] || '';
            });
        });

        // Update price based on selected medication
        const medicationSelects = document.querySelectorAll('.medication-select');
        medicationSelects.forEach(select => {
            select.addEventListener('change', function() {
                const priceInput = this.closest('.medication-row').querySelector('.price');
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                priceInput.value = price || '';
            });
        });

        // Add another medication row
        const addMedicationButton = document.querySelector('.add-medication');
        let medicationCount = 1;
        addMedicationButton.addEventListener('click', function() {
            if (medicationCount < 5) {
                const medicationRow = document.createElement('div');
                medicationRow.classList.add('medication-row');
                medicationRow.innerHTML = `
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="medication">Medication:</label>
                        <select class="form-control medication-select" name="medication[]" required>
                            <option value="">Select a medication</option>
                            @foreach ($medications as $medication)
                                <option value="{{ $medication->name }}" data-price="{{ $medication->price }}">
                                    {{ $medication->name }} - 
                                    @if($medication->stock > 0)
                                        Available in stock ({{ $medication->stock }})
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
                                <select name="tablets[]" class="form-control" required>
                                    <option value="">Number of Tablets</option>
                                    <option value="1">1 Tablet</option>
                                    <option value="2">2 Tablets</option>
                                    <option value="3">3 Tablets</option>
                                    <option value="4">4 Tablets</option>
                                    <option value="5">5 Tablets</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="frequency[]" class="form-control" required>
                                    <option value="">Times Daily</option>
                                    <option value="1">1 Time Daily</option>
                                    <option value="2">2 Times Daily</option>
                                    <option value="3">3 Times Daily</option>
                                    <option value="4">4 Times Daily</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="meal_relation[]" class="form-control" required>
                                    <option value="">Before/After Food</option>
                                    <option value="before">Before Eating</option>
                                    <option value="after">After Eating</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="dosage[]">
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" class="form-control price" name="price[]" readonly>
                    </div>
                    <div class="form-group">
                        <label for="date_added">Date Added:</label>
                        <input type="date" name="date_added[]" class="form-control" readonly required>
                    </div>
                    <button type="button" class="remove-medication">Remove</button>
                `;
                document.querySelector('.medication-container').appendChild(medicationRow);
                medicationCount++;

                // Set the default value of the date input to today's date
                const newDateInput = medicationRow.querySelector('input[type="date"]');
                if (newDateInput) {
                    newDateInput.value = new Date().toISOString().split('T')[0];
                }

                // Update price based on selected medication for new row
                const newMedicationSelect = medicationRow.querySelector('.medication-select');
                newMedicationSelect.addEventListener('change', function() {
                    const priceInput = this.closest('.medication-row').querySelector('.price');
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    priceInput.value = price || '';
                });

                // Remove medication row
                const removeButtons = document.querySelectorAll('.remove-medication');
                removeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        button.parentElement.remove();
                        medicationCount--;
                    });
                });
            } else {
                alert('Maximum of 5 medications can be added.');
            }
        });

        // Remove medication row
        const removeButtons = document.querySelectorAll('.remove-medication');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                button.parentElement.remove();
                medicationCount--;
            });
        });
    });
</script>


</body>
</html>
