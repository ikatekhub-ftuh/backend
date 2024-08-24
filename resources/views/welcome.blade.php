<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antek Hub</title>
    <style>
        /* Mengatur style untuk keseluruhan halaman */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom, #D80100, #000000);
            font-family: 'Open Sans', sans-serif;
            color: white;
            text-align: center;
        }

        .logo img {
            width: 212px;
            height: 212px;
            padding-bottom: 60px;
        }

        /* Style untuk bagian teks */
        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .content h1 {
            font-size: 3em;
            margin: 0;
        }

        .content p {
            font-size: 1.5em;
            margin: 0;
        }

        .copyright {
            position: absolute;
            bottom: 0;
        }
    </style>
</head>
<body>    
    <!-- Bagian untuk teks tengah -->
    <div class="content logo">
        <img src="/storage/logo-ikatek.PNG" alt="">
        <h1>ANTEK HUB</h1>
        <p>Adaptive Collaborative</p>
    </div>

    <div class="copyright">
        <p>Copyright © <?= date("Y"); ?> Antek Hub.</p>
    </div>
</body>
</html>
