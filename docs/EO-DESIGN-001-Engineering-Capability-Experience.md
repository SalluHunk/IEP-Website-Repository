---
id: EO-DESIGN-001
title: Engineering Capability Experience — Design Concept
mission: Homepage presentation evolution (post-DEL-002)
operation: HORIZON
purpose: Design concept, layout, typography, motion spec, visual direction, and implementation plan for replacing the homepage's service-card grid with a capability-led visual experience.
status: Approved and Implemented — see docs/EO-DESIGN-001-Implementation-Report.md for the production deployment record
lifecycle: Implemented
last_updated: 2026-07-14
---

# EO-DESIGN-001 — Engineering Capability Experience

**Live prototype:** https://claude.ai/code/artifact/3de58dd7-c0ca-44c1-83ce-19b27c69209c (interactive — includes the real scroll-reveal and flow-line animation; a screenshot could not represent this adequately, so the artifact itself is the primary deliverable for §1–§5 below). **Updated to v2** with the refinements below (headline, capability-flow animation, CTA wording, mobile layout) — resize the artifact's browser viewport below ~767px to see the mobile layout directly.

## Repository Position

**Depends On**
- `docs/EO-DEL002-002-Homepage-Restructure-Report.md` (the section this design replaces)
- `PDC-001` Article VI (Design Constitution — colour, imagery, motion philosophy), Article VIII / `PDC-A001` (Services stage)
- `PDC-A001` AMD-1 (Service Portfolio Structural Model — the Stage×Domain model this design visualizes)
- `CMS-005A` (`service_category` taxonomy — the real, governed data this design's three domains are drawn from)
- `POA-GOV-001` (governance framework this mission operates under)

**Enables**
- A future implementation Engineering Order, once Mission Control authorizes production work

**Governance note, stated up front:** no repository document, service taxonomy, or constitutional content is touched by this mission. The three domain names, descriptions, and service counts used throughout this concept are the exact, verbatim `service_category` taxonomy terms already live on `/services/` — not new copy. `PDC-A001`'s Article VIII "Services" stage still exists on the homepage after this change; only its presentation evolves, per this Engineering Order's own explicit framing.

---

## 1. Complete Design Concept

**The governing idea:** the homepage's Services section currently answers "what does IEP sell?" This concept makes it answer "can IEP handle a problem like mine?" instead — before a visitor ever reaches the actual service list. It replaces a 9-card product grid with a single, cinematic diagram of IEP's three governed engineering domains, presented as one interconnected system rather than a menu.

**Why this isn't a generic dark-hero treatment:** the visual language is deliberately not invented from scratch — it extends the exact dark, blueprint-grid, animated-flow-line system already live and proven on this homepage's own hero section (`section 1` of the live `_elementor_data`, the `.iep-anim-hero` block: near-black background, `#7FC98A` glow accent, dashed animated SVG flow paths via `stroke-dashoffset`, a blueprint grid overlay masked to a radial gradient). This design reuses that exact visual grammar rather than introducing a competing aesthetic elsewhere on the same page — a real risk with "premium dark section" briefs is that they end up looking like a stock template bolted onto the site; grounding it in the site's own existing, governed dark-section language (Article VI: "Dark graphite sections may be used selectively, to create emphasis and narrative contrast at specific moments") avoids that.

**Headline — exploration and final pick (refined):**

| # | Headline | Register | Grounding |
|---|---|---|---|
| A | "We engineer what others only study." | Confident, differentiating | `PDC-001` Article I Constitutional Statement (generic consultancies "deliver only studies") |
| B | **"Complexity in. Certainty out."** *(recommended)* | Terse, systems/transfer-function | Article VI Design Constitution ("think like a systems architect"); states no claim directly, lets the diagram resolve it |
| C | "Engineered outcomes, not engineering reports." | Outcome-vs-documentation | Article III Objective 4 (measurable, outcome-led results); Article IV ("delivers — not merely recommends") |
| D | "Systems thinking, applied at industrial scale." | Quiet, descriptive | Near-literal echo of the brief's own target feelings ("systems thinking," "industrial scale") |
| E | "Industrial complexity, engineered into outcomes." | Arc from problem to result | Reorders the EO's own example phrasing into original wording |

**Recommendation: B, "Complexity in. Certainty out."** It's the option that most literally executes "communicate confidence before explanation" — a two-clause, near-mathematical statement that states nothing specific and everything at once, resolved immediately by the diagram beneath it. Every option is original wording, none copied from the EO's own examples, and each is traceable to a real constitutional source rather than invented tone. A ("We engineer what others only study") is the strongest runner-up if Mission Control prefers a claim that ties more explicitly to IEP's differentiation-from-generic-consultancies positioning rather than a systems-diagram framing.

**Typographic refinement (per Mission Control):** set as two stacked noun/connector couplets rather than one running line — `Complexity` / `In.` (smaller, accent green), then `Certainty` / `Out.` (same treatment) — instead of a single sentence-style line. This gives the headline its own vertical rhythm independent of the diagram below it and reads closer to a manifesto statement than a marketing line, reinforcing "confidence before explanation" further than the flat version did.

**The diagram, not cards:** the three domains are rendered as nodes on a schematic — asymmetric positions, connected by animated flow paths, each carrying a small engineering-drawing-style annotation (`Domain / 01`, a service count) rather than a title-and-description card. This is the concept's central bet: an engineering audience reads a connected system diagram as competence signalling in a way a card grid cannot — it implies the three domains are integrated, not three separate product lines to choose between. This directly visualizes `PDC-A001` AMD-1's actual Stage×Domain model (these domains genuinely do work together across one project lifecycle — the diagram isn't decorative, it's a correct simplification of a real governed relationship).

### 1a. Content Structure

1. Eyebrow: `Engineering capability` (mono, tracked, small)
2. Headline: `We engineer what others only study.`
3. One-line subhead
4. The domain diagram (three nodes + connecting flow paths)
5. Supporting narrative (one sentence, engineers-to-engineers register)
6. Single CTA: `View all services →`, linking to `/services/` *(refined — see CTA wording below)*

**CTA wording (refined):** changed from the original draft ("Explore engineering services") to **"View all services"**. Reasoning: the original repeated "engineering" from the section's own eyebrow ("Engineering capability"), and the site already has an established CTA convention for "see more of this category" links — "View all case studies," "View all testimonials" — both live on the homepage today. "View all services" matches that existing voice exactly rather than inventing a new phrasing pattern for this one section. Alternatives considered and set aside: "See the full capability set" (too abstract, undercuts the concrete destination), "See how the domains connect" (interesting, but implies the CTA leads to more of *this diagram*, not to `/services/`, which would mislead).

---

## 2. Section Layout

Full-bleed, single-column, centre-anchored on desktop, generous vertical rhythm (matches the existing hero and Commercial Challenge sections' own `padding: 130px 0` pattern). No sidebar, no multi-column card grid — deliberately spacious, since the brief calls for the section to "create curiosity rather than exhaust information."

- **Above the diagram:** eyebrow → headline → subhead, left-aligned within a constrained max-width (matches the existing site's centred-content convention, but headline is left-set within its own block rather than centred, to read more like a technical brief than a marketing banner — a small, deliberate departure from the rest of the homepage's centred headings, justified by this section's different register).
- **Diagram zone:** full width up to 920px, centred, generous surrounding whitespace on the blueprint grid.
- **Below the diagram:** narrative line (left border rule, not centred — echoes an engineering-drawing note/annotation convention) → CTA, left-aligned beneath it.
- **Corner registration marks** (thin open corner brackets, top-left and bottom-right) — a small blueprint/technical-drawing motif reinforcing "this is a schematic, not a marketing panel," used exactly once, restrained.

**Mobile (refined — now a real, distinct layout, not a scaled-down SVG):** below 767px (the site's own existing mobile breakpoint, reused rather than inventing a new one), the diagonal SVG diagram is replaced entirely by a vertical HTML list — the same three domains, same order, connected by a single vertical trace line running down the left edge through all three node markers. Each row: a small ringed marker, a mono tag (`Domain / 01 · 3 services`), the domain title, and its one-line description — the same content and hierarchy as the desktop nodes, restructured for a narrow column rather than visually shrunk. This is a distinct layout, not a responsive scale-down of the diagonal diagram (which was the risk flagged in the original plan) — implemented and visible in the v2 prototype (resize the artifact's viewport below ~767px to see it).

---

## 3. Typography Hierarchy

| Role | Face (site's real stack) | Weight | Size (desktop) | Notes |
|---|---|---|---|---|
| Eyebrow | IBM Plex Mono | 500 | 12px | Tracked +0.22em, uppercase — matches the real hero's existing eyebrow treatment exactly |
| Headline | Archivo | 800 | clamp(30–64px) | Tight tracking (-0.01em), `text-wrap: balance`, max-width 15ch to force a considered line break |
| Subhead | System sans (site body stack) | 400 | 14–18px | Muted colour, max-width 46ch |
| Node title | Archivo | 700 | 15px | Two-line wrap for longer domain names |
| Node tag/annotation | IBM Plex Mono | 500 | 10px | Uppercase, tracked — the "engineering callout" register |
| Narrative | System sans | 400 | 14px | 1.7 line-height, left border rule |
| CTA | Archivo | 700 | 15px | Tight tracking |

**Simplification disclosed:** the concept prototype (the linked artifact) uses system-font fallback stacks rather than embedding Archivo/IBM Plex Mono as web fonts, since the artifact tool's sandbox blocks external font CDNs and this is a review prototype, not shippable code. **The real implementation must use the site's actual already-loaded Archivo/IBM Plex Mono stack** (confirmed loaded site-wide, used by the existing hero) — this is a one-line fix at implementation time, not a design open question.

---

## 4. Motion Specification

Every motion choice ties to "communicate precision, not entertainment" (the EO's own stated constraint):

1. **Page-load reveal:** eyebrow, headline, subhead fade+rise in sequence (staggered ~120ms), once, on load — matches the existing hero's own `fadeInUp` pattern already used site-wide, not a new animation vocabulary.
2. **Capability-flow animation (refined):** the original draft used a generic continuously-scrolling dashed line on the connecting paths — reconsidered, because a uniform infinite dash-scroll reads as ambient texture, not a deliberate signal. **Replaced with a small glowing pulse that physically travels along each connecting path** (SVG `animateMotion`, one pulse per path, each at a slightly different duration — 3.4s / 3.8s / 4.3s — so the three don't move in visual lockstep), while the paths themselves become a faint, static blueprint guideline rather than the moving element. This separates "the schematic" (static) from "the signal" (moving) — a clearer read of "connection paths illuminating" than the original single moving-dash approach. The pulses are dormant until the section scrolls into view, then start with a short stagger (echoing the node reveal), settling into a continuous ambient loop after their first pass. **Deliberately not a strict left-to-right sequence implying domain 1 → 2 → 3 happens in that order** — the three governed domains are a presentation-layer grouping (`CMS-005A`'s own documented framing), not a mandated pipeline, so the paths form a connected loop rather than asserting an order the taxonomy doesn't actually claim.
3. **Sequential node reveal on scroll:** each domain node fades and rises into place as the section enters the viewport, staggered by ~160ms per node, via `IntersectionObserver` (one-time reveal, not a repeating scroll-jack effect) — this is the one genuinely new interaction this section introduces, and it directly serves "capability domains revealing sequentially" from the brief.
4. **Mobile flow (refined):** the vertical trace line reuses the same pulse motif, now travelling top-to-bottom through the stacked list instead of along a curved path — consistent motion vocabulary between breakpoints, not a separate mobile animation invented from scratch.
5. **CTA hover:** a small lift + colour shift, consistent with the site's existing `.iep-btn` hover convention.
6. **Respect for `prefers-reduced-motion`:** all animations disabled, content shown fully visible immediately, if the visitor's OS requests reduced motion — not present anywhere else on the current site, and worth adding here as a genuine accessibility improvement, not scope creep (it's a one-line media query).

**Deliberately not included**, despite being listed as options in the brief: parallax between blueprint and photography (no photography in this concept — the diagram *is* the visual, adding a photographic layer risks diluting the "systems diagram" read into a generic tech-hero collage); light sweeps (evaluated and cut — reads as decorative shine rather than precision, closer to "entertainment" than the brief's own stated goal).

---

## 5. Visual Direction

Extends the site's own established dark-section palette rather than introducing a new one:

| Token | Value | Source |
|---|---|---|
| Background | `#05080b` | Identical to the live hero's `.iep-anim-hero` background |
| Panel/node fill | `#0d1512` | New, close analog to the hero's dark tones |
| Accent line/glow | `#7fc98a` | Identical to the live hero's `--accent` |
| Brand green | `#4c8b5a` | The site's primary accent everywhere else (buttons, icons) |
| Text primary | `#eef4f0` | Matches hero |
| Text secondary | `#a9bcc2` | Close analog to hero's `#b4c2c9` |

Blueprint grid: a faint two-axis line grid, radially masked so it fades toward the edges — the exact `.iep-grid` technique from the live hero, reused rather than reinvented. Corner registration marks, thin (1px) open brackets — a restrained nod to technical-drawing sheets, used exactly twice (not scattered).

No photography in this concept. The brief lists "industrial infrastructure imagery" as an available option, but the diagram itself is doing the "systems thinking" communication — adding a background photograph risks competing with it rather than reinforcing it. If Mission Control wants a photographic layer, the hero's own approach (a dim, blurred industrial photo *behind* the graphic layer, per `.iep-photo` in the live hero) is the precedent to follow, kept subordinate to the diagram, not this section's primary color source.

---

## 6. Implementation Recommendation

**Build as a hand-coded HTML/CSS/JS block inside an Elementor HTML widget**, replacing the current `[iep_services_by_category]` shortcode section on the homepage only. This is not a new technical pattern for this site — it's the exact same approach already used for the hero section (`section 1`, a raw HTML widget with embedded `<style>`/SVG/`<script>`), and it matches this project's own stated preference (`CLAUDE.md`: "Default to hand-coded PHP/HTML/CSS template files... Avoid generating Elementor JSON or WPBakery shortcode markup as the primary implementation" — an Elementor HTML widget carrying real hand-written code, rather than Elementor's own visual-builder widgets, satisfies that preference; it's functionally a code block, not page-builder assembly).

**Data should still come from the CMS, not be hardcoded a second time.** The three domain names, descriptions, and service counts should be read live from the `service_category` taxonomy (the same data `/services/`'s shortcode already queries) via a small PHP snippet that outputs the three domains' data as inline JSON or directly interpolates it into the HTML widget's markup server-side — not typed as static text a second time. This preserves the single-source-of-truth principle `CMS-005A` established and avoids reintroducing the exact hardcoding problem `EO-DEL002-001` found (D-01) and `EO-DEL002-002` just fixed.

**`/services/` is unaffected.** This section only changes what the homepage shows; the full 9-service, 3-category grid remains exactly as deployed on `/services/` — the CTA is the bridge between the two.

---

## 7. Technical Feasibility Assessment

| Component | Feasibility | Notes |
|---|---|---|
| Dark blueprint section, HTML/CSS/SVG | **High** | Directly precedented by the live hero section on this exact page — proven technique, proven browser support, zero new dependencies |
| Capability-flow pulse animation | **High** | SVG `animateMotion` along existing path data — native browser feature, no library; refined from a plain `stroke-dashoffset` scroll to a travelling glow pulse, prototyped and working in v2 |
| Scroll-triggered sequential reveal | **High** | `IntersectionObserver` is supported in every browser this site needs to support; no library dependency |
| Domain data pulled live from `service_category` taxonomy | **High** | The taxonomy and its data are already proven queryable (confirmed working for `/services/`'s shortcode) — this is a read-only query against data that already exists, not new architecture |
| Mobile layout | **High** *(upgraded from Medium)* | Originally flagged as open design work — now resolved: a distinct vertical HTML layout (not a scaled SVG) is designed and implemented in the v2 prototype, reusing the site's existing 767px breakpoint. No longer an open question. |
| Custom font loading (Archivo/IBM Plex Mono) | **High** | Already loaded site-wide (used by the existing hero) — no new font loading needed at implementation time, only a concern for the throwaway prototype artifact |
| Deployment mechanism | **High** | Same proven pattern this entire engagement has used: fetch current `_elementor_data` → validated script-based splice → `wp_update_post_meta` → verify `_elementor_edit_mode` → cache-busted verification → host+browser cache purge. No new deployment risk beyond what's already been handled repeatedly this session. |

**No feasibility blockers identified.** The one real engineering task (not just styling) is the mobile diagram layout — everything else is a direct extension of patterns already proven live on this exact page.

---

## 8. Final Implementation Plan

**Phase 1 — Domain data wiring**
Small PHP snippet (Code Snippets, same pattern as every other deployment this engagement) that queries `service_category` terms + their `display_order`-ordered service counts, outputting the three domains' name/description/count as data the HTML widget can consume — read-only, no taxonomy changes.

**Phase 2 — Markup and styling**
Hand-coded HTML/CSS block (extending this concept's prototype, with real Archivo/IBM Plex Mono already available, and desktop + genuine mobile layouts both built) inside a new Elementor HTML widget, replacing the current Services section's shortcode widget.

**Phase 3 — Motion**
Flow-path animation, sequential node reveal via `IntersectionObserver`, `prefers-reduced-motion` handling.

**Phase 4 — Deployment**
Same script-based `_elementor_data` splice technique as `EO-DEL002-002` — fetch current structure, replace only the Services section's inner content (leaving section order and every other section untouched), dry-run verification, live deployment, cache purge, cache-busted live verification.

**Phase 5 — Verification**
Confirm the domain data displayed matches `/services/`'s live taxonomy exactly (name, description, count) — the same cross-page consistency check `EO-DEL002-002`'s Verification report used for the prior Services fix. Responsive check at the same three breakpoints. Confirm the CTA correctly routes to `/services/`.

**This plan is not authorized for execution.** Per this Engineering Order's own deliverable structure (ending in "final implementation plan," not an implementation authorization — unlike `EO-DEL002-002`, which explicitly stated "you are now authorized to commence production implementation"), this mission stops at the plan. A follow-up Engineering Order authorizing implementation is the expected next step, consistent with this engagement's established audit/plan → authorize → implement rhythm.

## Source References

**Primary Sources**
- Mission Control's EO-DESIGN-001 mission brief
- `PDC-001` Article I (Constitutional Statement — source of the headline's grounding), Article VI (Design Constitution)
- `PDC-A001` AMD-1 (Service Portfolio Structural Model)
- Live homepage `_elementor_data`, hero section (`section 1`) — source of the reused visual/motion techniques

**Related Repository Documents**
- `docs/EO-DEL002-001-Homepage-Constitutional-Audit.md`, `docs/EO-DEL002-002-Homepage-Restructure-Report.md`
- `deployment/CMS-005A-Service-Taxonomy/` (the taxonomy this design's data would come from)
