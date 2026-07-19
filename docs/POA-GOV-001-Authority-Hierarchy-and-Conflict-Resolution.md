---
id: POA-GOV-001
title: Authority Hierarchy & Conflict Resolution
purpose: Formalizes the organization-wide governance layer of the Paravyoma Organizational Architecture (POA) — how the Constitution, Repository, Engineering Orders, and Organizational Case Law relate, and how conflicts between them are resolved
repository_layer: Governance (POA-GOV)
status: Materialized — pending Architecture Review
version: 1.0.0
owner: TBD
last_updated: 2026-07-14
---

# POA-GOV-001 — Authority Hierarchy & Conflict Resolution

## Repository Position

**Depends On**
- `KNOWLEDGE-SOURCES-001` (§4 Authority Hierarchy, §5 Conflict Resolution, §9 AI Behaviour — this document generalizes these from "knowledge sources" to the full organizational architecture; it does not replace or re-derive them)
- `PDC-001` Article XII (Constitutional Governance — Authority, Repository Precedence, Implementation Compliance)
- `PDC-A001` (AMD-4 — the first recorded instance of a live implementation conflicting with a client-approved source being flagged rather than silently resolved)
- `docs/EO-DEL002-001-Homepage-Constitutional-Audit.md` (the DEL-002 incident — the first recorded instance of an Engineering Order itself conflicting with the Repository's governing model; the operational trigger for this document's materialization)

**Enables**
- `POA-CASE-001` and all future `POA-CASE-###` documents (this document supplies the governing rules that case law is evaluated against)
- `POA-META-001` (this document is registered there as the first `POA-GOV` family member)
- All future Engineering Orders — this document is the reference an Engineering Corps session consults when an EO appears to conflict with the Repository

**Materialization note:** No `POA-GOV-*` document existed prior to this one. This document does not invent new governance — it collects and formalizes rules already operating in this repository (`KNOWLEDGE-SOURCES-001`, `PDC-001` Article XII) and extends them, using the DEL-002 incident as evidence, to a document type — Engineering Orders — that did not exist in the repository's vocabulary when those rules were first written. Every rule below traces to either an existing repository document or a directly observed incident; none is asserted without that trace.

---

## 1. Purpose

This document governs how the four capabilities of the Paravyoma Organizational Architecture — **Believes** (Constitution), **Knows** (Repository), **Acts** (Engineering Orders & Execution), and **Learns** (Organizational Case Law) — relate to one another, and defines the authority hierarchy and conflict-resolution procedure that applies when they disagree. It exists because those four capabilities were, until the DEL-002 incident, integrated only implicitly: `PDC-001` Article XII governs the Constitution's own authority; `KNOWLEDGE-SOURCES-001` governs knowledge-source authority; nothing previously governed how a live, in-session Engineering Order relates to either. This document closes that gap.

This document does not govern project *content* (positioning, design, service catalogue, homepage narrative — that remains `PDC-001`'s and its amendments' domain). It governs the *process* by which any instruction, at any layer, is checked against the Repository before being acted on.

## 2. First Principles

Restated from Mission Control's own framing at the launch of Operation JURIS, as the founding statement of this document:

| Capability | POA Component | Function |
|---|---|---|
| Believes | Constitution (`PDC-001` + amendments) | What the organization holds to be true and governing |
| Knows | Repository (`KNOWLEDGE-SOURCES-001` + all derived documents) | What the organization has evidenced and recorded |
| Acts | Engineering Orders & Execution | How the organization does work |
| Learns | Organizational Case Law (`POA-CASE-*`) | How the organization improves its own governance from what execution reveals |

These four capabilities form one operating cycle, not four independent systems. An Engineering Order that Acts without checking what the organization Believes and Knows is not executing the architecture — it is bypassing it. A conflict discovered during Acts that is resolved silently, without being written back into Learns, teaches the organization nothing and will recur.

Additional first principles, already established and carried forward from existing repository documents rather than newly asserted here:

- **Repository First.** The repository, not chat history or working memory, is the durable record. *(`KNOWLEDGE-SOURCES-001` §6.)*
- **Constitution Before Implementation.** No implementation proceeds ahead of, or in place of, constitutional grounding. *(`PDC-001` Article XII, Implementation Compliance; restated directly as an Engineering Principle in `EO-DEL002-001`.)*
- **Metadata/Evidence Drives Presentation, Not the Reverse.** Derived documents interpret evidence; they do not become evidence themselves. *(`KNOWLEDGE-SOURCES-001` §2, Evidence Classification.)*
- **Evidence Before Recommendation.** A recommendation is labelled as such and never silently promoted to fact. *(`KNOWLEDGE-SOURCES-001` §6, Separation of Facts and Recommendations.)*
- **No Architectural Drift.** A live implementation that diverges from an approved source is a defect in the implementation, not a silent redefinition of the source. *(`KNOWLEDGE-SOURCES-001` §5, Repository Authority Principle; validated in practice by `PDC-A001` AMD-4.)*

