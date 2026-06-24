<?php

use App\Enums\FiliereType;
use App\Enums\OptionType;

readonly class CreateDefenseReportDTO {
    public function __construct(
        public string $owner,
        public string $theme,
        public Date $defense_date,
        public FiliereType $filiere,
        public Number $note,
        public OptionType $option
    ){}

    public static function fromRequest(): self{
        return new self(
            owner: 
        );
    }
}