@extends('layouts.base')

@section('content')
<div class="privacy-policy-container" style="max-width: 800px; margin: 2em auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(34,185,255,0.07); padding: 2em 1.5em; font-size: 1.1em;">
    <h1 style="font-size: 2.2em; font-weight: 700; color: #22b9ff; text-align: center; margin-bottom: 1em;">Privacy Policy</h1>
    <p style="text-align: center; color: #888; margin-bottom: 2em;">Effective date: <b>{{ date('F d, Y') }}</b></p>
    <p>Your privacy is important to us. This Privacy Policy explains how information about you is collected, used, and protected by Inna Tarasyan when you use this website.</p>

    <h2>Information We Collect</h2>
    <ul>
        <li><b>Personal Information:</b> We may collect your name, email address, or other contact details if you contact us directly or sign up for updates.</li>
        <li><b>Usage Data:</b> We automatically collect information about your device, browser, IP address, and how you interact with the site (such as pages visited and time spent).</li>
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
<style>
@media (max-width: 600px) {
    .privacy-policy-container {
        padding: 1em 0.5em;
        font-size: 1em;
    }
    .privacy-policy-container h1 {
        font-size: 1.4em;
    }
}
</style>
@endsection 