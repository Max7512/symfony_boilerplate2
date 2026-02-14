<?php

namespace App\Form\Flow\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class NameDTO
{
    #[Assert\NotBlank(groups: ['step1'])]
    public ?string $name = null;
}