## 3. Authority Hierarchy

This generalizes `KNOWLEDGE-SOURCES-001` §4's nine-tier hierarchy — originally scoped to knowledge sources — to the full POA architecture, with one addition: **Engineering Orders are now explicitly placed**, using the DEL-002 incident as the evidence for where they belong.

| Tier | Layer | Examples | Notes |
|---|---|---|---|
| 1 | Latest explicit Mission Control approval | A decision Mission Control confirms as final, in the form of an approved Constitutional Amendment or an explicit, unambiguous sign-off | Supreme. Overrides every other tier. |
| 2 | Signed proposal / agreed scope | Project Proposal, Statement of Work, Commercial Proposal | Unchanged from `KNOWLEDGE-SOURCES-001` §4. |
| 3 | Client review documents | `CRN-001` and successors | Unchanged. |
| 4 | Questionnaire | Client Questionnaire | Unchanged. |
| 5 | Brochure | IEP Brochure | Unchanged. |
| 6 | Sitemap | Approved Sitemap | Unchanged. |
| 7 | Wireframes | Homepage Wireframe | Unchanged. |
| 8 | Repository derived documents | `PDC-001`, `PDC-A001`, Specifications, Missions, **Engineering Orders**, Case Law | **New in this document:** Engineering Orders are placed here, not at Tier 1. An Engineering Order directs *how* work is executed; it is not itself a Tier 1 approval unless it explicitly and unambiguously records a Mission Control decision to amend the Constitution. See §4 and §7 for the reasoning and the DEL-002 case that established it. |
| 9 | AI recommendations | Engineering Corps proposals, suggested interpretations | Unchanged — always subordinate. |

**Placement rule for Engineering Orders (new):** An Engineering Order's *instructions* (what work to do, in what order, to what standard) are always actionable at Tier 8 authority. An Engineering Order's *embedded content* that describes or implies project facts — a visitor-journey model, a positioning statement, a claim of client approval — is evidence only if it is traceable to a Tier 1–7 source; otherwise it is treated as an Engineering Corps-facing instruction to be checked against the Repository, not as new Tier 1–7 evidence in its own right, however confidently or authoritatively it is phrased.

## 4. Conflict Resolution Algorithm

When an instruction (an Engineering Order, a Mission, or any other input) appears to conflict with the Repository, the following procedure applies, in order:

