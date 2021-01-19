<?php

namespace App\Form;

use App\Entity\ValueObject\PassportInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;
use App\Form\Type\DatePickerType;

class PassportInfoType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('country')
            ->add('expireAt', DatePickerType::class)
            ->setDataMapper($this)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PassportInfo::class,
            'empty_data' => null,
            'label_format' => 'passportInfo.form.label.%name%',
        ]);
    }

    public function mapDataToForms($viewData, $forms): void
    {
        if (null === $viewData) {
            return;
        }

        if (!$viewData instanceof PassportInfo) {
            throw new UnexpectedTypeException($viewData, PassportInfo::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $forms['number']->setData($viewData->getNumber());
        $forms['country']->setData($viewData->getCountry());
        $forms['expireAt']->setData($viewData->getExpireAt());
    }

    public function mapFormsToData($forms, &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $viewData = new PassportInfo(
            $forms['number']->getData(),
            $forms['country']->getData(),
            $forms['expireAt']->getData()
        );
    }
}
