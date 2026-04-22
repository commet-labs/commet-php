<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Commet;
use PHPUnit\Framework\TestCase;

class CommetTest extends TestCase
{
    public function testValidKey(): void
    {
        $commet = new Commet('ck_test_abc123');

        $this->assertInstanceOf(Commet::class, $commet);
    }

    public function testRejectsEmptyApiKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Commet('');
    }

    public function testRejectsInvalidApiKeyPrefix(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Commet('sk_invalid_prefix');
    }
}
