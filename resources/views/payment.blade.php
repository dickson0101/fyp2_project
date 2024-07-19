<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

   <style>
       body, html {
           height: 100%;
           margin: 0;
           display: flex;
           justify-content: center;
           align-items: center;
           flex-direction: column;
           text-align: center;
           background-image: url('/images/meetings-page-bg.jpg'); /* 替换为你的背景图像URL */
           background-size: cover; /* 使背景图像覆盖整个页面 */
           background-position: center; /* 使背景图像居中 */
           background-repeat: no-repeat; /* 防止背景图像重复 */
           position: relative; /* 使定位相对于body */
       }
       h1 {
           color: white; /* 设置字体颜色为白色 */
       }
       #payment-form {
           display: flex;
           gap: 50px; /* 调整按钮之间的间距 */
           margin-top: 50px; /* 添加上边距使按钮与标题有一定距离 */
       }
       button {
           height: 250px; /* 可以根据需要调整 */
           width: 300px; /* 可以根据需要调整 */
           border: none;
           cursor: pointer;
           text-decoration: none;
           color: black;
           font-size: 16px;
           border-radius: 5px;
           background-color: while; /* 按钮默认背景颜色 */
           box-shadow: 0 0 40px 40px rgba(0, 123, 255, 0) inset, 0 0 0 0 rgba(0, 123, 255, 0); /* 初始阴影效果 */
           transition: all 150ms ease-in-out; /* 过渡效果 */
       }

       button:hover {
           box-shadow: 0 0 10px 0 rgba(0, 123, 255, 0.5) inset, 0 0 10px 4px rgba(0, 123, 255, 0.5); /* 鼠标悬停时的阴影效果 */
       }

       .back-button {
           position: fixed;
           top: 20px;
           left: 20px;
           background-color: #f8f9fa;
           border: none;
           padding: 10px 20px;
           cursor: pointer;
           text-decoration: none;
           color: #333;
           font-size: 16px;
           border-radius: 5px;
       }
       .back-button:hover {
           background-color: #e2e6ea;
       }
   </style>
</head>
<body>
   <a href="/nursePage" class="back-button">Back</a>
   <div>
       <h1><strong>Choose your Payment Method</strong></h1>
       <form action="/checkout" method="POST" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
           <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <button type="submit" name="payment_method" value="debit_card">Debit Card</button>
           <button type="submit" name="payment_method" value="cash">Cash</button>
       </form>
   </div>
</body>
</html>
