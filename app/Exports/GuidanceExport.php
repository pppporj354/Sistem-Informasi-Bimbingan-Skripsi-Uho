<?php

namespace App\Exports;

use App\Models\Guidance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class GuidanceExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $guidancesQuery = Guidance::with(['student.user', 'lecturer.user', 'thesis'])
            ->latest('schedule');

        if (!empty($this->filters['status']) && in_array($this->filters['status'], ['pending', 'approved'])) {
            $guidancesQuery->where('status_request', $this->filters['status']);
        }

        if (!empty($this->filters['lecturer_id']) && $this->filters['lecturer_id'] !== 'all') {
            $guidancesQuery->where('lecturer_id', $this->filters['lecturer_id']);
        }

        if (!empty($this->filters['q'])) {
            $q = $this->filters['q'];
            $guidancesQuery->whereHas('student', function ($sq) use ($q) {
                $sq->where('nim', 'like', "%$q%");
            })->orWhereHas('student.user', function ($uq) use ($q) {
                $uq->where('name', 'like', "%$q%");
            });
        }

        if (!empty($this->filters['start_date'])) {
            $guidancesQuery->whereDate('schedule', '>=', $this->filters['start_date']);
        }

        if (!empty($this->filters['end_date'])) {
            $guidancesQuery->whereDate('schedule', '<=', $this->filters['end_date']);
        }

        return $guidancesQuery;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Mahasiswa',
            'NIM',
            'Dosen Pembimbing',
            'Judul Skripsi',
            'Status',
            'Catatan Dosen',
        ];
    }

    public function map($guidance): array
    {
        return [
            optional($guidance->schedule)->format('Y-m-d H:i') ?? '-',
            $guidance->student->user->name ?? '-',
            $guidance->student->nim ?? '-',
            $guidance->lecturer->user->name ?? '-',
            $guidance->thesis->title ?? '-',
            $guidance->status_request === 'approved' ? 'Disetujui' :
                ($guidance->status_request === 'pending' ? 'Diajukan' : '-'),
            $guidance->lecturer_notes ?? '-',
        ];
    }
}
