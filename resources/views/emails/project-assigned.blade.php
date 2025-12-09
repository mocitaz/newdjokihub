@extends('emails.layout')

@section('content')
    <div style="text-align: center;">
        <h1>Mission Assignment 🚀</h1>
        <p>You have been hand-picked for a new key project.<br>Please align with the timeline below.</p>
    </div>

    <div class="info-box">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; width: 40%; vertical-align: top;">
                    <span class="info-label">Project Name</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; width: 60%; text-align: right; vertical-align: top;">
                    <span class="info-value">{{ $project->name }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; vertical-align: top;">
                    <span class="info-label">Project Budget</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; text-align: right; vertical-align: top;">
                    <span class="info-value" style="color: #059669;">Rp {{ number_format($project->nett_budget, 0, ',', '.') }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; vertical-align: top;">
                    <span class="info-label">Deadline</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; text-align: right; vertical-align: top;">
                    <span class="info-value">{{ $project->end_date ? $project->end_date->format('d M Y') : 'Flexible' }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; vertical-align: top;">
                    <span class="info-label">Reference ID</span>
                </td>
                <td style="padding: 10px 0; text-align: right; vertical-align: top;">
                    <span class="info-value" style="font-family: monospace; letter-spacing: 0.05em;">{{ $project->order_id }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="highlight-text">
        <strong>⚡ Next Steps:</strong><br>
        Review the project brief in your dashboard. Ensure all deliverables are understood before commencing.
    </div>

    <div style="text-align: center;">
        <a href="{{ route('projects.show', $project) }}" class="btn">Enter Workspace</a>
    </div>
@endsection
