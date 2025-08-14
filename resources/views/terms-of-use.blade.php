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
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">1. Welcome</h2>
                        <p class="text-gray-700 dark:text-gray-300">
                            Thanks for visiting Crypto Trading! These Terms of Use explain how you can use our website, mobile app, and services (called the "Service").
                        </p>
                        <p class="text-gray-700 dark:text-gray-300">
                            By using our Service, you’re agreeing to these Terms. If you don’t agree, please don’t use our platform.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">2. Agreeing to These Terms</h2>
                        <p class="text-gray-700 dark:text-gray-300">
                            To use our Service, you must be at least 18 years old and legally able to agree to these Terms. If you’re using the Service for a company, you confirm that you have the right to accept these Terms for that company.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">3. What We Offer</h2>
                        <p class="text-gray-700 dark:text-gray-300">
                            Crypto Trading provides tools, insights, and features to help you understand and manage cryptocurrency trading. Here’s what’s included:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 ml-6 mb-4 space-y-2 custom-list">
                            <li>Live market data and analysis</li>
                            <li>Social media features like Facebook integration</li>
                            <li>Trading tools and learning resources</li>
                            <li>Community forums and discussion areas</li>
                            <li>Tools to track and manage your portfolio</li>
                        </ul>
                    </section>

                    <section class="bg-blue-50 dark:bg-blue-900 p-6 rounded-lg border-l-4 border-blue-400 dark:border-blue-300 acknowledgment">
                        <h2 class="text-xl font-semibold text-blue-900 dark:text-blue-100 mb-3">Please Note</h2>
                        <p class="text-blue-800 dark:text-blue-200">
                            By continuing to use our Service, you confirm that you’ve read and understood these Terms, and that you agree to follow them. If not, please stop using the Service.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection
