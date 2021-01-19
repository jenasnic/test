<?php

namespace App\Form\Type;

use App\Enum\UserTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        //$resolver->setRequired(['enum', 'value_format']);
        //$resolver->setAllowedTypes('value_format', 'string');

        $resolver->setDefaults([
            'choices' => UserTypeEnum::getAll(),
            'choice_label' => function ($choice, $key, $value) {
                return sprintf('enum.type.%u', $value);
            }
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
