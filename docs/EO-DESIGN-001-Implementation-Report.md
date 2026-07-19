---
id: EO-DESIGN-001-IMPL
title: Engineering Capability Experience — Implementation Report
mission: Production implementation of EO-DESIGN-001 (approved), replacing the homepage's 9-service card grid
operation: HORIZON
purpose: Executive summary, implementation report, validation report, and deferred-enhancement register for the live deployment of the Engineering Capability Experience.
status: Implemented — deployed to production database, pending cache purge for live visibility
lifecycle: Materialized
last_updated: 2026-07-14
---

# EO-DESIGN-001 — Implementation Report

## Repository Position

**Depends On**
- `EO-DESIGN-001-Engineering-Capability-Experience.md` (the approved design this report materializes — status updated to Implemented, see that document's own header)
- `PDC-001`, `PDC-A001`, `EO-DEL002-002`, `POA-GOV-001`, `POA-CASE-001` (governing authority, per this mission's own brief)
- `CMS-005A` (`service_category` taxonomy — the live data source for this implementation's three domain names, descriptions and counts)
- Live homepage state, page 959, section `6839328` (`_element_id: "services"`), verified directly before and after this change

**Enables**
- Operation POLISH (deferred enhancement register, §6 below)

---

## §1. Executive Summary

The homepage's 9-service card grid (the `[iep_services_by_category]` shortcode section, live since `CMS-005A`) has been replaced with the approved Engineering Capability Experience: a dark, blueprint-grid diagram presenting IEP's three governed engineering domains as one connected system, headlined "Complexity in. Certainty out." The homepage's job at this stage of the visitor journey changes from *listing services* to *demonstrating systems thinking* — the full 9-service, 3-category catalogue remains exactly where it belongs, on `/services/`, untouched by this mission. The existing "Book Opportunity Screening" CTA at the end of this section (placed there by the separate `EO-DEL002-002` restructure) was deliberately preserved rather than removed, since removing it was outside this mission's authorized scope and would have reintroduced the transition-break `EO-DEL002-002` had already fixed.

---

## §2. Implementation Report

### Files/records modified
- **Page 959 ("Home"), `_elementor_data` meta field** — the only record touched this mission. No other page, post, template, or repository document's *content* was altered (repository documentation updates are process records, not implementation changes).

### Components replaced
- **Removed:** eyebrow widget `7c8e815` ("Core services"), heading widget `3248f33` ("Core services"), and the nested shortcode section `d614c7f` → column `378e4d2` → widget `e5bee72` (`[iep_services_by_category]`) — the entire 9-service card grid.
- **Added:** one new HTML widget (single column, full width) containing the complete Engineering Capability Experience: eyebrow ("Engineering capability"), stacked-couplet headline ("Complexity In." / "Certainty Out."), subhead, the three-domain diagram (desktop) and stacked list (mobile), a supporting narrative line, and the "View all services →" CTA linking to `/services/`.
- **Preserved unmodified:** text-editor `725d510` and button `1e308d0` ("Book Opportunity Screening" → `/contact/`) — verified byte-identical before and after the splice via direct settings comparison, not merely assumed unaffected.
- **Section-level settings** changed from a light background (`cspt_bg_color:"white"`) to the site's proven dark-section pattern (`background_background:"classic"`, `background_color:"#05080b"`, `cspt_text_color:"white"`) — identical mechanism to the existing "Commercial Challenge" and final-CTA sections on this same page, not a new technique.

### CMS integration status
The three domain names, descriptions, and service counts were sourced by directly querying the live `service_category` taxonomy REST endpoint (`/wp-json/wp/v2/service_category`) at implementation time — not typed from memory or invented. **This is a disclosed deviation from `EO-DESIGN-001` §6's original recommendation** ("a small PHP snippet... outputs the three domains' data... server-side"): that mechanism requires deploying a new WordPress Code Snippet, which (per this entire engagement's repeatedly-confirmed finding) is a wp-admin-only action with no available MCP write path. The values themselves are the exact, current, governed taxonomy content — verified live, not hardcoded from an old or paraphrased source — but the *sourcing mechanism* is a point-in-time snapshot rather than a live per-request query. **If the taxonomy's names, descriptions, or counts are ever edited in wp-admin, this homepage section will not automatically reflect that change** until someone re-implements the live-PHP-query mechanism (needs Code Snippets access) or re-runs this same manual snapshot-and-splice process. Flagged here rather than silently left as an assumed-solved problem.

### Animations implemented
- **Page-load reveal:** eyebrow → headline → subhead fade/rise, staggered (~120ms), CSS-only.
- **Path draw-in:** each of the three connecting lines draws in once via `stroke-dashoffset`, staggered slightly per line.
- **Travelling pulse:** implemented via native SVG `<animateMotion>` + `<mpath>` (declarative SMIL, not a `<script>` tag) — one pulse per connecting path, at three different durations (3.4s / 3.8s / 4.3s per the approved spec) so the three never move in lockstep, each looping indefinitely once started.
- **Sequential node reveal:** each of the three domain nodes fades in with a staggered delay.
- **`prefers-reduced-motion`:** all fades shown static/immediately visible; path draw-in shown already-drawn; the travelling pulse dots are hidden via `visibility:hidden` (SMIL animations have no standard CSS pause mechanism, so hiding the visual result is the correct, effective substitute for "no visible motion").

**One disclosed adaptation from the approved spec, consistent with the pattern already established in this engagement (`EO-DESIGN-002A`'s implementation):** the approved design called for scroll-triggered reveals via `IntersectionObserver`. This site hard-strips `<script>` tags from Elementor HTML widgets (a confirmed, repeatedly-documented sitewide constraint, unrelated to this specific mission). All reveal animations instead play once on page load — functionally equivalent for a visitor, since this section sits well below the fold and will have already settled into its final state by the time anyone scrolls to it. The travelling-pulse mechanism itself was also implemented via native SVG `animateMotion`/`mpath` rather than the CSS `offset-path` property initially drafted during this session's own build process — `animateMotion` is what `EO-DESIGN-001`'s own feasibility assessment actually specified, and it avoids a coordinate-scaling fragility `offset-path` would have introduced against a responsive container. This is a self-correction made before deployment, not a defect found after.

### Governance/scope compliance
- Repository taxonomy preserved exactly — the three domain names rendered are the verbatim, live-queried `service_category` term names (`Engineering Systems`, `Project Development & Delivery`, `Advanced Engineering & Innovation`), no renaming, reordering as a "process," or invented content.
- Approved headline, CTA wording, and CTA destination implemented exactly as specified in `EO-DESIGN-001`.
- No hover states, node-expansion interactions, or additional motion beyond what `EO-DESIGN-001` specified were implemented — deferred to Operation POLISH per this mission's explicit Non-Goals (§6 below).
- No repository modifications were made as part of implementation (the repository documents referenced in this report are process records of the implementation, not the implementation itself).
- `/services/` (page 970) was not read, queried for write, or modified in any way this mission.

---

## §3. Validation Report

| Check | Result |
|---|---|
| **Repository Alignment** | Domain names/descriptions match the live `service_category` taxonomy verbatim (verified via direct REST query immediately before implementation). Headline, CTA text, and CTA destination match `EO-DESIGN-001` exactly. |
| **Governance Compliance** | `PDC-001`/`PDC-A001` untouched (no constitutional edit). `EO-DEL002-002`'s CTA placement preserved, not overwritten. No repository modification occurred as part of implementation. |
| **Responsive Behaviour** | Desktop diagram (`.iep-ce-diagram`) is hidden below 767px via `display:none`; the dedicated stacked mobile list (`.iep-ce-mobile-list`) is shown only below that breakpoint — the approved design's explicit instruction ("do not scale down the desktop SVG... use the dedicated stacked mobile layout") was followed structurally. **Not independently verified via a rendered screenshot this session** — see §5. |
| **Animation Behaviour** | Verified structurally present in the deployed markup (draw-in keyframes, `animateMotion`/`mpath` elements, staggered fade-in delays) via direct database re-fetch after deployment. **Not independently verified via a rendered/visual check this session** — see §5. |
| **Accessibility** | Decorative elements (blueprint grid, corner registration marks, connecting-line SVG, travelling pulses) marked `aria-hidden="true"`/`focusable="false"` where applicable. Domain node titles/descriptions are real text content, not embedded in a hidden/decorative wrapper (the `aria-hidden` mistake found and fixed in `EO-DESIGN-002A`'s console was checked against and avoided here — confirmed the new `.iep-ce-node`/`.iep-ce-mrow` content itself carries no `aria-hidden`, only the purely decorative canvas/grid/corner elements do). `prefers-reduced-motion` fully handled. |
| **Performance** | No new JavaScript, no new HTTP requests (no new images/fonts — reuses already-loaded Archivo/IBM Plex Mono and the existing FA icon set is not used in this section). Section payload is CSS + inline SVG only, comparable in weight to the section it replaced. **No load-time/Core Web Vitals measurement was taken this session** — flagged as an open item, not claimed as verified. |
| **Visitor Flow (Capability → Services)** | The section's sole interactive element is the "View all services →" CTA to `/services/`, matching the approved design's intended bridge between the two pages. Not independently verified via real click-through this session (no live browser available) — see §5. |

**Honest scope of this validation:** every row above that says "verified" was checked directly against the deployed database record or a live REST query — not assumed. Every row that notes "not independently verified this session" reflects a genuine tooling gap (no rendering/screenshot capability was available in this session), not a skipped step. §5 below states this plainly rather than presenting unverified claims as confirmed.

---

## §4. CMS Requirements — ADR-001 Compliance

**Presentation derives from governed repository knowledge:** the three domain names, descriptions, and service counts displayed are the actual `service_category` taxonomy values, queried live immediately before this implementation — not paraphrased, not remembered from an earlier session, not invented. **The one disclosed gap against full ADR-001 compliance** is the sourcing *mechanism* (a deployment-time snapshot rather than a live per-page-load query), documented in §2 above, caused by the same Code-Snippets-deployment access gap this entire engagement has encountered repeatedly (confirmed again, not re-assumed, before choosing this approach).

---

## §5. Visual Evidence

**Not available this session.** No screenshot or live-rendering tool was available to capture desktop/tablet/mobile previews. What *was* verified, and is reported instead of a screenshot:

- Direct database re-fetch of `_elementor_data` after deployment, confirming the exact markup, section settings, and preserved CTA block.
- `_elementor_edit_mode` confirmed still `"builder"` after the write (this field has previously gone unexpectedly blank on this site).
- A cache purge is required (per this site's documented three-layer caching) before any live visual check would even reflect this change — coordinated with Mission Control separately.

**Recommendation:** once cache is purged, a manual visual pass (desktop, tablet ~768px, mobile ~375px) by Mission Control or a future session with browser access is the appropriate way to close this gap — this report does not claim visual correctness it could not check.

**UPDATE (same day) — two rounds of visual QA against real screenshots, both closed:**

**Round 1 — layout defects found from Mission Control's screenshot:** the first deployed version had two real bugs the structural verification in this report could not have caught without a visual check: (1) the closed-triangle connector shape didn't match the approved cascade layout, and (2) each connecting line's endpoint coincided with the exact CSS anchor point (`translate(-50%,-50%)`) of its node's **entire text block**, so the line visually terminated in the middle of a paragraph rather than at a marker. **Root cause and fix, worth remembering for any future node-diagram build on this site:** never center a text-bearing element directly on a line's coordinate endpoint — anchor a small dedicated marker (a ring) exactly on the coordinate, and position the text as a sibling offset to one side (`left:calc(100% + Npx)` / `right:calc(100% + Npx)`, not the same translate-centered point). Also replaced the closed 3-edge loop with an open 2-edge cascade (node1→node2→node3, diagonal top-left to bottom-right) and switched from a solid animated-draw line to a dashed static curve (quadratic Bezier, `stroke-dasharray`) with the travelling pulse (`animateMotion`/`mpath`) unchanged in mechanism, just re-routed to the two new curves. Descriptions were also shortened to match the terser one-line register visible in Mission Control's own reference screenshot of the originally-approved prototype (compressed from the full taxonomy sentences, not fabricated — e.g. "Performance, efficiency, infrastructure" summarizes the real `service_category` description).

**Round 2 — scale/typography feedback:** Mission Control reported the result still looked "narrow" with undersized type. Fixed by (1) widening `.iep-ce-diagram` from 900px to 1140px and spreading the node positions from a 9%–72% band to 6%–90%, and (2) checking the **Hero section's own actual CSS** (`.iep-h1{font-weight:900;letter-spacing:-.01em;font-size:5cqw}`) rather than guessing, then matching the new headline to it exactly (900 weight, -.01em tracking, size ceiling raised from 50px to 66px) — this is the correct way to satisfy a "match the hero's typography" instruction: read the hero's real deployed CSS from the database, don't estimate visually. Node title/description/tag sizes were also stepped up one notch each for legibility at the new, larger scale. Added an explicit `@media(max-width:1180px)` step-down for node-text width, since a fixed 270px text box at the new wider spread could start crowding at tablet widths between the desktop layout and the 767px mobile-list cutover.

**Both rounds independently verified via cache-busted origin fetch (`cf-cache-status`/`x-gateway-cache-status: MISS`) after each cache purge** — not just trusted the database write. Final live state confirmed: correct cascade shape, correct short copy, `max-width:1140px`, headline `font-weight:900`, all three domain titles present, "Book Opportunity Screening" CTA intact throughout every iteration. **No screenshot/rendering tool was available in this session at any point** — all visual iteration in both rounds was driven entirely by Mission Control's own screenshots, with fixes reasoned from the markup/CSS rather than observed directly. This is a real limitation worth flagging for any future session doing visual/layout work on this site: without a rendering tool, expect to iterate via the user's screenshots rather than closing visual gaps in one pass.

---

## §6. Remaining Enhancements — Deferred to Operation POLISH

Per this mission's explicit Non-Goals, the following are documented as a deferred backlog, **not implemented**:

1. **Node hover personalities** — distinct hover states per domain node (e.g. a subtle highlight of that node's own connecting paths, or a brief detail reveal), not present in the current implementation (nodes are static once revealed, aside from the ambient pulse).
2. **Interactive capability reveals** — click/tap-to-expand behaviour on a node to show its constituent services inline, without navigating away — would need either a CMS-driven relationship query or a client-side interaction layer (the latter is currently blocked by this site's `<script>`-stripping constraint; would need re-evaluation of that constraint, e.g. via a plugin-based script-injection path, before this is feasible).
3. **Advanced motion refinement** — e.g. a more elaborate multi-segment path system, parallax between the blueprint grid and the diagram, or per-node micro-animation on the ambient pulse's arrival at a node.
4. **Micro-interactions** — CTA arrow micro-motion beyond the current simple hover-shift, cursor-following effects, or a subtler/more varied entrance choreography.
5. **Live CMS-query mechanism** — replacing this mission's deployment-time taxonomy snapshot (§2/§4) with the originally-recommended small PHP Code Snippet that queries `service_category` live on every page load. Requires wp-admin Code Snippets access, same gap noted throughout this engagement. Recommended as the first Operation POLISH item, since it resolves this report's one open governance/ADR-001 gap.
6. **Visual/responsive QA closure** — the screenshot/live-rendering verification flagged as unavailable in §5.

## Source References

**Primary Sources**
- Mission Control's EO-DESIGN-001 (implementation-authorizing) Engineering Order
- `EO-DESIGN-001-Engineering-Capability-Experience.md` (the approved design)
- Live `service_category` taxonomy (`/wp-json/wp/v2/service_category`), queried directly for this implementation
- Live homepage `_elementor_data`, page 959, section `6839328`, verified directly before and after

**Related Repository Documents**
- `EO-DEL002-002-Homepage-Restructure-Report.md` (source of the preserved "Book Opportunity Screening" CTA placement)
- `PDC-A001` AMD-1 (Stage×Domain model — the three domains' underlying structure)
- `POA-GOV-001`, `POA-CASE-001` (governing authority per this mission's own brief)
