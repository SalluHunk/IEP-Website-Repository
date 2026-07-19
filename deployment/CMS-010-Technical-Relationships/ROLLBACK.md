# CMS-010 — Technical Relationships Module: Rollback

## Rolling back Step 1 (Code Snippet)
Snippets → find "CMS-010 — Technical Relationships" → Deactivate (or delete). This immediately:
- Removes `cspt-service`'s REST visibility again (reverting Part 1's retrofit) — any tooling relying on `services-cpt`/`/iep-cms/v1/service(s)` will stop working, same as before this package existed.
- Un-registers all 6 relationship fields from wp-admin edit screens. **The underlying post meta (the actual relationship data written in Steps 4–6) is NOT deleted** — it's ordinary post meta (`related_industries`, `related_services`, `related_case_studies` keys) and persists in the database even with the field group unregistered. Reactivating the snippet later makes it visible and editable again, unchanged.
- Removes the `/iep-cms/v1/relate/...` endpoints and the `[iep_related]` shortcode. If `[iep_related]` was placed on any live page (Step 8), that shortcode tag would render as literal visible text until either the snippet is reactivated or the shortcode is removed from the page.

## Rolling back individual relationships (not the whole module)
Call the relevant `/relate/...` endpoint again with a corrected array (e.g. an empty array to clear all relationships for one post) — the bidirectional sync means this correctly updates both sides, same as any other change.

## Rolling back the Services REST retrofit specifically, while keeping relationships
Not supported as a partial rollback — Part 1 (REST retrofit) is a prerequisite for the two Services-touching relationship pairs to function via the endpoints. If Services REST access itself needs to be reverted while keeping Case Study↔Industry Sector data intact, that one pair doesn't depend on Services at all, so it would be unaffected by deactivating just the Services-specific portion — but this package ships as one snippet, not separable pieces, so a partial rollback would mean copying only Part 1 + Part 2's Case Study/Industry field groups + the one relevant endpoint into a new snippet. Not expected to be needed; flagged for completeness.

## If Industry Sector ↔ Service (the editorial-synthesis table) needs to be cleared
Call `/relate/industry-service` for each of the 8 industry sectors with `service_ids: []` — clears that pair specifically without touching the two evidence-grounded pairs.
