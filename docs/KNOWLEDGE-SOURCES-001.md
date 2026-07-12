---
Document:
  KNOWLEDGE-SOURCES-001.md

Lifecycle:
  Frozen

Architecture Review:
  AQR-001 Passed

Repository Layer:
  Knowledge

Baseline:
  Repository Baseline v1.0
id: KNOWLEDGE-SOURCES-001
title: Knowledge Sources
purpose: The repository's authoritative index of project knowledge sources, their authority level, evidence/verification status, and how conflicts between them are resolved
status: Approved
version: 1.0.0
owner: TBD
last_updated: 2026-07-05
---


## Repository Metadata

Repository Layer:
Knowledge

Document Type:
Knowledge Register

Parent:
README.md

Children:
PDC-001
DL-001
DSS-001
CMS-001
SEO-001
Mission Documents

## Repository Scope

This document governs only the knowledge contained within the IEP Website Repository.

It indexes project evidence.

It does not replace client documentation.

It does not own project decisions.

Project decisions are established within the Project Design Constitution (PDC-001).

This document exists solely to identify, classify and govern project knowledge sources.

## Repository Lifecycle

Every repository document follows the same lifecycle.

Draft

↓

Materialized

↓

Architecture Review

↓

Approved

↓

Frozen

↓

Superseded

↓

Archived

Knowledge Sources has now reached
Frozen Version 1.0.

# KNOWLEDGE-SOURCES-001 — Knowledge Sources

This document is the authoritative knowledge register for the IEP Website Repository. It catalogs every approved knowledge source, defines its authority, verification status and repository usage. It is not a summary of the project.

## 1. Purpose

This document defines the project's evidence base and authority hierarchy. It records where project knowledge originates, how authoritative each source is relative to the others, how conflicts between sources are resolved, and how every other document in this repository is expected to derive its information. No repository document — Constitution, Specification, Mission, or Record — should assert a project fact without that fact being traceable to a source catalogued here.

## 2. Repository Knowledge Model

This repository distinguishes five layers of documents, each derived from the layer above it:

**Source Documents**
External, client-originated or client-derived evidence — proposals, questionnaires, brochures, sitemaps, wireframes, review notes, email confirmations. These are not authored by this repository; they are ingested into it as evidence. Housed under `references/`.

↓

**Constitution Documents**
Foundational, project-wide principles and constraints synthesized from Source Documents. There is one constitution: `PDC-001-Project-Design-Constitution.md`. Every statement in a Constitution Document must trace back to one or more Source Documents.

↓

**Specification Documents**
Concrete, implementable specifications derived from the Constitution — design language, design system, CMS architecture, performance/SEO standards (`DL-001`, `DSS-001`, `CMS-001`, `SEO-001`). Specifications elaborate the Constitution; they do not introduce new project facts that aren't already grounded in it or in a Source Document.

↓

**Mission Documents**
Scoped units of implementation work derived from one or more Specifications (`missions/CLAUDE-###-*.md`). A Mission should be traceable to the Specification(s) it implements.

↓

**Record Documents**
Documents that capture the evolution of the project over time rather than prescribing it — the Design Decision Register (`DDR-001`) and the Changelog. Records observe and log what happened across the other four layers; they do not originate new requirements.

### Evidence Classification

The five-layer model above collapses into two categories for evidentiary purposes:

**Primary Knowledge Sources** — original client or project artefacts: Proposal, Scope of Work, Client Questionnaire, IEP Brochure, Approved Sitemap, Homepage Wireframe, Designer Instructions, Client Review Notes, Email Confirmations. These are the "Source Documents" layer above. They are evidence.

**Derived Repository Documents** — everything generated from Primary Sources: `PDC-001`, `DL-001`, `DSS-001`, `CMS-001`, `SEO-001`, `DDR-001`, Claude Missions, and `README.md`. These span the Constitution, Specification, Mission, and Record layers above. **They are never evidence.** A Derived Repository Document derives its authority entirely from the Primary Sources it is traceable to (see Section 7, Traceability Rules) — it has no independent standing.

## 3. Knowledge Sources Catalogue

### 3.1 Primary Knowledge Sources

