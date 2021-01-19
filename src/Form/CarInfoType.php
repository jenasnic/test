<?php

namespace App\Form;

use App\Entity\ValueObject\CarInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

class CarInfoType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('licensePlate')
            ->add('horsePower')
            ->setDataMapper($this)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CarInfo::class,
            'empty_data' => null,
            'label_format' => 'carInfo.form.label.%name%',
        ]);
    }

    public function mapDataToForms($viewData, $forms): void
    {
        if (null === $viewData) {
            return;
        }

        if (!$viewData instanceof CarInfo) {
            throw new UnexpectedTypeException($viewData, CarInfo::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $forms['licensePlate']->setData($viewData->getLicensePlate());
        $forms['horsePower']->setData($viewData->getHorsePower());
    }

    public function mapFormsToData($forms, &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $viewData = new CarInfo(
            $forms['licensePlate']->getData(),
            $forms['horsePower']->getData()
        );
    }
}
