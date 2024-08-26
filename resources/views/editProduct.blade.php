<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<div class="container-fluid background_bg" style="color: black;">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6 form-container" style="margin-top: 30px;">
        <h3>Edit Product</h3>
        <form action="{{route('updateProduct')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @foreach($products as $product)
            <div class="form-group">
            <img src="{{asset('images')}}/{{$product->image}}" alt="" width="300" class="img-fluid"><br>
            <label for="medicationName">Medication Name</label>

            <input type="hidden" name="id" value="{{$product->id}}">

            <input class="form-control" type="text" id="medicationName" name="medicationName" required value="{{$product->name}}"> 
            
            </div>

                <div class="form-group">
                    <label for="medicationDescription">Description</label>
                    <textarea class="form-control" id="medicationDescription" name="medicationDescription" placeholder="Description" required value="{{$product->description}}"></textarea>
                </div>

                <div class="form-group">
                    <label for="expireDate">Expired Date</label>
                    <input class="form-control" type="date" id="expireDate" name="expireDate" required value="{{$product->expDate}}">
                </div>

                <div class="form-group">
                    <label for="prices">Price</label>
                    <input class="form-control" type="number" id="prices" name="prices" required value="{{$product->price}}">
                </div>

                <div class="form-group">
                    <label for="Quantitys">Quantity</label>
                    <input class="form-control" type="number" id="stock" name="quantity" required value="{{$product->price}}">
                </div>

                <div class="form-group">
                    <label for="medicationImage">Image</label>
                    <input class="form-control" type="file" id="medicationImage" name="medicationImage">
                </div>

                <div class="form-group">
                    <label for="publishers">Publishers</label>
                    <input class="form-control" type="text" id="publishers" name="publishers" required  value="{{$product->publisher}}">
                </div>

            <button type="submit" class="btn btn-primary">Update</button>
              @endforeach        
        </form>
        
        </div>
        </div>
    </div>
