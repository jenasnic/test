<?php

namespace App\Service\Serializer;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserApiNormalizer implements ContextAwareNormalizerInterface
{
    private TranslatorInterface $translator;

    private ObjectNormalizer $normalizer;

    public function __construct(TranslatorInterface $translator, ObjectNormalizer $normalizer)
    {
        $this->translator = $translator;
        $this->normalizer = $normalizer;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['type'] = $this->translator->trans(sprintf('enum.type.%u', $data['type']));

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        // @todo : update condition to apply normalizer for API only
        return $data instanceof User;
    }
}
