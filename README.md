# README

Create a Password Policy and validate passwords against it.

Useful for when a user is creating/updating their password.

## Installation

Use Composer to manage your dependencies:

`composer require code-pros/password-policy`

## Example

    /**
     * Setup a password policy
     * This policy is from OWASP's security cheat sheet.  Look it up for good reading!
     *
     * Must match 3/4 of the following
     * - Lowercase character
     * - Uppercase character
     * - Special character
     * - Digit
     * Must match all of the following
     * - between 10 and 128 characters
     * - no consecutive characters more than twice
     */
    $childPolicy = \CodePros\PasswordPolicy\Builder::create()
            ->addMustRule(new \CodePros\PasswordPolicy\Rules\Characters\Lowercase(1))
            ->addMustRule(new \CodePros\PasswordPolicy\Rules\Characters\Uppercase(1))
            ->addMustRule(new \CodePros\PasswordPolicy\Rules\Characters\Digit(1))
            ->addMustRule(new \CodePros\PasswordPolicy\Rules\Characters\Special(1))
            ->pctRulesMustPass(75)
            ->build();

    $policy = \CodePros\PasswordPolicy\Builder::create()
            ->addMustRule(new \CodePros\PasswordPolicy\Rules\Characters\Length(10, 128))
            ->addMustNotRule(new \CodePros\PasswordPolicy\Rules\ConsecutiveCharacters(3))
            ->mustPassPolicy($childPolicy)
            ->build();

    /**
     * Validate a password
     */
    $valid = $policy->validate('user supplied password');

    /**
     * Get back a list of rules and whether the last validation passed each.
     */
    $messages = $policy->getDetailedStatus();

## Development

### Development Process

1. Make your changes.
2. Test with PHPUnit.

### Build Process

1. Choose a new version number according to [semver](http://semver.org/).
2. Summarize your changes in CHANGELOG with the new version number.
3. Create a git tag with the version number.
4. Push the changes and tag.
