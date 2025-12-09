@extends('emails.layout')

@section('content')
    <div style="text-align: center;">
        <h1>Secured Successfully 🔒</h1>
        <p>You have successfully claimed this project.<br>It is now locked exclusively for you.</p>
    </div>

    <div class="info-box">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; width: 40%; vertical-align: top;">
                    <span class="info-label">Project Scope</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; width: 60%; text-align: right; vertical-align: top;">
                    <span class="info-value">{{ $project->name }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; vertical-align: top;">
                    <span class="info-label">Locked Value</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px dashed #e2e8f0; text-align: right; vertical-align: top;">
                    <span class="info-value" style="color: #059669;">Rp {{ number_format($project->nett_budget, 0, ',', '.') }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; vertical-align: top;">
                    <span class="info-label">Due Date</span>
                </td>
                <td style="padding: 10px 0; text-align: right; vertical-align: top;">
                    <span class="info-value">{{ $project->end_date ? $project->end_date->format('d M Y') : 'Open Timeline' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="highlight-text">
        <strong>💡 Pro Tip:</strong><br>
        Maintain regular updates on your progress. Clients trust consistency.
    </div>

    <div style="text-align: center;">
        <a href="{{ route('projects.show', $project) }}" class="btn">Start Working</a>
    </div>
@endsection
