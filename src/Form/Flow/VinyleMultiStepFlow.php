<?php

namespace App\Form\Flow;

use App\Form\Flow\VinyleStep1Type;
use App\Form\Flow\VinyleStep2Type;
use App\Form\Flow\VinyleStep3Type;
use Symfony\Component\Form\Flow\AbstractFlowType;
use Symfony\Component\Form\Flow\FormFlowBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Flow\VinyleType;
use Symfony\Component\Form\Flow\Type\NavigatorFlowType;
 
class VinyleMultiStepFlow extends AbstractFlowType
{
    public function buildFormFlow(FormFlowBuilderInterface $builder, array $options): void
    {
        $builder->addStep('step1', VinyleStep1Type::class);
        $builder->addStep('step2', VinyleStep2Type::class);
        $builder->addStep('step3', VinyleStep3Type::class);
 
        $builder->add('navigator', NavigatorFlowType::class);
    }
 
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VinyleType::class, // la classe de votre Form
            'step_property_path' => 'currentStep',
        ]);
    }
}
