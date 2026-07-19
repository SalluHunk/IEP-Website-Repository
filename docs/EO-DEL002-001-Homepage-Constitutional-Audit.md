---
id: EO-DEL002-001
title: Constitutional Homepage Audit
mission: DEL-002 — Homepage Constitutional Alignment
operation: HORIZON
purpose: Comprehensive audit of the live homepage against repository-governing architecture, producing an implementation drift register and execution plan. Audit only — no implementation performed.
status: Complete — Awaiting Mission Control Approval
lifecycle: Materialized
last_updated: 2026-07-14
---

# EO-DEL002-001 — Constitutional Homepage Audit

## Repository Position

**Depends On**
- `PDC-001` (Articles III, IV, VII, VIII, X, XI, XII)
- `PDC-A001` (First Constitutional Amendment — governing 12-stage homepage model)
- `CRN-001`
- `content/CONTENT-001-Services/CONTENT-004-Visitor-Journey-Constitution-Review.md` (prior visitor-journey audit, 2026-07-13 — this document supersedes its homepage-specific findings with fresh live verification, and confirms/updates several)
- Live site state, verified directly for this audit: homepage page ID 959 (`_elementor_data`, fetched 2026-07-14), primary navigation menu ID 4, `/services/` page ID 970

**Enables**
- EO-DEL002-002 (implementation), once authorized by Mission Control

**Note on scope documents requested but not found materialized:**
- `ADR-001` — no file of this name, or de facto equivalent, exists anywhere in the repository (confirmed via full-repository search). This audit cannot validate compliance against a document that doesn't exist and does not attempt to substitute a guess.
- `CMS Architecture` — `docs/CMS-001-CMS-Architecture.md` remains an unmaterialized **Placeholder** (v0.1.0, "to be written," last updated 2026-07-05). The closest de facto CMS architecture references are `docs/CMS-001-Production-Migration-Strategy.md` and `docs/CMS-ARCH-001-Service-Taxonomy.md`, used below in its place.
- `SEO-001` (Performance and SEO) is also still Placeholder — metadata findings below are recorded as observed defects against general practice, not against an authored repository standard, since none exists yet.

---

## 1. Executive Summary

The homepage (`iep.technology/`, page ID 959) is a single, entirely hand-authored Elementor page with **zero CMS-driven content anywhere on it** — confirmed by direct inspection of its stored `_elementor_data`: no shortcode widgets, no Elementor dynamic tags, no references to any custom post type, anywhere across all twelve sections. This is a materially different state from `/services/` (page 970), which — following this engagement's `CMS-005`/`CMS-005A` work, completed and verified live earlier in this session — now renders its service content dynamically from the `cspt-service` CPT and `service_category` taxonomy via the `[iep_services_by_category]` shortcode.

That gap has produced the audit's single most important finding: **the homepage's own "Core services" section still displays the old, pre-`CONTENT-001` 8-item service list** (Energy studies, Efficiency assessments, Decarbonisation, Grant funding, Procurement support, Project delivery, Commissioning, Performance verification), while a visitor who clicks through to `/services/` sees the new, approved 9-service catalogue in 3 categories. `CONTENT-004` (2026-07-13) flagged this exact scenario as a future risk contingent on `CMS-005` deploying ("verify... the homepage's own Services section is updated in step"); it has now happened, in the direction predicted.

Structurally, the live homepage carries forward **two unresolved deviations `PDC-A001` (AMD-4) already found and asked to be corrected** (Who-We-Help/Commercial-Challenge order swap; Technical Capability positioned after, not before, Leadership) — both still present, confirmed by fresh extraction, not merely re-cited from the prior review. A **third ordering discrepancy** was found during this audit that either represents new drift or a correction to the prior review's record: Case Studies now renders *before* Services, the reverse of both `PDC-A001`'s governing 12-stage model and `CONTENT-004`'s own recorded live order from one day earlier. This audit treats the freshly-extracted structural order as ground truth and flags the discrepancy explicitly rather than silently reconciling it (see §7, Drift D-03).

