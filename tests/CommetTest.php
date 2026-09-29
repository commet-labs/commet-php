<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Commet;
use PHPUnit\Framework\TestCase;

class CommetTest extends TestCase
{
    public function testValidKey(): void
    {
        foreach (['ck_', 'ck_live_', 'ck_sandbox_', 'rk_', 'rk_live_', 'rk_sandbox_'] as $prefix) {
            $commet = new Commet($prefix . 'test_abc123');
            $this->assertInstanceOf(Commet::class, $commet);
        }
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
