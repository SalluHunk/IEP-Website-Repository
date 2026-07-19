# CONTENT-001 — Service Knowledge Extraction & Content Synthesis

**Mission:** OPERATION PHOENIX / CONTENT-001. **Type:** Knowledge Synthesis, not copywriting.
**Purpose:** extract and synthesize service content for the client's approved 9-service catalogue (see `IEP-Website-Repository/deployment/CMS-005-Services/MIGRATION-REPORT-v1.1.md` for how this catalogue superseded the earlier 7-service model) from verified project sources, so the CMS-005 deployment package can be completed with minimal additional client input.
**Status:** Extraction complete. Nothing in this package has been written into WordPress. `cspt-service`'s field content is still unpopulated (per CMS-005's own status) — this package is the sourcing layer CMS-005 was waiting on.

## What this is (and isn't)

This is **evidence-based synthesis**, not marketing copy. Every substantive claim in every `SERVICE-0X-*.md` file is traceable to one or more Primary Knowledge Sources (per `KNOWLEDGE-SOURCES-001`'s Evidence Classification) and tagged with a Confidence Rating. Where the evidence doesn't support a claim, the file says so explicitly (`Gap`) rather than inventing one. Nothing here should be pasted onto the live site as-is without also reading each file's Confidence Ratings and Outstanding Questions — several sections are frankly thin, and that thinness is the point of this exercise: it tells the project team exactly where real client input is still needed, and where it isn't.

## Source Key

Used throughout this package as shorthand citations. Authority tiers per `KNOWLEDGE-SOURCES-001` §3.1/§4.

| Code | Source | Tier | Evidence Status | File |
|---|---|---|---|---|
| **[BRO]** | IEP Brochure (250506) | 5 | Verified | `IEP Brochure - 250506.pdf` / `.claude/brochure_extract.txt` (IEP-Wpress) |
| **[BRF]** | Website Content + Presentation Briefing Document ("Designer Instructions" / content-briefing source in `KNOWLEDGE-SOURCES-001`) | 4/5 | Verified | `New Website Proposed Content AH ver2 2026 06 09.docx` (Project Start) / `.claude/proposed_content_extract.txt` (IEP-Wpress) |
| **[QST]** | Client Questionnaire (blank + approved versions — identical content in both; approval version additionally confirms case-study/branding/design-validation answers) | 4 | Verified | `Website Discovery & Content Validation Questionnaire.docx` + `_Approval.docx` (Project Start) |
| **[HPC]** | Homepage Narrative | — (per this mission's own Authoritative Sources list) | Verified | `IEP-Homepage-Copy.md` (IEP-Wpress) — itself synthesized from [BRO]+[BRF], cited here per the mission brief's explicit instruction to treat Homepage Narrative as a source |
| **[CRN]** | Client Review Notes (CRN-001) | 3 | Verified | `references/CRN-001-Client-Review-Notes.md` |
| **[SOW]/[CP]** | Project Proposal — Statement of Work / Commercial Proposal | 2 | Verified, but **out of scope for service content** — see note below | `Docs to send/IEP_SOW_Proposal_Paravyoma_v3.pdf`, `IEP_Commercial_Proposal_Paravyoma - V3.pdf` |

### Why [SOW]/[CP] contribute nothing to the service files

Both documents were read in full for this mission. They are Paravyoma Technologies' proposal **to build IEP's website** — scope of work, page list, timeline, commercial terms for the web project. They contain zero content about what IEP's own engineering services actually are (no service descriptions, capabilities, or deliverables). The only relevant fact either document supplies is structural — [SOW] §2.4 lists "Services" as page 03 with purpose "Service pillars, methodology, and structured capability presentation," confirming a services page is in scope — and that fact is not service *content*, so it isn't cited inside the individual service files. This is recorded here rather than silently treating Tier 2 as absent, per `KNOWLEDGE-SOURCES-001` §9 ("never fabricate evidence" cuts both ways — don't fabricate a contribution a source doesn't make, either).

### Sources not used (per `KNOWLEDGE-SOURCES-001`, unchanged)

Approved Sitemap and Homepage Wireframe remain catalogued **Missing** — not located during this mission either. Email Confirmations remain **Missing**. None of the three would plausibly contain service-capability content even if located (sitemap/wireframe are structural; email confirmations are approval records) — their absence does not create gaps in the service files.

## Package contents

```
CONTENT-001-Services/
├── README.md                          — this file
├── SERVICE-01-Opportunity-Screening.md
├── SERVICE-02-Energy-Utilities.md
├── SERVICE-03-Product-Design.md
├── SERVICE-04-Water-Wastewater.md
├── SERVICE-05-Low-Carbon-Energy.md
├── SERVICE-06-Engineering-Feasibility.md
├── SERVICE-07-Funding-Procurement.md
├── SERVICE-08-AI-Monitoring.md
├── SERVICE-09-Technology-Innovation.md
├── MASTER-SERVICE-MATRIX.md            — comparison table across all 9
├── CLIENT-QUESTIONS.md                 — genuinely unanswerable-from-evidence items only
└── CHANGELOG.md
```

## How confidence ratings work

Each service file rates **each of its 8 sections independently** (a service can be `Verified` for Capabilities and `Gap` for Deliverables at the same time):

- **Verified** — directly stated in one or more Primary Sources, in language close enough to the section's claim that no interpretive leap was needed.
- **Partially Supported** — evidence exists but requires inference, is thinner than ideal, comes from a single indirect mention (e.g. one line in a leadership bio), or covers only part of the section's scope.
- **Gap** — no Primary Source evidence found. The section says so plainly rather than filling the space.

## Headline finding

Evidence quality is **not evenly distributed across the 9 services**. Services 1, 2, 6, 7, and 9 (Opportunity Screening, Energy/Utilities/Process Efficiency, Engineering Design/Feasibility/Investment Case, Funding/Procurement/Project Delivery, Technology Innovation & R&D Support) have strong multi-source evidence, including real case studies with financial figures. Services 3 and 4 (Product Design & Optimisation, Water/Wastewater & Circular Resource Management) have real but narrower evidence — mostly from leadership bios and 1–2 case studies rather than dedicated service descriptions. Service 5 (Low-carbon & Resilient Energy Systems) is well evidenced for "low-carbon," thin for "resilient." **Service 8 (AI-enabled Monitoring, Assurance & Continuous Improvement) is the clear outlier** — see `SERVICE-08-AI-Monitoring.md` and `CLIENT-QUESTIONS.md` — most of its 8 sections are `Gap`, and the one AI-related evidence fragment that exists is a single unelaborated phrase in a leadership bio, not a described service. See `MASTER-SERVICE-MATRIX.md` for the full picture.
