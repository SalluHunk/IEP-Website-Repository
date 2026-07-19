# CMS-002 — Leadership Module: Deployment Package

**Status:** v1.0 — Ready for manual deployment. Nothing in this package has been applied to WordPress. Prepared under WCP-001 (Website Completion Program), Work Package 03, after `CMS-002`'s original execution attempt (2026-07-12) confirmed the write-side blocker documented in `docs/CMS-002-Leadership-Module-Report.md`.
**Generated:** 2026-07-15.
**Sources used:** `docs/CMS-002 — Leadership Module.md` (mission brief), `docs/CMS-002-Leadership-Module-Report.md` (prior blocked-execution findings and field comparison), `CMS-005-Services/` (package format precedent), the live Leadership page (post 972, read directly this session) for all real content.

## What this is

Converts the existing `cspt-team-member` CPT — currently has published items with no ACF fields and no REST route (confirmed blocked in `CMS-002`'s 2026-07-12 report, reconfirmed live 2026-07-15) — into the CMS-driven Leadership module. Reuses the existing CPT; no new post type is created, per the mission's Repository Rules.

## Why this exists: the SFTP investigation

This session tried to wire up direct SFTP/SSH access to unblock CMS work generally (see `missions/WCP-001-Progress-Register.md`, Blocker A). The host (GoDaddy Managed WordPress, confirmed via the user's FileZilla config) only allows creating a single FTP account whose password can't be viewed or edited after creation, and offers no SSH-key option — genuinely not viable without the user manually handling a password each session, which is outside this session's standing rules on credential handling regardless of consent. So: **no SFTP path exists for this engagement.** This package is the alternative that was already proven to work for CMS-003 and CMS-004 — everything in it installs via wp-admin (Code Snippets + ACF's own Import tool + the native post editor), no file-system access required at all.

## Package contents

```
CMS-002-Leadership/
├── README.md
├── IMPLEMENTATION-GUIDE.md      — deployment steps + full 7-person content migration table
├── VERIFICATION.md
├── ROLLBACK.md
├── CHANGELOG.md
├── DECISIONS.md                 — every judgment call, with reasoning
├── repository-update.md
├── acf-json/
│   └── group_team_member_fields.json
└── php/
    └── team-helper-functions.php     — REST retrofit + [iep_team_grid] shortcode (Code Snippet)
```

## Read `DECISIONS.md` before deploying

This package ships a **7-field group**, not all 9 fields the mission's brief listed as candidates. "Featured Flag" and "Areas of Expertise" were excluded — no verified live content justifies them (all 7 people are shown, none marked "featured"; expertise is already inline in Qualifications/Biography). "Credentials" was not split out from "Qualifications" — the live content mixes academic and professional-membership letters in one string per person with no clean existing split to migrate from. A new field, "Team Group," was added beyond the mission's example list — it's what lets the shortcode reproduce the live page's existing two-section layout (Directors, then The team).

## The practical path to real value, without SFTP

Same pattern as `CMS-004` and `CMS-005`: this module needed a code change (retrofitting REST support onto an existing CPT) and a template change (a shortcode reading ACF fields). Both ship as one Code Snippet — installable through wp-admin's Snippets screen, no file access needed. The ACF field group ships as a JSON file importable through **Custom Fields → Tools → Import Field Groups** in wp-admin — also no file access needed.

## What's being replaced

The live Leadership page (972) currently has all 7 people's real content hand-typed directly into Elementor text-editor/heading/image widgets. This package doesn't touch that page — it prepares the CMS layer (fields + content + shortcode) so the *user* can decide when to swap the hand-coded section for the `[iep_team_grid]` shortcode via Elementor's native Shortcode widget. See `IMPLEMENTATION-GUIDE.md`.
