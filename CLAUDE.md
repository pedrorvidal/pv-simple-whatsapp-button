# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A WordPress plugin (`pv-simple-whatsapp-button`) intended to render a configurable floating WhatsApp button (phone number + prefilled message). Requires PHP 8.1+, `declare(strict_types=1)` throughout.

**Current state:** only the admin settings screen is implemented (`includes/class-pv-swb-settings.php`, registered under Settings → WhatsApp Button). It stores `phone_number` and `message` in the `pv_swb_settings` option. There is no front-end output yet — no `wp_footer` hook, no button markup/CSS/JS. When asked to add the button itself, this is greenfield work, not a bug fix.

## Commands

Install dev dependencies (PHPCS/WPCS + PHPStan, vendored under `vendor/`):
```
composer install
```

Lint (WordPress-Extra + WordPress-Docs ruleset, see `phpcs.xml.dist`):
```
vendor/bin/phpcs
```

Auto-fix lint issues:
```
vendor/bin/phpcbf
```

Static analysis (level 5, WordPress stubs via `szepeviktor/phpstan-wordpress`):
```
vendor/bin/phpstan analyse
```

There are no automated tests (no PHPUnit/WPUnit setup) and no build step (no `package.json`/JS/CSS pipeline).

## Architecture

- `pv-simple-whatsapp-button.php` — plugin bootstrap. Hooks `pv_swb_init()` on `plugins_loaded`, which requires `includes/class-pv-swb-settings.php` and instantiates `PV_SWB_Settings`.
- `includes/class-pv-swb-settings.php` — `PV_SWB_Settings` class: registers the admin settings page (`admin_menu`) and the `pv_swb_settings` option with a sanitize callback (`admin_init`). Phone numbers are stripped to digits only; message is passed through `sanitize_text_field()`.
- Every PHP file starts with the direct-access guard (`if ( ! defined( 'ABSPATH' ) ) { exit; }`) and `declare(strict_types=1);` — keep both when adding files.

## Conventions

- Global functions/classes/constants must be prefixed `pv_swb_` / `PV_SWB_` (enforced by `WordPress.NamingConventions.PrefixAllGlobals` in `phpcs.xml.dist`).
- Follow WordPress-Extra + WordPress-Docs coding/doc standards (full docblocks on classes/methods, Yoda conditions, etc.) — run `phpcs` before considering PHP changes done.
- `phpstan.neon` and `phpcs.xml` are gitignored in favor of `.dist` variants (see `.gitignore`); the tracked `phpstan.neon` currently in the repo is the working config — don't assume future edits to it will be picked up by other clones unless renamed appropriately.
- All commit messages, status text, README, comments, and any other written content must be in English.
- Never mention Claude Code (or any AI assistant) as author, co-author, or contributor anywhere — not in code, comments, commit messages, PR descriptions, or logs.
