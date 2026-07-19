---
id: PDC-A001
title: First Constitutional Amendment
purpose: Records implementation-driven refinements to PDC-001, discovered through CONTENT-001 through CONTENT-004, without editing PDC-001's own text
status: Materialized — pending Architecture Review
lifecycle: Materialized
owner: TBD
last_updated: 2026-07-13
---

# PDC-A001 — First Constitutional Amendment

## Repository Position

**Depends On**
- `PDC-001` (all 12 Articles, unedited — this document amends by addition, not by modifying PDC-001's text)
- `CRN-001`
- `content/CONTENT-001-Services/` (`CONTENT-002`, `CONTENT-002A`, `CONTENT-003`, `CONTENT-004`)
- Live site state, verified directly (current WordPress navigation menu, current homepage section order) rather than assumed from documentation

**Enables**
- Any future implementation Mission touching the service catalogue, the homepage, or primary navigation — this document, alongside `PDC-001`, is now the governing reference for those areas.

## Executive Summary

`PDC-001` was frozen at Version 1.0 following AQR-006, before the 9-service catalogue existed and before the homepage's live implementation could be checked against it directly. Four implementation missions since then — `CONTENT-002` (portfolio review), `CONTENT-002A` (portfolio constitution), `CONTENT-003` (content enhancement), and `CONTENT-004` (visitor journey review) — surfaced six findings materially affecting how the Constitution should be read or applied. **`PDC-001` is not edited by this document.** Per this mission's Repository Rules, every finding below is recorded as an amendment entry, classified as Clarification, Expansion, or a validated no-amendment finding, each citing the implementation mission(s) that produced it.

The headline result: **`PDC-001` held up well.** Of the six findings, none required a Correction — no implementation proved an original Article wrong. Two findings validated Article VIII's original homepage sequence as correct and identified the live site's deviation from it as unapproved implementation drift, not a constitutional gap. The remaining four findings are genuine new ground — a service-portfolio structural model, two clarifying operational rules, and formal recognition of three homepage stages and the primary navigation order, none of which existed in `PDC-001`'s original scope.

---

## Amendment Register

### AMD-1 — Service Portfolio Structural Model (Stage × Domain)

**Classification:** Expansion

**Affected Articles:** VII (Content Constitution), VIII (Homepage Narrative Constitution — "Services" stage)

**Reason:** `PDC-001` established that services should be presented outcome-first (Article VII) but never addressed how the service catalogue's internal items relate to one another. The approved 9-service catalogue could not be implemented without resolving real, evidence-based overlaps between services.

**Evidence:** `CONTENT-002` identified four unresolved capability-boundary duplications across the 9 approved services (Screening vs. Feasibility on diagnostic depth; two energy services both claiming "fuel switching"; Funding vs. Innovation both claiming grant-funding capability; inconsistent decarbonisation terminology). `CONTENT-002A` resolved all four under a single model: services are either **Stage** (describe *when* in the engagement — Screening, Feasibility, Funding & Delivery, Monitoring), **Domain** (describe *what subject matter* — Energy/Utilities/Process, Water/Wastewater, Low-carbon Energy), **Supporting Capability** (a toolkit used within Stage services, not independently engaged), or **Adjacent Offering** (a parallel track outside the core lifecycle — Technology Innovation & R&D).

**Implementation Source:** `CONTENT-002`, `CONTENT-002A`

**Impact:** Any future service content must be classified against this model before drafting. The model also supplies the attribution rule for which service "owns" a given capability when more than one plausibly could.

**Repository Implications:** `CMS-005`'s field content and any future service catalogue changes should be authored against this model. `CONTENT-003`'s publication-ready service copy already reflects it.

**Superseded Guidance:** None — `PDC-001` had no prior position on this; nothing is being replaced.

---

### AMD-2 — Supporting Capability Exclusion Principle

**Classification:** Clarification

**Affected Articles:** III (Business Objectives, Objective 5), VIII ("Services" stage 5 vs. "Technical Capability" stage 7)

**Reason:** Article III, Objective 5 already states the site's core narrative themes "shall be business outcomes, cost reduction, and operational performance — not a service listing," citing the Commercial Proposal's Strategic Positioning directly. What Article III didn't specify is what happens when an approved catalogue item is itself a capability, not an outcome-bearing offering — a case implementation actually encountered.

**Evidence:** Service 3 (Product Design & Optimisation, incl. CFD/FEA) is evidenced only as internal validation tooling supporting other services, with no business challenge or deliverable of its own anywhere in the source material. This is independently corroborated by Article VIII itself, which already separates "Services" (stage 5) from "Technical Capability" (stage 7, Primary Message: "IEP holds genuine in-house technical/simulation capability, e.g. CFD, FEA, process modelling") — content that is, in substance, Service 3's own content, already given a constitutional home distinct from "Services" before the 9-service catalogue existed.

**Implementation Source:** `CONTENT-002`, `CONTENT-002A`

**Impact:** A catalogue item lacking an evidenced business challenge and deliverable of its own must be presented as supporting/credibility content, cross-linked from the services it supports — never as a peer "service listing" item — even where the client's approved catalogue numbers it alongside services that do have their own business case. This is now a checkable test, not just a stylistic preference.

**Repository Implications:** Applies to Service 3 today. Establishes the test for any future catalogue addition of the same shape.

**Superseded Guidance:** None. Article VIII already had the correct underlying model (Services vs. Technical Capability as separate homepage stages); this clarifies that the distinction is a live governing test for the service catalogue's internal structure, not only a homepage-layout artefact.

---

### AMD-3 — Evidentiary Gating for Service Publication

**Classification:** Clarification

**Affected Articles:** VII (Messaging Hierarchy), X (Content Integrity)

**Reason:** Article X already prohibits unsupported claims ("Unsupported claims shall never be introduced... every measurable statement shall originate from verified evidence") and Article VII's Messaging Hierarchy requires Business Outcome to lead every piece of content. Neither Article previously stated explicitly what to do when a catalogue item has *no* evidenced business challenge at all — a case implementation had to resolve concretely, not hypothetically.

**Evidence:** Service 8 (AI-enabled Monitoring, Assurance & Continuous Improvement) has, across every Primary Source reviewed, exactly one piece of relevant evidence: an unelaborated phrase in a single director's biography. No business challenge, capability, or deliverable is evidenced. `CONTENT-002` found that publishing this service in full would require inventing content Article X prohibits; `CONTENT-002A` found it would additionally violate Article VII's Messaging Hierarchy, since the service could not open with an evidenced Business Outcome.

**Implementation Source:** `CONTENT-001`, `CONTENT-002`, `CONTENT-002A`, `CONTENT-003`

**Impact:** No service, and by extension no content unit governed by the Messaging Hierarchy, may be published beyond its disclosed, sourced evidence fragments until a business challenge is evidenced. This makes publication readiness an evidentiary gate, not only an accuracy check — a piece of content can be entirely truthful and still not be ready to publish, if it has nothing to say yet.

**Repository Implications:** Sets a repeatable pattern for any future thin-evidence content unit. `CONTENT-003` already applied this rule directly, by deliberately not expanding Service 8 beyond a "Status: Pending" disclosure.

**Superseded Guidance:** None.

---

### AMD-4 — Homepage Section Order: Constitution Validated, Implementation Drift Flagged

**Classification:** No amendment — Article VIII and `CRN-001` both confirmed correct

**Affected Articles:** VIII (stages 2–3 order; stage 7 position)

**Reason:** `CONTENT-004` compared the live homepage's actual section order against Article VIII directly and found two deviations: "Who We Help" (stage 3) appears before "Commercial Challenge" (stage 2), inverted from Article VIII's stated order; and "Technical Capability" (stage 7) now appears after Leadership (stage 8) instead of before it.

**Evidence:** Both deviations were checked against `CRN-001`'s own "Homepage Narrative" entry — a Tier 3, client-approved Primary Source, independent of Article VIII's own text — which states the identical 9-stage order Article VIII records, word for word: "Executive Trust → Commercial Challenge → Who We Help → Why IEP → Services → Methodology → Technical Capability → Leadership → Call To Action." No source anywhere records client approval for either deviation. Per `KNOWLEDGE-SOURCES-001`'s Repository Authority Principle, a live implementation that conflicts with an actual client-approved source is wrong and must be corrected — it is never treated as an update to that source.

**Implementation Source:** `CONTENT-004`

**Impact:** **Article VIII is not amended.** Both Article VIII and `CRN-001` are independently confirmed correct by this review. The live homepage itself has drifted from approved direction, with no record of why or when.

**Repository Implications:** Recommend a future implementation mission restore the live homepage's section order to match Article VIII / `CRN-001` — specifically, Commercial Challenge before Who We Help, and Technical Capability before Leadership. This is a live-site content correction, not a constitutional matter, and is out of this mission's scope to execute — recorded here so the discrepancy isn't lost between review cycles.

**Superseded Guidance:** None.

---

### AMD-5 — Homepage Narrative Expansion: Funding Capability, Case Studies, Testimonials

**Classification:** Expansion

**Affected Articles:** VIII (Homepage Narrative Constitution)

**Reason:** The live homepage carries three sections — Funding Capability, Case Studies, Testimonials — with no corresponding stage anywhere in Article VIII's original 9-stage model. `CONTENT-004` assessed all three directly and found each strengthens the visitor journey rather than conflicting with it.

**Evidence:** Funding Capability (positioned after "Why IEP") reinforces Article III's Objective 10 (funding/financial credibility as a differentiator) with dedicated homepage-level content. Case Studies (positioned after "Services") supplies evidence immediately following the capability claim it supports, strengthening the Problem → Solution → Evidence progression `CONTENT-004`'s Commercial Journey review confirmed the site otherwise follows. Testimonials (positioned immediately before the Call To Action) supplies trust reinforcement at the precise point a visitor is asked to act — sound Trust → Action sequencing.

**Implementation Source:** `CONTENT-004`; underlying content traceable to Homepage Narrative (`IEP-Homepage-Copy.md`, §5 Funding Capability, §8 Case Studies, §11 Testimonials)

**Impact:** Article VIII's governing sequence is now a 12-stage model, not 9: Executive Trust → Commercial Challenge → Who We Help → Why IEP → **Funding Capability** → Methodology → Services → **Case Studies** → Technical Capability → Leadership → **Testimonials** → Call To Action. (Note: this ordering restores Technical Capability ahead of Leadership per AMD-4 — the 12-stage model describes where these stages belong, not the live page's current, unapproved sequence.)

