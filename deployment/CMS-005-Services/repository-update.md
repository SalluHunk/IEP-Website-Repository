# CMS-005 — Repository Update

## New capability

The existing `cspt-service` CPT gains a genuine, evidence-justified field model (9 fields, not the 15 candidates the mission listed — 6 were excluded or deferred with reasoning, see `DECISIONS.md`) and a deployable path — `[iep_services_grid]` — to make the *existing* live Services page render from that CPT instead of hardcoded Elementor content, without needing file/SFTP access. This is the same "find the non-SFTP path" pattern `CMS-003` and `CMS-004` established, applied to the third CMS-001 module.

**v1.1 (2026-07-13):** the module targets the client's newer 9-service catalogue (previously 7) — see `MIGRATION-REPORT-v1.1.md`. Architecture, field count, and deployment mechanism are unchanged; only the migration table's target titles and content-sourcing status changed. Still not deployed.

## Dependencies

- **`CMS-003` (Global Settings)** — soft dependency, for the CTA fallback chain in `iep_get_service_cta()`. Degrades gracefully if not deployed.
- **`cspt-portfolio` (the Case Studies CPT)** — the `related_case_studies` field targets it and is configurable today because that CPT already exists, even though its content is still demo (per `CMS-BOOT-002`). The field won't show meaningful results until the Case Studies module replaces that demo content.
- **File/SFTP access** — only for the optional `recommended-templates/` (archive/single pages), not for the shortcode-based deployment this package actually recommends first.
- **`BACKUP-001` current** — this package edits both CPT content and the live Services page.

## Next recommended module

Per `CMS-001`'s sequence, Downloads and Testimonials come next, ahead of Case Studies (deliberately — Case Studies' relationship fields are only meaningful once Downloads and Testimonials exist to relate to). Given this module and `CMS-004` both found real, no-SFTP deployment paths via Code Snippets + shortcodes/Options Pages, the same approach is worth trying first for **Testimonials** — it's a new, simple CPT (no existing demo-content problem to clean up, unlike Services/Leadership) and could plausibly ship as a Code-Snippets-only package the same way, without waiting on the SFTP blocker that's stalled Leadership specifically.
