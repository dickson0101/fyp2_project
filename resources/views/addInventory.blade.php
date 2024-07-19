@extends('layout')
@section('content')

<div class="details">
    <div class="recentOrders">
        
        <div class="cardHeader">
            <h2>inventory medication</h2>
            <div class="search">
                <label>
                    <input type="text" placeholder="Search here">
                    <ion-icon name="search-outline"></ion-icon>
                </label>
            </div>
            <a href="{{ route('addMedication') }}" class="btn" >Add new medication</a>
            
            
        </div>

        <table>
            <thead>
                <tr>
                    <td>Medication ID</td>
                    <td>Product name</td>
                    <td>Quantity</td>
                    <td>EXP Date</td>
                    <td>Description</td>
                    <td>Price</td>
                    <td>Action</td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                
                    <td>
                        <button onclick="confirmDelete('')" class="btn-warning">Edit</button>&nbsp;
                        <button onclick="confirmDelete(' ')" class="btn-danger">Delete</button>
                    </td>
                    
                </tr>

                <tr>
                    <td>2</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button onclick="confirmDelete('')" class="btn btn-warning btn-xs">Edit</button>&nbsp;
                        <button onclick="confirmDelete(' ')" class="btn btn-danger btn-xs">Delete</button>
                    </td>
                    
                    
                </tr>

                <tr>
                    <td>3</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button onclick="confirmDelete('')" class="btn btn-warning btn-xs">Edit</button>&nbsp;
                        <button onclick="confirmDelete(' ')" class="btn btn-danger btn-xs">Delete</button>
                    </td>
                    
                    
                </tr>

                <tr>
                    <td>4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button onclick="confirmDelete('')" class="btn btn-warning btn-xs">Edit</button>&nbsp;
                        <button onclick="confirmDelete(' ')" class="btn btn-danger btn-xs">Delete</button>
                    </td>
                    
                </tr>

                <tr>
                    <td>5</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button onclick="('')" class="btn btn-warning btn-xs">Edit</button>&nbsp;
                        <button onclick="confirmDelete(' ')" class="btn btn-danger btn-xs">Delete</button>
                    </td>
                </tr>

                <tr>
                    <td>6</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button onclick="('')" class="btn btn-warning btn-xs">Edit</button>&nbsp;
                        <button onclick="confirmDelete(' ')" class="btn btn-danger btn-xs">Delete</button>
                    </td>
                    
                </tr>

                <tr>
                    <td>7</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button onclick="confirmDelete('')" class="btn btn-warning btn-xs">Edit</button>&nbsp;
                        <button onclick="confirmDelete(' ')" class="btn btn-danger btn-xs">Delete</button>
                    </td>
                    
                </tr>

                <tr>
                    <td>8</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button onclick="confirmDelete('')" class="btn btn-warning btn-xs">Edit</button>&nbsp;
                        <button onclick="confirmDelete(' ')" class="btn btn-danger btn-xs">Delete</button>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>

    
    
        
    </div>
</div>
</div>
</div>

         <script >
 function confirmDelete(redirectUrl) {
            var confirmDelete = confirm("Are you sure you want to delete this item?");
            if (confirmDelete) {
                // 用户点击确定，执行删除操作
                window.location.href = redirectUrl;
            } else {
                // 用户点击取消，不执行任何操作
            }
        }
         </script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@endsection