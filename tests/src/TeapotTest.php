<?php

declare(strict_types=1);

/**
 * Derafu: Derafu ORG Page.
 *
 * Copyright (c) 2025 Esteban De La Fuente Rubio / Derafu <https://www.derafu.org>
 * Licensed under the MIT License.
 * See LICENSE file for more details.
 */

namespace Derafu\TestsOrg;

use Derafu\Org\Teapot;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Teapot::class)]
class TeapotTest extends TestCase
{
    public function testImATeapot(): void
    {
        $this->assertSame("I'm a teapot", (string)(new Teapot()));
    }
}