Separately, and important to resolve before any implementation begins: **this Engineering Order's own stated visitor-journey template does not match the repository's actual governing model.** `PDC-A001` (materialized 2026-07-13, synthesizing `CONTENT-002` through `CONTENT-004`) establishes a 12-stage homepage narrative. The EO's template names 9 stages, several of which don't correspond to anything in `PDC-A001` or `PDC-001` Article VIII (a "Resources" stage has no repository grounding and no live homepage presence at all), while omitting stages the repository does govern (Commercial Challenge, Who We Help, Funding Capability, Testimonials as named stages) and renaming two others ("Featured Projects" for Case Studies, "Engineering Service Categories" for Services) without a recorded amendment. Per `PDC-001` Article XII, an implementation instruction that conflicts with the Constitution is flagged, not silently followed — this audit uses `PDC-A001` as the authoritative baseline throughout, and recommends Mission Control reconcile the two before EO-DEL002-002 is authorized.

**Maturity read:** the homepage is content-complete and narratively coherent as *written* prose, but structurally and technically behind where the rest of this engagement's CMS work has now taken `/services/`. No constitutional principle has been violated in the sense of inventing claims or breaking positioning — the issues found are all sequencing, synchronisation, and CMS-adoption gaps, not content-integrity failures.

---

## 2. Homepage Structural Assessment

Current live section order, confirmed by direct extraction from `_elementor_data` (byte-offset ordering within the stored JSON, which mirrors render order), fetched live 2026-07-14:

| # | Section (live heading) | Mapped stage |
|---|---|---|
| 1 | "Cut waste. Improve profits. Fund the investment." (Hero) | Executive Trust |
| 2 | "Built for energy-intensive industry" | Who We Help |
| 3 | "Waste is a margin leak" | Commercial Challenge |
| 4 | "We solve this." / "The antidote to a crowded consultancy market" | Why IEP |
| 5 | "We bridge the gap between 'good idea' and 'approved project'" | Funding Capability |
| 6 | "A six-step roadmap from data to delivery" | Methodology |
| 7 | "Featured case studies" (3 items) | Case Studies |
| 8 | "Core services" (8 cards — old catalogue) | Services |
| 9 | "A specialist team built for delivery" | Leadership |
| 10 | "Technical depth and rigorous modelling" (CFD, FEA, AI process simulation, Industrial modelling) | Technical Capability |
| 11 | "Testimonials" | Testimonials |
| 12 | "Stop the margin leak. Start the conversation." | Call To Action |

**Every section is a hardcoded Elementor section** — headings, card titles, icons, and body copy are all literal values in `_elementor_data`. No widget on the page is of type `shortcode`, no Elementor dynamic tag is bound to any field, and no reference to any `cspt-*` post type exists anywhere in the stored data (all confirmed by direct pattern search across the full page payload, not sampled).

Structural flow is logically complete — all 12 `PDC-A001` stages are represented, nothing is missing outright — but the ordering has 2–3 deviations from the governing model (§7).

---

## 3. Visitor Journey Assessment

Evaluated against `PDC-A001`'s 12-stage model: **Executive Trust → Commercial Challenge → Who We Help → Why IEP → Funding Capability → Methodology → Services → Case Studies → Technical Capability → Leadership → Testimonials → Call To Action.**

| Transition | Constitution says | Live site does | Verdict |
|---|---|---|---|
| Hero → next | Commercial Challenge | Who We Help | **Deviation** (unresolved from `PDC-A001` AMD-4) |
| stage 2/3 pair → Why IEP | either order, then Why IEP | Who We Help → Commercial Challenge → Why IEP | Pair intact, internal order swapped |
| Why IEP → Funding | Funding Capability next | ✓ matches | Correct |
| Funding → Methodology | Methodology next | ✓ matches | Correct |
| Methodology → Services | Services next | Case Studies next | **Deviation** (see D-03) |
| Services → Case Studies | Case Studies next | Case Studies precedes Services | **Deviation** (see D-03) |
| Case Studies → Technical Capability | Technical Capability next | Services, then Leadership, then Technical Capability | **Deviation** (unresolved from `PDC-A001` AMD-4) |
| Technical Capability → Leadership | Leadership next | Leadership precedes Technical Capability | **Deviation** (same as above) |
| Leadership/Technical Capability → Testimonials | Testimonials next | ✓ matches | Correct |
| Testimonials → CTA | CTA next | ✓ matches | Correct |

