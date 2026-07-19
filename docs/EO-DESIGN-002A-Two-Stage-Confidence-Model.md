---
id: EO-DESIGN-002A
title: Two-Stage Engineering Confidence Model — Amendment to EO-DESIGN-002
mission: Homepage presentation evolution (post-DEL-002, resolves EO-DESIGN-002 §0)
operation: HORIZON
purpose: Resolves EO-DESIGN-002's open placement question by directing two distinct, complementary confidence sections rather than one. Designs the new Executive Confidence Strip (Layer 1) in full; carries Technical Capability Experience (Layer 2) forward from EO-DESIGN-002 unchanged in position, expanded in treatment. Authorized for implementation.
status: Implemented — deployed to production database, pending cache purge for live visibility
lifecycle: Materialized
last_updated: 2026-07-14
---

# EO-DESIGN-002A — Two-Stage Engineering Confidence Model

## Repository Position

**Depends On**
- `EO-DESIGN-002-Engineering-Confidence-Layer.md` (this document resolves that mission's §0 placement question and supersedes its single-section framing — the "confidence console" design in EO-DESIGN-002 §1–§9 is **not discarded**, it becomes this document's Layer 2)
- `EO-DESIGN-001-Engineering-Capability-Experience.md` (Layer 2's narrative predecessor, unchanged)
- `PDC-A001` AMD-4/AMD-5 (12-stage homepage model — this amendment does not add a 13th stage; it redefines what occupies stage 1 and confirms stage 9's position)
- `PDC-001` Article VIII (stage-preservation principle — addressed directly in §4 below, since replacing Trust Metrics touches stage 1)
- Mission Control's EO-DESIGN-002A brief and Engineering Corps Directive (both quoted/paraphrased where load-bearing, not reproduced in full)

**Enables**
- Direct implementation — this document is itself the implementation authorization EO-DESIGN-002's own §10 said would be needed as a follow-up.

**Supersession note, stated precisely:** EO-DESIGN-002's §0 offered Candidate A (Trust Metrics) and Candidate B (Technical Capability) as alternatives and recommended B. Mission Control's resolution is **not** "B was right" — it is "both, doing different jobs." This is a materially different outcome from either candidate alone, recorded here as an amendment rather than as a quiet edit to EO-DESIGN-002, consistent with `POA-GOV-001`'s discipline of recording how open questions were actually resolved.

---

## §1. The Two-Stage Model, as Directed

```
Hero
 ↓
Executive Confidence Strip   — "I feel I can trust them."      (Layer 1 — NEW, replaces Trust Metrics, stage 1)
 ↓
Commercial Challenge → Who We Help → Why IEP → Funding → Methodology → Capability Experience
 ↓
Technical Capability Experience — "They can actually execute."  (Layer 2 — EXPANDED, stays at stage 9, unchanged position)
 ↓
Leadership → Case Studies → Testimonials → Call To Action
```

**Why this is a real distinction, not two sections asking the same question twice:** Layer 1 answers a first-glance, low-information question — *does this organisation look disciplined?* — answerable in seconds, before a visitor has read anything about what IEP actually does. Layer 2 answers a late-journey, high-information question — *now that I've seen their scope and their thinking, do I believe they can execute it?* — answerable only after Commercial Challenge, Funding, Methodology, and the Capability Experience have already given the visitor something concrete to validate against. A visitor who bounces after five seconds only ever needed Layer 1. A visitor evaluating a real project needs Layer 2 to close the decision. Neither layer can do the other's job.

---

## §2. Layer 1 — Executive Confidence Strip (new design)

### 2a. Design Concept

**Governing idea:** this is the site's *fastest* section, not its richest. A visitor forms the "these people are disciplined" impression in the time it takes to read five short phrases — the design's entire job is to make that reading effortless, not to hold attention. Where Layer 2 (§3) rewards a visitor who stops and looks closely, Layer 1 must work even for a visitor who only glances.

**Why it is not a smaller version of the Technical Capability console:** Mission Control's directive is explicit that these are different forms of confidence, and the design must look different, not just say different words in the same component. The radial console / steady-glow motif (established in `EO-DESIGN-002` and carried into Layer 2 below) is reserved exclusively for Layer 2. Layer 1 uses a **plain horizontal signal strip** — no diagram, no connecting lines, no central hub. This is a deliberate visual-vocabulary split: Layer 2 "shows a system," Layer 1 "states a posture."

**Placement continuity with Hero:** rather than breaking to a new background immediately, the strip sits on the same dark canvas as the Hero (`#05080b`, shared with the site's existing hero and the Layer 2/Services grammar), separated only by a thin accent-green hairline rule — visually reading as the Hero's own closing statement rather than a new section a visitor has to mentally context-switch into. The break to a light background happens after the strip, at Commercial Challenge, which is where the site's established rhythm already expects the first light section to begin.

**Content shape:** five short engineering-posture signals, chosen from the brief's list for direct evidentiary grounding (see §2f) — not descriptions of what IEP sells (that's Services' job) and not a claim about outcomes (that's Case Studies' job). Each signal is two to four words plus a one-line, optional micro-descriptor — deliberately terser than Layer 2's modules, since this section must be readable in a glance.

### 2b. Section Layout

Full-width band, `padding: 64px 0` (roughly half the site's standard 130px section rhythm — this section is intentionally light and fast, not a full "stage").

- Five signal items in a single horizontal row on desktop, evenly spaced, separated by thin vertical hairline dividers (not cards — no borders, no background fills per item, matching the brief's explicit "not a badge wall" instruction).
- Each item: a small line-icon (FA5-classic, matching site convention) above a short mono-tracked label, with the optional micro-descriptor in smaller muted text beneath.
- No heading, no eyebrow, no CTA. This section does not introduce itself — it simply appears as the Hero's trailing statement, which is itself part of the "effortless" design goal (a labelled section header would slow the read down).
- Top border: a 1px `#7fc98a`-at-low-opacity hairline, the section's only ornament, marking it as distinct from Hero without a hard visual break.

**Mobile (below 767px):** five items become a 2+2+1 wrapped grid (not a vertical list — at this section's information density, five short stacked rows would read as a list of stats, exactly the "counter section" register this layer must avoid). Hairline dividers become horizontal, between rows only.

### 2c. Typography Hierarchy

| Role | Face | Weight | Size | Notes |
|---|---|---|---|---|
| Signal label | Archivo | 700 | 14px | Uppercase, tight tracking — reads as a posture statement, not a sentence |
| Signal micro-descriptor | System sans | 400 | 12px | Muted (`#a9bcc2`), optional per item — omit rather than pad if a signal is self-explanatory |
| Icon | — | — | 20px | Single colour (`#7fc98a`), line-style only, no fills — restrained, consistent with "not a badge wall" |

### 2d. Motion Specification

Deliberately the quietest motion on the page:

1. **On load (not on scroll — this section is above the fold with the Hero):** the five items fade in together with a single, very short (~250ms) stagger of ~40ms each — fast enough to feel instantaneous, not a scroll-reveal performance.
2. **One-time hairline sweep:** a single thin light pulse travels left-to-right along the top border hairline, once, on load — the section's only "systems check" cue, intentionally subtle and never repeating (explicitly not a looping scan effect — a one-time pass reads as "checked," a looping one reads as "still checking," which undercuts the confidence this section exists to deliver).
3. **No steady-glow indicators here** — that motif is reserved for Layer 2, per §2a's visual-vocabulary split.
4. **`prefers-reduced-motion`:** static, fully visible immediately, no sweep.

### 2e. Visual Direction

| Token | Value | Source |
|---|---|---|
| Background | `#05080b` | Shared with Hero — continuity, not a new palette |
| Divider | `#7fc98a` at ~15% opacity | Restrained — hairlines, not borders |
| Icon/accent | `#7fc98a` | Site accent |
| Label text | `#eef4f0` | Matches Hero text |
| Descriptor text | `#a9bcc2` | Matches Hero secondary text |

No blueprint grid, no corner registration marks here — those are Layer 2/Services' signature motifs. Layer 1 is deliberately the plainest section on the page.

### 2f. Copy Recommendations (five signals, each evidenced)

| Signal | Micro-descriptor (optional) | Evidence source |
|---|---|---|
| **Integrated Engineering** | Energy, water and low-carbon systems, one team. | `service_category` taxonomy — three governed domains |
| **Stage-Gated Delivery** | Screening through to delivery, gated at every stage. | `PDC-A001` AMD-1 (Stage services) |
| **Investment-Focused Thinking** | Every recommendation is built to be funded. | Live "Funding Capability" homepage section |
| **Cross-Disciplinary Expertise** | Chartered engineers across energy, water and process. | Live Leadership credentials (BEng MIET; CEng FEI FIET PhD) |
| **Engineering Governance** | Evidence-led, outcome-first, nothing published unproven. | `PDC-001` Article X (Content Integrity) |

Two of the brief's seven suggested themes — "Systems Engineering" and "Industrial Lifecycle Coverage" — were **not** included here; both are more precisely Layer 2's territory (systems engineering depth is a rational-validation claim, not a first-glance posture one), and repeating a theme across both layers would blur the distinction Mission Control's directive requires. This is a deliberate exclusion, not an oversight.

### 2g. Accessibility

Same principles as `EO-DESIGN-002` §9: reading order matches visual order regardless of the wrapped-grid mobile layout; the one-time hairline sweep is purely decorative (no information conveyed by it alone); `prefers-reduced-motion` removes the sweep and fade entirely, showing static content.

---

## §3. Layer 2 — Technical Capability Experience (carried forward, position unchanged)

**This is `EO-DESIGN-002`'s full design (§1–§9 of that document — confidence console, six steady-glow indicator modules, radial layout, dark blueprint grammar) — not redesigned here, only reconfirmed and re-scoped:**

- **Position:** unchanged — stage 9, immediately after the Capability Experience (`EO-DESIGN-001`), immediately before Leadership. `EO-DESIGN-002`'s own recommendation on this point stands; Mission Control's directive confirms it rather than revising it.
- **Content:** the six confidence dimensions in `EO-DESIGN-002` §6 (Systems Engineering Depth, Stage-Gated Delivery, Investment Protection, Evidence-Led Delivery, Senior-Led Execution, Integrated Domain Thinking) already match the brief's own Layer 2 question list ("Can they execute? Do they possess specialist expertise? Do they understand engineering complexity? Can they manage technical risk?") closely enough that no rewrite is needed — cross-checked term by term, every one of the brief's four Layer 2 questions is already addressed by an existing dimension.
- **One refinement directed by this brief, not previously specified:** "present specialist capabilities as an interconnected engineering ecosystem" and the theme list (CFD, FEA, Industrial Modelling, AI Simulation, Process Engineering, Design Validation, Digital Engineering, Systems Integration) maps onto `EO-DESIGN-002`'s **Signal / 01 "Systems Engineering Depth"** module specifically — that module's one-line description should be read as a *category* covering this fuller theme list, not expanded into eight separate modules (which would break the six-module console's balance and re-introduce the "tag cloud" problem this brief explicitly says to avoid). Recommendation: the six-module structure stays exactly as designed; if Mission Control wants the CFD/FEA/AI-simulation/etc. themes individually visible, they belong as sub-labels within Signal/01's expanded hover or detail state at implementation time, not as six-becomes-eight new top-level modules.
- **No redundancy with Layer 1:** `EO-DESIGN-002`'s Signal/01 ("Systems Engineering Depth") and Layer 1's "Integrated Engineering" signal sound adjacent but are not duplicative — Layer 1's version is a one-line posture statement with zero technical detail (glance-speed), Layer 2's is a full module with description, connecting trace-lines, and (per this amendment) an implied deeper theme list. Same underlying evidence, different depth for a different journey moment — consistent with how `PDC-A001` AMD-1/AMD-2 already treats the same capability differently across the Services (stage 7) and Technical Capability (stage 9) stages.

**Nothing else in `EO-DESIGN-002` §1–§9 changes.** Refer to that document for full layout, typography, motion, visual direction, and accessibility detail.

---

## §4. Constitutional Check — Replacing Trust Metrics (stage 1)

`PDC-001` Article VIII's stage-preservation principle requires a Constitutional Amendment before a stage is reordered, omitted, or repurposed — Trust Metrics sits within stage 1 ("Executive Trust"), so replacing its content is checked against that principle here rather than silently assumed permissible:

- **Stage is preserved, not removed:** stage 1's *purpose* (Executive Trust — immediate credibility on arrival) is unchanged; only its *treatment* changes, from four literal counters to five posture signals. This is the same category of change `EO-DESIGN-001` already made to the Services stage (stage 7 kept its purpose, changed its treatment from a card grid to a diagram) — precedented, not novel.
- **No amendment required for the swap itself**, on that basis — Article VIII governs stage order and purpose, not the specific component used to deliver a stage.
- **One genuine open item, flagged not resolved:** Trust Metrics' current copy includes `£50k–£1m+ savings identified` — a number that also appears in the Results section directly above it (stage 1's own KPI tiles, per the live homepage audit in `EO-DESIGN-002` §0). Removing Trust Metrics does not remove that figure from the page — it remains live in the Results section, unaffected by this mission. No content integrity issue arises from this overlap; noted only so a future session doesn't mistake Trust Metrics' removal for the figure disappearing from the homepage entirely.

---

## §5. Implementation Strategy (both layers)

Same proven approach as every prior direct-database Elementor change this engagement has made — no new deployment technique required:

1. **Fetch** current `_elementor_data` for page 959 (Home).
2. **Locate** the Trust Metrics section (stage 1, currently four vertical stat counters) and the Technical Capability section (stage 9, currently headline + four tags) by their existing element/section IDs.
3. **Replace Trust Metrics' inner widget content** with the new Executive Confidence Strip markup (hand-coded HTML/CSS per §2, five signals per §2f) — same Elementor HTML-widget pattern used throughout this engagement, consistent with this project's stated preference for hand-coded content over page-builder assembly.
4. **Replace Technical Capability's inner widget content** with the expanded confidence-console markup already specified in full in `EO-DESIGN-002` §1–§9 (six modules, radial layout, steady-glow motion, per that document — implementing it for the first time, since `EO-DESIGN-002` itself was plan-only).
5. **Splice via a validated script** (never hand-edit the JSON string directly), matching this engagement's established method.
6. **Push** via `wp_update_post_meta`, **verify** `_elementor_edit_mode` remains `"builder"` immediately after (this exact field has gone unexpectedly blank before on this site).
7. **Purge cache at all three known layers** for this site — WP Engine EverCache/CDN, Elementor's own internal parsed-`_elementor_data` cache (invalidated only by an Elementor-editor save or a host+browser purge, not by the direct-DB write itself), and confirm via a cache-busted fetch rather than trusting a "200 OK" response.
8. **Verify both sections independently:** Trust Metrics' replacement (five signals, correct copy, hairline sweep behaves once not on loop) and Technical Capability's replacement (six modules, correct radial layout at desktop, correct stacked layout at the 767px breakpoint, steady-glow not synchronized across modules, `prefers-reduced-motion` fallback on both sections).
9. **Confirm the Results section (the KPI-range tiles directly above Trust Metrics) is untouched** — this mission replaces Trust Metrics only, not the adjacent Results section, per §4's boundary note.

**Scope boundary, restated:** this mission touches exactly two sections on page 959 — Trust Metrics (stage 1) and Technical Capability (stage 9). Every other stage, and every other page, is out of scope and must be verified unchanged after deployment, not merely assumed unchanged.

---

## §6. Mobile Behaviour Summary (both layers)

- **Layer 1:** five-item row → 2+2+1 wrapped grid at 767px (§2b) — deliberately not a vertical stat list, to avoid re-introducing the "counter section" read on mobile that this whole mission removes on desktop.
- **Layer 2:** radial console → vertical stacked list with a single top-to-bottom trace line at 767px, per `EO-DESIGN-002` §2/§8 — unchanged from that document's spec.

---

## §7. Final Implementation Plan

**Phase 1 — Layer 1 build:** hand-coded HTML/CSS block per §2, five signals per §2f, desktop row + mobile wrapped-grid layouts, one-time hairline sweep + load-fade motion, `prefers-reduced-motion` fallback.

**Phase 2 — Layer 2 build:** implement `EO-DESIGN-002`'s full confidence-console design (not previously built) — six modules, radial + mobile-stacked layouts, core-activation reveal, steady-glow motion, `prefers-reduced-motion` fallback.

**Phase 3 — Deployment:** per §5, both sections in the same maintenance window (one fetch → one splice touching both section IDs → one push → one verification pass), rather than two separate deployments, to minimise the number of cache-purge/verification cycles against page 959.

**Phase 4 — Verification:** per §5 step 8–9, plus a full-page read-through confirming the twelve-stage narrative still transitions coherently at both new/changed points (Hero → Executive Confidence Strip → Commercial Challenge; Capability Experience → Technical Capability Experience → Leadership).

**Authorization status: this plan is authorized for implementation**, per Mission Control's Engineering Corps Directive ("You are authorized to proceed under the Two-Stage Engineering Confidence Model"). Unlike `EO-DESIGN-002`, this document does not stop at plan-only status.

---

## §8. Deployment Record (2026-07-14)

**Implemented and pushed to page 959's `_elementor_data`, same session.** Both sections' section IDs were located directly in the live JSON structure before any change (not assumed from this document's own placeholder IDs):

- **Trust Metrics → Executive Confidence Strip:** section `bc618ce` (previously 4 credential icon-boxes: Senior engineering team / Funding expertise / End-to-end delivery / Industrial specialists — confirmed via direct inspection to be a badge row with **no numeric counters at all**; the "4+ years/6+ sectors" figures referenced in `EO-DESIGN-002`'s §0 audit belong to the adjacent Results section, `edb54d3`, which was correctly left untouched). Section-level settings changed to `background_background:"classic"`, `background_color:"#05080b"`, structure collapsed to one full-width column containing one HTML widget carrying the five-signal strip (§2 of this document).
- **Technical Capability → Technical Capability Experience:** section `10bafbe` (`_element_id: technical-capability`), confirmed unchanged in position. Eyebrow widget `41dbe05`, heading widget `bc7e4ad`, and subhead widget `cb442ec` edited in place (minimal-diff, matching this engagement's established pattern) to the new copy in §1/§6 of `EO-DESIGN-002`. The nested 4-column icon-tag row (`15a4edb` — CFD / FEA / AI process simulation / Industrial modelling) was replaced with a single HTML widget containing the six-module confidence console; the real evidenced CFD/FEA/AI-simulation/Industrial-modelling copy was **not discarded** — folded into Signal/01 ("Systems Engineering Depth")'s description per this document's own §3 instruction, so no technical detail was lost in the consolidation. The decorative blueprint-overlay widget (`bp0ve0l`) was left untouched.
- **Motion adaptation, not previously flagged:** `EO-DESIGN-002`'s motion spec called for `IntersectionObserver`-based scroll-triggered reveals. This site hard-strips `<script>` tags from Elementor HTML widgets (confirmed sitewide constraint, documented in prior missions). Both sections were implemented with **pure CSS/SVG animation that plays once on page load** instead (fades, one-time hairline sweep, one-time SVG trace-line draw, ambient steady-glow pulses) — functionally equivalent for a visitor scrolling to either section (both will have already settled into their steady state well before the visitor arrives), fully consistent with the site's proven zero-JS animation pattern (hero, blueprint overlay, process timeline). `prefers-reduced-motion` support implemented as specified.
- **Verification performed:** re-fetched `_elementor_data` directly from the database after the push (not just trusted the write response) — confirmed both sections' new markup present, brace-balance of the full stored JSON string correct (901/901), `_elementor_edit_mode` still `"builder"` (the field previously found to go unexpectedly blank on this site). A live cache-busted fetch immediately after deployment still showed the old content — expected, consistent with this site's documented three-layer caching (WP Engine EverCache/CDN + Elementor's own internal parsed-`_elementor_data` cache), not a deployment failure.
- **Outstanding:** a host-level cache purge (WP Engine "Flush Cache" or the site's "Clear Cache For Me" plugin) plus a browser refresh is needed before either section is visible to real visitors — the database write is confirmed correct independent of that. Full visual/responsive QA (both breakpoints, `prefers-reduced-motion`, icon rendering) should be done after the purge, since no in-session visual rendering check was available for this deployment.

**UPDATE (same day, post-purge QA pass):** Mission Control purged cache; both sections confirmed live and rendering correctly on the front end — Executive Confidence Strip shows the five signals in the correct dark strip treatment, Technical Capability Experience shows the new headline and all six Signal/01–06 modules with the "Engineering Confidence" core. One real bug found and fixed during this pass: the desktop confidence-console wrapper had been marked `aria-hidden="true"` on the entire `.iep-cc-console` container — since the mobile stacked-list variant is `display:none` on desktop (correctly excluded from the accessibility tree by that alone), this meant a screen reader on a desktop viewport would have received **no accessible content at all** for the six confidence signals, only decorative markup. Fixed by moving `aria-hidden` off the console wrapper and onto only the connector-line SVG (the one genuinely decorative element) — module titles and descriptions are now exposed to assistive technology on both breakpoints, consistent with `EO-DESIGN-002` §9's own accessibility principle ("module titles and descriptions carry the actual information... no content is conveyed by glow state alone") — the bug was an implementation slip against that stated intent, not a design gap. Fix pushed and independently re-verified via direct database re-fetch; **awaiting one more cache purge before this specific fix is visible live** (same purge mechanism as before — no new blocker). **Also confirmed, not a bug:** an AI-driven text-extraction check of the page reported the six signals "appearing twice" — this is the desktop-radial-console and mobile-stacked-list existing as two parallel DOM subtrees (per design, only one shown per breakpoint via CSS `display:none`), not a real rendering duplication; a sighted visitor at any single viewport width sees the signals exactly once.

## Source References

**Primary Sources**
- Mission Control's EO-DESIGN-002A brief and accompanying Engineering Corps Directive
- `EO-DESIGN-002-Engineering-Confidence-Layer.md` §0 (the placement question this amendment resolves), §1–§9 (Layer 2's full design, carried forward)
- `EO-DESIGN-001-Engineering-Capability-Experience.md` (Layer 2's narrative predecessor and shared visual grammar precedent)
- `PDC-001` Article VIII (stage-preservation principle, addressed in §4), Article X (Content Integrity)
- `PDC-A001` AMD-1, AMD-2 (Stage×Domain model — evidentiary source for both layers' copy)

**Related Repository Documents**
- `docs/EO-DEL002-002-Homepage-Restructure-Report.md` (live stage order this amendment's deployment must preserve)
- `content/CONTENT-001-Services/CONTENT-002A-Service-Portfolio-Constitution.md`
