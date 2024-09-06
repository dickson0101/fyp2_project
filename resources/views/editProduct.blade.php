<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Edit Product</title>
</head>

<body>
    <div class="container-fluid background_bg" style="color: black;">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6 form-container" style="margin-top: 30px;">
                <h3>Edit Product</h3>
                <form action="{{ route('updateProduct') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @foreach($products as $product)
                        <div class="form-group">
                            <img src="{{ asset('images/' . $product->image) }}" alt="" width="300" class="img-fluid"><br>
                            <label for="medicationName">Medication Name</label>
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input class="form-control" type="text" id="medicationName" name="medicationName" required value="{{ $product->name }}">
                        </div>

                        <div class="form-group">
                            <label for="medicationDescription">Description</label>
                            <textarea class="form-control" id="medicationDescription" name="medicationDescription" placeholder="Description" required>{{ $product->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="expireDate">Expired Date</label>
                            <input class="form-control" type="date" id="expireDate" name="expireDate" required value="{{ $product->expDate }}">
                        </div>

                        <div class="form-group">
                            <label for="prices">Price</label>
                            <input class="form-control" type="number" id="prices" name="prices" required value="{{ $product->price }}">
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input class="form-control" type="number" id="quantity" name="quantity" required value="{{ $product->stock }}">
                        </div>

                        <div class="form-group">
                            <label for="medicationImage">Image</label>
                            <input class="form-control" type="file" id="medicationImage" name="medicationImage">
                        </div>

                        <div class="form-group">
                            <label for="publishers">Publishers</label>
                            <input class="form-control" type="text" id="publishers" name="publishers" required value="{{ $product->publisher }}">
                        </div>

                        <div class="form-group">
                            <label for="batchNo">Batch Number</label>
                            <input class="form-control" type="text" id="batchNo" name="batchNo" required value="{{ $product->batch }}">
                        </div>

                        <div class="form-group">
                            <label for="dateAppro">Approval Date</label>
                            <input class="form-control" type="date" id="dateAppro" name="dateAppro" required value="{{ $product->appDate }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    @endforeach        
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK3xV1K8Xf5y1FJ2M6InjYx8O2i5Zj6+YjNMyPexxHkF0b" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UOa1z8+e2bUl8VbA1Uap4/sgF17iZtM9elxV8V5iwP1B6s6pK1QF1d6do3mN9D" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></script>
</body>

</html>
