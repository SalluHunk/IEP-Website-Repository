# CMS-003 — Global Settings: Deployment Package

**Status:** Ready for manual deployment. Nothing in this package has been applied to WordPress — it was generated entirely offline against the repository's verified sources.
**Generated:** 2026-07-12
**Sources used:** `PDC-001`, `IEP-Phase6.5-CMS-Spec.md` (§11 Global Company Information, §13 Homepage Settings), `CMS-001-Production-Migration-Strategy.md`, `CMS-BOOT-001-Readiness-Report.md`, `CMS-BOOT-002-Readiness-Report.md`, `CRN-001-Client-Review-Notes.md`, `KNOWLEDGE-SOURCES-001.md`. No content in this package was invented — every field's default value is either sourced directly from the live site (and marked as such) or deliberately left blank with a note explaining why, per `KNOWLEDGE-SOURCES-001`'s evidence discipline.

## What this is

A production-ready ACF Pro Options Page for Global Settings — the module `CMS-001` sequenced second (right after Leadership), specifically to fix the footer-duplication problem `CMS-BOOT-002` found: every 2026-redesign page currently hardcodes its own copy of the footer instead of reading from one shared source. This package is that shared source.

## Package contents

```
CMS-003-Global-Settings/
├── README.md                     — this file
├── IMPLEMENTATION-GUIDE.md        — step-by-step wp-admin deployment
├── VERIFICATION.md                — post-deployment checklist
├── ROLLBACK.md                    — how to undo this package
├── repository-update.md           — what this introduces, dependencies, what's next
├── acf-json/
│   └── group_global_settings.json — the Options Page field group, ready to import
└── php/
    ├── options-page.php           — registers the Options Page
    └── helper-functions.php       — safe getters for templates (iep_get_global_setting, iep_get_global_image_url)
```

## Before you deploy — read this

Several fields are intentionally **blank or marked placeholder** in the field group, not filled in with guesses:

| Field | Status |
|---|---|
| Company Registration Number | **Not sourced.** The live footer says "Registered in England" only — no number exists anywhere in the verified site inventory. |
| LinkedIn URL | **Placeholder.** The live footer links to the generic `linkedin.com`, not a company page. `CRN-001` records the real LinkedIn integration approach as an open decision. |
| Default Social Share Image | **Not sourced.** No asset was found anywhere in the inventory. |
| Global CTA Text | **Not sourced.** No distinct value exists on the live site beyond the two CTAs already captured. |
| Newsletter Text | **Not sourced.** `CRN-001` records newsletter implementation as an open decision. Do not write marketing copy into this field — that's outside this package's scope by design. |
| Footer Legal Text | **Reserved, not populated.** The live footer's legal links (Privacy/Terms/Cookie/Careers/Resources) are page links, not free text — that's a footer-navigation concern for the `CMS-001` consolidation module, not this field. |

Everything else (Company Name, Tagline, Office Address, Contact Email, Contact Telephone, Primary/Secondary CTA text and URLs, Footer Copyright) is populated with the **real value currently live on iep.technology**, captured directly from the site during `CMS-BOOT-002` and re-confirmed for this package.

**One thing worth flagging to the client before go-live:** the live Contact Email and Contact Telephone are a director's personal email/mobile, not general company contact details. This package preserves that as-is (per "preserve before replacing" — see `CMS-001`), but it's worth a deliberate decision rather than carrying it forward by default.