**Repository Implications:** Article VIII's own preservation principle ("shall not reorder, omit, or repurpose a stage without a new Constitutional Amendment") now applies to all 12 stages. This document is that amendment for the 3 new ones.

**Superseded Guidance:** Article VIII's stage count (9) is superseded by 12. None of the original 9 stages' content, purpose, or Visitor Question/Desired Response/Transition Logic framing is altered.

---

### AMD-6 — Primary Navigation Order: New Constitutional Coverage

**Classification:** Expansion

**Affected Articles:** VIII (scope extension — Article VIII's text explicitly limits itself to "the homepage journey... it does not prescribe" anything beyond that)

**Reason:** `PDC-001` has no Article governing the order of primary site navigation (as distinct from the homepage's own internal section order, which Article VIII already governs). `CONTENT-004` found that the live navigation order independently reproduces the same sound narrative logic Article VIII establishes for the homepage, without ever having been asked to.

**Evidence:** Live navigation order, confirmed directly against the current WordPress menu: Home → About → Services → Industries → Case Studies → Leadership → Testimonials → Insights → Contact. `CONTENT-004`'s Journey Map (Path 2) found this ordering places evidence (Case Studies) before trust-building (Leadership), consistent with the Problem → Solution → Evidence → Trust → Action model Article VIII's homepage sequence also follows.

**Implementation Source:** `CONTENT-004`

**Impact:** The current primary navigation order is constitutionally endorsed. Future navigation changes should be held to the same "no reordering without a recorded amendment" discipline Article VIII already applies to the homepage.

**Repository Implications:** Closes a real gap — until now, nothing in the repository governed navigation order at all, so a future navigation change would have had no constitutional reference point to check against.

**Superseded Guidance:** None — new coverage, not a correction of anything previously stated.

---

## Homepage Review

Specifically requested by this mission — consolidated from the Amendment Register above, addressed item by item:

- **Homepage section order:** Constitution validated (AMD-4). The live page has drifted from both Article VIII and `CRN-001`; recommend correcting the live page, not the Constitution.
- **Leadership transition:** Affected by the Technical Capability repositioning (AMD-4). Article VIII's stage 7 → 8 transition logic ("Who will I work with?" leading into Leadership) only functions with Technical Capability positioned before Leadership, as both Article VIII and `CRN-001` specify. It currently isn't.
- **Technical Capability positioning:** Same finding as above — should precede Leadership, per two independent Tier-appropriate sources (AMD-4).
- **Funding:** New stage, formally recognised (AMD-5) — inserted after "Why IEP."
- **Case Studies:** New stage, formally recognised (AMD-5) — inserted after "Services."
- **Testimonials:** New stage, formally recognised (AMD-5) — inserted after Technical Capability/Leadership, before Call To Action.
- **Navigation:** New constitutional coverage established (AMD-6) — the current order is endorsed, not just tolerated.

**Determination: Article VIII should be explicitly clarified via this amendment (not edited directly), reflecting a 12-stage model with the original 9 stages' relative order restored to what both Article VIII and `CRN-001` already specify.** The live homepage's current implementation does not yet match this model on two points (AMD-4) — that is a correction owed to the live site, not to the Constitution.

---

## Effective Constitutional State

`PDC-001` remains Frozen at Version 1.0, unedited, exactly as approved via AQR-006. Read together with this document, the effective governing state is:

1. **Articles I–VI, IX–XII** — unaffected by this amendment, stand as originally written.
2. **Article III** — clarified by AMD-2: Objective 5's "not a service listing" principle extends explicitly to excluding supporting-capability content from the service catalogue's peer listing.
3. **Article VII** — clarified by AMD-2 and AMD-3: the Messaging Hierarchy and Content Integrity principles jointly gate publication on evidenced business outcome, not just factual accuracy; the Service Portfolio Structural Model (AMD-1) governs how service content is organised before it's drafted.
4. **Article VIII** — expanded by AMD-5 and AMD-6, validated (not amended) by AMD-4: the homepage narrative is now a 12-stage model (the original 9, plus Funding Capability, Case Studies, and Testimonials), and primary navigation order now has constitutional coverage for the first time. The live site does not yet fully conform to this state (see AMD-4) — that is an implementation gap, not a constitutional one.
5. **Article VIII, "Services" stage specifically** — additionally governed by AMD-1 and AMD-2's Service Portfolio Structural Model, which did not exist when Article VIII was originally materialized.

This document, `PDC-A001`, is now the governing amendment reference for the service catalogue, homepage narrative, and primary navigation — to be read alongside `PDC-001`, never in place of it, per `PDC-001` Article XII's own Authority principle ("Primary Knowledge Sources remain authoritative over PDC-001 at every point of conflict"), which extends by the same logic to this amendment being subordinate to both `PDC-001` and the Primary Sources it, in turn, derives from.

## Source References

**Primary Sources**
- `CRN-001` (`references/CRN-001-Client-Review-Notes.md`) — Homepage Narrative, cited in AMD-4
- Live WordPress navigation menu (ID 4, "Top Menu Primary") and live page/section state, verified directly for this mission

**Related Repository Documents**
- `PDC-001`, Articles III, VII, VIII, X, XII
- `content/CONTENT-001-Services/CONTENT-002-Service-Constitution-Review.md`
- `content/CONTENT-001-Services/CONTENT-002A-Service-Portfolio-Constitution.md`
- `content/CONTENT-001-Services/CONTENT-003-Service-Content-Enhancement.md`
- `content/CONTENT-001-Services/CONTENT-004-Visitor-Journey-Constitution-Review.md`
- `KNOWLEDGE-SOURCES-001` (Repository Authority Principle, cited in AMD-4)
