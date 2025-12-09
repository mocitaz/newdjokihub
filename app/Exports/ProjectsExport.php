<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $projects;

    public function __construct($projects = null)
    {
        $this->projects = $projects ?? Project::with(['assignedUser', 'creator'])->get();
    }

    public function collection()
    {
        return $this->projects;
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Project Name',
            'Status',
            'Budget (Rp)',
            'Admin Fee %',
            'Admin Fee (Rp)',
            'Nett Budget (Rp)',
            'Assigned To',
            'Created By',
            'Claimed At',
            'Start Date',
            'End Date',
            'Created At',
        ];
    }

    public function map($project): array
    {
        return [
            $project->order_id,
            $project->name,
            ucfirst(str_replace('_', ' ', $project->status)),
            $project->budget,
            $project->admin_fee_percentage,
            $project->admin_fee,
            $project->nett_budget,
            $project->assignedUser ? $project->assignedUser->name : '-',
            $project->creator->name,
            $project->claimed_at ? $project->claimed_at->format('Y-m-d H:i:s') : '-',
            $project->start_date ? $project->start_date->format('Y-m-d') : '-',
            $project->end_date ? $project->end_date->format('Y-m-d') : '-',
            $project->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
