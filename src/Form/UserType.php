<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Type\TypeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use App\Enum\UserTypeEnum;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('username')
            ->add('type', TypeType::class)
//             ->add('carInfo', CarInfoType::class)
//             ->add('passportInfo', PassportInfoType::class)
        ;

        $formModifier = function (FormInterface $form, ?int $type) {
            $form->add('carInfo', HiddenType::class, ['data' => null]);
            $form->add('passportInfo', HiddenType::class, ['data' => null]);

            switch ($type) {
                case UserTypeEnum::CAR :
                    $form->add('carInfo', CarInfoType::class);
                    break;
                case UserTypeEnum::PASSPORT :
                    $form->add('passportInfo', PassportInfoType::class);
                    break;
            }
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
            /** @var User $user */
            $user = $event->getData();
            $formModifier($event->getForm(), $user->getType());
        });

        $builder->get('type')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) {
            $type = $event->getForm()->getData();
            $formModifier($event->getForm()->getParent(), $type);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'label_format' => 'user.form.label.%name%',
        ]);
    }
}
