@extends('layout')
@section('content')

<div class="container-fluid background_bg" style="color: white;">
<style>
   
input[type=text], select, textarea {
  width: 100%; 
  padding: 12px; 
  border: 1px solid #2c2b2b; 
  border-radius: 
  box-sizing border-box;
  margin-top: 6px; 
  resize: vertical 
}


input[type=submit] {
  background-color: #04AA6D;
  color: rgb(34, 33, 33);
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}


input[type=submit]:hover {
  background-color: #45a049;
}


.container {
  border-radius: 5px;
  background-color: rgb(0, 0, 0);
  padding: 20px;
  background: fixed;
  background-size: cover;
  color: white;
}

        
  </style>

  <body>
  <div class="container" style="">
   
    <h3 class="text-center">Feedback</h3>
         <form action="{{route('feedback')}}" method="post" enctype='multipart/form-data'>
         @csrf
         <br><br>
      <label for="firstName">First Name</label>
      <input type="text" id="firstName" name="firstName" placeholder="Your name..">
      <br><br>
      <label for="lastName">Last Name</label>
      <input type="text" id="lastName" name="lastName" placeholder="Your last name..">
      <br><br>
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" placeholder="Your E-mail..">
 
 
      </select>
  
      <label for="content">Any issue or problem</label>
      <textarea id="content" name="content" placeholder="Write something.." style="height:200px"></textarea>
  
      <input type="submit" value="Submit">
  
    </form>
  </div>

  
</body>

</div>
      

@endsection

