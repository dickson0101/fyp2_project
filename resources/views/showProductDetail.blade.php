@extends('layout')
@section('content')
    <div class="row">
        @foreach($products as $product)
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <div class="card-body">
                    <form action="{{ route('addCart') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <div class="row">
                            <div class="col-md-3">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <img src="{{ asset('images') }}/{{ $product->image }}" alt="" class="img-fluid">
                            </div>
                            <div class="col-md-9">
                                <br><br>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Description:</th>
                                            <td>{{ $product->description }}</td>
                                        </tr>
                                        <tr>
                                            <th>Price:</th>
                                            <td>RM {{ $product->price }}</td>
                                        </tr>
                                        <tr>
                                            <th>System Requirement:</th>
                                            <td>{{ $product->requirement }}</td>
                                        </tr>
                                        <tr>
                                            <th>Developer:</th>
                                            <td>{{ $product->developer }}</td>
                                        </tr>
                                        <tr>
                                            <th>Publisher:</th>
                                            <td>{{ $product->publisher }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-danger btn-xs" type="submit">Add My Favourite</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