**Net effect on a first-time visitor:** the journey is still readable and doesn't strand the visitor — every stage exists and each transition individually makes local sense — but three of `PDC-A001`'s specifically-designed transitions no longer function as authored:
- The "Is this relevant to my business?" (Commercial Challenge) → "Is this built for organisations like mine?" (Who We Help) question sequence is inverted.
- Technical Capability's authored transition logic, "Who will I work with?", is supposed to lead directly into Leadership. It currently sits *after* Leadership, so that transition question is answered by nothing.
- A visitor sees proof (Case Studies) before the capability claim it's supposed to substantiate (Services) — proof-before-claim rather than claim-then-proof.

The CTA embedded at the end of the Methodology section ("Book Opportunity Screening") still asks for action before the visitor has reached the Services section that would justify it — the same break `CONTENT-004` recorded on 2026-07-13, still present, confirmed by fresh button-text extraction.

**Cross-page consistency:** the homepage → `/services/` transition, specifically, is now the site's most visible journey break. A visitor who reads "Core services" on the homepage (8 old items) and then clicks through to Services in primary navigation sees a completely different, uncorrelated 9-item, 3-category list. This is a worse outcome than either state alone — it actively contradicts what the visitor was just told.

---

## 4. Repository Alignment Assessment

| Document | Status | Homepage compliance |
|---|---|---|
| `PDC-001` Art. I–VII, IX–XII | Frozen v1.0 | No violations found — no invented claims, no unsupported statistics, no branding/colour/typography deviations observed in the sections reviewed |
| `PDC-001` Art. VIII (original 9-stage) | Frozen v1.0, superseded in stage-count by `PDC-A001` | Partially followed — see §3 |
| `PDC-A001` (12-stage model, AMD-1–6) | Materialized, pending Architecture Review | Followed on 9 of 12 transitions; 3 deviations (2 previously known, 1 newly surfaced) |
| `ADR-001` | **Not found in repository** | Not evaluable |
| CMS Architecture (`CMS-001-CMS-Architecture.md`) | **Unmaterialized placeholder** | Not evaluable against this document directly; evaluated instead against the de facto architecture in `CMS-001-Production-Migration-Strategy.md` and `CMS-ARCH-001-Service-Taxonomy.md` — see §5 |
| `CONTENT-001` – `CONTENT-004` | Materialized | Homepage content is broadly consistent with the Stage×Domain service model and evidentiary-gating principles in spirit, but the homepage's own Services section predates all four documents and reflects none of their findings |
| `CMS-005` | Deployed live (this session, on `/services/` only) | **Not propagated to the homepage** — this is the core drift finding, D-01 |
| `CMS-005A` | Deployed live (this session, on `/services/` only) | Same as above |

**This Engineering Order's own visitor-journey template**, compared against `PDC-A001`:

| EO template stage | Corresponding `PDC-A001` stage(s) | Note |
|---|---|---|
| Hero | Executive Trust | Match |
| Trust & Credibility | (no direct match — closest is Executive Trust, already covered by Hero) | Possible duplicate naming of Hero's own purpose |
| Engineering Service Categories | Services | Renamed, no recorded amendment |
| Why Industrial Engineering Pioneers | Why IEP | Match |
| Engineering Methodology | Methodology | Match |
| Featured Projects | Case Studies | Renamed, no recorded amendment |
| Resources | **No corresponding stage anywhere in `PDC-001` or `PDC-A001`** | Not governed; does not exist on the live homepage |
| Leadership | Leadership | Match |
| Call To Action | Call To Action | Match |
| *(omitted from EO template)* | Commercial Challenge, Who We Help, Funding Capability, Technical Capability, Testimonials | 5 of `PDC-A001`'s 12 stages have no place in the EO's 9-stage template |

