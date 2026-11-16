PLAN
- [2026-11-16T10:49:58-05:00] [USER] Remove the unused course identifier and relationship from repository definitions; leave existing databases untouched.
DECISIONS
- [2026-11-16T10:49:58-05:00] [USER] Approved removing the courses table, listing link, seed references, and README course-number features.
PROGRESS
- [2026-11-16T10:49:58-05:00] [CODE] Updated schema.sql, seed.sql, erd.dbml, and README.md; the Docker backup already lacked the relationship.
DISCOVERIES
- [2026-11-16T10:49:58-05:00] [TOOL] Docker daemon unavailable; full MySQL import not verified.
OUTCOMES
- [2026-11-16T10:49:58-05:00] [TOOL] Both listing seed inserts executed in SQLite with 20 rows; git diff --check passed.
