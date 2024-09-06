<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Medical System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            height: 100%;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header {
            background: #50a3a2;
            color: white;
            padding: 1rem 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #ffffff;
            color: #50a3a2;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
        }
        .btn:hover {
            background: #e8e8e8;
        }
        .main-content {
            display: flex;
            height: calc(100% - 200px);
        }
        .left-side {
            width: 60%;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right-side {
            width: 40%;
            background: url('{{ asset('images/medical.jpg') }}') no-repeat center center/cover;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .login-section {
            margin-top: 20px;
        }
        .login-btn {
            display: inline-block;
            padding: 10px 30px;
            background: #50a3a2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
        }
        .register-link {
            margin-top: 10px;
            font-size: 0.9em;
        }
        .about-us {
            background: #f4f4f4;
            padding: 30px 0;
            text-align: center;
            position: relative; /* For positioning the line */
        }
        .about-us hr {
            width: 50%;
            margin: 20px auto;
            border: 0;
            border-top: 1px solid #ccc;
        }
        footer {
            background: #50a3a2;
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }
        header #branding h1 {
            margin: 0;
        }
        header nav {
            display: flex;
            gap: 10px;
        }
        header .highlight, header .current a {
            color: #e8491d;
            font-weight: bold;
        }
        header a:hover {
            color: #ffffff;
            font-weight: bold;
        }

        .social-media {
        margin-top: 10px;
    }
    .social-icon {
        margin: 0 10px;
        color: white;
        text-decoration: none;
        font-size: 1.5em;
    }
    .social-icon:hover {
        color: #e8e8e8;
    }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">Medical</span>System</h1>
            </div>
            <nav>
                <a href="{{ route('login') }}" class="btn">Login</a>
                <a href="{{ route('register') }}" class="btn">Register</a>
            </nav>
        </div>
    </header>

    <div class="main-content">
        <div class="left-side">
            <h1>Welcome to Our Medical System</h1>
            <div class="login-section">
                <a href="{{ route('login') }}" class="login-btn">Login</a>
                <p class="register-link">
                    Don't have an account? <a href="#">Register here</a>
                </p>
            </div>
        </div>
        <div class="right-side">
            <!-- This div will be the background image -->
        </div>
    </div>

    <section class="about-us">
        <hr> <!-- 添加的水平线 -->
        <h2>About Us</h2>
        <p>We are dedicated to providing high-quality medical services and ensuring the well-being of our patients.<br>Our team of experienced professionals is committed to delivering personalized care and innovative healthcare solutions.</p>
    </section>

    <footer>
    <p>&copy; 2023 Our Medical System. All rights reserved.</p>
    <div class="social-media">
        <a href="https://www.facebook.com" target="_blank" class="social-icon">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.instagram.com" target="_blank" class="social-icon">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.twitter.com" target="_blank" class="social-icon">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="https://www.linkedin.com" target="_blank" class="social-icon">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
</footer>


</body>
</html>
