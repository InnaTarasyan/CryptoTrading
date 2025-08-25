<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>500 Internal Server Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fefefe;
            text-align: center;
            padding: 50px;
            color: #333;
        }
        h1 {
            font-size: 48px;
            margin-bottom: 10px;
        }
        p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        a {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Oops! Something went wrong.</h1>
<p>We're experiencing an internal server error. Please try again later.</p>
<a href="{{ url('/') }}">Go Back to Home</a>
</body>
</html>
