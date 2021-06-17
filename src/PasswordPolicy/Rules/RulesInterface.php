<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy\Rules;

/**
 * Interface that rules must follow
 */
interface RulesInterface
{
    public function matches(string $password): bool;

    /**
     * Gets a human-readable description of this rule
     * @return string
     */
    public function getDescription(): string;
}
