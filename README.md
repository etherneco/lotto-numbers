# Lotto Numbers

## Overview
Small Symfony 4.3 project demonstrating a CLI command and a front-end lottery machine UI. Built as a clean, testable sample project for recruitment and job applications.

## What It Shows
- Symfony Console command with input validation and predictable exit codes
- Front-end interactive page with animated lotto machine and dynamic draw count
- PHPUnit tests validating output format, uniqueness, and timing behavior
- Clear, minimal codebase focused on readability

## Tech Stack
- PHP 7.1+
- Symfony 4.3 (Console, FrameworkBundle)
- PHPUnit
- Vanilla HTML/CSS/JS (no build step)

## Quick Start
```bash
composer install
php -S 127.0.0.1:8000 -t public
```
Open `http://127.0.0.1:8000/` to see the UI.

## CLI Usage
```bash
php bin/console lotto:numbers --loNum=1 --hiNum=59 --initShuffle=0 --shuffle=0
```

## Tests
```bash
vendor/bin/phpunit
```

## Structure
- `src/Command/LottoCommand.php` CLI command
- `src/Controller/LottoPageController.php` UI page
- `src/LottoNumbers.php` number generator
- `tests/app/Command/ListCommandTest.php` tests

## Notes for Recruiters
I keep this repository intentionally small to highlight code clarity, modern PHP practices, and test coverage. If you want a more complex sample (API, database, CI pipeline, or Docker setup), I can provide it.
