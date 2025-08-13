@extends('layouts.base')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Terms of Use</h1>
        
        <div class="prose prose-lg max-w-none">
            <p class="text-gray-600 text-sm mb-8">
                <strong>Last updated:</strong> {{ date('F j, Y') }}<br>
                <strong>Effective date:</strong> {{ date('F j, Y') }}
            </p>

            <div class="space-y-6">
                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. Introduction</h2>
                    <p class="text-gray-700 mb-4">
                        Welcome to Crypto Trading ("we," "our," or "us"). These Terms of Use ("Terms") govern your use of our website, 
                        mobile applications, and services (collectively, the "Service") operated by Crypto Trading.
                    </p>
                    <p class="text-gray-700 mb-4">
                        By accessing or using our Service, you agree to be bound by these Terms. If you disagree with any part of these terms, 
                        then you may not access the Service.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. Acceptance of Terms</h2>
                    <p class="text-gray-700 mb-4">
                        By using our Service, you represent that you are at least 18 years old and have the legal capacity to enter into these Terms. 
                        If you are using the Service on behalf of a company or other legal entity, you represent that you have the authority to bind such entity to these Terms.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. Description of Service</h2>
                    <p class="text-gray-700 mb-4">
                        Crypto Trading provides cryptocurrency trading information, market analysis, social media integration, and related financial services. 
                        Our Service includes but is not limited to:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 ml-6 mb-4 space-y-2">
                        <li>Cryptocurrency market data and analysis</li>
                        <li>Social media integration with platforms like Facebook</li>
                        <li>Trading tools and educational content</li>
                        <li>Community features and discussions</li>
                        <li>Portfolio tracking and management</li>
                    </ul>
                </section>

                <section class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-400">
                    <h2 class="text-xl font-semibold text-blue-900 mb-3">Acknowledgment</h2>
                    <p class="text-blue-800">
                        By using our Service, you acknowledge that you have read these Terms of Use, understand them, 
                        and agree to be bound by them. If you do not agree to these Terms, please do not use our Service.
                    </p>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection 