# CMS-005 v1.1 — Service Catalogue Migration Report

**Trigger:** OPERATION PHOENIX / CMS-005A — a newer client-approved service catalogue (9 services) supersedes the 7-service model this package originally shipped with (2026-07-12).
**Scope:** mapping only. No field content is authored here — see "Content status" below and `DECISIONS.md`'s v1.1 addendum for why.

## Old → New mapping

| # | Old Service (v1.0) | ↓ | New Service (v1.1) | Type | Reason |
|---|---|---|---|---|---|
| 1 | Energy Management | ↓ | Energy, Utilities & Process Efficiency | **Merged** (with #3) | Old title's scope (energy audits, monitoring & reporting, energy reduction strategies) is a direct subset of the new title's "Energy, Utilities" wording. |
| 3 | Industrial Engineering | ↓ | Energy, Utilities & Process Efficiency | **Merged** (with #1) | Old title's scope (process optimisation, manufacturing efficiency, operational excellence) maps to the new title's "Process Efficiency" wording. Not mapped to New #3 (Product Design & Optimisation) — that title is specifically CFD/FEA/experimental design simulation, a different technical domain from process optimisation. |
| 2 | Sustainability & Net Zero | ↓ | Low-carbon & Resilient Energy Systems | **Renamed** | Old title's scope (carbon reduction, sustainability programmes, decarbonisation planning) is the direct predecessor of "low-carbon... energy systems." |
| 4 | Consultancy & Advisory | ↓ | Engineering Design, Feasibility & Investment Case | **Renamed / narrowed** | Old title's scope (strategic assessments, improvement roadmaps, implementation support) is generic advisory; the new title keeps the same "assessment → roadmap → decision" shape but scopes it specifically to engineering design, feasibility, and investment case. |
| 5 | Training & Development | ↓ | *(none)* | **Removed** | No title in the new catalogue references training, workshops, or knowledge transfer. **Flagged for client confirmation, not assumed final** — see Open Question below. |
| 6 | Research & Development support | ↓ | Technology Innovation & R&D Support | **Merged** (with #7) / **Renamed** | Direct title continuity ("R&D support" → "R&D Support"). |
| 7 | Technology validation | ↓ | Technology Innovation & R&D Support | **Merged** (with #6) | Old title's "technology-readiness assessment" and "Innovate UK & Horizon Europe applications" language (from #6) are both innovation/R&D-support activities. Note: "independent performance validation" has secondary conceptual overlap with New #8 (AI-enabled Monitoring, Assurance & Continuous Improvement) — flagged here in case the client intends a split, but this report maps it as a single merge into #9 since splitting one old service across two new ones isn't supported by anything in the approved titles themselves. |
| — | *(none)* | ↓ | Opportunity Screening & Diagnostic Review | **New** | No predecessor in the v1.0 migrated services. Echoes CMS-003's existing Global Settings primary CTA text ("Book Opportunity Screening") and the "Energy studies / Efficiency assessments" items from the live Services page's third list, which v1.0's `DECISIONS.md` §1 had classified as page-level process narrative rather than a distinct service — worth noting since the client's new catalogue promotes this into an explicit named service. |
| — | *(none)* | ↓ | Product Design & Optimisation (incl. CFD, FEA, experimental analysis) | **New** | No predecessor — a new engineering-simulation capability not present in the old 7-service or the excluded-narrative content. |
| — | *(none)* | ↓ | Water, Wastewater & Circular Resource Management | **New** | No predecessor anywhere in v1.0's verified content. |
| — | *(none)* | ↓ | Funding, Procurement & Project Delivery | **New (promoted)** | No predecessor among the 7 migrated services, but directly corresponds to "Grant funding / Procurement support / Project delivery" from the live page's third list — which v1.0's `DECISIONS.md` §1 explicitly excluded as page-level methodology narrative, not a service. The client's new catalogue now treats this as a named service in its own right, which supersedes (not invalidates) that earlier read — §1 was a reasonable call on the evidence available at the time. |
| — | *(none)* | ↓ | AI-enabled Monitoring, Assurance & Continuous Improvement | **New** | No predecessor. Distinct from Old #7 (Technology validation) — that was a one-off validation/assessment activity; this title's "monitoring... continuous improvement" framing describes an ongoing service, not a point-in-time assessment. See the note under #7 above for the one place these two ideas brush up against each other. |

## Summary

- **Merged:** 2 events — (Energy Management + Industrial Engineering) → Energy, Utilities & Process Efficiency; (Research & Development support + Technology validation) → Technology Innovation & R&D Support.
- **Renamed:** 2 — Sustainability & Net Zero → Low-carbon & Resilient Energy Systems; Consultancy & Advisory → Engineering Design, Feasibility & Investment Case.
- **Removed:** 1 — Training & Development (no successor title; flagged, not assumed dropped for good).
- **New:** 5 — Opportunity Screening & Diagnostic Review; Product Design & Optimisation; Water, Wastewater & Circular Resource Management; Funding, Procurement & Project Delivery (promoted from previously-excluded page narrative); AI-enabled Monitoring, Assurance & Continuous Improvement.
- **Old services accounted for:** 7 of 7. **New services accounted for:** 9 of 9.

## Content status (important)

This report maps **titles only**. It does **not** carry v1.0's sourced Executive Summary / Key Benefits copy over onto the new titles, even for the "Renamed"/"Merged" rows, because:

1. Merged and renamed titles have a broader or differently-scoped remit than their predecessor(s) — e.g. "Energy, Utilities & Process Efficiency" is not simply "Energy Management" relabelled, it explicitly adds "Utilities." Reusing old copy verbatim would silently assert the new service's scope matches the old one's, which is an inference beyond what the approved title says.
2. The mission's Repository Rules explicitly prohibit inventing descriptions/marketing copy or inferring capabilities beyond the approved titles.

All 9 new services' `executive_summary`, `full_description`, and `key_benefits` are therefore **not yet sourced** — see the updated migration table in `IMPLEMENTATION-GUIDE.md` and `DECISIONS.md`'s v1.1 addendum. Only `display_order` (taken directly from the client's own numbered list) is populated at migration time.

## Open question for the client

Training & Development (old #5) has no home in the new catalogue. Recommend confirming with the client whether this is:
(a) intentionally dropped as a standalone service, or
(b) folded into another service's delivery (e.g. as part of implementation support under Engineering Design, Feasibility & Investment Case) without a title of its own, or
(c) an omission to be added back as a 10th service.

Not resolved in this package — resolving it is a content decision, not an architecture one.