Evidence Status reflects whether the repository currently possesses and has confirmed this source — it is independent of how authoritative the source is (see Section 4, Authority vs Verification). Allowed values: `Verified` (located and content-confirmed), `Referenced` (located, content not yet fully ingested/confirmed), `Pending` (expected, not yet obtained or confirmed), `Missing` (no evidence of this source has been located), `Superseded` (an earlier version exists but has been replaced by a newer one at the same tier), `Archived` (retained for record but no longer active evidence).

| Source Name | Description | Purpose | Primary Topics | Authority Level | Evidence Status | Repository Usage |
|---|---|---|---|---|---|---|
| **Project Proposal** | The commercial/scope engagement document(s) presented to and agreed with the client — comprises a Statement of Work (`IEP_Proposal_Paravyoma_v3.docx`) and a companion Commercial Proposal (`IEP_Commercial_Proposal_Paravyoma - V3.docx`), both dated June 2026. | Establishes the commercial and scope boundary of the engagement. | Engagement scope, deliverables, commercial terms, timeline, project objectives, strategic positioning | Tier 2 — Signed proposal / agreed scope | **Verified** — both v3 documents located and content-confirmed (2026-07-05), used directly to draft `PDC-001` Articles I–III. The Statement of Work carries a signatory block naming Tim Griffiths with a June 9, 2026 date, but the signature field itself is blank in the extracted text — content is confirmed, but full execution/counter-signature is not independently confirmed from the file alone. | Informs `PDC-001` (Articles I–III materialized; non-negotiable constraints, scope boundaries for remaining Articles) |
| **Scope of Work** | A statement of work defining deliverables in more granular/technical terms than the commercial proposal, where one exists as a distinct document. | Defines what is and is not in scope at a working level. | Deliverables, exclusions, phasing | Tier 2 — Signed proposal / agreed scope | **Pending** — not yet confirmed as a separately located document; may be embedded within the Project Proposal rather than standalone | Informs `PDC-001`, Mission scoping |
| **Client Questionnaire** | The client-completed discovery/content-validation questionnaire (`Website Discovery & Content Validation Questionnaire.docx`) and its answered approval record (`...Questionnaire_Approval.docx`). | Captures client-provided facts that cannot be inferred — business details, preferences, constraints. | Business information, content preferences, stated requirements, leadership biographies, design validation | Tier 4 — Questionnaire | **Verified** — both files located and content-confirmed (2026-07-05), used directly to draft `PDC-001` Articles II–III. Note: the §1.1/§1.2 objectives-ranking checkboxes were left unmarked by the client in both versions; §11 (Future Roadmap) was explicitly answered "Nothing decided as of now" — this gap is carried into `PDC-001` Article II as a flagged ambiguity, not silently resolved. | Informs `PDC-001` (Articles II–III materialized), `CMS-001` (content modeling), copy sourcing |
| **IEP Brochure** | The client's existing company brochure, used as sourced content for the website (case studies, services, positioning, results). | Source content — company positioning, service descriptions, results, case studies, leadership. | Company overview, services, case studies, results/statistics, leadership | Tier 5 — Brochure | **Verified** — located and content-confirmed; already used as sourcing evidence for homepage and Case Study copy | Informs `CMS-001` (Case Study / Service / Leadership content modeling), homepage and page copy sourcing |
| **Approved Sitemap** | The client-approved information architecture for the site. | Defines the approved page/navigation structure. | Page inventory, navigation hierarchy | Tier 6 — Sitemap | **Missing** — no distinct sitemap document has been located in the source archive | Informs `DSS-001` (information architecture, navigation) |
| **Homepage Wireframe** | Any client-approved or designer-produced wireframe for the homepage layout. | Defines the approved structural layout intent for the homepage prior to visual design. | Section order, layout structure | Tier 7 — Wireframes | **Missing** — no wireframe document has been located in the source archive | Informs `DSS-001` (component/layout specification), Homepage Mission documents |
| **Designer Instructions** | Design and presentation guidance (imagery direction, accessibility/contrast guidance, copy-style rules) found embedded within a content-briefing source document rather than as a standalone file. | Directs visual/creative execution constraints supplied by or on behalf of the client. | Imagery direction, accessibility/contrast rules, copy style, tone | Tier 4/5 — treated as client-provided guidance, adjacent to Questionnaire/Brochure | **Verified** — located and content-confirmed within the content-briefing source; already used to inform copy and imagery guidance | Informs `DL-001` (design language), `DSS-001` |
| **Client Review Notes** | Curated record of client-approved decisions that modify, clarify, or refine the original Project Proposal — colour philosophy, typography, homepage narrative sequence, imagery direction, content direction, UX, scope decisions, and open items. Repository file: `references/CRN-001-Client-Review-Notes.md`. | Records client-approved feedback and requested changes on presented work. | Colour/typography/UX direction, homepage narrative order, imagery direction, content direction, scope decisions, open decisions | Tier 3 — Client review documents | **Verified** — materialized 2026-07-05 (Mission RM-006) as `CRN-001`, content-confirmed against the client review decisions relayed via Mission PDC-001-B and cross-corroborated by the Client Questionnaire's Design Validation section. Superseded the prior `Missing` status. | Informs `PDC-001` (Article VI, materialized ahead of this document but now traceable to it — see Article IX, Client Amendments, when materialized), `DDR-001` (decision register entries), Mission revisions |
| **Email Confirmations** | Email correspondence in which the client explicitly confirms or approves a decision. | Serves as the explicit-approval record for specific decisions. | Approvals, confirmations, decision sign-off | Tier 1 — Latest explicit client approval (when the email constitutes an approval) | **Missing** — no email exports or confirmations have been located in the source archive | Informs `DDR-001` as approval evidence for logged decisions |

