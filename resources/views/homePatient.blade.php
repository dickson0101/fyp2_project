@extends('layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="container">
    
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="profile-pic"></div>
            <div>
                <h2 class="username">Administrator</h2>
                <p class="email">admin@edoc.com</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Log out</button>
        </form>
        <nav class="sidebar-nav">
        <a href="{{ route('homePatient') }}" class="nav-link active">Home</a>
            <a href="{{ route('aboutUs') }}" class="nav-link">About Us</a>
            <a href="{{ route('contactUs') }}" class="nav-link">Contact Us</a>
            <a href="{{ route('F&Q') }}" class="nav-link">F&Q</a>
            <a href="{{ route('feedback') }}" class="nav-link">Feeback</a>
            <a href="{{ route('account') }}" class="nav-link">Account</a>
        </nav>
       
    </div>

<div class="main-content">
    <div class="header">
    
            
        <div class="date-container">
            <p class="date-label">Today's Date</p>
            <p class="date-value">{{ now()->format('Y-m-d') }}</p>
        </div>
    </div>

<body>
        
<div class="cardBox">
    <a href="{{ route('appointment') }}" class="card"> 
        <div>
            <div class="cardName">Make Appointment</div>
        </div>
        <div class="iconBx">
            <ion-icon name="today-outline"></ion-icon>
        </div>
    </a>

     

</div>


            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Appointment</h2>
                        
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Time</td>
                                <td>Treatmennt</td>
                                <td>Doctor Name</td>
                                <td>Appointment Status</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>26/6/24</td>
                                <td>8.00AM</td>
                                <td>Fracture</td>
                                <td>Dr.Chong</td>
                                <td><span class="status delivered">Approve</span></td>
                            </tr>

                            <tr>
                                <td>28/6/24</td>
                                <td>9.00AM</td>
                                <td>Hypertension</td>
                                <td>Dr.Wahida</td>
                                <td><span class="status inProgress">In Progress</span></td>
                            </tr>

                            <tr>
                                <td>30/6/24</td>
                                <td>11.00AM</td>
                                <td>Fever</td>
                                <td>Dr.Neo</td>
                                <td><span class="status return">Reject</span></td>
                            </tr>

                            <tr>
                                <td>06/7/24</td>
                                <td>2.00PM</td>
                                <td>Covid-19</td>
                                <td>Dr.Chan</td>
                                <td><span class="status inProgress">In Progress</span></td>
                            </tr>

                            <tr>
                                <td>09/7/24</td>
                                <td>2.30PM</td>
                                <td>Asthma</td>
                                <td>Dr.Yang</td>
                                <td><span class="status delivered">Approve</span></td>
                            </tr>

                            <tr>
                                <td>10/7/24</td>
                                <td>8.30AM</td>
                                <td>Injuried</td>
                                <td>Dr.Najib</td>
                                <td><span class="status delivered">Approve</span></td>
                            </tr>

                            <tr>
                                <td>12/7/24</td>
                                <td>12.00PM</td>
                                <td>HIV</td>
                                <td>Dr.Mahathir</td>
                                <td><span class="status delivered">Approve</span></td>
                            </tr>

                            <tr>
                                <td>14/7/24</td>
                                <td>5.00PM</td>
                                <td>Others</td>
                                <td>Dr.Azizah</td>
                                <td><span class=" status delivered">Approve</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                
                
                    
                </div>
            </div>
        </div>
    </div>

</body>
@endsection
