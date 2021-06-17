<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy\Rules\Characters;

/**
 * String has a certain number of special characters
 *
 * Special characters are as defined here:
 * https://www.owasp.org/index.php/Password_special_characters
 * US Keyboard accessible, ASCII characters
 */
class Special extends Characters
{
    public const DESCRIPTION_TYPE = 'Special character';

    public function getNumChars(string $password): int
    {
        $specialChars = [
            ' ',
            '!',
            '"',
            '#',
            '$',
            '%',
            '&',
            '\'',
            '(',
            ')',
            '*',
            '+',
            ',',
            '-',
            '.',
            '/',
            ':',
            ';',
            '<',
            '=',
            '>',
            '?',
            '@',
            '[',
            '\\',
            ']',
            '^',
            '_',
            '`',
            '{',
            '|',
            '}',
            '~'
        ];

        return strlen($password) - strlen(str_replace($specialChars, '', $password));
    }
}
