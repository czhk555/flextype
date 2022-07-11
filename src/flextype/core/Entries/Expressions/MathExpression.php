<?php

declare(strict_types=1);

 /**
 * Flextype - Hybrid Content Management System with the freedom of a headless CMS
 * and with the full functionality of a traditional CMS!
 *
 * Copyright (c) Sergey Romanenko (https://awilum.github.io)
 *
 * Licensed under The MIT License.
 *
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 */

namespace Flextype\Entries\Expressions;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

use function Flextype\registry;

class MathExpression implements ExpressionFunctionProviderInterface
{
    public function getFunctions()
    {
        return [
            new ExpressionFunction('ceil', static fn (int|float $num): float => '\ceil($num)', static fn (array $arguments, int|float $num): float => \ceil($num)),
            new ExpressionFunction('floor', static fn (int|float $num): float => '\floor($num)', static fn (array $arguments, int|float $num): float => \floor($num)),
            new ExpressionFunction('min', static fn (mixed ...$values): mixed => '\min($values)', static fn (array $arguments, mixed ...$values): mixed => \min($values)),
            new ExpressionFunction('max', static fn (mixed ...$values): mixed => '\max($values)', static fn (array $arguments, mixed ...$values): mixed => \max($values)),
        ];
    }
}
