# Copilot Instructions for CRM Project

## Project summary
This project is a Laravel 13 application using:
- PHP 8.3+
- Laravel 13
- MySQL as the primary database
- Vite for frontend asset building
- pnpm as the package manager
- Tailwind CSS for UI styling
- Laravel Breeze for authentication scaffolding

## Core workflow
- Prefer Laravel conventions over custom solutions.
- Keep database configuration compatible with MySQL.
- Use pnpm instead of npm for frontend dependency management.
- Use Vite for frontend asset compilation and local dev.
- Keep code aligned with Laravel 13 patterns and Eloquent models.

## Package manager and commands
Use these commands when working in this project:

- Install frontend dependencies:
  pnpm install

- Run Vite dev server:
  pnpm run dev

- Build frontend assets for production:
  pnpm run build

- Start the Laravel app:
  php artisan serve

- Run tests:
  php artisan test

- Run a specific test file or filter:
  php artisan test --filter=CustomerTest

- Run migrations:
  php artisan migrate

- Reset database and rerun migrations:
  php artisan migrate:fresh

## Database and environment rules
- This project is configured for MySQL and should stay on MySQL unless explicitly changed.
- Keep `.env` values consistent with the local MySQL database username, password, and name.
- Avoid switching to SQLite unless the task explicitly requires a temporary local-only setup.
- When creating new database tables, use Laravel migrations and avoid editing database state manually.

## Laravel conventions
- Use Eloquent models for database access.
- Put business logic in services/controllers only when it is appropriate; keep controllers thin when possible.
- Prefer route model binding for CRUD actions.
- Use `Request` validation in controllers for form input.
- Use named routes and `route(...)` helpers in Blade templates.
- Keep the app secure by using authentication middleware (`auth`, `verified`) where required.

## CRM-specific conventions
- Customer-related logic belongs under the `Customer` model and `CustomerController`.
- Follow a standard CRUD flow: index -> create -> store -> show -> edit -> update -> destroy.
- Use consistent customer fields:
  - name
  - company
  - email
  - phone
  - source
  - status
  - notes
- Keep statuses consistent and explicit, such as: `new`, `contacted`, `qualified`.
- Prefer low-friction data validation and clear user feedback messages.

## Frontend conventions
- Use Vite for asset bundling.
- Keep styles primarily in Tailwind utility classes.
- Prefer Blade views for page structure and Laravel + Tailwind integration.
- When adding new frontend assets, update the relevant Blade template or Vite entry points.
- Keep the UI simple, readable, and consistent with the existing Breeze layout.

## Testing requirements
- Add or update feature tests when changing routes, validation, or database behavior.
- Use `RefreshDatabase` for tests that depend on the database.
- Validate user-facing behavior, not only model state.
- Favor real behavior tests over mock-heavy tests.
- This project already has customer-related tests; keep them passing after feature changes.

## Code quality rules
- Preserve existing structure and naming patterns.
- Keep files and imports clean and organized.
- Do not introduce unnecessary dependencies.
- Keep the solution simple and production-friendly.
- Prefer small, focused changes over broad refactors.

## Before finishing a task
- Run the relevant Laravel test command.
- If a feature changes frontend assets, run a Vite build check when appropriate.
- Confirm the app still works with the existing MySQL setup.
- Summarize changes and verification results clearly.
