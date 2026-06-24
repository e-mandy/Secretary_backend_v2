<?php

use App\Enums\FiliereType;
use App\Enums\OptionType;
use App\Http\Requests\DefenseReport\StoreDefenseReportRequest;
use Illuminate\Http\UploadedFile;

readonly class CreateDefenseReportDTO {
    public function __construct(
        public string $owner,
        public string $theme,
        public string $defense_date,
        public FiliereType $filiere,
        public float $note,
        public OptionType $option,
        public UploadedFile $file
    ){}

    public static function fromRequest(StoreDefenseReportRequest $request): self{
        $data = $request->validated();
    
        return new self(
            owner: $data['owner'],
            theme: $data['theme'],
            note: $data['note'],
            option: $data['option'],
            filiere: $data['filiere'],
            defense_date: $data["defense_date"],
            file: $request->file('file')
        );
    }
}