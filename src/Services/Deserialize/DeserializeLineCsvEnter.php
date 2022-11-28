<?php

declare(strict_types=1);

namespace App\Services\Deserialize;

use App\Services\Model\LineCsvEnter;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DeserializeLineCsvEnter
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private DecoderInterface $decoder
    ) {

    }

    public function deserialize($data, string $type = LineCsvEnter::class, array $context = []): array
    {
        $lines = $this->decoder->decode($data,'csv', $context);
        $linesObjet = [];
        foreach ($lines as $line) {
            $linesObjet[] = $this->denormalizer->denormalize($line,$type, context: $context);
        }
        return $linesObjet;
    }
}