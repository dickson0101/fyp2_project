<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include jQuery first, then Popper.js, and then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-Gn5384XdqQ7+5CDOzxPXJKXJeaLUEFcn9U7XrmeyjEU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEX/4CSn7E1opfXt/BWmomsI9UlfQyaT7DjB" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        const carousel = new bootstrap.Carousel('#carouselExampleDark');
    </script>
</head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">

<body>

    <div class="container-fluid background_bg" style="color: black;">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-8 form-container" style="margin-top: 30px;">

                <h3 class="text-center">View medication</h3>
                    @csrf

                

</body>

</html>

<div>
    <h3>ALL Medication</h3>
        <div class="card">
            @foreach($products as $product)
            <div class="col-md-3" style="float: left; margin-bottom: 10px;">
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <img src="{{asset('images/')}}/{{$product->image}}" alt="" style="width:50%; max-height:200px;" class="img-fluid">
                    <div class="card-heading">

                        <h6>RM {{$product->price}}</h6>
                        <h3> {{$product->description}}</h3>
                        <h3> {{$product->expDate}}</h3>
                        <h3> {{$product->publisher}}</h3>
                        
                        <div>
                        <a href="{{route('productDetail', ['id' => $product->id])}}" class="btn btn-warning btn-xs">more information</a><br><br>
                            <a href="{{route('editProduct',['id'=>$product->id])}}" class="btn btn-warning btn-xs">Edit</a><br><br>
                            <a href="{{route('deleteProduct',['id'=>$product->id])}}" class="btn btn-danger btn-xs">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