**Recommendation stated plainly:** do not implement against the EO's own template as written. It would require removing or demoting Commercial Challenge, Who We Help, Funding Capability, Technical Capability, and Testimonials — all constitutionally governed, none flagged as deficient by any prior audit — and inventing a "Resources" section with no evidentiary basis, in violation of Article X's Content Integrity constraint against introducing unsupported/unplanned content. This is exactly the kind of conflict Article XII requires be flagged rather than resolved silently. Mission Control should confirm whether the EO template was a simplified paraphrase (not intended to override `PDC-A001`) or an intentional proposed amendment (which would need to go through the same Constitutional Amendment process `PDC-A001` itself followed) before EO-DEL002-002 proceeds.

---

## 5. CMS & Metadata Assessment

**CMS-driven content:** None. Confirmed by structural scan of the full `_elementor_data` payload — zero `shortcode` widgets, zero Elementor `dynamic` tag bindings, zero references to `cspt-service`, `cspt-portfolio`, `cspt-team-member`, or `service_category` anywhere on the page. Every heading, card title, icon selection, and body paragraph across all 12 sections is a literal, hand-typed value.

**Dynamic service taxonomy:** Not used on the homepage. The `service_category` taxonomy and `[iep_services_by_category]` shortcode exist and are proven live on `/services/`, but nothing on the homepage calls them. The homepage's "Core services" section is the same kind of hardcoded card grid `/services/` used to have before this session's `CMS-005`/`CMS-005A` work replaced it.

**Metadata integrity:**
- No `<meta name="description">` tag present on the homepage response (confirmed via live fetch, 2026-07-14) — a genuine gap, though not checkable against `SEO-001` since that document is itself an unmaterialized placeholder.
- **Three `<h1>` elements** on a single page load: a hidden/theme site-title H1 ("Industrial Energy Pioneers Limited – Cut Waste..."), a generic page-title H1 ("Home"), and the actual hero H1 ("Cut waste. Improve profits. Fund the investment."). Semantically, a page should carry exactly one H1; this is a real technical defect independent of any repository content standard.
- Canonical URL tag is present and correct (`https://iep.technology/`).

