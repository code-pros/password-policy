<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules;

use CodePros\PasswordPolicy\Rules\Levenshtein;
use PHPUnit\Framework\TestCase;

class LevenshteinTest extends TestCase
{
    /**
     * @covers \CodePros\PasswordPolicy\Rules\Levenshtein::__construct
     * @covers \CodePros\PasswordPolicy\Rules\Levenshtein::matches
     */
    public function testMatches()
    {
        $rule = new Levenshtein('string', 2);

        $this->assertFalse($rule->matches('strring'));
        $this->assertTrue($rule->matches('asdfv'));
        $this->assertTrue($rule->matches('rstign'));
        $this->assertFalse($rule->matches('spring'));
        $this->assertFalse($rule->matches('sring'));
    }
}
