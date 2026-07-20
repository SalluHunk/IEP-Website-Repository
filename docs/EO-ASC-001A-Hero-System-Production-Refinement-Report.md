---
id: EO-ASC-001A
title: Hero System Production Refinement — Implementation Report
mission: EO-ASC-001A — Operation ASCENT, Burn 1
operation: ASCENT
purpose: Deliverable report for EO-ASC-001A — homepage Hero/Executive Confidence production refinement
status: Implemented
lifecycle: Materialized
last_updated: 2026-07-20
---

# EO-ASC-001A — Hero System Production Refinement — Implementation Report

## Repository Position

**Depends On**
- `missions/WCP-001-Progress-Register.md` — WP-01/WP-09's own finding (Hero and Executive Trust Metrics duplicate the same 4 numbers) is the specific problem this mission resolves
- `docs/WCP-001-Operation-Horizon-Completion-Report.md` §5 — this open item was carried forward from that report directly into this mission
- Live WordPress state (page 959, `_elementor_data`), verified directly before and after implementation

**Enables**
- Closes the Hero/Trust-Metrics duplication finding first raised in WP-01 (2026-07-14) and re-confirmed in WP-09 (2026-07-19)
- Any future homepage mission touching the Hero or the section immediately following it should treat this report, not the pre-refinement state, as current

**Note on mission origin.** This Engineering Order arrived directly from Mission Control as a chat instruction, not as a pre-existing repository document — no `EO-ASC-001A` or "Operation ASCENT" reference existed anywhere in this repository before this mission (confirmed by search before starting). The brief's own referenced GitHub URL (`github.com/SalluHunk/POA-Repository`) also does not match this repository's actual remote (`github.com/SalluHunk/IEP-Website-Repository`, set up earlier this session) — noted here, not corrected in the brief itself, since the brief is Mission Control's own document.

---

## Executive Summary

Implemented all 5 in-scope tasks from EO-ASC-001A against the live homepage (page 959). The mission's own framing — "the current Executive Trust Metrics presentation feels like a standalone section" — describes exactly the finding this repository's own WP-01 (2026-07-14) and WP-09 (2026-07-19) validation passes already surfaced and left open: a section (`edb54d3`, eyebrow "Executive trust metrics") sitting directly beneath the Hero that repeats the identical 4 numbers the Hero's own on-image dials already show, on a jarring light-grey background sandwiched between two dark sections. This mission resolves that finding rather than introducing a new one.

**One real evidentiary gap was found and resolved before implementation, not glossed over**: Task 2 asked for an "ISO 9001 Certification" claim. No documentary evidence of this certification exists anywhere in the repository — the only trace is an orphaned, empty "Quality Management" page (669) whose excerpt mentions ISO 9001 but whose body was never written. Per this repository's standing anti-fabrication discipline (`PDC-001` Article X), this was flagged to Mission Control directly rather than published on the strength of the stub page alone. **Mission Control confirmed directly, in session, that IEP holds ISO 9001 certification** — that confirmation, not the stub page, is the evidentiary basis for including the claim. Recorded here for the record.

