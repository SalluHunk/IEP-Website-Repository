---
id: CONTENT-002A
title: Service Portfolio Constitution
purpose: The authoritative definition of each service's purpose, boundaries, owned capabilities, and the portfolio's canonical structure — resolving the boundary and classification questions raised by CONTENT-002
status: Materialized — pending Architecture Review
lifecycle: Materialized
owner: TBD
last_updated: 2026-07-13
---

# CONTENT-002A — Service Portfolio Constitution

## Repository Position

**Depends On**
- `PDC-001` (Articles III, IV, VII, VIII — Business Objectives, Company Positioning, Content Constitution, Homepage Narrative Constitution)
- `content/CONTENT-001-Services/` (all 9 `SERVICE-0X-*.md` files, `MASTER-SERVICE-MATRIX.md`)
- `content/CONTENT-001-Services/CONTENT-002-Service-Constitution-Review.md`

**Enables**
- `deployment/CMS-005-Services/` (future revision — this document supplies the capability-to-service assignment CMS-005's field content should follow)
- Future service page copywriting (a downstream mission, not this document)

## What this is

This is a **decision document**, not another review. `CONTENT-002` diagnosed four live boundary-duplication issues and two structurally miscast services; this document resolves them. Where CONTENT-002 asked "does this belong to Service X or Service Y," this document answers. Where a question genuinely cannot be answered from evidence — Service 8's basic existence, "resilient" in Service 5's title — this document says so plainly and does not force an answer that isn't there.

**No service content is rewritten here.** This governs which service owns which capability and why; it does not draft Executive Summaries, capability copy, or marketing language. That remains `CONTENT-001`'s territory for a future revision.

**The client's approved 9-service catalogue and its numbering (1–9) are not altered.** All 9 titles from the approved catalogue remain, in their given order, as the canonical CMS/data-model catalogue. What this document adds is an underlying structural model that explains *why* certain capabilities sit where they do, and a *separate, non-binding* presentation layer for how the portfolio might be grouped in site navigation — clearly marked as such, never conflated with the catalogue itself.

---

## 1. The Governing Model: Stage × Domain

Building on `CONTENT-002`'s findings, this document identifies that the 9 approved services are not 9 peers of the same kind. They fall into four distinct roles, and nearly every boundary-duplication issue CONTENT-002 found is actually the same underlying capability appearing at a *different point* in this model — not a genuine conflict, once the model is made explicit.

### Stage Services — the client's engagement lifecycle, domain-agnostic

These describe *when in the engagement* a service applies, regardless of what technical domain is involved.

| Stage | Service | Role |
|---|---|---|
| Diagnose | **1. Opportunity Screening & Diagnostic Review** | Broad, low-commitment identification of where opportunities might exist |
| Design & Justify | **6. Engineering Design, Feasibility & Investment Case** | Deep, investment-grade study of a specific identified opportunity |
| Fund & Deliver | **7. Funding, Procurement & Project Delivery** | Securing funding and executing the justified project |
| Sustain *(pending evidence — see §5)* | **8. AI-enabled Monitoring, Assurance & Continuous Improvement** | Ongoing performance assurance after delivery |

### Domain Services — the subject-matter expertise, stage-agnostic

These describe *what technical subject* a service applies to. A Domain service's evidence and case studies span multiple Stages (a Domain case study typically shows Diagnose → Design → Deliver all happening within that domain) — this is expected, not a boundary violation.

| Domain | Service |
|---|---|
| Energy, utilities, and process systems | **2. Energy, Utilities & Process Efficiency** |
| Water, wastewater, and circular resource streams | **4. Water, Wastewater & Circular Resource Management** |
| Low-carbon energy supply | **5. Low-carbon & Resilient Energy Systems** |

### Supporting Capability — not a Stage, not a Domain

A technical toolkit used *within* Stage services (chiefly Design & Justify) to validate Domain-service recommendations before they're committed to. It is not something a client engages independently of a Stage/Domain engagement.

| Capability | Formerly presented as |
|---|---|
| CFD, FEA, AI process simulation, thermo-fluid modelling, Aspen Plus process modelling, CAD | **3. Product Design & Optimisation** |

### Adjacent Offering — outside the Stage/Domain lifecycle entirely

A specialist track that doesn't move a client through Diagnose → Design → Deliver. It has its own, separate engagement logic (technology development and validation, not operational efficiency).

| Service |
|---|
| **9. Technology Innovation & R&D Support** |

**Why this resolves the boundary questions:** every duplication CONTENT-002 found is a Stage service and a Domain service (or two Domain services, or a Stage and an Adjacent service) independently citing the same underlying piece of evidence, because the evidence genuinely sits at the intersection of both. That is not an error to eliminate — it is what a Stage × Domain structure predicts. What was missing was the explicit rule for which one *owns* the capability's description, and which one merely *references* it. §3 below states those rules.

---

## 2. Purpose of Each Service

One or two sentences each — the test is whether a reader immediately understands what the service provides, per `CONTENT-002`'s Purpose criterion.

1. **Opportunity Screening & Diagnostic Review** — A short, low-commitment diagnostic that identifies where energy, utilities, water, or process waste is likely to exist across a client's site, before any deeper engagement is proposed.
2. **Energy, Utilities & Process Efficiency** — Delivered engineering work that reduces energy, utilities, and process waste at an existing industrial or commercial site, most concretely through waste-heat recovery and utilities optimisation.
3. **Product Design & Optimisation (incl. CFD, FEA and experimental analysis)** — IEP's in-house simulation and modelling capability, used to validate the engineering recommendations made under Services 2, 4, 5, and 6 before capital is committed. *(Not a standalone client engagement — see §5.)*
4. **Water, Wastewater & Circular Resource Management** — Delivered engineering work that reduces water and wastewater treatment costs and recovers value from process waste streams, most concretely demonstrated in Food & Beverage.
5. **Low-carbon & Resilient Energy Systems** — Delivered engineering work that reduces the carbon intensity of a client's energy supply through renewable integration, fuel switching, and thermal storage. *("Resilient" is not yet defined — see §6.)*
6. **Engineering Design, Feasibility & Investment Case** — Converts a diagnosed opportunity (from Service 1, or from ongoing work in any Domain service) into an investment-grade, capital-approval-ready business case, including the engineering design work needed to specify the solution.
7. **Funding, Procurement & Project Delivery** — Secures grant/government funding for a justified project (from Service 6), manages procurement and contractor delivery, and verifies the installed solution performs as designed.
8. **AI-enabled Monitoring, Assurance & Continuous Improvement** — *(Purpose cannot currently be stated from evidence — see §5. Provisionally: ongoing, post-delivery performance monitoring and continuous improvement of an implemented solution, extending Service 7's one-off verification into something sustained.)*
9. **Technology Innovation & R&D Support** — Helps organisations develop, independently validate, and secure innovation-specific funding for emerging technologies — a parallel track to the core efficiency/decarbonisation lifecycle (Services 1–2/4/5–6–7), not a stage within it.

---

## 3. Boundary Rules

The governing rules for the four issues `CONTENT-002` identified, stated as decisions.

### Rule A — Service 1 vs. Service 6 (diagnostic depth)

**"Energy studies" and "efficiency assessments" belong to Service 1 when broad and exploratory; the same underlying activity belongs to Service 6 once it is scoped to a specific identified opportunity and produced to investment-approval standard.**

- Service 1 owns: comprehensive analysis of *current* consumption across a site (establishing the baseline), identification of *candidate* efficiency/decarbonisation *options* (a list, not yet a business case).
- Service 6 owns: the feasibility study that takes *one* of those candidate options and builds it into a capital-approval-ready case (financial modelling, investment appraisal, risk assessment, environmental impact assessment).
- Test: if the output is "here is where problems might be," it's Service 1. If the output is "here is the business case for this specific fix," it's Service 6.

### Rule B — Service 2 vs. Service 5 (fuel switching / renewable integration)

**The same engineering technique is owned by whichever service matches the business driver behind it.**

- Fuel switching or renewable integration undertaken to reduce operating cost or improve process efficiency of an existing system → **Service 2**.
- Fuel switching or renewable integration undertaken to reduce carbon intensity of the energy supply itself, including hydrogen adoption, solar thermal, and thermal storage → **Service 5**.
- Test: if the primary stated business driver is cost/efficiency, it's Service 2. If the primary stated business driver is decarbonisation/carbon exposure, it's Service 5. A project can (and often will) deliver both outcomes — ownership follows the *primary driver*, not every resulting benefit.

### Rule C — Service 2 vs. Service 6 (newly identified while building this document's capability matrix — not previously flagged in CONTENT-002)

Process optimisation, heat recovery design, and utilities optimisation appear in both services' capability lists in `CONTENT-001`. This is a Stage/Domain split, not a duplication, once made explicit:

- **Service 6** owns the *design and specification* of these interventions, as part of building the investment case (the "Engineer the solution" step in IEP's own methodology, which happens before funding is secured).
- **Service 2** owns being the *domain* under which the delivered, installed outcome is described and case-studied, once Service 7 has funded and delivered it.
- Test: if the content describes deciding what to build and proving it's worth building, it's Service 6. If the content describes the finished, installed result and its measured outcome, it's Service 2.

### Rule D — Service 7 vs. Service 9 (grant funding)

**Funding capability is owned by whichever lifecycle the funded project belongs to.**

- Funding for an efficiency, water/wastewater, or decarbonisation project that has been through Screening (1) and Feasibility (6) → **Service 7**, regardless of whether the funding mechanism happens to be a general government grant.
- Funding specifically tied to developing, piloting, or validating a new/emerging technology (Innovate UK, Horizon Europe, or equivalent innovation-specific programmes) → **Service 9**, because the underlying project belongs to the Adjacent Offering track, not the core Stage lifecycle.
- Test: ask what's being funded. A capital efficiency upgrade → Service 7. A technology that doesn't exist in proven form yet → Service 9.

### Rule E — Terminology hierarchy ("decarbonisation" / "low-carbon" / "net-zero" / "carbon reduction")

Not a capability-ownership rule, but a language rule, to stop the terms drifting further as content is developed:

- **"Decarbonisation"** — the umbrella outcome term. May appear anywhere a service's outcome reduces carbon, including as a Service 1 diagnostic *output category* ("identifying decarbonisation options").
- **"Low-carbon energy systems"** — Service 5's specific engineering domain (supply-side transition). Not used as a synonym for "decarbonisation" generally elsewhere.
- **"Net-zero"** — reserved for a stated, complete (100%) outcome, as in Service 5's Case 6. Not used loosely as a synonym for "significant reduction."
- **"Carbon reduction"** — a results/statistics word (case-study outcome reporting), usable in any service's Deliverables section where a case study reports a carbon figure, regardless of which service delivered it.

---

## 4. Capability Assignment Matrix

Every capability currently documented across the 9 `CONTENT-001` service files, assigned to its owning service per the rules above. "Supporting Evidence" capabilities are not owned by any single service — see §5.

| Capability | Owning Service | Rule Applied |
|---|---|---|
| Site surveys, utilities assessments, gap analysis, process mapping, instrumentation upgrades, data collection & validation | 1 — Opportunity Screening | Diagnostic baseline work |
| Opportunity identification | 1 — Opportunity Screening | Diagnostic output |
| Energy studies (broad consumption analysis) | 1 — Opportunity Screening | Rule A |
| Efficiency/decarbonisation *options* identification | 1 — Opportunity Screening | Rule A |
| Energy audits, monitoring & reporting, energy reduction strategies | 2 — Energy, Utilities & Process Efficiency | Domain ownership |
| Industrial utilities optimisation (steam, refrigeration, compressed air, CO₂) | 2 — Energy, Utilities & Process Efficiency | Domain ownership |
| Fuel switching (efficiency/cost-driven) | 2 — Energy, Utilities & Process Efficiency | Rule B |
| Manufacturing efficiency, operational excellence (delivered outcome) | 2 — Energy, Utilities & Process Efficiency | Domain ownership |
| Waste heat recovery engineering — delivered/installed (heat exchangers, thermal batteries) | 2 — Energy, Utilities & Process Efficiency | Rule C (delivered stage) |
| CFD, FEA, AI process simulation, thermo-fluid modelling, Aspen Plus, CAD | *Supporting Evidence* | See §5 |
| Water and wastewater systems engineering | 4 — Water, Wastewater & Circular Resource Management | Domain ownership |
| Anaerobic digestion plant specification/design/installation | 4 — Water, Wastewater & Circular Resource Management | Domain ownership |
| Biogas recovery and on-site treatment | 4 — Water, Wastewater & Circular Resource Management | Domain ownership |
| Protein recovery, biomass fuel production, zero-waste operation design | 4 — Water, Wastewater & Circular Resource Management | Domain ownership |
| Decarbonisation planning (delivered engineering, not diagnostic naming) | 5 — Low-carbon & Resilient Energy Systems | Rule E |
| Renewable energy integration, hydrogen, solar thermal, thermal storage, electrification strategy | 5 — Low-carbon & Resilient Energy Systems | Domain ownership |
| Fuel switching (decarbonisation-driven) | 5 — Low-carbon & Resilient Energy Systems | Rule B |
| *("Resilient" capability)* | *Unassigned — pending client input* | See §6 |
| Mass/energy balances, cost analysis, financial modelling, investment appraisal, risk assessment | 6 — Engineering Design, Feasibility & Investment Case | Stage ownership |
| Feasibility studies (investment-grade) | 6 — Engineering Design, Feasibility & Investment Case | Rule A |
| Process optimisation, heat recovery design, utilities optimisation, waste-to-resource design — *design/specification stage* | 6 — Engineering Design, Feasibility & Investment Case | Rule C (design stage) |
| Environmental impact assessments | 6 — Engineering Design, Feasibility & Investment Case | Stage ownership |
| Strategic assessments, improvement roadmaps, implementation support | 6 — Engineering Design, Feasibility & Investment Case | Stage ownership |
| Government/general grant funding, grant application management | 7 — Funding, Procurement & Project Delivery | Rule D |
| Procurement process management, EPC contractor supervision | 7 — Funding, Procurement & Project Delivery | Stage ownership |
| Technical specifications, project management | 7 — Funding, Procurement & Project Delivery | Stage ownership |
| Commissioning, one-off post-implementation performance verification | 7 — Funding, Procurement & Project Delivery | Stage ownership |
| *(No capability currently evidenced)* | 8 — AI-enabled Monitoring, Assurance & Continuous Improvement | See §5 |
| Technology assessment, pilot project development, demonstrator programmes | 9 — Technology Innovation & R&D Support | Adjacent-offering ownership |
| Innovate UK / Horizon Europe applications, technical due diligence | 9 — Technology Innovation & R&D Support | Rule D |
| Independent performance validation, technology-readiness assessment, independent technical review, commercial-viability assessment, risk evaluation, investment analysis & funding (innovation-specific) | 9 — Technology Innovation & R&D Support | Adjacent-offering ownership |

---

## 5. Supporting Evidence (not owned by any single service)

**Technical Validation & Simulation Capability** — CFD, FEA, AI process simulation, thermo-fluid system modelling, industrial process modelling (Aspen Plus), CAD, electrical circuit design.

This is the entirety of what was previously presented as Service 3 (Product Design & Optimisation). Per `CONTENT-002`'s strongest finding — corroborated directly by `PDC-001` Article VIII, which already defines "Technical Capability" as homepage narrative stage 7, distinct from "Services" at stage 5 — this capability is **not a standalone, independently purchasable service**. No evidence source describes a client engaging IEP for this capability in isolation, a business challenge it solves on its own, or a deliverable it produces independently.

**Its role in the portfolio:** supporting validation evidence referenced from within Services 2, 4, 5, and 6, wherever a claim benefits from "this was modelled/simulated before being recommended." It should be *authored* as credibility content (team expertise, modelling capability, "how we validate before you commit capital") rather than as a service with its own business-challenge-to-deliverable arc.

**What does not change:** Service 3 remains one of the 9 client-approved catalogue titles and retains its own `cspt-service` entry for CMS/data purposes — this document does not have authority to remove an approved catalogue item (see "What this is," above). What changes is how its content should be authored and how it should be presented in navigation (see §7).

**Service 8's single evidence fragment** ("...R&D and AI applications for energy management," from Dr Asthana's biography) is too thin to generalise into a supporting-evidence capability the way Service 3's content could. It remains parked as a single sourced sentence, per `CONTENT-001`'s and `CONTENT-002`'s existing recommendation, not promoted into this section.

---

## 6. Status Flags

Two services carry a status flag distinct from the other seven, which are all cleared for content development under the rules above.

### Service 3 — Product Design & Optimisation: **Reclassified — Supporting Capability, Not Standalone Service**
Content development should proceed as credibility/capability material embedded within Services 2, 4, 5, and 6 (per §5), not as an independent service page with its own business-challenge narrative. If future client input establishes a genuine standalone "product design" engagement (see `CLIENT-QUESTIONS.md` items 5–7), this flag should be revisited — this document does not foreclose that possibility, it simply reflects what the evidence supports today.

### Service 8 — AI-enabled Monitoring, Assurance & Continuous Improvement: **Pending — Not Ready for Content Development**
Per `CONTENT-002`, publishing this service beyond its single sourced sentence would violate `PDC-001` Article VII (Messaging Hierarchy) and Article VIII stage 5 (services must map to an established commercial challenge), because no business challenge is currently evidenced. This document does not assign it any capability beyond flagging the gap (§4). Resolution requires client input per `CLIENT-QUESTIONS.md` items 1–4, not further internal synthesis — there is no more evidence to extract from existing sources.

### Service 5's "resilient" component: **Unresolved terminology, not a status flag on the whole service**
The "low-carbon" half of Service 5 is fully cleared for content development. The "resilient" half has no capability assignment because no source defines what it means. This is narrower than Service 8's problem — it affects one word in a title, not the service's entire viability — and should be resolved by asking the client directly (`CLIENT-QUESTIONS.md` item 7), not by inference.

---

## 7. Canonical Order

### Catalogue Order (fixed — do not alter)

The 9 services retain the client-approved numbering and titles exactly as given, unchanged by this document:

1. Opportunity Screening & Diagnostic Review
2. Energy, Utilities & Process Efficiency
3. Product Design & Optimisation (incl. CFD, FEA and experimental analysis)
4. Water, Wastewater & Circular Resource Management
5. Low-carbon & Resilient Energy Systems
6. Engineering Design, Feasibility & Investment Case
7. Funding, Procurement & Project Delivery
8. AI-enabled Monitoring, Assurance & Continuous Improvement
9. Technology Innovation & R&D Support

This order governs `display_order` in the CMS-005 field group and any data-model context. It is Tier-1 client-approved and is not this document's to change.

### Presentation Layer (recommended, non-binding — for site navigation/grouping only)

A separate, optional grouping for how the portfolio might be *narrated* on the site, consistent with the Stage × Domain model in §1 and with `PDC-001` Article VIII's existing homepage sequence logic (which already separates "Services" from "Technical Capability" as different stages). This does not renumber the catalogue — it groups the same 9 items under a narrative logic a visitor can follow:

1. **Start here:** Opportunity Screening & Diagnostic Review (1)
2. **What we work on** *(Domain group, order between these three not significant)*: Energy, Utilities & Process Efficiency (2) · Water, Wastewater & Circular Resource Management (4) · Low-carbon & Resilient Energy Systems (5)
3. **How we justify it:** Engineering Design, Feasibility & Investment Case (6) — *validated by the Technical Capability content drawn from Service 3, presented here or cross-linked, not as its own nav item*
4. **How we fund and deliver it:** Funding, Procurement & Project Delivery (7)
5. **Keeping it working** *(flagged Pending — do not present as a live offering until Service 8's status changes)*: AI-enabled Monitoring, Assurance & Continuous Improvement (8)
6. **A parallel track:** Technology Innovation & R&D Support (9)

Adopting this presentation layer is a design/IA decision for the project team to make when the Services page is next built — this document recommends it as consistent with both the evidence and `PDC-001`, but does not mandate it over the client's own preferences if they differ.

---

## 8. Governance

- This document derives its authority from `CONTENT-002`'s findings and, through it, from the same Primary Sources `CONTENT-001` cites — it introduces no new project facts, only a structural model (Stage × Domain) for organising facts already established.
- Per `KNOWLEDGE-SOURCES-001`'s Repository Authority Principle, this document — like all repository-derived documents — remains subordinate to any actual client-approved evidence. If the client confirms a different capability boundary, a different service classification, or resolves Service 8 or the "resilient" question, that confirmation overrides this document, not the reverse.
- Recommend this document pass Architecture Review before being treated as binding for future content missions, consistent with how `PDC-001` itself was frozen only after AQR-006. Until then, its status is **Materialized**, not **Frozen**.
- Future amendments to this document should be incremental (per `KNOWLEDGE-SOURCES-001`'s Incremental Evolution principle) — e.g. lifting Service 8's Pending flag once client input arrives — not a wholesale rewrite.