1. **Identify the conflict precisely.** State what the instruction says, what the Repository says, and the specific point of disagreement. Do not proceed past this step on a vague sense that something is "off" — the conflict must be nameable.
2. **Locate each side's Authority Tier**, per §3. Compare tiers, not confidence, phrasing, or recency of delivery.
3. **If the instruction is Tier 1–7 evidence** (an explicit Mission Control approval, or traceable to signed scope, client review, questionnaire, brochure, sitemap, or wireframe) **and the Repository's position is Tier 8 or below** (a Specification, Mission, or prior Engineering Order): the instruction wins. Update the Repository — via the appropriate mechanism (a new Constitutional Amendment for Constitution-level facts, a Specification update otherwise) — to reflect it. This is not silent override; it is evidence promotion, and it is logged.
4. **If the instruction is Tier 8 or below** (an Engineering Order's own embedded content, not traceable to Tier 1–7 evidence) **and the Repository's position is Tier 1–7, or is a Derived Document that is itself traceable to Tier 1–7 evidence** (e.g. `PDC-001`, `PDC-A001`): the Repository wins. The instruction is **not** silently followed and is **not** silently discarded — it is flagged back to Mission Control per §8 (Escalation Model), with the specific conflict named per step 1.
5. **If both sides are the same tier** (e.g. two Tier 8 documents disagree): the more recent, more specific, or more directly-evidenced document governs, consistent with `KNOWLEDGE-SOURCES-001` §5's "latest approved decision wins within a tier" — but only if that recency itself is traceable to an actual approval event, not merely to which file was edited last.
6. **Record the resolution.** Every conflict resolved under this algorithm that reaches step 4 (Repository overrides instruction) is a candidate for `POA-CASE` documentation per §9 — this is how the organization Learns from what Acting revealed.
7. **Never resolve silently.** At every step above, the losing side of a conflict is named and the reason recorded — never quietly dropped or quietly substituted. This is unchanged from, and restates, `KNOWLEDGE-SOURCES-001` §9's "Identify conflicts" rule and `PDC-001` Article XII's "the conflict shall be flagged rather than silently resolved."

## 5. Governance Rules

Concrete, checkable rules — the operational form of the principles above. Each traces to an existing repository rule or the DEL-002 incident; none is newly invented.

1. **An Engineering Order shall not silently redefine a Constitutional Article or Amendment.** Where an EO's content conflicts with `PDC-001` or a `PDC-A###` amendment, the conflict is flagged per the Algorithm above, not implemented. *(New — extends `PDC-001` Article XII to Engineering Orders specifically, evidenced by DEL-002.)*
2. **No Derived Repository Document may assert authority over the Tier 1–7 evidence it derives from.** *(`KNOWLEDGE-SOURCES-001` §5, Repository Authority Principle — unchanged, restated for the full architecture.)*
3. **Amendments are additive.** A frozen or approved document is never edited in place to record a change; a new amendment document is created that depends on it. *(`PDC-A001`'s own construction — "does not edit `PDC-001`'s own text" — and `KNOWLEDGE-SOURCES-001` §10, "refined, not rewritten.")*
4. **Every conflict resolution is traceable.** A resolved conflict names both sides, their tiers, and the resolution reached — never a bare outcome with no visible reasoning. *(`KNOWLEDGE-SOURCES-001` §7, Traceability Rules, extended to conflict events specifically.)*
5. **Observation is not doctrine.** A single incident, however clear, is recorded as `POA-CASE` evidence at Validation Status "Observed" and is not treated as a binding rule for future missions until corroborated by a second independent incident (Validation Status "Corroborated") and confirmed by Architecture Review (Validation Status "Validated Precedent"). *(New — the explicit governance need identified by Operation JURIS's own Engineering Rules: "Do not elevate observations into constitutional principles without explicit evidence.")*
6. **Case Law informs but does not bind future Engineering Orders on its own authority.** A `POA-CASE` document at "Observed" status is persuasive — it tells a future Engineering Corps session what happened once and why — but only a "Validated Precedent," confirmed via Architecture Review, carries the same operational weight as a Governance Rule in this document. *(New — direct consequence of Rule 5 and the Validation Process, §9.)*
7. **The Repository is checked before an Engineering Order is executed, not after.** Where an EO's scope touches an area governed by `PDC-001`, `PDC-A001`, or any Specification, the Engineering Corps confirms consistency before implementation begins — this audit-then-execute sequence is exactly what `EO-DEL002-001`/`EO-DEL002-002`'s own two-phase structure (audit first, implementation gated on Mission Control approval) already demonstrates and this rule generalizes it as standard practice.

## 6. Operational Doctrines

Doctrines differ from Governance Rules (§5) in kind: a Governance Rule is a designed constraint stated once and binding from the moment it is written. A Doctrine is a *repeatedly observed practice*, evidenced across multiple, independent missions, that has proven itself reliable enough to state as expected default behaviour — but remains open to revision if a future case contradicts it. The following are recorded as Doctrines specifically because each has been independently observed more than once in this repository's history (contrast with `POA-CASE-001`, §9 below, which records a principle observed exactly *once*):

1. **Flag conflicts explicitly rather than silently resolving them.** Observed independently in `PDC-A001` AMD-4 (a live homepage order conflicting with `CRN-001`/Article VIII, flagged rather than either silently "corrected" in the Constitution or silently left as-is) and in `EO-DEL002-001` (an Engineering Order's visitor-journey template conflicting with `PDC-A001`, flagged rather than either silently implemented or silently ignored). Two independent instances — qualifies as Doctrine, not merely Observed.
2. **Verify live state directly before trusting prior documentation or memory.** Observed across `CMS-BOOT-001`, `CMS-BOOT-002`, `CONTENT-004`, and repeatedly within this session's own CMS-005A cache-debugging and `EO-DEL002-001` audit work (cache-busted fetches, direct `_elementor_data` extraction, rather than trusting the last-known state). Multiple independent instances — Doctrine.
3. **Additive amendment over in-place editing.** Observed in `PDC-A001` (did not edit `PDC-001`) and in this document's own construction relative to `KNOWLEDGE-SOURCES-001` (extends, does not edit). Doctrine.

## 7. Roles & Responsibilities

Roles already evidenced in this repository's operating history, formalized here rather than newly invented:

- **Mission Control** — issues Engineering Orders, holds Tier 1 authority, is the sole party who can convert a Repository-vs-Instruction conflict into a formal Constitutional Amendment. Receives escalations per §8.
- **Engineering Corps** (the AI collaborator executing Engineering Orders) — executes Tier 8-authority instructions, applies the Conflict Resolution Algorithm (§4) before and during execution, never silently resolves a Tier 1–7-vs-Tier-8 conflict in either direction, and is responsible for surfacing candidate `POA-CASE` material per §9 when a conflict resolution sets a reusable precedent.
- **Architecture Review** (the existing `AQR-###` process, e.g. `AQR-001`, `AQR-006`) — the only body empowered to promote a Corroborated case to Validated Precedent, or to approve a new Constitutional Amendment. Unchanged from its existing role in `PDC-001` Article XII and `KNOWLEDGE-SOURCES-001`'s Repository Lifecycle — this document does not create a new review body, it clarifies what Architecture Review's approval now also gates (case-law promotion).
- **The Repository itself** — not an actor, but the governing artifact every role above is accountable to. Per `KNOWLEDGE-SOURCES-001` §6, "if it isn't in the repository, it isn't established" — this applies equally to governance decisions made under this document.

## 8. Escalation Model

1. **Engineering Corps detects a conflict** during Algorithm step 1 (§4).
2. **Engineering Corps classifies the conflict** by tier (Algorithm step 2) and determines whether it resolves automatically (steps 3, 5) or requires escalation (step 4).
3. **Where escalation is required**, Engineering Corps states the conflict plainly to Mission Control — both positions, their tiers, and the specific point of disagreement — and does not proceed with implementation on the disputed point until a decision is returned. This is exactly the pattern `EO-DEL002-001` followed: the audit report named the EO-template-vs-`PDC-A001` conflict and explicitly asked Mission Control to confirm intent before `EO-DEL002-002` (implementation) would proceed.
4. **Mission Control resolves the escalation** in one of two ways:
   - Confirms the Engineering Order's content was non-binding shorthand or a simplification not intended to override the Repository — no Repository change occurs, and the resolution itself may become `POA-CASE` material (§9).
   - Issues an explicit, Tier 1 decision to amend the Constitution or a Specification — the Repository is updated via the normal amendment mechanism (a new `PDC-A###` or Specification revision), and the resolution is logged in `POA-CASE` as a Repository-evolution event.
5. **No conflict is left unresolved and unrecorded.** An escalation without a returned decision blocks the disputed portion of implementation indefinitely, per Governance Rule 7 (§5) — it does not default to either side by inaction.

## 9. Validation Process

Governs how a governance idea moves from a single incident to a binding rule — the mechanism `POA-CASE` documents exist to drive.

```
Incident occurs
   ↓
Recorded as POA-CASE-### at Validation Status: Observed
   ↓ (a second, independent incident reaches the same resolution)
Validation Status: Corroborated
   ↓ (Architecture Review confirms the principle should bind future missions)
Validation Status: Validated Precedent
   ↓ (Architecture Review elevates it into this document, or into PDC-001 via a new Amendment)
Promoted to a Governance Rule (§5) or a Constitutional Amendment (PDC-A###)
```

- **Observed** (single incident): persuasive only. Cited in future missions as "this happened once, here's what was decided" — not treated as binding.
- **Corroborated** (two or more independent incidents, same resolution): stated as a candidate Doctrine (§6) — the Engineering Corps may treat it as expected default behaviour, but Architecture Review has not yet confirmed it.
- **Validated Precedent** (Architecture Review confirmed): binding — equivalent in force to a Governance Rule in this document until superseded.

This mirrors, deliberately, the Repository Lifecycle already established in `KNOWLEDGE-SOURCES-001` §10 (Draft → Materialized → Architecture Review → Approved → Frozen) — Validation Status is that same discipline applied to precedent rather than to a single document's own maturity.

**Explicit constraint, restated from Operation JURIS's own Engineering Rules:** no Engineering Corps session may unilaterally mark a `POA-CASE` document's Validation Status as "Corroborated" or "Validated Precedent" without the evidence this section requires (a second independent incident; Architecture Review, respectively). `POA-CASE-001` (§9 of this document's companion) is correctly marked "Observed" and only "Observed," for exactly this reason.

## Source References

**Primary Sources**
- Mission Control's Operation JURIS mission brief (this document's Engineering Order) — direct source for §2's four-capability framing and the mandate to materialize this document
- `docs/EO-DEL002-001-Homepage-Constitutional-Audit.md` — the DEL-002 incident, evidentiary basis for §3's Engineering Order tier placement and §9's Validation Process

**Related Repository Documents**
- `KNOWLEDGE-SOURCES-001` (§2, §4, §5, §6, §7, §9, §10 — generalized, not replaced, by this document)
- `PDC-001` Article XII (Constitutional Governance)
- `PDC-A001` (AMD-4 — first precedent for flagging rather than silently resolving)
- `POA-CASE-001` (the first Case Law document produced under this framework)
- `POA-META-001` (registers this document as the first `POA-GOV` family member)