Evidence Status is not guessed. Where the repository has not confirmed possession of a source, that source is marked `Pending` or `Missing` rather than assumed present — these are honest placeholders, to be resolved (matched to an actual file under `references/`, content-ingested, or confirmed genuinely absent) as part of routine repository maintenance (see Section 8).

### 3.2 Derived Repository Documents

Per the Evidence Classification above, these are never evidence — they are listed here only to complete the inventory, not as catalogued sources with their own Evidence Status:

| Document | Layer (Section 2) |
|---|---|
| `PDC-001` | Constitution |
| `DL-001`, `DSS-001`, `CMS-001`, `SEO-001` | Specification |
| Claude Missions (`missions/CLAUDE-###-*.md`) | Mission |
| `DDR-001`, `changelog/CHANGELOG.md` | Record |
| `README.md` | Repository orientation (not itself a knowledge-model layer) |

## 4. Authority Hierarchy

When sources conflict, the following order governs:

1. Latest explicit client approval
2. Signed proposal / agreed scope
3. Client review documents
4. Questionnaire
5. Brochure
6. Sitemap
7. Wireframes
8. Repository derived documents
9. AI recommendations

A source higher in this list overrides a source lower in this list on any point where they conflict, regardless of recency, except where a lower-tier source is more recent than the *same* higher tier (e.g. a newer signed proposal supersedes an older one — recency governs within a tier, authority governs across tiers).

### Authority vs Verification

Authority and Verification are independent properties of a source and must not be conflated:

- **Authority** defines how authoritative a source is *relative to other sources*, per the Authority Hierarchy above — a fixed, structural property of the source's type (e.g. a signed proposal is always Tier 2, regardless of whether the repository currently holds a copy of it).
- **Verification** (recorded as Evidence Status, Section 3.1) defines whether the repository *currently possesses and has confirmed* that source — a factual, time-varying property of the repository's current state.

