Lead Management (Laravel + Vue 3)

Lightweight lead & contact management built with Laravel (API) and Vue 3 + Vite + Tailwind (SPA). Designed for speed, clarity, and easy extension into a full CRM.

Tech mix (from GitHub stats): Vue ~68%, PHP ~22%, Blade/JS/CSS the rest. 
GitHub

✨ Core Features

Leads: create, assign owner, status (New/In-Progress/Won/Lost), next action date.

Contacts: name, title, phone, email, company link; quick notes.

Companies: logo (S3-ready), industry tags, website, source.

Timeline & Notes: per lead/contact history (calls, emails, meetings).

Search & Filters: by status, owner, company, industry, date range.

Exports: CSV (Excel-ready) for leads/contacts.

Auth & Security: hashed passwords, CSRF, form requests, policies.

Queues & Scheduler: reminders/follow-ups (Laravel queue + schedule).

Responsive UI: Tailwind-styled SPA for desktop & mobile.

Want multi-tenant / multi-vendor access? See “Multi-Tenant (Optional)” below.

🏗️ Stack

Backend: Laravel 11/12, Eloquent, Form Requests, Policies

Frontend: Vue 3, Pinia, Vite, Tailwind CSS

DB: PostgreSQL (UUIDs, indexes, FKs)

Auth: Laravel Sanctum (JWT optional)

Background jobs: Laravel Queues (Redis recommended)

🚀 Quick Start
Prerequisites

PHP 8.2+

Composer

Node 18+

PostgreSQL 14+ (or MySQL)

Redis (optional, for queues)

1) Clone & install
git clone https://github.com/rifatcse09/lead_management.git
cd lead_management
composer install
cp .env.example .env
php artisan key:generate

2) Configure .env
APP_NAME="Lead Management"
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=lead_management
DB_USERNAME=postgres
DB_PASSWORD=postgres

# Files (S3 optional)
FILESYSTEM_DISK=public
# For S3: S3_* keys...

# Sanctum / CORS (if SPA served on different port)
SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost:5173

3) Migrate & seed
php artisan migrate --seed

4) Frontend
npm install
npm run dev

5) Serve API
php artisan serve


API: http://localhost:8000

SPA (Vite): http://localhost:5173

🔐 Authentication

Default auth via Sanctum (SPA tokens / session cookies).

Protect routes with policies; use FormRequest for validation.

🗂️ Suggested DB Schema (high-level)

companies (id, name, industry, website, logo, created_by, …)

contacts (id, company_id, name, title, phone, email, …)

leads (id, company_id, contact_id, owner_id, status, source, next_action_on, …)

notes (id, notable_id, notable_type, body, created_by, …) ← polymorphic

reminders (id, lead_id, remind_at, message, user_id, sent_at, …)

users (id, name, email, password, role, …)

Adjust table names/columns to match your current migrations.

🧪 Testing
php artisan test


Add feature tests for:

Create/Update Lead

Permissions (policy)

Filters (status/date/owner)

Export CSV

🧵 Queues & Scheduler

Queue driver: redis recommended (QUEUE_CONNECTION=redis)

Example cron (send reminders, daily digest):

php artisan schedule:work

📦 Build & Production
npm run build
php artisan config:cache
php artisan route:cache
php artisan queue:work --daemon


Serve via Nginx/Apache; point webroot to /public.

For Docker, add PHP-FPM + Nginx + Node build stage.

🛡️ Roles & Access

Admin: manage users, settings

Member: manage own leads/contacts

Policies restrict resource access by owner/team.

🏢 Multi-Tenant / Multi-Vendor (Optional)

If you need per-client isolation:

Add teams (or tenants) table and team_user pivot.

Scope queries by team_id via a global scope / middleware.

Store assets under tenants/{team_id}/… if S3 is used.

Separate API tokens per tenant with Sanctum abilities.

This keeps each client/vendor’s data isolated while reusing the same codebase.

📤 Exports

Endpoints or buttons that return CSV:

/leads/export?status=Won&owner=me

/contacts/export?company=Acme

Use LazyCollections for large datasets.

🗺️ Roadmap

Email/calendar integration (Google/Microsoft)

Kanban pipeline for leads

PDF reports & dashboards

Audit trail (activity log)

Webhooks + basic API for integrations

🤝 Contributing

PRs welcome. Please:

Follow PSR-12

Add tests

Keep commits scoped & descriptive

📄 License

MIT
