# CMS-009 — Resources Module: Repository Update Note

This package is WP-07's deliverable under `missions/WCP-001-Progress-Register.md`. First attempt at this module — no prior blocked-execution report to supersede. The original Blocker A note (2026-07-14) correctly predicted this module might not need a new CPT (native Media is REST-exposed); this package's `DECISIONS.md` records why a CPT was chosen anyway.

Unlike CMS-002/006/007/008, this package **cannot be marked "deployed and populated"** in the normal sense even once applied — there is no real content to populate. Once the ACF field group and Code Snippet are installed and the Step 4 smoke test passes, WP-07 should be recorded as "infrastructure deployed, awaiting real content" rather than "deployed and populated," to keep the progress register honest about what actually exists live.

Once deployed and verified, update:
- `missions/WCP-001-Progress-Register.md` — record WP-07 as infrastructure-complete (not content-complete) once the user confirms Steps 1–4 of `IMPLEMENTATION-GUIDE.md` are done and `VERIFICATION.md` passes.
- If/when real Resources content is ever provided by the client, that's a new population pass reusing this package's endpoint — not a new deployment package.
- WP-08 (Technical Relationships) depends on WP-03–07 content existing — flag that Resources will remain unlinked from that relationship-wiring work until real content exists here, same as it would for any other empty module.
