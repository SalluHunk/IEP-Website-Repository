# CMS-004 — Repository Update

## ACF / Global Settings mapping

Every footer element mapped to its data source, and where it comes from when Global Settings isn't the answer:

| Footer element | Source | Note |
|---|---|---|
| Logo | `CMS-003` → `white_logo` | Reversed/white logo, since the footer background is dark. |
| Company Name | *(not rendered in the footer)* | The footer shows the logo image, not a text company name — `company_name` exists in Global Settings for other uses (e.g. `<title>` tags, structured data) but isn't part of this element. |
| Tagline | `CMS-003` → `company_tagline` | |
| Address | `CMS-003` → `office_address` | |
| Telephone | `CMS-003` → `contact_telephone` | |
| Email | `CMS-003` → `contact_email` | |
| LinkedIn | `CMS-003` → `linkedin_url` | Still the placeholder URL until `CMS-003`'s open item is resolved — see that package's README. |
| Copyright | `CMS-003` → `footer_copyright_text` | |
| **CTA** | **Not mapped — deliberately excluded** | The live footer element itself contains no CTA button. The "Book Opportunity Screening"/"Contact us" buttons live in a separate section immediately *above* the footer, not inside it. Adding one to `footer.php` would be a visual addition beyond what exists today, which the mission's "no visual regression" / "No redesign" rules rule out. `CMS-003`'s `primary_cta_text`/`secondary_cta_text` fields remain available in Global Settings for whoever eventually consolidates that separate CTA section — out of scope here. |
| **Footer Legal Text** | **Not mapped — field unused** | `CMS-003`'s `footer_legal_text` field is reserved for a short disclaimer sentence, but no such text exists on the live footer today (which has legal *links*, not free text) — see below. |
| Footer Navigation (Services/Industries columns, legal links) | **WordPress Menus**, not Global Settings | Three new menus (`iep-footer-services`, `iep-footer-industries`, `iep-footer-legal`) — see `IMPLEMENTATION-GUIDE.md`'s Navigation section for why. |
| Company Registration Number, Default Social Image, Global CTA Text | **Not used** | None of these appear in the current footer at all; they exist in `CMS-003` for future use elsewhere, not this module. |

## What this introduces

A single canonical `footer.php`, three new WordPress menus carrying real (not demo) footer navigation content, and a reviewed, safety-gated script to retire the 14 duplicated per-page footers — closing out the central finding from `CMS-BOOT-002`.

## Dependencies

- **`CMS-003` deployed and its helper functions active** — hard dependency, `footer.php` calls them directly.
- **File/SFTP access** — required for `footer.php` itself (a real theme template file cannot be deployed via Code Snippets, unlike everything in `CMS-003`). This is the same access gap open since `CMS-BOOT-001`; the menu creation and cleanup-script steps don't need it, only Step 4 of `IMPLEMENTATION-GUIDE.md` does.
- **`BACKUP-001` current** — this package edits 14 pages' content; confirm the backup is still recent before running Step 6, not just present in principle.

## Next recommended module

With Global Settings (`CMS-003`) and the footer (`CMS-004`) both packaged, the CMS-001 sequence's next item is **Services** — but per `CMS-002-Leadership-Module-Report.md`, `cspt-service` has the same no-REST-route blocker that stopped Leadership. Two realistic paths from here:

1. **Resolve the SFTP/REST-route blocker generally** — a small PHP change (flip `show_in_rest` on the three existing CPTs, ideally alongside placing `footer.php` in the same file-access session as this module) would unblock Leadership, Services, and Case Studies all at once, rather than one at a time.
2. **Package the Services *page* update only, same pattern as this module** — the Services page's static content could be reduced/simplified in the same "prepare, don't execute" style, while leaving `cspt-service`'s actual data entry as a manual wp-admin task, same as Leadership's unresolved gap.

Recommend option 1 if/when SFTP access becomes available — it clears the single blocker that's stopped every CPT-based module so far, rather than continuing to work around it module-by-module.