**Hardcoded implementation that should derive from metadata (flagged per this EO's explicit instruction):**
1. **"Core services" section** — should render from the same `service_category` taxonomy `/services/` already uses (e.g. a lighter, homepage-appropriate excerpt via the existing shortcode infrastructure, or a new excerpt-mode variant), not a second, independently-maintained hardcoded list.
2. **"Featured case studies" section** — currently 3 hardcoded case study cards; case study content exists as real posts (`cspt-portfolio`, per `CMS-BOOT-002`) but, like the CPTs generally, has zero REST exposure and is not wired to any dynamic query here. Lower priority than Services (no live catalogue mismatch exists for Case Studies the way it now does for Services), but the same underlying pattern.
3. **"Technical depth and rigorous modelling" and Leadership sections** — hardcoded text, but with no known live-vs-source mismatch (no CMS module for these exists yet), so no active drift — noted for completeness, not urgency.

---

## 6. UX Assessment

**Caveat, stated plainly per this session's own verification standard:** the in-session browser's screenshot tool was unresponsive throughout this audit (repeated timeouts) — visual hierarchy, true reading rhythm, and mobile rendering were **not** verified by direct visual inspection this session. The findings below are derived from DOM structure, heading hierarchy, section count, and copy length — a reasonable proxy for structural UX, but not a substitute for a visual pass. Flagging this explicitly rather than claiming a visual QA that didn't happen.

- **Visual hierarchy (structural signal only):** heading tag usage is otherwise clean per section (one H2 per section, H3 for sub-items/cards) apart from the multi-H1 issue in §5.
- **Scroll experience / information density:** 12 sections is a long but not excessive single-page scroll for this narrative type; consistent with `PDC-001` Article VI's stated preference for scale-driven hierarchy over ornamentation. No section reads as obviously overloaded from its extracted text volume.
- **CTA placement:** 4 distinct CTA/link texts found site-wide on the homepage ("Book Opportunity Screening" ×2, "View all case studies", "View all testimonials") — reasonable count, not over-CTA'd, but one instance (end of Methodology) precedes the content it references (§3).
- **Conversion flow:** Testimonials immediately before the final CTA is good sequencing (trust immediately before the ask), consistent with `CONTENT-004`'s prior finding.
- **Mobile experience:** not verified this session (see caveat above) — recommend a dedicated visual/responsive pass before or during EO-DEL002-002, not assumed from this audit.

---

## 7. Implementation Drift Register

| ID | Finding | Severity | First identified |
|---|---|---|---|
| D-01 | Homepage "Core services" section shows the **old** 8-item catalogue; `/services/` now shows the **new**, CMS-driven 9-service, 3-category catalogue. Direct, visitor-visible contradiction between two pages of the same site. | **Critical** | New this audit (predicted as a risk by `CONTENT-004`, now confirmed materialized) |
| D-02 | Who-We-Help / Commercial-Challenge order swapped vs. `PDC-A001`/Article VIII/`CRN-001`. | High | `CONTENT-004` (2026-07-13); reconfirmed live, unresolved |
| D-03 | Case Studies now renders before Services; `PDC-A001`'s model and `CONTENT-004`'s own 2026-07-13 record both state Services-before-Case-Studies. Either new regression or a correction to the prior record — cause undetermined, current live order confirmed via direct structural extraction and treated as ground truth. | High | New this audit |
| D-04 | Technical Capability renders after Leadership (and after Case Studies), not before Leadership as `PDC-A001`/Article VIII specify; its own "Who will I work with?" transition logic no longer functions. | High | `CONTENT-004` (2026-07-13); reconfirmed live, unresolved |
| D-05 | Homepage is 100% hardcoded Elementor content — no CMS/shortcode/dynamic-tag usage anywhere, in tension with this engagement's own stated end-state goal that pages should not contain hardcoded information. | Medium (structural debt, not a visible defect on its own) | Consistent with `CMS-BOOT-002`'s original finding; reconfirmed unchanged for the homepage specifically |
| D-06 | This EO's own visitor-journey template conflicts with `PDC-A001`, the actual governing model (omits 5 governed stages, adds one ungoverned "Resources" stage, renames two stages without amendment). | High (process risk — could cause incorrect implementation if not resolved first) | New this audit |
| D-07 | `ADR-001` does not exist in the repository; `CMS-001-CMS-Architecture.md` and `SEO-001` remain unmaterialized placeholders, limiting what this audit's Repository Compliance section could check against. | Medium (documentation gap, not a site defect) | New this audit |
| D-08 | No `<meta name="description">` on the homepage; 3 `<h1>` elements on a single page load. | Medium | New this audit |
| D-09 | Methodology-section CTA ("Book Opportunity Screening") precedes the Services section it logically follows. | Low | `CONTENT-004` (2026-07-13); reconfirmed live, unresolved |
| D-10 | Insights (thin scaffold in primary nav), Careers/Resources (live scaffolds outside nav), Quality Management/Grants (real content, orphaned from all navigation) — unchanged since `CONTENT-004`. | Low–Medium (unchanged, not homepage-specific) | `CONTENT-004` (2026-07-13); reconfirmed unresolved, out of this audit's direct scope but noted for completeness |

---

## 8. Prioritized Recommendations

1. **Resolve D-06 first, before any other homepage work begins.** Confirm with Mission Control whether this EO's 9-stage template is a paraphrase or a proposed amendment. Implementing against it as written would remove or misname five constitutionally-governed stages — a bigger risk than any single ordering defect below.
2. **Critical — fix D-01 (Services list mismatch).** This is the one drift item a visitor is now guaranteed to notice if they read both pages. Shortest path: point the homepage's Services section at the same `service_category` taxonomy data `/services/` already uses (excerpt of 3, one per category, or similar), rather than re-typing the 9 new titles by hand a second time.
3. **High — restore D-02 and D-04's ordering** (Commercial-Challenge-before-Who-We-Help; Technical-Capability-before-Leadership), per `PDC-A001` AMD-4, which already recommended this and remains unactioned.
4. **High — resolve D-03** once D-06 is settled, since the correct target order depends on which governing model is confirmed authoritative.
5. **Medium — D-08 metadata fixes** (add a meta description; resolve to a single H1 — likely a theme-template fix affecting every page, not just the homepage, worth scoping accordingly).
6. **Medium — D-05, longer-term:** treat the homepage's remaining hardcoded sections (Case Studies excerpt, Leadership excerpt) as future CMS-migration candidates once their underlying CPT/taxonomy data is itself REST-exposed or otherwise reachable — no urgency, no live mismatch currently forces this.
7. **Low — D-09** CTA reposition (move or re-justify the Methodology section's CTA).
8. **Low — D-07, D-10:** administrative/documentation gaps carried forward from `CONTENT-004`; address opportunistically, not blocking.

---

## 9. Proposed Implementation Plan (subject to Mission Control authorization — EO-DEL002-002)

**Phase 1 — Governance reconciliation (no code changes)**
- Mission Control confirms the authoritative visitor-journey model (D-06). Output: either a note that the EO template was non-binding shorthand, or a new Constitutional Amendment (`PDC-A002`) if stages are genuinely to change.

**Phase 2 — Services synchronisation (highest visitor-facing impact)**
- Build a homepage-appropriate rendering of the live `service_category` taxonomy (full grid or curated excerpt, per design direction), replacing the hardcoded "Core services" section.
- Reuses existing, already-proven infrastructure (`service_category` taxonomy, `service_icon` ACF field, `[iep_services_by_category]` shortcode or a new excerpt-mode sibling) — no new CPT/taxonomy work required.

**Phase 3 — Section reordering**
- Direct `_elementor_data` edit (same splice-and-verify technique used for `/services/` this session: fetch → Python-validated splice → `wp_update_post_meta` → verify `_elementor_edit_mode` → cache-busted live verification → host+browser cache purge) to correct D-02, D-03 (once resolved), and D-04.

**Phase 4 — Metadata and technical fixes**
- Add homepage meta description.
- Resolve to a single H1 (likely requires a theme-template-level fix rather than a page-level one — scope to confirm during implementation).

**Phase 5 — Verification**
- Cache-busted fetch confirming new section order, new Services content, and metadata changes.
- Cross-check homepage Services section against `/services/` for exact-match category names/counts.
- Visual/responsive pass (screenshot tooling permitting) — not completed in this audit; should not be skipped in implementation.

**Do not begin implementation. Awaiting Mission Control approval per this EO's own instruction.**

## Source References

**Primary Sources**
- `PDC-001`, Articles III, IV, VII, VIII, X, XI, XII
- `PDC-A001` — First Constitutional Amendment, all 6 amendment entries
- `content/CONTENT-001-Services/CONTENT-004-Visitor-Journey-Constitution-Review.md`
- Live WordPress state, verified directly 2026-07-14: page 959 `_elementor_data`, primary navigation menu ID 4, page 970 current state

**Related Repository Documents**
- `docs/CMS-001-Production-Migration-Strategy.md`, `docs/CMS-ARCH-001-Service-Taxonomy.md` (used in place of the unmaterialized `CMS-001-CMS-Architecture.md`)
- `deployment/CMS-005-Services/`, `deployment/CMS-005A-Service-Taxonomy/`
