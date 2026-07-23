<?php

namespace App\Services;

use App\DTOs\DefenseReport\CreateDefenseReportDTO;
use App\DTOs\DefenseReport\UpdateDefenseReportDTO;
use App\Http\Resources\DefenseReportResource;
use App\Models\DefenseReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DefenseReportService {
    public function index(){
        $reports = DefenseReport::orderBy('created_at', 'desc')->paginate(10);

        return DefenseReportResource::collection($reports);
    }

    public function create(CreateDefenseReportDTO $data): DefenseReportResource {
        $file_path = $data->file->store('uploads/defense_reports', 'public');

        $report = DefenseReport::create([
            'owner'               => $data->owner,
            'theme'               => $data->theme,
            'defense_date'        => $data->defense_date,
            'filiere'             => $data->filiere->value,
            'option'              => $data->option->value,
            'note'                => $data->note,
            'defense_report_path' => $file_path,
        ]);

        return new DefenseReportResource($report);
    }

    public function show(DefenseReport $report): DefenseReportResource {
        return new DefenseReportResource($report);
    }

    public function update(DefenseReport $report, UpdateDefenseReportDTO $data): DefenseReportResource {
        $updateData = array_filter([
            'owner'        => $data->owner,
            'theme'        => $data->theme,
            'defense_date' => $data->defense_date,
            'filiere'      => $data->filiere?->value,
            'option'       => $data->option?->value,
            'note'         => $data->note,
        ], fn($v) => $v !== null);

        if ($data->file) {
            Storage::disk('public')->delete($report->defense_report_path);
            $updateData['defense_report_path'] = $data->file->store('uploads/defense_reports', 'public');
        }

        $report->fill($updateData)->save();

        return new DefenseReportResource($report->fresh());
    }

    public function download(DefenseReport $defense_report){
        if(!Storage::disk('public')->exists($defense_report->defense_report_path)) abort(404, "Fichier introuvable sur le serveur");

        $file_extenstion = pathinfo($defense_report->file_path, PATHINFO_EXTENSION);
        $file_name = Str::slug($defense_report->title, '-') . "." . $file_extenstion;

        return Storage::disk('public')->download($defense_report->defense_report_path, $file_name);
    }

    public function destroy(DefenseReport $report): bool {
        Storage::disk('public')->delete($report->defense_report_path);

        return (bool) DefenseReport::destroy($report->id);
    }

    public function getPDFUrl(DefenseReport $defense_report){
         $path = storage_path($defense_report->defense_report_path);
    
        if (!file_exists($path)) {
            abort(404);
        }

        return $path;
    }
}
