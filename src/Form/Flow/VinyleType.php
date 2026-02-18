<?php

namespace App\Form\Flow;

use App\Form\Flow\DTO\DescriptionDTO;
use App\Form\Flow\DTO\NameDTO;
use App\Form\Flow\DTO\PriceDTO;
use Symfony\Component\Validator\Constraints\Valid;

class VinyleType
{
    public function __construct(
        #[Valid(groups: ['step1'])]
        public ?NameDTO $name = null,

        #[Valid(groups: ['step2'])]
        public ?DescriptionDTO $description = null,

        #[Valid(groups: ['step3'])]
        public ?PriceDTO $price = null,

        public string $currentStep = 'step1',
    ) {
    }
}
