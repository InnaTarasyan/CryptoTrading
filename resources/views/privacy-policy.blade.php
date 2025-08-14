@extends('layouts.base')

@section('content')
    <style>
        html {
            scroll-behavior: smooth;
        }

        /* Font & background styles */
        body {
            font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 1.05rem;
            line-height: 1.75;
            background: linear-gradient(135deg, #f8fafc, #e0f2fe);
            color: #1f2937; /* gray-800 */
            transition: background-color 0.3s ease, color 0.3s ease;
            padding: 1rem;
        }

        .dark body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #d1d5db; /* gray-300 */
        }

        /* Container card */
        .privacy-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            max-width: 750px;
            margin: 2rem auto;
            transition: background-color 0.3s ease, border 0.3s ease;
        }

        .dark .privacy-card {
            background-color: #1f2937;
            border: 1px solid #374151;
        }

        /* Headings */
        h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #22b9ff;
            text-align: center;
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: inherit;
        }

        /* Paragraphs */
        p {
            margin-bottom: 1rem;
            color: inherit;
        }

        /* Effective date */
        .effective-date {
            text-align: center;
            color: #888;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        /* Lists */
        ul {
            list-style: none;
            padding: 0;
            margin-left: 1rem;
            max-width: 600px;
        }

        ul li {
            position: relative;
            padding-left: 1.75rem;
            margin-bottom: 0.75rem;
            font-size: 1.05rem;
            line-height: 1.6;
        }

        ul li::before {
            content: '✓';
            position: absolute;
            left: 0;
            top: 0.2rem;
            color: #22b9ff;
            font-weight: bold;
            font-size: 1rem;
        }

        /* Links */
        a {
            color: #22b9ff;
            text-decoration: underline;
        }

        a:hover {
            color: #1a8fcc;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .privacy-card {
                padding: 1rem 1rem;
                font-size: 1rem;
            }

            h1 {
                font-size: 1.6rem;
            }

            h2 {
                font-size: 1.25rem;
            }
        }
    </style>

    <div class="privacy-card">
        <h1>Privacy Policy</h1>
        <p class="effective-date">Effective date: <b>{{ date('F d, Y') }}</b></p>

        <p>Your privacy is important to us. This Privacy Policy explains how information about you is collected, used, and protected by Inna Tarasyan when you use this website.</p>

        <h2>Information We Collect</h2>
        <ul>
            <li><strong>Personal Information:</strong> We may collect your name, email address, or other contact details if you contact us directly or sign up for updates.</li>
            <li><strong>Usage Data:</strong> We automatically collect information about your device, browser, IP address, and how you interact with the site (such as pages visited and time spent).</li>
        </ul>

        <h2>How We Use Your Information</h2>
        <ul>
            <li>To provide, operate, and maintain the website</li>
            <li>To improve, personalize, and expand our website</li>
            <li>To communicate with you, respond to inquiries, and provide support</li>
            <li>To analyze usage and trends to improve user experience</li>
            <li>To comply with legal obligations</li>
        </ul>

        <h2>Cookies</h2>
        <p>This website uses cookies to enhance your browsing experience. Cookies are small data files stored on your device. You can disable cookies in your browser settings, but some features of the site may not function properly.</p>

        <h2>Your Rights</h2>
        <ul>
            <li>You have the right to access, update, or delete your personal information.</li>
            <li>You may opt out of receiving communications at any time.</li>
            <li>To exercise your rights, please contact us using the details below.</li>
        </ul>

        <h2>Security</h2>
        <p>We take reasonable steps to protect your information from unauthorized access, disclosure, or loss. However, no method of transmission over the Internet or electronic storage is 100% secure.</p>

        <h2>Links to Other Sites</h2>
        <p>This website may contain links to external sites not operated by us. We are not responsible for the privacy practices or content of those sites.</p>

        <h2>Changes to This Policy</h2>
        <p>We may update this Privacy Policy from time to time. Changes will be posted on this page with an updated effective date.</p>

        <h2>Contact</h2>
        <p>If you have any questions or concerns about this Privacy Policy or your data, please contact Inna Tarasyan at <a href="mailto:inna.tarasyan@gmail.com">inna.tarasyan@gmail.com</a>.</p>
    </div>
@endsection
