
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">

    <title>Product Detail</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <br><br>
            <h3>Product Detail</h3>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text"><strong>Description:</strong> {{ $product->description }}</p>
                    <p class="card-text"><strong>Expired Date:</strong> {{ $product->expDate }}</p>
                    <p class="card-text"><strong>Price:</strong> {{ $product->price }}</p>
                    <p class="card-text"><strong>Publisher:</strong> {{ $product->publisher }}</p>
                    <p class="card-text"><strong>Image:</strong><br><img src="{{ url('images/'.$product->image) }}" alt="{{ $product->name }}" width="200"></p>
                    <a href="{{ route('addInventory') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>

</body>
</html>
