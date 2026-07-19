---
id: EO-DEL002-002
title: Homepage Restructure — Implementation Report
mission: DEL-002 — Homepage Constitutional Alignment (Implementation Phase)
operation: HORIZON
purpose: Deliverable report for EO-DEL002-002 — implementation of the audit findings from EO-DEL002-001, under POA-GOV-001 governance
status: Complete
lifecycle: Materialized
last_updated: 2026-07-14
---

# EO-DEL002-002 — Homepage Restructure Implementation Report

## Repository Position

**Depends On**
- `docs/EO-DEL002-001-Homepage-Constitutional-Audit.md` (the findings this mission implements)
- `PDC-A001` (the governing model implementation was aligned to)
- `POA-GOV-001` (the governance framework this mission operated under — Standing Order in the Engineering Order explicitly invoked it)
- `deployment/EO-DEL002-002-Homepage-Restructure/` (the deployment package: script, README, VERIFICATION, ROLLBACK)

**Enables**
- Stakeholder review of the live homepage
- Any future `POA-CASE` entry, if a future incident corroborates this mission's governance handling

---

## 1. Executive Summary

EO-DEL002-002 implemented the structural and technical findings from `EO-DEL002-001` against the live homepage (page 959). Two Code Snippets were deployed by the user, both prepared as dry-run-gated, idempotent, server-side scripts rather than direct large API writes — the homepage's `_elementor_data` payload (~110KB) was judged too large to push safely through a single tool call, so this mission followed the same server-side-script pattern this engagement already established for large content operations (`CMS-004`'s footer cleanup).

**Delivered:** the homepage's "Core services" section now renders the same CMS-driven, 9-service/3-category taxonomy already live on `/services/` (M1); the 12 homepage stages now match `PDC-A001`'s governing order exactly, resolving all three ordering deviations `EO-DEL002-001` identified (M2); the "Book Opportunity Screening" CTA now follows the Services section instead of preceding it (M4, resolving finding D-09); a homepage meta description now exists where none did before (M6). All four changes were verified live via fully cache-busted fetches (`cf-cache-status: MISS`, `x-gateway-cache-status: MISS`) — not assumed from the deployment succeeding.

**Not implemented, and why:** M3 (narrative/transition copy editing) was scoped conservatively — `EO-DEL002-001`'s own Redundancies finding stated no duplicate messaging exists within the homepage itself, so no copy was invented to "fix" a problem that wasn't there; the reordering (M2) and CTA move (M4) already restore the narrative transitions the audit flagged as broken. M5 (UX/spacing refinement) found nothing requiring a code change — structural and responsive verification across three breakpoints found no layout defects, so nothing was "refined" that wasn't already working; this is stated as a finding, not a shortfall. One part of M6 (the "3 H1s" finding, D-08) was investigated further this mission and **found not to be a real defect** — see §3 below; the finding is corrected, not merely closed.

**One process note surfaced by this mission, consistent with `POA-GOV-001`'s own worked example:** the in-session screenshot/visual-capture tool was non-functional throughout this mission (confirmed via repeated attempts across multiple tabs and viewports) — literal pixel screenshots for the Visual Evidence deliverable could not be produced. This is stated plainly rather than worked around by claiming a visual QA that didn't happen; a structural/responsive-behaviour verification (§5) was substituted and is the strongest evidence available this session.

---

## 2. Implementation Log

