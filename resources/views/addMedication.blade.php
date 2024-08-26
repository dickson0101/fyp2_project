<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Doctor Appointment</title>
    <style>
         
    </style>
</head>
<body>
<div class="container">
    <!-- Sidebar and other content -->
    <div class="main-content">
        <div class="header">
            <a href="{{ route('showProduct') }}"> 
                <button class="btn btn-light">← Back</button>
            </a>
            <div class="date-container">
                <p class="date-label">Today's Date</p>
                <p class="date-value" id="currentDate"></p>
            </div>
        </div>

            <h1>Add New Medication</h1><br>
            
            <form action="{{ route('addMedication') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- form fields -->
                <div class="form-group">
                    <label for="medicationName">Medication Name</label>
                    <input class="form-control" type="text" id="medicationName" name="medicationName" required>
                </div>

                <div class="form-group">
                    <label for="medicationDescription">Description</label>
                    <textarea class="form-control" id="medicationDescription" name="medicationDescription" placeholder="Description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="expireDate">Expiration Date</label>
                    <input class="form-control" type="date" id="expireDate" name="expireDate" required>
                </div>

                <div class="form-group">
                    <label for="prices">Price</label>
                    <input class="form-control" type="number" id="prices" name="prices" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input class="form-control" type="number" id="quantity" name="quantity" step="1" required>
                </div>

                <div class="form-group">
                    <label for="medicationImage">Image</label>
                    <input class="form-control" type="file" id="medicationImage" name="medicationImage">
                </div>

                <div class="form-group">
                    <label for="publishers">Publishers</label>
                    <input class="form-control" type="text" id="publishers" name="publishers" required>
                </div>

                <button class="medication-button" type="submit" class="btn btn-primary">Add New</button>
            </form>

            
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