All 5 tasks implemented as a single coordinated change (all 5 targets sit in the same two adjacent Elementor widgets/sections, so splitting them into separate pushes would have added risk without benefit). Independently verified via direct database re-fetch (all new copy present, all old copy absent, JSON valid, element count unchanged) and via an isolated local test harness at 3 breakpoints (screenshot tooling remains non-functional this session, consistent with every prior session this engagement — same substitute-verification method used in WP-02, `EO-DEL002-002`, and WP-09/10). **Live-visual confirmation is pending the standard host + Elementor cache purge** — confirmed via cache-busted fetch that the origin (`cf-cache-status: MISS`, `x-gateway-cache-status: MISS`) is still serving the old copy, matching the exact caching behaviour documented in `CMS-005A-Service-Taxonomy-Deployment-Report.md`: Elementor keeps its own internal parse cache independent of the CDN, normally cleared only by a host-level purge (and ideally a re-save through Elementor's own editor). This is expected, not a new defect.

---

## 1. Implementation Log

| Task | Change | Widget(s) |
|---|---|---|
| 1 — Hero Supporting Narrative | Rewrote the Hero's supporting paragraph: 17 words → 36 words, establishing industrial focus, executive credibility (Chartered Engineers), commercial outcomes (funding, delivered projects), and engineering authority (identify/validate/deliver) in one sentence | `9199a96` (`.iep-sub`) |
| 2 — Executive Confidence Layer | Retired the "Executive trust metrics" eyebrow/section identity; renamed to "Executive brief"; added a 4-item reassurance-style credential row (ISO 9001 Certified / Industrial manufacturing expertise / Engineering-led delivery / Commercial & funding capability) beneath the existing outcome metrics, same section (`edb54d3`) | `41bb1be`, `a9048b3`, `5fa77fc` |
| 3 — Dashboard Refinement | Same 4 outcome metrics kept (Energy/CO2/Wastewater reduction + savings range) — SVG ring diameter reduced from 112px to 52px, card-style spacing removed, metrics now read as a slim strip above the new credential row rather than a full competing section | `5fa77fc` |
| 4 — CTA Hierarchy | Primary CTA ("Book Opportunity Screening") unchanged. Secondary CTA relabeled "View Case Studies" → "See Proven Results" (the brief's own suggested direction — used as-is, it was already evidence-oriented and points at real content). Href unchanged (`#case-studies`, confirmed still a valid in-page anchor) | `9199a96` (`.iep-cta-secondary`) |
| 5 — Hero Continuity | Section `edb54d3`'s background changed from light grey (`#F3F6F7`) to dark (`#05080b`), matching both the Hero above it and the existing Executive Confidence Strip (`bc618ce`) below it — removes the dark→light→dark visual break that was the root cause of the "two disconnected sections" feeling. Padding tightened (48px → 40px) for a less visually dominant footprint | `edb54d3` (section settings) |

## 2. What Was Deliberately Not Touched

Per the brief's own Engineering Constraints and this repository's "Preserve Architecture" principle:
- The existing Executive Confidence Strip (`bc618ce`/`909a380` — "Systems Thinking / Stage-Gated Delivery / Investment Protection / Integrated Engineering / Engineering Governance") is untouched. It already functions as a mature confidence-communicating section; the brief's complaint targeted the section *above* it (Executive Trust Metrics), not this one.
- Homepage section order, primary navigation, CMS bindings, the Engineering Capability Experience (Services), and the footer are all unchanged.
- No new homepage sections were added — Task 2's new content lives inside the existing `edb54d3` section, not a new one.

## 3. ISO 9001 — Evidentiary Record

Before writing any copy, searched the repository for "ISO 9001" — 4 files matched, none containing real evidence; all were incidental matches on the orphaned "Quality Management" page's *name* (page 669), a page this repository's own `CONTENT-004-Visitor-Journey-Constitution-Review.md` had already flagged (2026-07-13) as one of several orphaned, thin-content pages. Fetched page 669's actual content directly: its excerpt reads "Quality Management ISO 9001 References & Recommendations," but its body is a single empty H1 heading — no certificate, certifying body, scope, or date. This is a content stub, not evidence of a real certification.

Flagged this directly to Mission Control before proceeding with Task 2, rather than either fabricating the claim or silently omitting it. **Mission Control confirmed directly that IEP holds ISO 9001 certification.** This confirmation is the evidentiary basis recorded here; it does not retroactively make page 669 a real source, and page 669 itself remains an orphaned stub outside this mission's scope to fix (consistent with `EO-DEL002-002`'s own decision to leave D-10's orphaned-pages finding deferred).

## 4. Validation / QA

- **Database write**: independently re-fetched `_elementor_data` after the push (not trusting the write response) — all 6 new copy strings present, all 3 old copy strings absent, JSON re-parses with the same 15 top-level elements as before, `_elementor_edit_mode` still `"builder"`.
- **Isolated test harness**: the exact final widget markup (fetched fresh from the database, not retyped) was extracted into a standalone local HTML file, served over a local HTTP server (`file://` URLs render as static snapshots in this session's browser tool and don't execute JS — routing through `localhost` was necessary to get real DOM measurement), and tested at 375px (mobile), 768px (tablet), and 1280px (desktop). Zero horizontal overflow and zero element-overlap at any width, including a direct rectangle-collision check across all 4 new credential items and all 4 metric items.
- **CTA anchor integrity**: confirmed `#case-studies` still resolves to a real, present section (`81c62c4`) elsewhere on the page — the relabeled secondary CTA was not silently pointed at a broken anchor.
- **Live-visual confirmation: pending.** A cache-busted fetch (`cache: 'no-store'`, fresh query string) of the live homepage still returns the pre-refinement copy despite `cf-cache-status: MISS` / `x-gateway-cache-status: MISS` — this specific combination (MISS on both CDN layers, stale content anyway) is the same documented Elementor-internal-cache behaviour recorded in `CMS-005A-Service-Taxonomy-Deployment-Report.md` §"Deployment issue hit twice." Needs a host-level cache purge (and ideally a save-through-editor in Elementor) before it's visible to a visitor — the standing requirement for every direct-database Elementor write this entire engagement, not a new problem this mission introduced.
- **Screenshot tooling**: non-functional this session (consistent with `EO-DEL002-001`, `EO-DEL002-002`, and this program's own WP-09/WP-10) — the isolated harness and direct DOM measurement are the substitute evidence, same disclosed-limitation pattern as those reports.

## 5. Risks, Assumptions, Technical Debt

**Assumptions**
- Mission Control's confirmation of ISO 9001 certification is treated as authoritative for this mission's purposes. If that certification lapses, changes scope, or was for a different corporate entity, the claim on the live site would need updating — no automatic mechanism exists to keep a hand-typed certification claim in sync with reality.
- "See Proven Results" was used as literally suggested in the brief rather than substituting an alternative — judged already evidence-oriented and accurate to what the link leads to.

**Technical debt**
- Page 669 ("Quality Management," the only page-level home for ISO 9001 content) remains an empty stub, orphaned from navigation. The homepage now makes a certification claim with no supporting detail page a visitor could click through to for specifics (certifying body, scope, certificate number) — worth a future decision on whether to build that page out now that the claim is live on the homepage.
- The retired "Executive trust metrics" eyebrow/copy convention (giant 112px SVG dial rings, light-grey card treatment) is now unused on this page — no other page reuses that exact pattern, so no orphaned dependency was created, but it's a discarded visual pattern worth knowing about if a near-identical style is ever wanted again.

**Recommendations — Operation POLISH (out of this mission's scope, not implemented)**
- Build out page 669 with real ISO 9001 certificate details now that the homepage references it.
- Consider whether the Executive Confidence Strip (`bc618ce`, untouched by this mission) and the newly-refactored Executive Brief section (`edb54d3`) could eventually share more visual DNA (e.g. matching ring-and-trace-line treatment) now that they sit adjacent on a continuous dark background — not done here, since the brief explicitly scoped this mission to `edb54d3` only and "minimize code changes" argued against touching a working, unrelated section.

## Source References

**Primary Sources**
- Mission Control's direct chat instruction, EO-ASC-001A / "Operation ASCENT, Burn 1" mission brief (2026-07-20)
- Mission Control's direct in-session confirmation of ISO 9001 certification status
- Live WordPress state (page 959), verified directly before and after implementation, 2026-07-20

**Related Repository Documents**
- `missions/WCP-001-Progress-Register.md` (WP-01, WP-09 — origin of the finding this mission resolves)
- `docs/WCP-001-Operation-Horizon-Completion-Report.md` (§5 — carried this open item forward)
- `docs/CMS-005A-Service-Taxonomy-Deployment-Report.md` (the documented Elementor-cache behaviour this mission's own QA section cites)
- `content/CONTENT-001-Services/CONTENT-004-Visitor-Journey-Constitution-Review.md` (prior finding on page 669's orphaned/thin state)
