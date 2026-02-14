<?php

namespace App\Form\Flow\DTO\Types;

use App\Form\DTO\PriceDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', TextType::class, [
                'label' => 'Prix',
                'attr' => ['placeholder' => 'Prix du vinyle'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriceDTO::class,
        ]);
    }
}