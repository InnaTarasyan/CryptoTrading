<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Page Not Found - 404</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #f9f9f9;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 8rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #ff6b6b;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 320px;
            line-height: 1.4;
            color: #dcdcdc;
        }

        a.btn-home {
            padding: 12px 30px;
            font-size: 1.1rem;
            background-color: #ff6b6b;
            color: white;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        a.btn-home:hover {
            background-color: #e85c5c;
            box-shadow: 0 6px 20px rgba(232, 92, 92, 0.7);
        }

        /* Illustration styling */
        .illustration {
            margin-top: 40px;
            max-width: 300px;
            width: 100%;
            opacity: 0.85;
        }

        /* Responsive */
        @media (max-width: 480px) {
            h1 {
                font-size: 5rem;
            }

            h2 {
                font-size: 1.4rem;
            }

            p {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

<h1>404</h1>
<h2>Oops! Page not found.</h2>
<p>We couldn't find the page you're looking for. It might have been removed, renamed, or is temporarily unavailable.</p>
<a href="{{ url('/') }}" class="btn-home" aria-label="Go to Homepage">Go to Homepage</a>

<img src="https://cdn.dribbble.com/users/285475/screenshots/208308
