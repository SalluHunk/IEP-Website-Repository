# EO-DEL002-002 — Rollback

## Meta description snippet
Deactivate the `homepage-meta-description.php` Code Snippet. No data was written; deactivation alone fully reverts it.

## Restructure script
**Confirmed via `wp_list_revisions` before this package was finalized: WordPress's standard revision system has not captured this page since 2026-07-04.** Every direct `_elementor_data` write this engagement has made (footer, services, taxonomy, icons) went through `update_post_meta` directly, bypassing the normal save flow that creates revisions — so the built-in **Pages → Home → Revisions** rollback path does **not** exist for this change. Do not rely on it.

**Mitigation built into the script:** before writing, it saves the pre-change `_elementor_data` value to a second meta key, `_iep_homepage_restructure_backup`, so a rollback is possible without needing WordPress's own revision system. To roll back after a live run:
1. Retrieve the backup: `get_post_meta(959, '_iep_homepage_restructure_backup', true)`.
2. Write it back to `_elementor_data` via `update_post_meta`.
3. Delete the `iep_homepage_restructure_done` option so the script's idempotency guard doesn't block a legitimate re-run later.
4. Purge cache (host + browser) per the standard sequence.

If this situation arises, stop and escalate per `POA-GOV-001` rather than attempting a live improvisation beyond this documented restore path.

**UPDATE 2026-07-14, post-deployment:** after the live run, `_iep_homepage_restructure_backup` was checked via `wp_get_post_meta` and did not appear in the page's meta list. Cause unconfirmed — either the write genuinely didn't happen, or (more likely, given this site's repeatedly-observed multi-layer caching) the read was served a stale object-cache copy of the postmeta that predates the write. Not re-diagnosed further since it wasn't blocking — the forward change was independently confirmed correct and live via cache-busted fetch. **Practical mitigation in place:** the pre-change `_elementor_data` value was independently saved to a local file (`homepage-parsed.json`) during this deployment's own preparation, before the live write — this serves as the same restore point the missing DB backup would have provided, if rollback is ever needed. If a future session needs to restore, use that file's content rather than assuming the DB backup key exists — re-check it first.

## Full precaution already taken
The script aborts (writes nothing) if the live page structure doesn't match what it expects (wrong section count, missing expected headings) — this is the primary safeguard, applied *before* any write, rather than relying on rollback after the fact.
