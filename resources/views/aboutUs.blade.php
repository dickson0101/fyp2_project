@extends('layout')
@section('content')
    <div class="container-fluid background_bg" style="color: white;">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6 form-container" style="margin-top: 30px;">
                <h3 class="text-center">about us</h3>
                <form action="{{route('aboutUs')}}" method="post" enctype='multipart/form-data'>
                    @csrf

                            <h6 style="font-size: 2em; color: aliceblue; text-align: center;" >
                             </h6><br><br>
                             <div style="text-align: center;">
        Welcome to our gaming information website! We are a team of gaming enthusiasts who are passionate about sharing our <br>
         knowledge and expertise with others. Our mission is to provide high-quality and up-to-date information on all things <br>
          gaming-related. <br><br>

        We understand that the world of gaming can be overwhelming and ever-changing. That's why we strive to provide <br>
         comprehensive and easy-to-understand information that caters to all levels of gaming experience, from beginners <br>
          to experts. <br><br>
        
        Our team consists of writers, editors, and researchers who are dedicated to providing accurate and reliable information. <br>
         We are constantly staying up-to-date with the latest gaming news, trends, and technologies to ensure that our readers <br>
          have access to the most relevant and useful information. <br><br>
        
        Whether you're looking for information on gaming consoles, PC games, mobile games, or anything in between, we have you <br>
         covered. We provide guides, reviews, and tutorials on a wide range of gaming topics, including game genres, multiplayer <br>
          gaming, esports, game streaming, and much more. <br><br>
        
        We value our readers and strive to create a welcoming and inclusive community for all gamers. We encourage feedback, <br>
         suggestions, and questions from our readers and are always looking for ways to improve our content. <br>
        
        Thank you for choosing our website as your go-to source for gaming information. We hope you find our <br>
         content informative, engaging, and helpful in your gaming journey. <br><br>
        
        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
