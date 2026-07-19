# EO-DEL002-002 — Homepage Restructure Deployment Package

Implements Mission Control's final Engineering Order (EO-DEL002-002, Operation HORIZON / Mission DEL-002) against the drift findings recorded in `docs/EO-DEL002-001-Homepage-Constitutional-Audit.md`.

## Contents

- `php/homepage-restructure.php` — one-time, idempotent, dry-run-gated script implementing **M1** (replace the hardcoded homepage "Core services" grid with the CMS-driven `[iep_services_by_category]` shortcode), **M2** (reorder the 12 homepage stages to match `PDC-A001`'s governing model), and **M4**'s specific finding (move the "Book Opportunity Screening" CTA from the end of Methodology to the end of Services, per D-09).
- `php/homepage-meta-description.php` — **M6**: adds a homepage `<meta name="description">` tag. No SEO plugin exists on this site (confirmed during the audit), so this hooks `wp_head` directly, scoped to the front page only. Copy is trimmed from `PDC-001` Article I's Constitutional Statement, not newly drafted.

## Why a server-side script, not a direct API write

The homepage's `_elementor_data` payload is ~110KB. Prior large edits this engagement (`/services/`, footer) were ~24–40KB and were pushed directly via a WordPress API call. At this size, transmitting the full payload through a tool call is both expensive and avoidable — the established precedent for large, risky content operations on this site (`CMS-004`'s footer cleanup script) is a dry-run-gated, idempotent PHP script deployed via Code Snippets instead. This package follows that same pattern.

## Deployment sequence

1. **Deploy `homepage-restructure.php` as a Code Snippet, set to run Everywhere, and activate it.**
2. **Dry run first:** as an administrator, visit `https://iep.technology/?iep_homepage_restructure=1` (no `&live=1`). This writes nothing — it reports the new section order, confirms the Services/Methodology child-element counts, and reports the new payload size. **Review this output before proceeding.**
3. **If the dry run looks correct**, visit `https://iep.technology/?iep_homepage_restructure=1&live=1`. This is guarded by an option flag (`iep_homepage_restructure_done`) — running it a second time is a safe no-op, not a double-application.
4. **Purge cache at both layers**, per this engagement's own established lesson (`CMS-005A`): WP Engine host-level (Hosting → Flush Cache) **and** browser cache. Direct-database `_elementor_data` writes are not picked up by Elementor's own internal parsed-page cache without this — the script attempts an Elementor cache clear automatically, but the host-level purge has needed to be done manually every time this pattern has been used so far this engagement.
5. **Deploy `homepage-meta-description.php` as a second, separate Code Snippet**, run Everywhere, activate. No dry-run gate needed — it only adds a `<meta>` tag via `wp_head`, no data is written.
6. **Verify** — see `VERIFICATION.md`.

## Rollback

See `ROLLBACK.md`. The restructure script does not delete the original data irreversibly in the sense of losing it from WordPress's revision history, but there is no automated rollback button — reverting requires either restoring from a page revision (if WordPress's revision system captured one before the live run) or re-running the original section order manually. Treat the dry-run step as the real safety gate, not the rollback path.
