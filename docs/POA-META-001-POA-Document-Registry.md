---
id: POA-META-001
title: POA Document Registry
purpose: Registers the Governance (POA-GOV) and Organizational Case Law (POA-CASE) document families — naming conventions, versioning, and repository placement — analogous to how KNOWLEDGE-SOURCES-001 registers the Knowledge layer
repository_layer: Meta (POA-META)
status: Materialized
version: 1.0.0
owner: TBD
last_updated: 2026-07-14
---

# POA-META-001 — POA Document Registry

## Repository Position

**Depends On**
- `README.md`
- `KNOWLEDGE-SOURCES-001` (the existing registry this document sits alongside — see §4, Relationship to Existing Layers)
- `POA-GOV-001`, `POA-CASE-001` (the two document families this registry formally establishes)

**Enables**
- Every future `POA-GOV-###` and `POA-CASE-###` document — this registry is where a future Engineering Corps session confirms naming, versioning, and placement before creating one
- Future missions that need to cite a governance precedent — this document is the index that makes `POA-CASE` discoverable as a family, not just as individual files

**Materialization note.** This Engineering Order instructed "Update POA-META-001." No document of that name existed anywhere in the repository prior to this mission — confirmed by a full repository search before writing this file. This document is therefore a first materialization, not an update to prior content. Recorded here explicitly, per this repository's standing rule against silently asserting continuity that doesn't exist (`KNOWLEDGE-SOURCES-001` §9, Never fabricate evidence).

---

## 1. Purpose

`KNOWLEDGE-SOURCES-001` registers and governs the repository's **Knowledge** layer — Primary Sources and the Derived Documents built from them (`PDC-001`, Specifications, Missions, Records). It does not, and was never scoped to, register the two new document families Operation JURIS introduces: **Governance** (`POA-GOV`) and **Organizational Case Law** (`POA-CASE`). This document performs that registration, in the same spirit and structure as `KNOWLEDGE-SOURCES-001`, without duplicating or amending it.

## 2. Relationship to Existing Layers

`KNOWLEDGE-SOURCES-001` §2 defines five layers: Source → Constitution → Specification → Mission → Record. `POA-GOV` and `POA-CASE` are not a sixth and seventh entry in that same chain — they sit **alongside** it, governing how the whole chain (plus Engineering Orders, a Mission-adjacent instruction type that chain did not originally name) relates and resolves conflict:

```
                    POA-GOV  ──────────────┐
                       (governs)           │
                                            ▼
Source → Constitution → Specification → Mission → Record
                                            │
                                    (Engineering Orders
                                     direct this layer)
                                            │
                                            ▼
                                       POA-CASE
                                    (records precedent
                                     from what Acting
                                       revealed)
```

`POA-GOV` documents are prescriptive, like Constitution and Specification documents, but scoped to *process* (how conflicts resolve, how authority is structured) rather than *project content* (positioning, design, service catalogue). `POA-CASE` documents are observational, like Record documents (`DDR-001`, the Changelog), but scoped to *governance precedent* (what happened when an instruction conflicted with the Repository, and how it was resolved) rather than *design decisions*.

## 3. POA-GOV — Governance Documents

**Purpose.** Formalizes organization-wide rules: authority hierarchy, conflict resolution procedure, roles, escalation, and the validation process by which an observed pattern becomes binding doctrine. `POA-GOV` documents are prescriptive and, once past Architecture Review, binding on future Engineering Orders and missions in the same way `PDC-001` is binding on project content.

