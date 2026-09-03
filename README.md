# 💬 PV Simple WhatsApp Button

A lightweight WordPress plugin that adds a configurable floating WhatsApp button to your site — no paid API, no bloat. Just a `wa.me` link, a settings page, and a button.

## ✨ Features

-   🟢 Floating WhatsApp button rendered in the site footer
-   ⚙️ Configurable phone number and pre-filled message
-   ↔️ Left/right position toggle
-   🔒 Digits-only phone validation, enforced on both the client and the server
-   ✨ Subtle hover animation
-   🌍 Fully translatable (ships with Brazilian Portuguese, `pt_BR`)
-   🛡️ Typed PHP (`strict_types`, PHP 8.1+) and typed TypeScript
-   🚫 Zero runtime dependencies — no external API calls, no tracking

## 📋 Requirements

|           | Version                |
| --------- | ---------------------- |
| WordPress | 6.0+                   |
| PHP       | 8.1+                   |
| Node.js   | 18+ (development only) |
| Composer  | 2.x (development only) |

## 📦 Installation

### 📥 From a release

1. Download the latest `.zip` from the [Releases](../../releases) page.
2. In your WordPress admin, go to **Plugins → Add New → Upload Plugin**.
3. Select the downloaded `.zip` and click **Install Now**.
4. Activate the plugin.

### 🛠️ From source (Git)

```bash
cd wp-content/plugins
git clone https://github.com/pedrorvidal/pv-simple-whatsapp-button.git
```

The compiled JavaScript (`build/`) is committed to the repository, so the plugin works immediately after cloning — no build step required to activate it. Development dependencies are only needed if you intend to modify the code (see [Development](#development) below).

## 🚀 Usage

1. In the WordPress admin, go to **Settings → WhatsApp Button**.
2. Enter your WhatsApp number, digits only, including the country and area code (e.g. `5551999999999` for a Brazilian number).
3. Optionally, set a default pre-filled message (max. 200 characters).
4. Choose whether the button appears on the left or right side of the screen.
5. Save changes.

The button appears automatically on every front-end page once a phone number is set. If no phone number is configured, the button does not render.

## 👩‍💻 Development

This project follows a **PHP + compiled TypeScript** architecture: PHP handles all server-side logic and rendering; a small TypeScript file provides client-side input validation as a progressive enhancement.

### 📦 Installing dependencies

```bash
composer install
npm install
```

### 🏗️ Building the front-end script

```bash
npm run build    # one-off, minified build
npm start        # watch mode, rebuilds on save
```

Compiled output goes to `build/index.js` and `build/index.asset.php` (auto-generated dependency/version manifest — do not edit by hand).

> **Note:** always run `npm run build` before committing changes to `src/index.ts`. The compiled `build/` directory is version-controlled, so a stale build will ship to anyone who clones or downloads the plugin.

### 🗂️ Project structure

```
pv-simple-whatsapp-button/
├── pv-simple-whatsapp-button.php   # Plugin bootstrap
├── includes/
│   ├── class-pv-swb-settings.php   # Admin settings page
│   └── class-pv-swb-render.php     # Front-end button rendering
├── src/index.ts                    # Admin script source
├── build/                          # Compiled script (committed)
├── languages/                      # Translation files (.pot/.po/.mo)
└── tests/                          # PHPUnit test suite
```

## ✅ Testing & Code Quality

This project enforces strict standards via PHPStan, WordPress Coding Standards (WPCS), and PHPUnit.

### 🔍 Static analysis

```bash
vendor/bin/phpstan analyse
```

Runs at PHPStan level 5, with WordPress core stubs provided by `szepeviktor/phpstan-wordpress`.

### 🎨 Coding standards

```bash
vendor/bin/phpcs        # check
vendor/bin/phpcbf       # auto-fix what's fixable
```

Follows the `WordPress-Extra` and `WordPress-Docs` rulesets, with the `pv_swb`/`PV_SWB` naming prefix enforced.

### 🧪 Unit tests

```bash
vendor/bin/phpunit
```

Tests use [Brain Monkey](https://github.com/Brain-WP/BrainMonkey) to mock WordPress core functions, avoiding the overhead of a full WordPress test environment. Coverage includes settings sanitization and WhatsApp URL construction.

### ▶️ Running everything

```bash
vendor/bin/phpcs && vendor/bin/phpstan analyse && vendor/bin/phpunit
```

## 🌍 Translations

Translation files live in `languages/`. To update them after adding or changing a translatable string:

```bash
wp i18n make-pot . languages/pv-simple-whatsapp-button.pot --domain=pv-simple-whatsapp-button
# edit the relevant .po file by hand to add/update translations
wp i18n make-mo languages/
```

## 🚢 Deployment

To produce a distributable `.zip`:

```bash
npm run build
vendor/bin/phpcs && vendor/bin/phpstan analyse && vendor/bin/phpunit
```

Once all checks pass, zip the plugin directory (excluding `vendor/`, `node_modules/`, and `tests/`), and upload it via **Plugins → Add New → Upload Plugin**, or push a tagged release to GitHub.

## 📄 License

GPLv2 or later. See [LICENSE](LICENSE) for the full text.