A source can be high-authority and unverified at the same time (a signed proposal the repository hasn't yet located), or low-authority and fully verified (a wireframe the repository has in hand). Neither property substitutes for the other.

**Example** — Approved Sitemap: Authority — Tier 6 (fixed, by source type, regardless of whether the repository holds a copy); Verification — Missing (as of 2026-07-05, no distinct sitemap document has been located). Contrast: Project Proposal is both high-authority (Tier 2) *and* Verified (as of 2026-07-05) — high authority does not imply verification, and the two must be checked independently for every source.

## 5. Conflict Resolution

- **Latest approved decision wins**, within a given tier of the Authority Hierarchy.
- **Business objectives remain stable.** A change in presentation, design, or implementation detail does not override a previously established business objective unless the objective itself was explicitly revised at Tier 1 or Tier 2.
- AI-behaviour rules governing invented requirements and flagged ambiguity are defined in Section 9 (AI Behaviour) and apply here.

### Repository Authority Principle

**Repository documents shall never override approved client evidence.** Repository documents interpret evidence — they never replace it. Tier 8 (Repository derived documents) and Tier 9 (AI recommendations) are always subordinate to Tiers 1–7. A Specification or Mission document that conflicts with an actual client-approved source is wrong and must be corrected; it is never treated as an update to that source.

## 6. Repository Principles

- **Repository First.** The repository, not chat history or working memory, is the durable record. If it isn't in the repository, it isn't established.
- **Evidence Driven.** Every assertion of project fact traces to a catalogued source.
- **Traceability.** Each layer of the Repository Knowledge Model (Section 2) is traceable to the layer(s) above it.
- **Single Source of Truth.** Where the same fact could be recorded in more than one place, it is recorded once and referenced, not duplicated.
- **Separation of Facts and Recommendations.** What the client has established as fact (Tiers 1–7) is kept structurally distinct from what this repository or its AI collaborators recommend (Tiers 8–9). Recommendations are labeled as such and never silently promoted to fact.
- **Incremental Evolution.** The knowledge base grows source-by-source and decision-by-decision; it is not re-derived from scratch each time new information arrives.
- **Prefer small, traceable refinements over large rewrites. Repository evolution shall preserve history, traceability, and architectural integrity.

## 7. Traceability Rules

- Every constitutional statement in `PDC-001` shall reference one or more Primary Knowledge Sources from Section 3.1 of this document.
- Every Specification (`DL-001`, `DSS-001`, `CMS-001`, `SEO-001`) shall reference one or more constitutional statements in `PDC-001` — Specifications should not introduce project facts unsupported by the Constitution or by a Primary Source.
- Every Mission (`missions/CLAUDE-###-*.md`) shall reference one or more Specifications — a Mission's scope must be traceable to the Specification(s) it implements.
- Every Record (`DDR-001`, `changelog/CHANGELOG.md`) shall reference the Mission or Specification that created it, capturing what changed and why rather than originating new requirements.

This creates complete traceability: Primary Source → Constitution → Specification → Mission → Record, with no layer free-floating from the one above it.

## 8. Knowledge Maintenance Workflow

Whenever new client information arrives:

1. **Register the new source** in this document (`KNOWLEDGE-SOURCES-001.md`) — catalogue name, description, authority tier, and primary topics.
2. **Assign Verification Status** — Evidence Status per Section 3.1, honestly reflecting whether the source is Verified, Referenced, Pending, Missing, Superseded, or Archived.
3. **Review constitutional impact** — determine whether the new source affects any statement in `PDC-001`.
4. **Update affected Specifications** (`DL-001`, `DSS-001`, `CMS-001`, `SEO-001`) as needed.
5. **Issue a new implementation Mission** if the update requires implementation work.

## 9. AI Behaviour

AI collaborators operating on this repository shall:

- **Never invent requirements.** Where no Primary Source establishes a fact, that fact does not exist in this repository until a source is added. Silence in the evidence base is not license to infer.
- **Never fabricate evidence.** A source's existence, content, or Evidence Status is never asserted without direct confirmation — see Section 3.1's Evidence Status discipline.
- **Flag ambiguity.** Where two sources at the same Authority tier conflict, or a needed fact has no source, the ambiguity is recorded (in `DDR-001` or the relevant Specification's open-questions area) rather than guessed.
- **Preserve traceability.** Every new or edited statement in a Derived Repository Document maintains its link to the Primary Source, Constitution, or Specification it derives from (Section 7).
- **Identify conflicts.** Where a new source conflicts with an existing one, the conflict is surfaced explicitly and resolved per Section 4 (Authority Hierarchy) and Section 5 (Conflict Resolution) — never silently overwritten.
- **Distinguish recommendation from fact.** What the client has established (Tiers 1–7) is kept structurally distinct from what this repository or its AI collaborators recommend (Tiers 8–9); recommendations are labeled as such and never silently promoted to fact.

## 10. Repository Maturity

```
Repository
   ↓
Knowledge Sources
   ↓
Constitution
   ↓
Specifications
   ↓
Mission
   ↓
Execution
   ↓
Records
```

Repository maturity is achieved by incrementally refining each layer of this chain as new evidence arrives — not by rewriting the repository. A mature repository is one where every layer stays current with the layer below it through small, traceable refinements (as this mission itself demonstrates: KNOWLEDGE-SOURCES-001 was refined, not rewritten, from its prior version). Rewriting from scratch discards traceability; incremental refinement preserves it.
