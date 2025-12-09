@extends('layouts.public')

@section('title', 'Support - DjokiHub')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20 pb-32">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-4">How can we help you?</h1>
        <p class="text-lg text-slate-500">Our team is here to assist with any questions or technical issues.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-12 items-start">
        
        <!-- Contact Info -->
        <div class="space-y-8">
            <div class="bg-blue-50 p-8 rounded-3xl border border-blue-100">
                <h3 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Email Support
                </h3>
                <p class="text-slate-600 mb-6">For general inquiries, account issues, or billing questions.</p>
                <a href="mailto:support@djokihub.com" class="text-blue-600 font-bold hover:underline text-lg">support@djokihub.com</a>
            </div>

            <div class="bg-purple-50 p-8 rounded-3xl border border-purple-100">
                <h3 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    Technical Issues
                </h3>
                <p class="text-slate-600 mb-6">Found a bug or having trouble with the codebase? Open an issue on our repository.</p>
                <a href="#" class="inline-flex items-center gap-2 text-purple-600 font-bold hover:underline text-lg">
                    Go to GitHub Issues
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
        </div>

        <!-- FAQ Quick Links -->
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50">
            <h3 class="text-xl font-bold text-slate-900 mb-6">Common Questions</h3>
            
            <div class="space-y-6">
                <div>
                    <h4 class="font-bold text-slate-800 mb-2">I forgot my password</h4>
                    <p class="text-sm text-slate-500">Contact your team administrator to request a password reset link.</p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 mb-2">How do I claim a task?</h4>
                    <p class="text-sm text-slate-500">Navigate to the Claim Center in your dashboard, select an available task, and click the "Claim" button.</p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 mb-2">Why is my payout pending?</h4>
                    <p class="text-sm text-slate-500">Payouts are processed weekly. If your task was approved after Wednesday, it will be included in the next cycle.</p>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-100">
                <a href="{{ route('home') }}#faq" class="block w-full py-3 px-4 bg-slate-900 text-white text-center font-bold rounded-xl hover:bg-slate-800 transition-colors">
                    View Full FAQ
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