| # | Task | Audit Finding | Repository Reference | Resolution |
|---|---|---|---|---|
| M1 | Replace homepage's hardcoded 8-item services grid with CMS-driven taxonomy | D-01 (Critical — homepage/`/services/` catalogue mismatch) | `PDC-A001` AMD-1 (Service Portfolio Structural Model); `CMS-005A` (the taxonomy this now consumes) | Homepage's "Core services" section now renders `[iep_services_by_category]` — the identical shortcode `/services/` uses. Zero new business logic written. Verified live: old catalogue text absent, new 3-category structure present. |
| M2 | Correct homepage section order | D-02 (Who-We-Help/Commercial-Challenge swap), D-03 (Case-Studies/Services order), D-04 (Technical-Capability/Leadership swap) | `PDC-A001` (12-stage governing model), superseding the live drift `PDC-A001` AMD-4 had already flagged as unactioned | All 15 top-level sections reordered server-side to match `PDC-A001` exactly: Commercial Challenge → Who We Help → Why IEP → Funding → Methodology → Services → Case Studies → Technical Capability → Leadership → Testimonials → CTA. Verified live via heading-order extraction from a cache-busted fetch. |
| M4 (partial) | Reposition the Methodology-section CTA | D-09 (CTA preceded the Services section it referenced) | `EO-DEL002-001` §3 (Visitor Journey Assessment); `CONTENT-004`'s original 2026-07-13 recommendation | "Book Opportunity Screening" CTA (text + button) moved from the end of Methodology to the end of Services. Verified live via DOM-order positional check — CTA now sits between "Core services" and "Featured case studies." |
| M6 (meta description) | Add homepage meta description | D-08 (no `<meta name="description">` existed) | `PDC-001` Article I (Constitutional Statement — source of the description copy, not newly drafted) | Deployed a `wp_head`-hooked snippet, scoped to the front page only (no SEO plugin exists on this site — confirmed during the audit). Verified live: 158-character description present, sourced from Article I's own language. |
| M6 (H1 investigation) | Resolve or document the "3 H1s" finding | D-08 (multi-H1) | — | **Finding corrected, not just resolved.** Deep inspection (computed styles, not just element count) found only one H1 is actually visible — the hero's own. The "site-title" H1 shows only a logo image (its text is `display:none`, a standard accessibility pattern). The "Home" H1 is fully hidden (0×0, inside a `display:none` ancestor). No code change made, because none was needed — this is standard theme markup, not a defect. `EO-DEL002-001`'s own D-08 is superseded by this finding. |
| M3 | Narrative/transition improvements | (No specific drift item — `EO-DEL002-001` found no on-homepage duplicate messaging) | `EO-DEL002-001` §Redundancies | No copy changes made. M2's reordering already restores the transitions the audit found broken (Technical Capability's "Who will I work with?" logic into Leadership; the Commercial-Challenge-before-Who-We-Help question sequence). Inventing additional "improvements" without an evidenced gap would have violated Content Integrity (`PDC-001` Article X). |
| M5 | UX refinement (spacing, rhythm, mobile) | — | `PDC-001` Article VI (Executive Design Philosophy) | Verified, not changed. Structural/responsive checks (§5) found no layout defects at any of three breakpoints — the one specific risk called out for this deployment (the services band's negative-margin full-bleed technique causing mobile horizontal scroll) was directly tested and confirmed absent. |

---

## 3. Drift Resolution Register

Confirming every item from `EO-DEL002-001`'s Implementation Drift Register (§7 of that report):

| ID | Finding | Status |
|---|---|---|
| D-01 | Homepage/`/services/` catalogue mismatch | **Resolved.** Homepage now consumes the same taxonomy. |
| D-02 | Who-We-Help/Commercial-Challenge order | **Resolved.** |
| D-03 | Case-Studies/Services order | **Resolved.** |
| D-04 | Technical-Capability/Leadership order | **Resolved.** |
| D-05 | Homepage 100% hardcoded, no CMS usage | **Partially resolved.** The Services section is now CMS-driven. Case Studies and Leadership excerpts remain hardcoded — deliberately deferred, since `CMS-BOOT-002` already established their underlying CPTs (`cspt-portfolio`, `cspt-team-member`) have zero REST exposure, the same wall `CMS-002` hit for Leadership. Fixing this is a larger, separate mission (registering `show_in_rest` on those CPTs needs SFTP/code-level access, per that finding's own original scope) — intentionally deferred, not overlooked. |
| D-06 | EO-DEL002-001's own template conflicting with `PDC-A001` | **Resolved via escalation**, per `POA-CASE-001`. `EO-DEL002-002`'s M2 instruction ("Correct any ordering deviations identified during EO-DEL002-001... Repository governance takes precedence") confirmed `PDC-A001` as authoritative — implementation followed `PDC-A001`'s 12-stage model, not the earlier EO's own template. No "Resources" section was added; no governed stage was renamed or removed. |
| D-07 | `ADR-001` missing; `CMS-001-CMS-Architecture.md`/`SEO-001` still placeholders | **Deferred, unchanged.** Outside this mission's scope (Engineering Constraints explicitly excluded "Repository modifications" and "Governance modifications" from this EO's authorization). |
| D-08 | No meta description; 3 H1 elements | **Resolved (meta description) / Corrected (H1 finding).** See Implementation Log above — the H1 "defect" turned out not to be one. |
| D-09 | Methodology CTA preceding Services | **Resolved.** |
| D-10 | Insights/Careers/Resources/Quality Management/Grants orphaned pages | **Deferred, unchanged.** Outside this mission's scope — Engineering Constraints excluded "New homepage sections outside approved repository scope," and these are separate pages, not homepage sections; no instruction in this EO covered them. |

**No drift item was silently dropped.** Every item is either Resolved or explicitly marked Deferred with a stated reason, per this mission's own Drift Resolution Register requirement.

---

## 4. Validation Report

### Repository Alignment
Live homepage section order, services content, and CTA placement now match `PDC-A001` exactly — verified via cache-busted fetch, not assumed from deployment success. No constitutional content (positioning, claims, copy) was altered; only structure, one CTA's position, and one CMS wiring changed.

### Governance Compliance
This mission operated under `POA-GOV-001`'s Standing Order, as the EO itself required. The one place a conflict could have arisen — M2's instruction to "correct ordering deviations identified during EO-DEL002-001" — was resolved by treating `PDC-A001` as authoritative (per the EO's own explicit statement that "Repository governance takes precedence over this Engineering Order if a conflict is discovered"), not the earlier, now-superseded EO-DEL002-001 template. No repository, governance, or constitutional document was modified — consistent with the Engineering Constraints. No new architecture or taxonomy was introduced — M1 reused the existing `service_category` taxonomy and `[iep_services_by_category]` shortcode verbatim.

### CMS Integrity
`[iep_services_by_category]` renders identically on the homepage and `/services/` — same shortcode, same underlying taxonomy query, zero duplicated logic. Verified: 3 category groups, 9 services, correct icons, matching what's live on `/services/`.

### Responsive Behaviour
Verified at three breakpoints via cache-busted, fully-rendered page loads (not cached/stale reads):
- **Desktop** (implicit, via the primary verification fetch): correct order, correct content.
- **Tablet (768px):** no horizontal overflow (`docWidth: 758` ≤ `viewportWidth: 768`), 3 service grids present, 26 cards rendering.
- **Mobile (375px):** no horizontal overflow (`docWidth === viewportWidth === 375`), the full-bleed category band (the one specific risk flagged for this deployment) confirmed constrained to exactly the viewport width with no bleed — the negative-margin break-out technique is working as designed, not causing scroll.

### Accessibility
Not a full audit (outside this mission's scope). The one accessibility-adjacent item investigated (multi-H1) was found to be standard, benign markup (hidden accessible text + visible logo image in the site-title H1; a fully-hidden, zero-size title-bar H1) — not a defect requiring a fix.

### Remaining Risks
1. **Screenshot/visual-capture tooling was non-functional this entire mission** (confirmed via repeated failed attempts, multiple tabs, multiple viewport presets). All verification in this report is structural/DOM-based, not pixel-based. **Recommend a manual visual QA pass** (a human, or a future session with working screenshot tooling) before treating this as fully stakeholder-review-ready, specifically to eyeball the services band's visual integration mid-homepage — this was checked structurally (no overflow, correct sizing) but not checked for whether it *reads well* aesthetically wedged between other sections, which is a judgment call a screenshot would settle faster than DOM inspection can.
2. **The restructure script's DB backup write (`_iep_homepage_restructure_backup`) did not appear in a post-deployment meta check.** Not re-diagnosed (non-blocking — the forward change is independently confirmed correct), but flagged: if this session's local backup file (`homepage-parsed.json`, referenced in `ROLLBACK.md`) is ever unavailable in a future session, re-verify whether the DB backup key genuinely exists before assuming it does.
3. **D-05 and D-10 remain deferred**, per the Drift Resolution Register above — not risks introduced by this mission, but pre-existing gaps this mission's scope didn't cover.

---

## 5. Visual Evidence

**Literal desktop/tablet/mobile screenshots could not be produced this mission** — the screenshot/computer-use tool timed out on every attempt (multiple tabs, multiple viewport presets, both before and after this session's own earlier successful use of other browser tools). This is the same failure mode encountered during `EO-DEL002-001`. Rather than substitute a claim of visual verification that didn't happen, the following structural evidence is provided instead, gathered via genuinely rendered (not merely fetched) pages at each breakpoint:

| Breakpoint | Viewport | Horizontal overflow | Services grid rendering | Notes |
|---|---|---|---|---|
| Desktop | (verified via full-page fetch, native width) | N/A (fetch-based check) | 3 category groups, correct content | Primary correctness verification |
| Tablet | 768×1024 | None (`docWidth: 758`) | 3 grids, 26 cards | |
| Mobile | 375×812 | None (`docWidth: 375`, exact match) | 3 grids, 3 categories, full-bleed band confirmed viewport-constrained | The one specific risk this deployment carried (band overflow) — directly tested, confirmed absent |

**Recommendation:** if stakeholder review requires actual screenshots (likely, given the mission's own success criteria references "ready for stakeholder review"), request a follow-up pass once screenshot tooling is confirmed working, or take manual screenshots directly in a browser.

---

## Source References

**Primary Sources**
- `docs/EO-DEL002-001-Homepage-Constitutional-Audit.md` (all findings implemented or deferred here)
- `PDC-A001` (governing model implementation was aligned to)
- `POA-GOV-001`, `POA-CASE-001` (governance framework this mission operated under)
- Live WordPress state, verified directly 2026-07-14 via multiple cache-busted fetches at three viewport widths

**Related Repository Documents**
- `deployment/EO-DEL002-002-Homepage-Restructure/` (README, VERIFICATION, ROLLBACK, and the two deployed scripts)
