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

        /* Center and space content */
        .prose,
        .prose p,
        .prose h1,
        .prose h2,
        .prose h3,
        .prose section {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .prose section {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: #ffffffcc;
        }

        .dark .prose section {
            background-color: #111827cc;
            border-color: #374151;
        }

        .prose section:last-child {
            border-bottom: none;
        }

        /* List styling */
        .prose ul {
            list-style: none;
            padding: 0;
            margin: 1rem auto;
            display: inline-block;
            text-align: left;
        }

        .prose ul li {
            position: relative;
            padding-left: 1.75rem;
            margin-bottom: 0.75rem;
            font-size: 1.05rem;
            line-height: 1.7;
            color: inherit;
        }

        .prose ul li::before {
            content: '✓';
            position: absolute;
            left: 0;
            top: 0.1rem;
            color: #4f46e5;
            font-weight: bold;
            font-size: 1rem;
        }

        /* Acknowledgment box */
        .acknowledgment {
            background-color: #e0f2fe;
            border-left: 4px solid #3b82f6;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-top: 2rem;
        }

        .dark .acknowledgment {
            background-color: #1e40af;
            border-left-color: #60a5fa;
            color: #dbeafe;
        }

        /* Responsive typography tweaks */
        h1, h2, h3 {
            line-height: 1.3;
        }

        h1 {
            font-size: 2rem;
        }

        h2 {
            font-size: 1.5rem;
        }

        .transition-colors {
            transition: all 0.3s ease;
        }

        /* Card container */
        .terms-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            max-width: 750px;
            margin: 0 auto;
        }

        .dark .terms-card {
            background-color: #1f2937;
            border: 1px solid #374151;
        }
    </style>



    <div class="container mx-auto px-4 py-12 pt-5">
        <div class="terms-card transition-colors">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                Terms of Use
            </h1>

            <div class="prose prose-lg dark:prose-invert max-w-none">
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-8 text-center">
                    <strong>Last updated:</strong> {{ date('F j, Y') }}<br>
                    <strong>Effective date:</strong> {{ date('F j, Y') }}
                </p>

                <div class="space-y-8">
                    <section>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">1. Welcome — We're Glad You're Here</h2>
                        <p class="text-gray-700 dark:text-gray-300">
                            Thanks for visiting Crypto Trading. We're excited to have you here and want to help you get the most out of your experience. These Terms of Use explain how you can use our website, apps, and services (which we’ll call the “Service”).
                        </p>
                        <p class="text-gray-700 dark:text-gray-300">
                            By using our Service, you're agreeing to these terms. If you ever feel unsure or uncomfortable about them, we encourage you to reach out — your understanding and trust are important to us.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">2. Your Agreement Matters</h2>
                        <p class="text-gray-700 dark:text-gray-300">
                            When you use our Service, you’re agreeing to follow these Terms. To do that, you need to be at least 18 years old and legally able to make this agreement. If you’re using the Service on behalf of a company or group, please make sure you’re allowed to do that — and that you’re okay taking responsibility on their behalf.
                        </p>
                        <p class="text-gray-700 dark:text-gray-300">
                            We know that legal language can feel heavy, but our goal is to make sure everyone using Crypto Trading is on the same page, so we can provide a safe, helpful experience for everyone.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">3. What You Can Expect From Us</h2>
                        <p class="text-gray-700 dark:text-gray-300">
                            Crypto Trading is designed to give you valuable tools, insights, and resources in the world of cryptocurrency. Whether you’re just starting or already experienced, we’re here to support you. Here’s a quick look at what we offer:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 ml-6 mb-4 space-y-2 custom-list">
                            <li>Up-to-date cryptocurrency market data and analysis</li>
                            <li>Connections to your favorite platforms like Facebook</li>
                            <li>Educational tools and trading features to help you learn and grow</li>
                            <li>A welcoming community where you can share, ask, and discuss</li>
                            <li>Portfolio tracking tools to help you stay organized and in control</li>
                        </ul>
                        <p class="text-gray-700 dark:text-gray-300">
                            Everything we build is with you in mind — to help you make smart, informed decisions in the crypto space.
                        </p>
                    </section>

                    <section class="bg-blue-50 dark:bg-blue-900 p-6 rounded-lg border-l-4 border-blue-400 dark:border-blue-300 acknowledgment">
                        <h2 class="text-xl font-semibold text-blue-900 dark:text-blue-100 mb-3">A Gentle Reminder</h2>
                        <p class="text-blue-800 dark:text-blue-200">
                            By continuing to use Crypto Trading, you're letting us know that you've read and understood these Terms — and that you're okay with them. If anything feels unclear or you're unsure about any part, don't hesitate to get in touch. We believe in transparency and want you to feel confident using our Service.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection
