@extends('layouts.public')

@section('title', 'Privacy Policy - DjokiHub')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20">
    <div class="mb-12">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Privacy Policy</h1>
        <p class="text-slate-500">Last updated: {{ date('F d, Y') }}</p>
    </div>

    <div class="prose prose-slate max-w-none">
        <p class="lead text-lg text-slate-600 mb-8">
            At DjokiHub, we take your privacy seriously. This privacy policy describes how we collect, use, and protect your personal information when you use our platform.
        </p>

        <h3>1. Information We Collect</h3>
        <p>We collect information that you provide directly to us, including:</p>
        <ul>
            <li>Personal identification information (Name, email address, phone number)</li>
            <li>Professional information (Resume, skills, portfolio)</li>
            <li>Financial information (Bank account details for payments)</li>
        </ul>

        <h3>2. How We Use Your Information</h3>
        <p>We use the information we collect to:</p>
        <ul>
            <li>Process your project applications and claims.</li>
            <li>Facilitate payments for completed work.</li>
            <li>Communicate with you about project updates and platform changes.</li>
            <li>Improve and optimize our platform services.</li>
        </ul>

        <h3>3. Information Sharing</h3>
        <p>We do not sell your personal information. We may share your information with:</p>
        <ul>
            <li>Project managers and administrators within the organization.</li>
            <li>Third-party service providers (e.g., payment processors) necessary for platform operations.</li>
        </ul>

        <h3>4. Data Security</h3>
        <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

        <h3>5. Contact Us</h3>
        <p>If you have any questions about this Privacy Policy, please contact us at <a href="mailto:privacy@djokihub.com" class="text-blue-600 hover:text-blue-800">privacy@djokihub.com</a>.</p>
    </div>
</div>
@endsection
