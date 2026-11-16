PLAN
- [2026-11-16T11:52:00-05:00] [USER] Require authentication for all pages except login, retaining the centralized route allowlist and direct-template guards.
- [2026-11-16T11:15:20-05:00] [USER] Centralize dashboard and allowlisted listing routing; prevent direct template execution.
- [2026-11-16T10:49:58-05:00] [USER] Remove the unused course identifier and relationship from repository definitions; leave existing databases untouched.
DECISIONS
- [2026-11-16T11:52:00-05:00] [CODE] Reused `requireLogin()` before routing and logout; retained `MARKETPLACE_ROUTED` to block direct template execution.
- [2026-11-16T11:15:20-05:00] [USER] Approved `index.php?action=addListing`, shared layout, and updates to existing links and form.
- [2026-11-16T10:49:58-05:00] [USER] Approved removing the courses table, listing link, seed references, and README course-number features.
PROGRESS
- [2026-11-16T10:49:58-05:00] [CODE] Updated schema.sql, seed.sql, erd.dbml, and README.md; the Docker backup already lacked the relationship.
DISCOVERIES
- [2026-11-16T10:49:58-05:00] [TOOL] Docker daemon unavailable; full MySQL import not verified.
OUTCOMES
- [2026-11-16T11:52:00-05:00] [TOOL] Local HTTP checks with a database stub passed for public login, redirects, protected routes, invalid actions, direct template access and logout.
- [2026-11-16T11:15:20-05:00] [TOOL] Routes, invalid actions, direct access, layout and POST verified with a database stub; PHP lint passed. Docker daemon unavailable, so live database integration remains unverified.
- [2026-11-16T10:49:58-05:00] [TOOL] Both listing seed inserts executed in SQLite with 20 rows; git diff --check passed.
