<?php
namespace App\DTOs\DefenseReport;

use App\Enums\FiliereType;
use App\Enums\OptionType;
use App\Http\Requests\DefenseReport\UpdateDefenseReportRequest;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

readonly class UpdateDefenseReportDTO {
    public function __construct(
        public ?string $owner,
        public ?string $theme,
        public ?string $defense_date,
        public ?FiliereType $filiere,
        public ?float $note,
        public ?OptionType $option,
        public ?UploadedFile $file
    ){}

    public static function fromRequest(UpdateDefenseReportRequest $request): self{
        $data = $request->validated();

        return new self(
            owner: $data['owner'] ?? null,
            theme: $data['theme'] ?? null,
            note: $data['note'] ?? null,
            option: isset($data['option']) ? OptionType::from($data['option']) : null,
            filiere: isset($data['filiere']) ? FiliereType::from($data['filiere']) : null,
            defense_date: isset($data['defense_date']) ? Carbon::parse($data['defense_date'])->toDateString() : null,
            file: $request->hasFile('file') ? $request->file('file') : null
        );
    }
}
