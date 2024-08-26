<div class="container">
    <h1 class="text-center">Add New Medication</h1>
    
    <div class="form-container">
        <form action="{{ route('medications.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Patient Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            
            <div class="medication-container">
                <div class="medication-row">
                    <div class="form-group">
                        <label for="medication">Medication:</label>
                        <select id="medication" name="medication[]" class="form-control" required>
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
                                <select id="tablets" name="tablets[]" class="form-control" required>
                                    <option value="">Number of Tablets</option>
                                    <option value="1">1 Tablet</option>
                                    <option value="2">2 Tablets</option>
                                    <option value="3">3 Tablets</option>
                                    <option value="4">4 Tablets</option>
                                    <option value="5">5 Tablets</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="frequency" name="frequency[]" class="form-control" required>
                                    <option value="">Times Daily</option>
                                    <option value="1">1 Time Daily</option>
                                    <option value="2">2 Times Daily</option>
                                    <option value="3">3 Times Daily</option>
                                    <option value="4">4 Times Daily</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="meal_relation" name="meal_relation[]" class="form-control" required>
                                    <option value="">Before/After Food</option>
                                    <option value="before">Before Eating</option>
                                    <option value="after">After Eating</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="dosage" name="dosage[]">
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price[]" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="date_added">Date Added:</label>
                        <input type="date" id="date_added" name="date_added[]" class="form-control" required>
                    </div>
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set the default value of the date input to today's date
        const dateInputs = document.querySelectorAll('#date_added');
        const today = new Date().toISOString().split('T')[0];
        dateInputs.forEach(input => {
            input.value = today;
        });

        // Combine dosage information into a single string
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const medications = document.querySelectorAll('#medication');
            const tablets = document.querySelectorAll('#tablets');
            const frequency = document.querySelectorAll('#frequency');
            const mealRelation = document.querySelectorAll('#meal_relation');
            const dosages = [];
            for (let i = 0; i < Math.min(5, medications.length); i++) {
                const dosage = `${tablets[i].value} Tablet, ${frequency[i].value} Time Daily, ${mealRelation[i].value} Eating`;
                dosages.push(dosage);
            }
            const dosageInputs = document.querySelectorAll('#dosage');
            dosageInputs.forEach((input, index) => {
                input.value = dosages[index] || '';
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
                        <select id="medication" name="medication[]" class="form-control" required>
                            <option value="">Select a medication</option>
                            <option value="Paracetamol" data-price="5">Paracetamol 500 mg</option>
                            <option value="Antibiotics" data-price="10">Antibiotics</option>
                            <option value="Anti-inflammatory" data-price="15">Anti-inflammatory</option>
                            <option value="Painkiller" data-price="20">Painkiller</option>
                            <option value="Sleeping_pill" data-price="25">Sleeping pill</option>
                            <option value="Glucose" data-price="30">Glucose</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dosage:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <select id="tablets" name="tablets[]" class="form-control" required>
                                    <option value="">Number of Tablets</option>
                                    <option value="1">1 Tablet</option>
                                    <option value="2">2 Tablets</option>
                                    <option value="3">3 Tablets</option>
                                    <option value="4">4 Tablets</option>
                                    <option value="5">5 Tablets</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="frequency" name="frequency[]" class="form-control" required>
                                    <option value="">Times Daily</option>
                                    <option value="1">1 Time Daily</option>
                                    <option value="2">2 Times Daily</option>
                                    <option value="3">3 Times Daily</option>
                                    <option value="4">4 Times Daily</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="meal_relation" name="meal_relation[]" class="form-control" required>
                                    <option value="">Before/After Food</option>
                                    <option value="before">Before Eating</option>
                                    <option value="after">After Eating</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="dosage" name="dosage[]">
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price[]" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="date_added">Date Added:</label>
                        <input type="date" id="date_added" name="date_added[]" class="form-control" required>
                    </div>
                `;
                document.querySelector('.medication-container').appendChild(medicationRow);
                medicationCount++;
            } else {
                alert('Maximum of 5 medications can be added.');
            }
        });

        // Update price based on selected medication
        document.querySelector('.medication-container').addEventListener('change', function(e) {
            if (e.target.matches('#medication')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const priceField = e.target.closest('.medication-row').querySelector('#price');
                priceField.value = selectedOption.getAttribute('data-price') || '';
            }
        });
    });
</script>
