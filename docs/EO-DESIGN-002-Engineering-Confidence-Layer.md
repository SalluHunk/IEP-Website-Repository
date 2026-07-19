---
id: EO-DESIGN-002
title: Engineering Confidence Layer — Design Concept
mission: Homepage presentation evolution (post-DEL-002, sequel to EO-DESIGN-001)
operation: HORIZON
purpose: Design concept, layout, typography, motion spec, visual direction, copy recommendations, and implementation plan for a non-metric "Engineering Confidence Layer" homepage section. Concept and plan only — not yet authorized for production implementation.
status: Materialized — awaiting Mission Control authorization to implement, and a placement decision (see §0)
lifecycle: Materialized
last_updated: 2026-07-14
---

# EO-DESIGN-002 — Engineering Confidence Layer

## Repository Position

**Depends On**
- `EO-DESIGN-001-Engineering-Capability-Experience.md` (the section this design follows narratively — "the next visitor question")
- `PDC-A001` AMD-1/AMD-2 (Service Portfolio Structural Model — the Stage×Domain framing this design's confidence dimensions draw on), AMD-4/AMD-5 (12-stage homepage model, Technical Capability stage)
- `PDC-001` Article VI (Design Constitution), Article X (Content Integrity — no unsupported claims)
- `content/CONTENT-001-Services/` (CONTENT-002A's Stage×Domain model, CONTENT-003's evidenced service content) — the evidentiary basis for every confidence dimension below
- Live homepage state, verified directly 2026-07-14 (not assumed) — see §0

**Enables**
- A future implementation Engineering Order, once Mission Control authorizes production work and resolves the placement question in §0

**Governance note, stated up front:** this mission introduces no new claims, statistics, or credentials. Every "confidence dimension" in §1 traces to a repository source already verified in a prior mission (cited inline). Where the brief's own example themes (Project Risk Visibility, Investment Protection, etc.) don't yet have a verified IEP-specific evidence source, they are reworded to a theme that does, or omitted — consistent with `PDC-001` Article X and the precedent `PDC-A001` AMD-3 set for Service 8 (don't publish a claim with no evidence behind it, even a soft one).

---

## §0 — Placement Question for Mission Control (read this first)

This section did not exist as a clean target when the mission brief was written, so — per `POA-GOV-001`'s discipline of flagging conflicts rather than resolving them silently — two real candidates were found on the live page, and they point in different directions:

| Candidate | What it is today | Why it fits | Why it might not |
|---|---|---|---|
| **A. "Trust Metrics" section** (currently sits directly under the Hero/Results metrics, before "Commercial Challenge" — homepage stage 1, "Executive Trust") | Four vertical stat counters: `4+ years active`, `6+ sectors served`, `£50k–£1m+ savings identified`, plus four credential tiles (Senior engineering team / Funding expertise / End-to-end delivery / Industrial specialists) | This is the site's **literal, existing instance** of "traditional trust sections... counters and marketing metrics" — the exact pattern this brief names and rejects. Replacing it directly satisfies "not a counter animation, not a badge wall." | Sits at the very top of the page, before a visitor has seen any evidence of *what* IEP does (Commercial Challenge, Services, Case Studies all come later). The brief's own framing — "the next visitor question naturally becomes... **after** the Capability Experience" — describes a moment later in the journey, not this one. |
| **B. "Technical Capability" section** (homepage stage 9, `PDC-A001` AMD-4/AMD-5 — sits after Services/Case Studies, before Leadership) | Headline "Technical depth and rigorous modelling" + four capability tags (CFD, FEA, AI process simulation, Industrial modelling). Thin — no counters, but underdeveloped. | Sits in **exactly the narrative position this brief describes**: right after the Capability Experience (`EO-DESIGN-001`'s Services redesign), right before Leadership ("who will I work with"). Room to grow without displacing real content. | Doesn't currently use counters, so "reject the counter approach" reads more as a general design instruction here than a literal replacement. |

**Recommendation: target Candidate B (Technical Capability, stage 9).** The brief's own psychological framing — "the next visitor question after Capability" — is a narrative-position instruction, not a request to find and replace whichever section happens to contain numbers. Stage 9 is where `PDC-A001` already puts this exact visitor question ("do they have genuine engineering competence, will they protect my investment"), and it is thin enough today that expanding it is additive, not disruptive.

The rest of this document is written against Candidate B. **Candidate A (Trust Metrics) is a legitimate, separate finding** — it is the site's real instance of the anti-pattern this brief describes, sitting in the "Executive Trust" stage where a different, lighter kind of credibility signal is arguably still appropriate (a first-glance visitor hasn't earned a deep systems-thinking section yet). It is flagged here as a candidate for a **future, separate Engineering Order** rather than folded into this one — conflating an early first-impression stage with a late deep-trust stage would blur two different visitor moments `PDC-A001`'s stage model deliberately keeps distinct.

---

## §1. Complete Design Concept

**The governing idea:** Stage 9 currently answers "does IEP have technical tools?" with four capability tags. This concept makes it answer "can I trust these engineers with a complex, expensive, high-consequence project?" — by showing *how* IEP's confidence is produced, not by asserting that it exists.

**Why this isn't a stats section, restated as a design rule:** every element in this design must pass one test — does it show a *mechanism* (a way risk gets reduced) or a *number* (a way to sound impressive)? Mechanisms pass. Numbers, even true ones, don't get admitted unless they're already-evidenced client outcomes (which belong in Case Studies, not here) — this section is deliberately about IEP's own operating discipline, not client results.

**Visual grammar — extends, doesn't reinvent:** same dark blueprint system as `EO-DESIGN-001` (`#05080b` background, `#7fc98a` accent glow, radially-masked grid, IBM Plex Mono annotations) — this is now the site's established "we are showing you engineering, not marketing" register, used at the two homepage moments (Services, Technical Capability) that make a competence claim. Reusing it a second time turns it into a recognizable motif across the page rather than a one-off treatment — a visitor who saw the Services diagram will read this section's grammar as "the same kind of claim, now about delivery instead of scope" without being told so explicitly.

**The core structural idea — a console, not a diagram:** `EO-DESIGN-001` used a flow diagram (domains connected by paths, implying *scope*). This section uses a different geometry deliberately, so the two sections don't read as the same component reskinned: a **central confidence core** with six instrument-style indicator modules arranged around it in a slightly asymmetric radial layout, each connected to the core and to its nearest neighbours by thin static trace-lines. This is the "Digital Twin Dashboard / Flight Readiness Console" register from the brief's creative direction — but restrained: six lit, steady indicators, not a control-room wall of gauges.

**The steady-glow principle (the section's one real idea):** every indicator carries a small circular status glow — but it does not count up, pulse erratically, or animate as a "live metric." It breathes slowly and steadily, like an instrument reading "nominal." This is the precise visual argument against counters: a counter says *look how big this number is*; a steady glow says *this has already been checked, and it's fine*. Same visual vocabulary (a small glowing indicator) used to make the opposite rhetorical point.

### 1a. Content Structure (Three Layers, per the brief)

**Layer 1 — Confidence Statement**
1. Eyebrow: `Engineering confidence` (mono, tracked — matches the site's established eyebrow convention)
2. Headline (see options below)
3. One-line subhead

**Layer 2 — Confidence Framework**
4. The confidence console: central core + six indicator modules + connecting trace-lines

**Layer 3 — Executive Outcome**
5. A single closing line naming what a visitor gains (not a repeat of the dimensions — a synthesis)
6. No CTA duplication — the section's own job is to build trust, not to convert; the existing "Book Opportunity Screening" CTA remains owned by the homepage's Call To Action stage (12), not repeated here. (Consistent with `PDC-001` Article VIII's one-CTA-per-job discipline, already followed by every other mid-page stage on this homepage.)

**Headline — exploration and recommendation:**

| # | Headline | Register | Grounding |
|---|---|---|---|
| A | **"Certainty isn't claimed. It's engineered in."** *(recommended)* | Direct continuation of `EO-DESIGN-001`'s closing line ("Complexity in. Certainty out.") | Answers the sibling section's own promise — creates a two-section arc across the homepage: Services says *what comes out*, this section explains *how it gets in*. Grounded in the brief's own core idea ("Confidence is engineered — not claimed") reworded for continuity rather than copied. |
| B | "Confidence is engineered, not claimed." | Near-verbatim brief language | Closest to the brief's own stated design philosophy; strong but doesn't connect to the sibling section the way A does. |
| C | "Reducing uncertainty before it becomes cost." | Risk/financial register | Verbatim brief example — precise, executive-facing, but reads slightly more like a services claim than a trust statement. |
| D | "We don't ask you to trust us. We show you the mechanism." | Confrontational/transparent | Original; strongest "not marketing" register, but riskier in tone for a first read — better as a subhead than a headline. |

**Recommendation: A.** It is the only option that makes this section legible as a continuation of a homepage-wide argument rather than a standalone trust panel — and it is fully original wording, not copied from either the brief or `EO-DESIGN-001`.

**Subhead (paired with A):** *"Every project carries risk before it carries results. Here's how we reduce it — systematically, not by promise."*

---

## §2. Section Layout

Full-bleed dark section, matching the established `padding: 130px 0` rhythm from the hero and Services sections.

- **Above the console:** eyebrow → headline → subhead, left-set within a constrained max-width — same asymmetric, technical-brief-register block treatment `EO-DESIGN-001` established for this visual grammar (a deliberate, now-repeated departure from the rest of the homepage's centred headings, which reads as intentional the second time it appears rather than inconsistent).
- **Console zone:** centred, max-width 960px, generous surrounding whitespace on the blueprint grid. Central core sits at the visual centre; six indicator modules arranged at asymmetric radial positions (not a perfect hexagon — a slight irregularity reads as "engineered to fit," not "templated"), each with its own trace-line back to the core plus one connection to an adjacent, thematically-related module (e.g., Systems Engineering Depth ↔ Evidence-Led Delivery; Funding & Investment Discipline ↔ Stage-Gated Execution) — six core-links plus a small number of cross-links, not a fully-connected mesh (which would read as noise, not structure).
- **Below the console:** the Layer 3 executive-outcome line, left border rule (echoes the same engineering-annotation motif `EO-DESIGN-001`'s narrative line used) — no CTA beneath it, by design (see 1a).
- **Corner registration marks:** reused once, top-left only this time (not mirrored bottom-right as in the Services section) — a deliberate small variation so the two sections don't feel like the exact same template with different words.

**Mobile (below 767px, the site's existing breakpoint):** the radial console is replaced by a vertical stacked list of the six indicator modules, each as a self-contained row (status glow · mono tag · title · one-line description), connected by a single vertical trace line down the left edge — the same "distinct layout, not a scaled diagram" approach `EO-DESIGN-001` used for its own mobile fallback, reused here as the now-established mobile pattern for this visual grammar rather than invented fresh.

---

## §3. Typography Hierarchy

| Role | Face (site's real stack) | Weight | Size (desktop) | Notes |
|---|---|---|---|---|
| Eyebrow | IBM Plex Mono | 500 | 12px | Tracked +0.22em, uppercase — identical treatment to the hero and Services eyebrow |
| Headline | Archivo | 800 | clamp(28–56px) | Slightly smaller ceiling than Services' headline (64px) — this section supports the Services section rather than competing with it for the page's loudest moment |
| Subhead | System sans (site body stack) | 400 | 14–18px | Muted colour, max-width 52ch |
| Core label ("Engineering Confidence") | Archivo | 700 | 16px | Centred within the core, all-caps, tight tracking |
| Indicator module title | Archivo | 700 | 15px | Two-line wrap allowed |
| Indicator mono tag | IBM Plex Mono | 500 | 10px | Uppercase, tracked — matches Services' node-tag register exactly (`Domain / 01` → here, `Signal / 01`) |
| Indicator description | System sans | 400 | 13px | 1.6 line-height, max-width 28ch per module — short by design, this is a signal not a paragraph |
| Executive outcome line | Archivo | 600 | 18–22px | Left border rule, slightly heavier weight than the Services section's narrative line — this is the section's one synthesising statement, it should carry more visual weight than a footnote |

---

## §4. Motion Specification

Every choice ties to the brief's five stated qualities: monitoring, precision, synchronization, readiness, stability.

1. **Page-load reveal:** eyebrow → headline → subhead, staggered ~120ms fade+rise — identical convention to every other section on this homepage, not a new vocabulary.
2. **Core activation on scroll-into-view:** the central core's ring illuminates first (a single clean fade, ~400ms), then the six trace-lines draw outward toward each indicator module (SVG stroke-dashoffset, ~600ms, slight stagger ~80ms per line) — reads as "the system checks in with each capability," a synchronization cue, not a decorative flourish.
3. **Steady-glow indicators (the section's signature motion, see §1):** once its trace-line completes, each module's status glow settles into a slow (~4.5s cycle), low-amplitude breathing pulse — deliberately calm and non-attention-seeking, explicitly **not** a counting animation, not a flashing alert, not synchronized across modules (slightly different phase per module, same technique `EO-DESIGN-001` used to keep its three flow-pulses from moving in lockstep — avoids a "blinking Christmas lights" read).
4. **Cross-link trace-lines:** static once drawn — no ongoing animation on the module-to-module connections, only the core-to-module lines and the indicator glows carry motion. This restraint is deliberate: too much simultaneous motion undercuts "stability," one of the brief's five named qualities.
5. **Mobile flow:** the vertical trace line draws top-to-bottom on scroll, each module's glow activating as its row enters the viewport — same steady-glow motif, sequenced by scroll position instead of a single load event.
6. **`prefers-reduced-motion`:** all draw/reveal animation replaced by an instant fully-visible state, glows rendered static (no pulse) — same accessibility commitment `EO-DESIGN-001` established, applied consistently here.

**Deliberately not included:** any animation that resembles counting, loading-bar fills, or ticking — these are precisely the "counter animation" register the brief instructs against, and would undercut the section's core argument even if the numbers themselves were removed from the copy.

---

## §5. Visual Direction

Identical token set to `EO-DESIGN-001`, reused rather than varied — this is now the site's "engineering-grammar" palette, not a one-off:

| Token | Value | Source |
|---|---|---|
| Background | `#05080b` | Identical to hero and Services section |
| Panel/module fill | `#0d1512` | Same as Services' node fill |
| Accent line/glow | `#7fc98a` | Identical to hero and Services |
| Brand green | `#4c8b5a` | Site-wide primary accent |
| Text primary | `#eef4f0` | Matches hero/Services |
| Text secondary | `#a9bcc2` | Matches hero/Services |
| Core ring (differentiator) | `#7fc98a` at reduced opacity, double-ring | New, but built from the existing accent, not a new colour — the one deliberate visual differentiator between this console and Services' flow diagram |

Blueprint grid: identical technique to Services (`.iep-grid`, radially masked). Corner registration mark: single, top-left, as noted in §2.

**No photography.** Same reasoning as `EO-DESIGN-001` — the console *is* the credibility signal; a background photo would compete with it, not reinforce it.

---

## §6. Copy Recommendations

Six confidence dimensions, each traced to a real repository source — no invented capability, no invented number:

| # | Dimension (mono tag) | Title | Description (≤28ch register) | Evidence source |
|---|---|---|---|---|
| 1 | `Signal / 01` | **Systems Engineering Depth** | Real CFD, FEA and process modelling — not spreadsheet estimates. | Live Technical Capability tags; `PDC-A001` AMD-2 (Product Design / CFD as evidenced supporting capability) |
| 2 | `Signal / 02` | **Stage-Gated Delivery** | Screening, feasibility, funding and delivery — each stage gates the next. | `PDC-A001` AMD-1 (Stage services: Screening, Feasibility, Funding & Delivery, Monitoring) |
| 3 | `Signal / 03` | **Investment Protection** | The bridge from a good idea to an approved, funded project. | Live homepage "Funding Capability" section (Gap → Solution → Outcome) |
| 4 | `Signal / 04` | **Evidence-Led Delivery** | Every recommendation traces to a modelled, verifiable outcome. | `PDC-001` Article X (Content Integrity); live Case Studies section's own challenge/solution/results structure |
| 5 | `Signal / 05` | **Senior-Led Execution** | Chartered and accredited engineers lead delivery, not junior staff. | Live Leadership section credentials (BEng MIET; CEng FEI FIET PhD; BSc FCA) |
| 6 | `Signal / 06` | **Integrated Domain Thinking** | Energy, water and low-carbon systems, engineered as one system. | `service_category` taxonomy — the three governed domains `EO-DESIGN-001` already visualizes |

**Layer 3 — Executive Outcome line (recommended):**

> "The result isn't a promise. It's a project that was de-risked before it ever reached your desk."

Alternates considered: *"Greater certainty. Better decisions. Lower execution risk."* (closer to the brief's own suggested emotional-outcome list, but reads as a bullet fragment rather than a sentence — set aside in favour of the single considered line above, consistent with the section's own "fewer, heavier words" typographic philosophy from §3).

---

## §7. Implementation Strategy

**Build as a hand-coded HTML/CSS/JS block inside an Elementor HTML widget**, replacing the current Technical Capability section's content on the homepage only — same approach `EO-DESIGN-001` recommended for Services, and consistent with this project's stated preference for hand-coded templates over page-builder assembly (`CLAUDE.md`).

**Data sourcing:** unlike `EO-DESIGN-001`, this section's six dimensions are not queried live from a CMS taxonomy — no `confidence_dimension` post type or field group exists, and creating one solely to hold six short, stable, non-time-sensitive lines would be new architecture for content that doesn't change often (`PDC-001` Article X doesn't require dynamic sourcing, only accuracy). **Recommendation: hand-write the six dimensions directly into the HTML widget**, exactly as the existing Technical Capability tags are today — flagged explicitly as a deliberate deviation from `EO-DESIGN-001`'s "CMS, not hardcoded" pattern, justified because the underlying content type (a short, curated trust statement) is materially different from a taxonomy-driven service list that already exists elsewhere and must stay in sync with it.

**Scope boundary:** this section replaces only the Technical Capability section's inner content (stage 9). It does not touch the Trust Metrics section (stage 1, Candidate A from §0), Services (stage 7, `EO-DESIGN-001`'s domain), Case Studies (stage 8), or Leadership (stage 10) — each stage's own content and transition logic stays intact, per `PDC-001` Article VIII's stage-preservation principle.

---

## §8. Mobile Behaviour

Covered in full in §2 and §4 (layout) — summary: the radial console becomes a vertical stacked list at the existing 767px breakpoint, same content and hierarchy as desktop (six modules, same titles/descriptions/order), connected by a single top-to-bottom trace line instead of a radial one. This is a distinct layout, not a shrunk version of the desktop diagram, consistent with the mobile-layout standard `EO-DESIGN-001` set (and explicitly avoids that design's originally-flagged risk of a diagram that becomes illegible when scaled down).

No horizontal scroll risk: the vertical list has no fixed-width elements wider than the mobile viewport; the desktop radial layout is fully replaced below the breakpoint, not scaled.

---

## §9. Accessibility Considerations

- **`prefers-reduced-motion`:** full static fallback, per §4 — every draw/pulse animation removed, all content immediately visible.
- **Colour contrast:** text primary `#eef4f0` on background `#05080b` and panel `#0d1512` both exceed WCAG AA for body text at the sizes specified in §3 (verify exact ratios at implementation time against the final rendered sizes, not just the tokens).
- **Non-color signal:** the steady-glow indicator is decorative, not informational — no content is conveyed by glow state alone; module titles and descriptions carry the actual information, so a visitor who cannot perceive the glow loses no information, only ambience.
- **Reading order:** DOM order must match visual reading order (eyebrow → headline → subhead → six modules in their numbered `Signal / 0N` order → outcome line) regardless of the radial visual arrangement — screen reader and keyboard-tab order should never depend on radial (x,y) position, only on source order.
- **No motion-triggered content changes:** unlike a counter (where the final number is the actual content and motion delays access to it), every module's full text content is present in the DOM from first paint — the animation is purely presentational, so a screen reader or a user who skips past the animation loses nothing, which is a stronger accessibility position than the counters this section replaces (a screen reader typically cannot meaningfully announce a counting-up number sequence anyway).

---

## §10. Final Implementation Plan

**Phase 0 — Placement decision (blocking, see §0)**
Mission Control confirms this section targets Technical Capability (stage 9), and separately decides whether the Trust Metrics section (stage 1, Candidate A) should be scoped as a future, distinct Engineering Order.

**Phase 1 — Markup and styling**
Hand-coded HTML/CSS block (six confidence dimensions per §6, hand-written per §7's sourcing decision) inside a new Elementor HTML widget, replacing the current Technical Capability section's widget content. Desktop radial layout and genuine mobile stacked layout both built together, not sequenced.

**Phase 2 — Motion**
Core-activation reveal, per-module steady-glow (staggered phase, per §4), scroll-triggered via `IntersectionObserver` (one-time reveal, matching the site's existing convention), `prefers-reduced-motion` handling.

**Phase 3 — Deployment**
Same proven technique this engagement has used repeatedly: fetch current `_elementor_data` for page 959 → validated script-based splice (replace only the Technical Capability section's inner content, leave section order and every other section untouched) → `wp_update_post_meta` → verify `_elementor_edit_mode` remains `"builder"` → cache-busted live verification → host + browser cache purge (both WP Engine EverCache and Elementor's own internal parsed-data cache, per this engagement's documented three-layer caching finding).

**Phase 4 — Verification**
Confirm the six confidence dimensions render correctly at desktop and the 767px mobile breakpoint; confirm no horizontal overflow; confirm `prefers-reduced-motion` fallback renders fully visible with no animation; confirm the Technical Capability → Leadership transition still reads coherently (this section is the direct predecessor to Leadership in the 12-stage model, per `PDC-A001` AMD-4/AMD-5 — a visual or tonal mismatch here would reintroduce the exact transition-break class of issue `CONTENT-004` originally flagged).

**This plan is not authorized for execution.** Consistent with `EO-DESIGN-001`'s own established rhythm (plan → authorize → implement) and this brief's own deliverable list, which ends at "final implementation plan," not an implementation instruction. A follow-up Engineering Order authorizing implementation — and resolving Phase 0 — is the expected next step.

## Source References

**Primary Sources**
- Mission Control's EO-DESIGN-002 mission brief
- Live homepage state (`iep.technology/`), verified directly 2026-07-14 — full section inventory in §0
- `PDC-001` Article VI (Design Constitution), Article VIII (Homepage Narrative Constitution), Article X (Content Integrity)
- `PDC-A001` AMD-1, AMD-2 (Stage×Domain model, Supporting Capability principle), AMD-4/AMD-5 (12-stage model, Technical Capability stage position)

**Related Repository Documents**
- `docs/EO-DESIGN-001-Engineering-Capability-Experience.md` (sibling section, shared visual grammar, this document's own headline continuity)
- `content/CONTENT-001-Services/CONTENT-002A-Service-Portfolio-Constitution.md` (evidence source for §6's six dimensions)
- `docs/EO-DEL002-002-Homepage-Restructure-Report.md` (current live stage order this design's placement decision depends on)
