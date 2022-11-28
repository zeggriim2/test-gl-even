<?php

declare(strict_types=1);

namespace App\Services\Transform;

interface TransformLine
{

    public function transform(array $linesEnter): array;
}