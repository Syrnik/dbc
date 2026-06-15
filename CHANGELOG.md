# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.2.1] - 2026-06-15

### Fixed
- Plugin now correctly zeroes out shipping cost when the payment step is disabled in Shop-Script 12 checkout

### Changed
- Updated frontend dependencies: Vite 8, @vitejs/plugin-vue 6, TypeScript 6, Vue 3.5.38
- Release workflow now compiles gettext .po files to .mo before packaging

## [1.2.0] - 2026-05-18

### Added
- English README (README.en.md) with links to Russian version
- GitHub Actions workflows for PHP compatibility checks and automated releases
- compress-app-plugin.php script for plugin validation and distribution packaging
- LICENSE file

### Changed
- Settings screen rebuilt for Webasyst UI 2.0 (Vue 3, TypeScript, Vite)
- Raised minimum PHP requirement to 7.4
- Added `app.installer >= 3.0` system requirement

## [1.1.0] - 2022-02-04

### Added
- Smarty view helper `shippingCost()` to retrieve the saved shipping cost in templates

## [1.0.0] - 2021

### Added
- Initial release
