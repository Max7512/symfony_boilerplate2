<?php

namespace App\Form\Flow\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PriceDTO
{
    #[Assert\NotBlank(groups: ['step3'])]
    #[Assert\PositiveOrZero(groups: ['step3'])]
    public ?float $price = null;
}