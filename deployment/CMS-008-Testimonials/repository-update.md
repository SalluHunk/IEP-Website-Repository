# CMS-008 — Testimonials Module: Repository Update Note

This package is WP-06's deliverable under `missions/WCP-001-Progress-Register.md`. First attempt at this module — no prior blocked-execution report to supersede, though the original Blocker A note (2026-07-14) mentioned `cspt-testimonial` returning `rest_no_route` when tested, which this package's adaptive registration handles regardless of whether that type turns out to already exist.

Once deployed and verified, update:
- `missions/WCP-001-Progress-Register.md` — mark WP-06 as deployed (not just packaged) once the user confirms Steps 1–6 of `IMPLEMENTATION-GUIDE.md` are done and `VERIFICATION.md` passes, same two-phase pattern as prior modules.
- Record which branch of Part 1's adaptive CPT handling actually fired on this site (retrofit vs. fresh-register) — useful data point for whoever scopes WP-07 (Downloads/Resources), in case the same "does this legacy CPT already exist" question comes up again.
