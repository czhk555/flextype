<?php

declare(strict_types=1);

/**
 * Flextype (https://flextype.org)
 * Founded by Sergey Romanenko and maintained by Flextype Community.
 */

namespace Flextype\Serializers;

use Atomastic\Macroable\Macroable;
use Flextype\Serializers\Json;
use Flextype\Serializers\Yaml;
use Flextype\Serializers\Frontmatter;
use Flextype\Serializers\Neon;

class Serializers
{
    use Macroable;

    /**
     * Create a Json instance.
     */
    public function json(): Json
    {
        return new Json();
    }

    /**
     * Create a Yaml instance.
     */
    public function yaml(): Yaml
    {
        return new Yaml();
    }

    /**
     * Create a Frontmatter instance.
     */
    public function frontmatter(): Frontmatter
    {
        return new Frontmatter();
    }
    
    /**
     * Create a Neon instance.
     */
    public function neon(): Neon
    {
        return new Neon();
    }
}