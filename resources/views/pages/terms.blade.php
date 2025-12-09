@extends('layouts.public')

@section('title', 'Terms of Service - DjokiHub')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20">
    <div class="mb-12">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Terms of Service</h1>
        <p class="text-slate-500">Last updated: {{ date('F d, Y') }}</p>
    </div>

    <div class="prose prose-slate max-w-none">
        <p class="lead text-lg text-slate-600 mb-8">
            Welcome to DjokiHub. By accessing or using our website and services, you agree to be bound by these Terms of Service.
        </p>

        <h3>1. Acceptance of Terms</h3>
        <p>By accessing DjokiHub, you agree to comply with these terms. If you do not agree, you may not use our services.</p>

        <h3>2. Eligibility</h3>
        <p>You must be at least 18 years old and capable of forming a binding contract to use DjokiHub. Access is currently by invitation only.</p>

        <h3>3. Project Deliverables</h3>
        <p>When you claim a task or project:</p>
        <ul>
            <li>You agree to deliver high-quality code that meets the specified requirements.</li>
            <li>All intelectual property rights for paid deliverables are transferred to the project owner.</li>
            <li>Payments are subject to successful code review and approval.</li>
        </ul>

        <h3>4. Payment Terms</h3>
        <p>Payments are processed weekly for approved deliverables. An administrative fee is deducted from the gross project value as stated in the project details.</p>

        <h3>5. Use of Service</h3>
        <p>You agree not to use DjokiHub for any unlawful purpose or in any way that interrupts, damages, or impairs the service.</p>

        <h3>6. Termination</h3>
        <p>We reserve the right to terminate or suspend your account immediately, without prior notice or liability, for any reason, including breach of these Terms.</p>

        <h3>7. Changes to Terms</h3>
        <p>We reserve the right to modify these terms at any time. We will notify you of any changes by posting the new terms on this site.</p>
    </div>
</div>
@endsection
