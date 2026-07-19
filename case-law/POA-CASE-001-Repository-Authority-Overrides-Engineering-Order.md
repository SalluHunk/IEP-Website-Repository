---
id: POA-CASE-001
title: Repository Authority Overrides Engineering Order
case_name: "Repository Authority v. Engineering Order Template (DEL-002)"
repository_layer: Organizational Case Law (POA-CASE)
status: Materialized
validation_status: Observed
validation_note: "This principle has been observed once and should not yet be elevated to certified doctrine."
version: 1.0.0
owner: TBD
last_updated: 2026-07-14
---

# POA-CASE-001 — Repository Authority Overrides Engineering Order

## Repository Position

**Depends On**
- `docs/EO-DEL002-001-Homepage-Constitutional-Audit.md` (the incident itself)
- `PDC-A001` (the governing document the Engineering Order conflicted with)
- `POA-GOV-001` (the governance framework this case is evaluated against, and which cites this case as its evidentiary basis for placing Engineering Orders at Tier 8)

**Enables**
- `POA-GOV-001` §3 (Engineering Order tier placement), §6 (Operational Doctrine 1), §9 (Validation Process, worked example)
- Any future `POA-CASE-###` addressing a similar conflict — a second, independent instance would corroborate this case's principle per `POA-GOV-001` §9

---

## Executive Summary

During Operation HORIZON (Mission DEL-002, Engineering Order `EO-DEL002-001`), Mission Control issued an Engineering Order instructing a constitutional audit of the homepage. The Order itself included a proposed nine-stage visitor-journey template, presented as the standard the homepage should be measured against. That template conflicted materially with `PDC-A001` — the repository's actual governing homepage narrative model, itself synthesized from four prior implementation missions (`CONTENT-002` through `CONTENT-004`) and validated in that synthesis. The Engineering Corps (Claude, executing the audit) did not implement or measure against the Order's template. It used `PDC-A001` as the audit's baseline, explicitly named the conflict in the delivered report, and asked Mission Control to reconcile the two before further implementation was authorized. **This is the first recorded instance, in this repository, of an Engineering Order's own embedded content being set aside in favour of the Repository's governing model.** It establishes — as an Observed instance only, not yet as binding doctrine — that Repository authority can override an Engineering Order's content when a genuine conflict exists, provided the conflict is surfaced rather than silently resolved in either direction.

## Background

`PDC-001` was frozen at Version 1.0 (Architecture Review `AQR-006`) with Article VIII defining a nine-stage homepage narrative. Over Operation PHOENIX, four missions (`CONTENT-002`, `CONTENT-002A`, `CONTENT-003`, `CONTENT-004`) reviewed the service catalogue and the live homepage against that Article, surfacing six findings. `PDC-A001` (First Constitutional Amendment, materialized 2026-07-13) synthesized those findings without editing `PDC-001` directly, expanding the governing model to twelve stages and validating (rather than correcting) two of Article VIII's original decisions. `PDC-A001` was, at the time of the DEL-002 incident, the most current, most evidenced statement of what the homepage's constitutional narrative should be — itself several missions and one Architecture-Review-track synthesis deep.

Operation HORIZON then issued `EO-DEL002-001`, instructing a fresh constitutional audit of the live homepage. The Order's own brief included a "visitor journey" diagram Mission Control wrote directly into the instruction: **Hero → Trust & Credibility → Engineering Service Categories → Why Industrial Engineering Pioneers → Engineering Methodology → Featured Projects → Resources → Leadership → Call To Action.**

## Facts

- `PDC-A001`'s governing model (12 stages): Executive Trust → Commercial Challenge → Who We Help → Why IEP → Funding Capability → Methodology → Services → Case Studies → Technical Capability → Leadership → Testimonials → Call To Action.
- `EO-DEL002-001`'s embedded template (9 stages): Hero → Trust & Credibility → Engineering Service Categories → Why IEP → Engineering Methodology → Featured Projects → Resources → Leadership → Call To Action.
- Comparing the two directly: the EO template omits five `PDC-A001`-governed stages entirely as named stages (Commercial Challenge, Who We Help, Funding Capability, Technical Capability, Testimonials); introduces one stage — "Resources" — with no basis anywhere in `PDC-001`, `PDC-A001`, or any of `CONTENT-001`–`CONTENT-004`, and with no corresponding section present anywhere on the live homepage; and renames two stages ("Featured Projects" for Case Studies, "Engineering Service Categories" for Services) without any recorded amendment authorizing the rename.
- No source anywhere in the repository — Primary or Derived — supports the EO template as written. It did not originate from a client-approval event, a questionnaire answer, or any prior mission finding traceable in the repository.

## Conflict

