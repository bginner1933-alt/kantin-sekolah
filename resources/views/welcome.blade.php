<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Blade</title>
    <style>
        /* Reset dan style dasar */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        /* Container utama */
        .container {
            text-align: center;
            padding: 40px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            z-index: 2;
            position: relative;
        }

        /* Background bergerak */
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #0FD7F1FF, #fbc2eb);
            background-size: 400% 400%;
            animation: moveBackground 20s ease infinite;
            z-index: -1;
        }

        @keyframes moveBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Efek animasi untuk teks */
        .welcome-text h1 {
            font-size: 3em;
            margin: 0 0 20px 0;
            color: #333;
            animation: fadeIn 1s ease-out forwards;
            opacity: 0;
        }

        .welcome-text p {
            font-size: 1.2em;
            margin-bottom: 30px;
            color: #555;
            animation: fadeIn 1.5s ease-out forwards;
            opacity: 0;
        }

        /* Animasi fade-in */
        @keyframes fadeIn {
            to { opacity: 1; }
        }

        /* Tombol login/register */
        .buttons a {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            font-size: 1.1em;
            text-decoration: none;
            border-radius: 50px;
            transition: 0.3s;
            font-weight: bold;
        }

        .login-btn {
            background: rgba(0, 0, 0, 0.1);
            color: #333;
            border: 2px solid #333;
        }

        .login-btn:hover {
            background: #333;
            color: white;
        }

        .register-btn {
            background: #08E3EBFF;
            color: white;
        }

        .register-btn:hover {
            background: #ff85ab;
        }

        /* Responsif untuk layar kecil */
        @media(max-width: 768px) {
            .welcome-text h1 { font-size: 2.5em; }
            .welcome-text p { font-size: 1.1em; }
            .buttons a { padding: 10px 20px; font-size: 1em; }
        }

    </style>
</head>
<body>

    <div class="background"></div>

    <div class="container">
        <div class="welcome-text">
            <h1>Selamat Datang!</h1>
            <p>Nikmati pengalaman interaktif ini.</p>
        </div>

        <div class="buttons">
            <a href="/login" class="login-btn">Login</a>
            <a href="/register" class="register-btn">Register</a>
        </div>
    </div>

</body>
</html>