**Naming convention.** `POA-GOV-###-Short-Title-In-Title-Case.md`, sequential three-digit numbering, one document per governance topic (not per mission or per incident — `POA-GOV-001` covers authority hierarchy and conflict resolution as one coherent topic, per this Engineering Order's own deliverable scope). A future `POA-GOV-002` would cover a materially distinct governance topic, not a revision of `POA-GOV-001`'s topic — revisions to an existing `POA-GOV` document's topic are handled via the same additive-amendment discipline as `PDC-001`/`PDC-A001` (see §5, Versioning).

**Versioning.** Standard repository front matter (`status`, `version`, `owner`, `last_updated`) plus `repository_layer: Governance (POA-GOV)`. Lifecycle follows the existing Repository Lifecycle (`KNOWLEDGE-SOURCES-001` §10.): Draft → Materialized → Architecture Review → Approved → Frozen → Superseded → Archived. A `POA-GOV` document is not binding doctrine until it has passed Architecture Review — `POA-GOV-001` is currently `Materialized — pending Architecture Review`, meaning its Governance Rules and Conflict Resolution Algorithm describe the intended standard but have not yet been formally ratified.

**Repository placement.** `docs/POA-GOV-###-*.md`, alongside `PDC-001` and other foundational documents — not a separate top-level directory, since `POA-GOV` documents function at the same "foundational reference" level readers already expect to find in `docs/`.

## 4. POA-CASE — Organizational Case Law

**Purpose.** Records specific incidents where an instruction (typically an Engineering Order) conflicted with the Repository, how the conflict was resolved, and what principle — if any — the resolution suggests. `POA-CASE` documents are observational, not prescriptive: a `POA-CASE` document describes what happened once; it does not, by itself, bind future missions (see `POA-GOV-001` §9, Validation Process, for how a case earns binding weight over time).

**Naming convention.** `POA-CASE-###-Short-Case-Name.md`, sequential three-digit numbering, one document per incident (analogous to a single legal case, not a topic area — multiple `POA-CASE` documents may later corroborate the same underlying principle, and are cross-referenced to each other rather than merged into one file). The filename's case name should be a short, memorable descriptor of the conflict's resolution (e.g. `Repository-Authority-Overrides-Engineering-Order`), not a mission code alone — this keeps the family scannable as case law, the way a legal citation is scannable by case name rather than docket number alone.

**Versioning.** Standard repository front matter, plus two fields specific to this family:
- `repository_layer: Organizational Case Law (POA-CASE)`
- `validation_status`: one of `Observed`, `Corroborated`, or `Validated Precedent`, per `POA-GOV-001` §9. **This field is independent of the document's own `status` (Lifecycle) field** — a `POA-CASE` document can be fully `Materialized` (properly written up, complete, accurate) while its `validation_status` remains `Observed` (only one incident exists). Conflating the two — treating a well-written case document as automatically binding — is exactly the error `POA-GOV-001` §9 exists to prevent.

**Repository placement.** A new top-level directory, `case-law/POA-CASE-###-*.md`, sibling to `docs/`, `content/`, `deployment/`, `references/`, `missions/`, and `changelog/`. `POA-CASE` is a growing, accumulating family in the same way `changelog/` is (rather than a small, fixed set of foundational references like `docs/`), so it earns the same top-level treatment `changelog/` already has, rather than living inside `docs/` where it would be harder to distinguish from foundational/prescriptive documents at a glance.

## 5. Registered Documents

| Document | Family | Validation Status (POA-CASE only) | Lifecycle Status | Location |
|---|---|---|---|---|
| `POA-GOV-001` — Authority Hierarchy & Conflict Resolution | POA-GOV | — | Materialized — pending Architecture Review | `docs/POA-GOV-001-Authority-Hierarchy-and-Conflict-Resolution.md` |
| `POA-CASE-001` — Repository Authority Overrides Engineering Order | POA-CASE | Observed | Materialized | `case-law/POA-CASE-001-Repository-Authority-Overrides-Engineering-Order.md` |

This table is the authoritative index of both families. Every future `POA-GOV-###` or `POA-CASE-###` document shall be added here at the time of its own materialization — an unregistered document is not considered part of the family for the purposes of `POA-GOV-001` §9's Validation Process (a `POA-CASE` document that isn't registered here cannot corroborate, or be corroborated by, another case, since discoverability is a precondition of corroboration).

## 6. Maintenance Workflow

Whenever a new `POA-GOV` or `POA-CASE` document is materialized:

1. Confirm it doesn't duplicate an existing entry's topic (`POA-GOV`) or incident (`POA-CASE`) — check §5 first.
2. Assign the next sequential number within its family.
3. Apply the naming convention and front matter fields specified in §3 or §4.
4. Place it in the correct directory per §3 or §4.
5. Add a row to §5's table.
6. If the new document is a `POA-CASE` corroborating an existing case, update that case's `validation_status` to `Corroborated` and cross-reference both documents' `Repository Impact` sections — do not silently leave the earlier case at `Observed` once genuine corroboration exists.

## Source References

**Primary Sources**
- Mission Control's Operation JURIS mission brief, Deliverable 3 — direct instruction to register `POA-GOV` and `POA-CASE`, including naming conventions, versioning, and repository placement

**Related Repository Documents**
- `KNOWLEDGE-SOURCES-001` (structural model this document parallels)
- `POA-GOV-001`, `POA-CASE-001` (the two documents registered here)
- `README.md` (repository orientation — a future revision should add this document to the Read Order; not performed here, as it falls outside this Engineering Order's three specified deliverables)
