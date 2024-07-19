@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ asset('css/appointment.css') }}">
<style>
*{
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}



h1{
    text-transform: uppercase;
    text-align: center;
    font-family: helvetica, arial, sans-serif;
    color: #666;
    font-weight: lighter;
}

.field{
    position: relative;
}

form{
    width: 500px;
    margin: 0 auto;
}

input, button, textarea{
    position: relative;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
    padding: 10px;
    font-size: 14px;
    margin-bottom: 10px;
    width: 100%;
    border: 1px solid #C7C7C7;
    background-color: #fafafa;
    -webkit-transition: background-color .3s, border-color .4s;
    -moz-transition: background-color .3s, border-color .4s;
    -o-transition: background-color .3s, border-color .4s;
    transition: background-color .3s, border-color .4s;
}

textarea{
    height: 100px;
    resize: none;
}

input:focus, textarea:focus, input:hover, textarea:hover{
    outline: none;
    border-color: #777;
}

button.medication-button{
    display: block;
    border: none;
    background-color: #666;
    color: #fff;
    position: relative;
    height: 50px;
    line-height: 50px;
    padding: 0;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    transform-style: preserve-3d;
    cursor: pointer;
}
</style>

<div class="main-content">
    <div class="header">
        <div class="search-container">
            <input type="text" placeholder="Search Doctor name or Email" class="search-input">
            <button class="search-button">Search</button>
        </div>
        <div class="date-container">
            <p class="date-label">Today's Date</p>
            <p class="date-value">2022-06-03</p>
        </div>
    </div>
    
<div class="container">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <br>
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
                    <input class="form-control" type="text" id="prices" name="prices" required>
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

@endsection
