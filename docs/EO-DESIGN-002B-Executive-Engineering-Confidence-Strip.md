---
id: EO-DESIGN-002B
title: Executive Engineering Confidence Strip — Refinement Concept
mission: Homepage presentation evolution (refines EO-DESIGN-002A's Executive Confidence Strip)
operation: HORIZON
purpose: Design concept, copy, typography, motion, visual direction, interaction, mobile layout, accessibility, and implementation approach for an upgraded Executive Confidence Strip. Concept and recommendation only — not yet authorized for production implementation.
status: Implemented — deployed to production database, pending cache purge for live visibility
lifecycle: Implemented
last_updated: 2026-07-14
---

# EO-DESIGN-002B — Executive Engineering Confidence Strip (Refinement Concept)

## Repository Position

**Depends On**
- `EO-DESIGN-002A-Two-Stage-Confidence-Model.md` (the mission this document refines — its Layer 1, "Executive Confidence Strip," is live today and is the direct subject of this upgrade)
- `EO-DESIGN-001-Implementation-Report.md` (shared visual grammar and the Hero-typography-matching discipline established there)
- `PDC-001` Article X (Content Integrity — governs which of this brief's example themes may be used verbatim vs. must be re-grounded)
- `PDC-A001` AMD-1, AMD-2 (Stage×Domain model — evidentiary source for the refreshed copy)
- Live homepage state, section `bc618ce`, verified directly before drafting this document (see §0)

**Enables**
- A future implementation Engineering Order, once Mission Control authorizes production work (this document ends at a recommendation, consistent with its own deliverable list, which stops at "final implementation recommendation" rather than an implementation instruction)

---

## §0. Relationship to EO-DESIGN-002A — stated up front, not silently assumed

This Engineering Order's brief describes replacing "the current numerical Trust Metrics strip" and gives a worked example of the anti-pattern (`20+ Years / 500 Projects / 18 Countries / 300 Engineers`). **That literal numeric-counter section no longer exists on the live homepage.** It was already replaced under `EO-DESIGN-002A`, whose Layer 1 ("Executive Confidence Strip") is live today at section `bc618ce` — five signals (Integrated Engineering, Stage-Gated Delivery, Investment-Focused Thinking, Cross-Disciplinary Expertise, Engineering Governance) in a plain dark horizontal row, verified present in the database immediately before drafting this document.

Read against the brief's own language — "feel like an executive dashboard distilled into a single elegant horizontal experience," "synchronized indicator illumination," "engineering trace lines," "high-end industrial control interface" — this Engineering Order is asking for something **visually and motion-wise considerably richer** than what shipped under `EO-DESIGN-002A`, which was a deliberately plain, restrained treatment (no per-item glow, no connecting trace line, a single one-time hairline sweep). **This document treats EO-DESIGN-002B as an upgrade/redesign mission for that same, already-live section — not a duplicate build of a section that no longer exists.** If Mission Control intended something different (e.g. a wholly separate, additional section), that should be clarified before implementation proceeds.

---

## §1. Executive Confidence Strip Concept

**Governing idea:** the current strip states five postures in plain text. This refinement makes it *behave* like a single instrument panel — one shared trace line running the strip's length, with each signal as a small steady indicator wired into it, all breathing in sync. Where `EO-DESIGN-001`'s domain diagram and `EO-DESIGN-002A`'s Layer 2 console each use *independent*, deliberately-unsynchronized pulses (to read as separate systems), this strip's signature move is the opposite: **every indicator pulses in unison** — one coordinated system, not five separate claims. That synchrony is the whole idea of "these things aren't marketing points, they're one operating discipline" made visible without saying it.

**Why this reads as "executive," not "KPI dashboard":** a KPI dashboard shows things that go up. An instrument panel shows things that are steady and monitored. This strip has zero numbers, zero counters, and zero motion that implies growth or achievement — only steady, synchronized, low-amplitude signal lights, which is a categorically different visual claim (competence and control, not scale).

**Three-second read, reward-on-inspection:** at a glance, a visitor sees five short bold phrases on a dark instrument strip with a calm synchronized glow — that's the three-second read. Only on closer look does the shared trace line, the mono signal numbering (`01 /`, `02 /`...), and the micro-descriptions reward attention — satisfying the brief's "minimal... rewards closer inspection without demanding it."

### 1a. Content Structure
1. A single shared horizontal trace line (the "bus"), running the width of the strip, with a small junction tick at each signal's position.
2. Five signal indicators along that line, each: a small steady-glow ring, a mono signal number (`01 /` … `05 /`), a short bold label, and an optional one-line micro-descriptor.
3. No heading, no eyebrow, no CTA — same as `EO-DESIGN-002A`'s original reasoning: this section doesn't introduce itself, it appears as the Hero's own trailing statement.

---

## §2. Copy Recommendations

Refreshed per this brief's suggested register, each still checked against a real repository source — none of the brief's six example themes are adopted as verbatim, unverified marketing copy:

| # | Signal | Micro-descriptor | Evidence / grounding note |
|---|---|---|---|
| 01 | **Systems Thinking** | Engineering decisions made in context, not isolation. | `PDC-A001` AMD-1 (Stage×Domain model) — the real basis for "context, not isolation." |
| 02 | **Stage-Gated Delivery** | Screening, feasibility, funding and delivery — each stage gates the next. | Unchanged from `EO-DESIGN-002A` — already evidenced against AMD-1's Stage services; still the most precise available phrasing. |
| 03 | **Investment Protection** | Engineering aligned with commercial outcomes, not treated as a cost centre. | Live "Funding Capability" homepage section; refined wording from `EO-DESIGN-002A`'s "Investment-Focused Thinking" per this brief's preferred term. |
| 04 | **Integrated Engineering** | Energy, water and low-carbon systems, engineered as one team. | **Deliberately not** the brief's own example phrasing ("mechanical, process, electrical, civil, automation") — that specific discipline list isn't evidenced anywhere in the repository's service/taxonomy content. Kept to the real, verified three domains instead, per `PDC-001` Article X. Flagged here rather than silently substituted without explanation. |
| 05 | **Engineering Governance** | Evidence-led, outcome-first, nothing published unproven. | Unchanged from `EO-DESIGN-002A` — `PDC-001` Article X, Content Integrity. |

**"Lifecycle Ownership" (the brief's sixth example) was considered and set aside**, not overlooked: its natural phrasing ("concept through commissioning") reaches toward the delivery lifecycle's later stages, and Service 8 (AI-enabled Monitoring) is the one catalogue item `PDC-A001` AMD-3 found to have no evidenced business challenge — publishing a "full lifecycle, concept-to-commissioning-and-beyond" claim risks implying monitoring-stage capability this repository has explicitly not cleared for publication. Five signals also keeps the strip at the same density as the version already live, consistent with this brief's own "minimal" instruction — adding a sixth wasn't necessary to satisfy the brief, and this was the one candidate with a real evidentiary caution attached.

---

## §3. Typography Hierarchy

Matches the Hero's real deployed CSS directly (the lesson from `EO-DESIGN-001`'s implementation pass — read the actual values, don't estimate):

| Role | Face | Weight | Size | Notes |
|---|---|---|---|---|
| Signal number | IBM Plex Mono | 500 | 11px | `01 /` style, tracked +0.1em, accent green — same instrument-panel numbering convention as the site's existing blueprint-overlay `FIG.01` tags |
| Signal label | Archivo | 800 | 15px | Matches Hero's `.iep-h1` weight family (900 on the Hero itself; 800 here since this is a secondary label, not a headline) |
| Micro-descriptor | Roboto | 400 | 12.5px | Muted (`#A9BCC2`), one line, no wrap forced — omit rather than truncate awkwardly if a phrase runs long |

---

## §4. Motion Specification

Every choice ties to the brief's stated quality: **stability, not excitement.**

1. **Synchronized indicator illumination (the section's one new idea):** all five ring indicators breathe together — identical duration, identical phase, no stagger — the opposite choice from `EO-DESIGN-001`/`EO-DESIGN-002A`'s deliberately-desynchronized pulses elsewhere on this page. This is the visual signature that separates this strip from every other glowing-dot element already on the homepage.
2. **One-time trace-line draw:** the shared horizontal bus line draws in once on load (a brief `stroke-dashoffset` reveal, sub-second), then sits static — same "checked once, now settled" logic as `EO-DESIGN-002A`'s original hairline sweep, just now literally the line the indicators sit on rather than a separate decorative rule.
3. **Slow ambient sweep (optional, restrained):** a single faint light band drifts once across the strip on load and does not repeat — continuous looping sweeps were considered and rejected, since a repeating sweep reads as "still scanning" rather than "already verified," which undercuts the calm/settled quality this brief asks for.
4. **Load reveal:** signals fade/rise in with a short stagger (~40ms apart), matching the existing strip's proven pattern.
5. **`prefers-reduced-motion`:** trace-line shown already-drawn, sweep skipped, indicator glow shown static (no pulse) — same accessibility commitment as every prior section this engagement has built.

**Explicitly avoided, per the brief's own "no flashy motion" instruction:** counters of any kind, spinning/rotating elements, per-item hover-triggered animation (this is a passive strip, not an interactive one), and anything that loops fast enough to draw ongoing attention away from the Hero above it.

---

## §5. Visual Direction

Same token set as every dark section on this homepage (Hero, `EO-DESIGN-001`'s capability diagram, `EO-DESIGN-002A`'s Layer 2 console) — continuing one visual system rather than introducing a fourth variant:

| Token | Value |
|---|---|
| Background | `#05080b` (shared with Hero) |
| Trace line / ring accent | `#7FC98A` |
| Label text | `#EEF4F0` |
| Descriptor text | `#A9BCC2` |
| Blueprint grid (new to this section) | Same faint two-axis line-grid technique used in `EO-DESIGN-001`'s diagram, radially masked, opacity ≤ .2 — restrained enough not to compete with the Hero's own grid directly above it |

**New in this refinement, not present in the original `EO-DESIGN-002A` strip:** the shared horizontal trace line with junction ticks at each indicator, and a faint blueprint grid texture — both requested explicitly by this brief ("engineering trace lines," "subtle engineering grids") and both absent from the simpler version currently live.

---

## §6. Interaction Behaviour

This strip has **no interactive elements** — no hover states, no click targets, no CTA. It is a passive credibility signal, positioned between the Hero (which does have CTAs) and the Commercial Challenge section (which does not open with one either) — consistent with `PDC-001` Article VIII's stage-appropriate CTA discipline already followed throughout this homepage. The only "interaction" is ambient: the synchronized pulse continues indefinitely at a slow, unobtrusive rate for as long as the section is on screen.

---

## §7. Mobile Layout (mobile-first, not a shrink)

Per the brief's explicit instruction, this is a distinct design, not a reflow of the desktop row:

- A single vertical column, each signal as its own row: ring indicator (left) → signal number + label (same line) → micro-descriptor (line below).
- The shared trace line becomes vertical, running down the left edge through each ring — the same vertical-bus pattern already proven in `EO-DESIGN-002A`'s Layer 2 mobile list and `EO-DESIGN-001`'s mobile domain list, reused here for consistency rather than invented fresh a third time.
- Synchronized pulse behaviour is preserved exactly (all rings still breathe in unison) — the one motion property that must survive at every breakpoint, since it's the concept's whole idea.
- Five rows at mobile density stay short enough (one line of descriptor each) that the section doesn't grow tall enough to feel like a scroll-heavy list — consistent with "confidence should survive regardless of screen size."

---

## §8. Accessibility Considerations

- **`prefers-reduced-motion`:** full static fallback per §4 — no pulse, no sweep, no line-draw animation; content fully visible immediately.
- **Non-color, non-motion signal:** the ring glow and trace line are decorative reinforcement only — signal number, label, and descriptor are the actual content and are never conveyed through glow/motion state alone (same principle applied correctly in `EO-DESIGN-001`'s diagram; the `aria-hidden` mistake found and fixed in `EO-DESIGN-002A`'s console will be checked against directly during implementation before shipping this one).
- **Reading order:** DOM order matches the intended reading order (signal 01 → 05) regardless of the desktop trace-line's visual routing.
- **Decorative elements marked appropriately:** the trace line, junction ticks, blueprint grid, and ambient sweep should all carry `aria-hidden="true"` at implementation time — the ring glow itself should not, since it sits adjacent to real label text within the same indicator, following the same pattern already corrected once this engagement.

---

## §9. Technical Implementation Approach

- **Same mechanism as every prior section this engagement:** a single hand-coded Elementor HTML widget replacing the current strip's widget content at section `bc618ce`, styled via an embedded `<style>` block — no new technical pattern.
- **Trace-line draw and synchronized pulse:** pure CSS (`stroke-dashoffset` keyframe for the one-time draw; a single shared `@keyframes` pulse applied identically, with no per-item delay offset, to all five ring-dot elements) — consistent with this site's confirmed `<script>`-stripping constraint; no JavaScript required anywhere in this design.
- **Deployment procedure, unchanged from every prior mission:** fetch fresh `_elementor_data` → locate the target widget by searching for a stable class-name substring already present in the live markup (e.g. `"iep-exec-strip"`) rather than a remembered widget id → splice → push via `wp_update_post_meta` → verify `_elementor_edit_mode` remains `"builder"` → independently re-fetch to confirm the write → cache purge (host + browser) → cache-busted curl verification before treating anything as live.
- **No CMS/taxonomy dependency:** unlike `EO-DESIGN-001`'s domain diagram, these five signals are stable, curated statements with no live-queryable governed data source of their own (same reasoning `EO-DESIGN-002A` used for its original version of this same strip) — hand-written content remains the right call here, not a gap to flag.

---

## §10. Final Implementation Recommendation

**Recommended for implementation as described above**, contingent on Mission Control resolving §0 (confirming this is understood as an upgrade to the already-live `EO-DESIGN-002A` strip, not a request to rebuild a numeric section that no longer exists) and on Mission Control's explicit authorization to proceed. **This document does not authorize implementation itself** — consistent with this brief's own deliverable list, which ends at "final implementation recommendation," and with this engagement's established plan → authorize → implement rhythm (contrast `EO-DESIGN-001`'s and `EO-DESIGN-002A`'s own Engineering Orders, both of which contained explicit authorization language this one does not).

If authorized, implementation is low-risk: it modifies only section `bc618ce`'s existing HTML widget content, does not touch the CTA-bearing sections elsewhere on the page, and reuses proven, already-validated techniques (CSS-only synchronized pulse, `stroke-dashoffset` line draw, the site's established blueprint-grid technique) rather than introducing new technical risk.

**UPDATE (same day) — implemented and deployed:** Mission Control authorized implementation. Located the existing widget by its stable class-name substring (`"iep-exec-strip"`, per §9's own recommendation), replaced its content with the design specified above, and pushed to page 959. **Verified independently after deployment** (re-fetched `_elementor_data` directly, not just trusted the write response): the shared trace line (`iep-exec-trace`), the synchronized pulse keyframe (`iepSyncPulse`, identical timing on all five rings, no stagger), and the refreshed copy (`Systems Thinking`, `Investment Protection`, etc.) are all present; brace balance of the widget's own markup is correct (44/44); `_elementor_edit_mode` remains `"builder"`; the unrelated "Book Opportunity Screening" CTA elsewhere on the page is untouched. **Outstanding:** same as every prior deployment this engagement — needs a host-level cache purge before it's visible live; a cache-busted verification will follow once that's done.

## Source References

**Primary Sources**
- Mission Control's EO-DESIGN-002B mission brief
- `EO-DESIGN-002A-Two-Stage-Confidence-Model.md` (the section this document refines)
- Live homepage `_elementor_data`, section `bc618ce`, verified directly before drafting
- `PDC-001` Article VIII, Article X
- `PDC-A001` AMD-1, AMD-2, AMD-3

**Related Repository Documents**
- `EO-DESIGN-001-Implementation-Report.md` (Hero-typography-matching precedent, `animateMotion`/CSS-only motion precedent)
