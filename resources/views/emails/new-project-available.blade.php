@extends('emails.layout')

@section('content')
    <div style="text-align: center;">
        <h1>New Drop Alert 🔥</h1>
        <p>A fresh opportunity has landed in the Claim Center.<br>Available immediately for all eligible staff.</p>
    </div>

    <div class="info-box">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; width: 40%; vertical-align: top;">
                    <span class="info-label">Project</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; width: 60%; text-align: right; vertical-align: top;">
                    <span class="info-value">{{ $project->name }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; vertical-align: top;">
                    <span class="info-label">Client</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; text-align: right; vertical-align: top;">
                    <span class="info-value">{{ $project->client_name ?? 'Internal Request' }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; vertical-align: top;">
                    <span class="info-label">Potential Earnings</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; text-align: right; vertical-align: top;">
                    <span class="info-value" style="color: #059669;">Rp {{ number_format($project->nett_budget, 0, ',', '.') }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; vertical-align: top;">
                    <span class="info-label">Difficulty</span>
                </td>
                <td style="padding: 10px 0; text-align: right; vertical-align: top;">
                    <span class="info-value">{{ ucfirst($project->difficulty ?? 'Standard') }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="highlight-text">
        <strong>⚡ Speed Matters:</strong><br>
        Projects in the Claim Center are First-Come, First-Served.
    </div>

    <div style="text-align: center;">
        <a href="{{ route('claim-center.show', $project) }}" class="btn">View & Claim Now</a>
    </div>
@endsection