Two governing statements of "what the homepage's visitor journey should be" existed simultaneously at the moment `EO-DEL002-001` was received: `PDC-A001`, evidenced across four prior missions and pending Architecture Review, and the Order's own embedded template, evidenced by nothing beyond its own text. `PDC-001` Article XII states plainly that "Implementation documents and Claude missions shall never override the Constitution. Where an implementation instruction conflicts with a constitutional Article, the Article governs, and the conflict shall be flagged rather than silently resolved." At the moment of receipt, it was not yet settled whether that rule extends to an Engineering Order specifically — Article XII was written before Engineering Orders existed as a named instruction type in this repository's practice.

## Resolution

The Engineering Corps treated `PDC-A001` as authoritative for the audit itself, explicitly declined to measure the homepage against the EO's own template, stated the reasoning in the delivered report (citing `PDC-001` Article XII and Operation HORIZON's own stated Engineering Principles — Repository First, Constitution Before Implementation, No Architectural Drift), and closed the report with a direct question to Mission Control: confirm whether the EO template was intended as non-binding shorthand or as a proposed amendment, before `EO-DEL002-002` (implementation) proceeds. No unilateral decision was made about which model is "correct" going forward — the conflict was surfaced, not resolved, by the Engineering Corps. Resolution of the underlying question (which model governs) remains with Mission Control, per the Escalation Model now formalized in `POA-GOV-001` §8.

## Governing Principles

- `PDC-001` Article XII, Repository Precedence: "Implementation documents and Claude missions shall never override the Constitution... the conflict shall be flagged rather than silently resolved."
- `KNOWLEDGE-SOURCES-001` §5, Repository Authority Principle: "Repository documents shall never override approved client evidence... a Specification or Mission document that conflicts with an actual client-approved source is wrong and must be corrected; it is never treated as an update to that source." (Applied here by extension — an Engineering Order's unevidenced content is treated the same way a Specification or Mission's would be.)
- `KNOWLEDGE-SOURCES-001` §9, AI Behaviour: "Identify conflicts... surfaced explicitly and resolved per Section 4... never silently overwritten."

## Lessons

1. **Engineering Orders are execution-layer instructions, not automatically Tier 1 evidence.** An Order's own confident phrasing, or its origin from Mission Control, does not by itself make embedded content (as opposed to the instruction to act) equivalent to an explicit, evidenced approval. This distinction did not exist explicitly in the repository's governance before this incident — `POA-GOV-001` §3 now states it directly, citing this case.
2. **A conflict between an Engineering Order and the Repository should be named, not absorbed.** The Engineering Corps did not choose a side and proceed silently in either direction — it executed the audit against the Repository's model and reported the discrepancy for a Mission Control decision. This is the behaviour `POA-GOV-001` §4 (Conflict Resolution Algorithm) and §8 (Escalation Model) now formalize as the standard procedure.
3. **This is one incident.** It shows the pattern can occur and can be handled well — it does not, by itself, prove the pattern always will be, or that no future Engineering Order should ever carry Tier-1-equivalent weight. See Validation Status below.

## Validation Status

**Observed.**

This principle has been observed once and should not yet be elevated to certified doctrine. It is recorded here so that a second, independent occurrence can be recognised and cited as corroboration (per `POA-GOV-001` §9) — and so that, if a future incident resolves *differently* (an Engineering Order's content proving correct against a Repository that was itself out of date), that outcome is equally recordable without contradicting an over-broad rule this single case would not have earned.

## Repository Impact

- Directly evidenced the need for, and is cited by, `POA-GOV-001` §3 (Engineering Order tier placement), §5 (Governance Rule 1), §6 (Operational Doctrine 1), and §9 (Validation Process).
- No existing repository document was edited as a result of this case — `PDC-A001` stands unmodified, `EO-DEL002-001`'s audit stands as delivered, and the underlying reconciliation question (which visitor-journey model governs, going forward) remains open, pending Mission Control's response, as of this document's writing.

## Future Implications

- If Mission Control confirms the EO template was non-binding shorthand: no further repository action needed; this case stands as the full record of the incident.
- If Mission Control instead intends the EO template (or elements of it, e.g. a "Resources" stage) as a genuine proposed change: that requires a new Constitutional Amendment (`PDC-A002` or equivalent) following the same evidentiary process `PDC-A001` itself followed — it does not retroactively validate this case's resolution as having been the "wrong" call, since surfacing the conflict rather than silently implementing either side was the correct action regardless of which side is ultimately confirmed.
- Future Engineering Orders that touch an area already governed by `PDC-001` or a `PDC-A###` amendment should expect the same check to occur, per `POA-GOV-001` §5, Governance Rule 7.

## Source References

**Primary Sources**
- `docs/EO-DEL002-001-Homepage-Constitutional-Audit.md`, §4 (Repository Alignment Assessment) and §1 (Executive Summary) — the audit report in which this conflict was surfaced

**Related Repository Documents**
- `PDC-001` Article XII
- `PDC-A001` (all six Amendment Register entries — the governing model this case defends)
- `KNOWLEDGE-SOURCES-001` §5, §9
- `POA-GOV-001` (the governance document this case evidences)
