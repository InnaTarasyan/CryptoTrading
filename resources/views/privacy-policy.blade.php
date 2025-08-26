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

        .safety-notice {
            background-color: #f1f8f5;
            border-left: 4px solid #34a853;
            padding: 15px 20px;
            margin: 20px auto;
            max-width: 700px;
            font-family: Arial, sans-serif;
            font-size: 15px;
            color: #202124;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .safety-notice a {
            color: #1a73e8;
            text-decoration: none;
        }

        .safety-notice a:hover {
            text-decoration: underline;
        }

        .safe-browsing-badge {
            display: inline-block;
            padding: 8px 12px;
            background-color: #34a853;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .safe-browsing-badge:hover {
            background-color: #2c8a44;
        }
        .security-rating {
            max-width: 320px;
            background: #f9f9f9;
            border: 2px solid #28a745; /* green border for success */
            padding: 1em 1.5em;
            border-radius: 8px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            box-shadow: 0 2px 6px rgba(40, 167, 69, 0.3);
            margin: 1em auto;
            text-align: center;
        }

        .security-rating h2 {
            margin-top: 0;
            color: #28a745;
        }

        .security-rating a {
            color: #28a745;
            text-decoration: none;
            font-weight: 600;
        }

        .security-rating a:hover {
            text-decoration: underline;
        }

        .badge {
            margin-top: 1em;
            display: inline-block;
            background: #28a745;
            color: white;
            font-weight: bold;
            font-size: 2rem;
            width: 60px;
            height: 60px;
            line-height: 60px;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.6);
            user-select: none;
        }
    </style>

    <div class="privacy-card">
        <h1>Privacy Policy</h1>
        <p class="effective-date">Effective date: <b>{{ date('F d, Y') }}</b></p>

        <p>We truly value your privacy and want you to feel safe and comfortable while using this website. This Privacy Policy explains how we collect, use, and protect the information you share with us.</p>

        <h2>Information We Collect</h2>
        <ul>
            <li><strong>Personal Information:</strong> If you reach out to us or subscribe for updates, we may collect your name, email, or other contact info — and only with your permission.</li>
            <li><strong>Usage Data:</strong> We automatically gather some details about your device, browser, IP address, and how you use our site to help us improve your experience.</li>
        </ul>

        <h2>How We Use Your Information</h2>
        <ul>
            <li>To keep the website running smoothly and reliably</li>
            <li>To make your experience more personalized and enjoyable</li>
            <li>To respond to your questions, feedback, or requests quickly and helpfully</li>
            <li>To understand how our site is used and find ways to improve it for you</li>
            <li>To meet legal requirements and keep everything above board</li>
        </ul>

        <h2>Cookies</h2>
        <p>Our website uses cookies — small files stored on your device — to make browsing smoother and remember your preferences. You can disable cookies in your browser, but some features might not work as well without them.</p>

        <h2>Your Rights</h2>
        <ul>
            <li>You have the right to see, update, or delete any personal information we have about you.</li>
            <li>You can unsubscribe from our emails anytime — no hard feelings!</li>
            <li>If you want to exercise these rights or have questions, please don’t hesitate to get in touch with us below.</li>
        </ul>

        <h2>Security</h2>
        <p>We do our best to protect your data with strong safeguards, but please remember that no method of online data transfer or storage is 100% risk-free.</p>

        <h2>Links to Other Sites</h2>
        <p>Sometimes, we link to other websites that we think you might find useful. We’re not responsible for how those sites handle your information, so please review their privacy policies directly.</p>

        <h2>Changes to This Policy</h2>
        <p>We may update this policy occasionally to reflect changes or improvements. When we do, we'll post the new version here with the latest effective date.</p>

        <h2>Contact</h2>
        <p>If you have any questions, concerns, or just want to say hello, feel free to reach out to Inna Tarasyan at <a href="mailto:inna.tarasyan@gmail.com">inna.tarasyan@gmail.com</a>. We're here to help!</p>

        <div class="safety-notice">
            ✅ As of our last check, Google Safe Browsing has not detected any unsafe content on this site.
            You can view the current status <a href="https://transparencyreport.google.com/safe-browsing/search" target="_blank" rel="noopener noreferrer">here</a>.
        </div>

        <a href="https://transparencyreport.google.com/safe-browsing/search?url=cryptotrading.website" target="_blank" class="safe-browsing-badge">
            ✔ Verified Clean by Google Safe Browsing
        </a>

        <section class="security-rating">
            <h2>Website Security</h2>
            <p>We’re proud to have earned an <strong>A+</strong> rating on
                <a href="https://securityheaders.com/?q=https%3A%2F%2Fcryptotrading.website&followRedirects=on"
                   target="_blank" rel="noopener noreferrer">SecurityHeaders.com</a> — ensuring your data is well protected.</p>
            <div class="badge">
                <span>A+</span>
            </div>
        </section>

        <div style="background-color:#f3f4f6; padding:10px; border-left:5px solid #28a745; font-family:sans-serif;">
            <p style="margin:0;">🔐 <strong>SSL Rating:</strong> <span style="color:#28a745;">A (IPv4 & IPv6)</span> — Verified by
                <a href="https://www.ssllabs.com/ssltest/analyze.html?d=cryptotrading.website" target="_blank" rel="noopener noreferrer">
                    SSL Labs
                </a> on August 26, 2025.
            </p>
        </div>

        <a href="https://www.ssllabs.com/ssltest/analyze.html?d=cryptotrading.website" target="_blank" rel="noopener noreferrer">
            <img src="screen__.png" alt="SSL Labs Grade A" style="max-width:150px;"/>
        </a>


    </div>
@endsection
