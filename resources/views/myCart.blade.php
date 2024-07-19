@extends('layout')
@section('content')

<style>
    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .table th:last-child,
    .table td:last-child {
        border-right: 1px solid #dee2e6;
    }

    /* Add a black background color to the table */
    table {
        color: white; /* Set text color to white for better visibility */
    }
</style>

<script>
    function cal() {
        var names = document.getElementsByName('subtotal[]');
        var subtotal = 0;
        var cboxes = document.getElementsByName('cid[]');
        var len = cboxes.length; // get the number of cid[] checkboxes inside the page
        for (var i = 0; i < len; i++) {
            if (cboxes[i].checked) { // calculate if checked
                subtotal = parseFloat(names[i].value) + parseFloat(subtotal);
            }
        }
        document.getElementById('sub').value = subtotal.toFixed(2); // convert 2 decimal places
    }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<form action="{{ route('deleteFavorites') }}" method="post">
    @csrf
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-2"></div>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Developer</th>
                            <th>Publisher</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carts as $cart)
                        <tr>
                            <td>
                                <input type="checkbox" name="cid[]" id="cid[]" value="{{$cart->cid}}" onclick="cal()">
                                <input type="hidden" name="subtotal[]" id="subtotal[]" value="{{$cart->price}}">
                                
                                <!-- Display image in the table cell -->
                                <img src="{{asset('images')}}/{{$cart->image}}" alt="" class="img-fluid">
                            </td>
                            <td>{{$cart->name}}</td>
                            <td>{{$cart->price}}</td>
                            <td>{{$cart->developer}}</td>
                            <td>{{$cart->publisher}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr align="right">
                            <td colspan="2">&nbsp;</td>
                            <td colspan="2">RM</td>
                            <td><input type="text" value="0" name="sub" id="sub" size="7" readonly /></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="row mt-3">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="form-row row">
                    <div class="col-xs-12">
                        <button class="btn btn-danger btn-lg" type="submit">Delete My Favorites</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
