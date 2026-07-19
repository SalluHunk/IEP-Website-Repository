# BACKUP-001 — Production Baseline

**Mission:** BACKUP-001 (mandatory rollback point before any CMS implementation begins)
**Timestamp:** 2026-07-12
**Environment:** iep.technology — WordPress 6.8.5, PHP 8.2.30, theme `greenly-child` v1.0 (parent `greenly` v8.4)
**Method:** WordPress MCP (REST + resources). No SFTP/hosting-panel/database access this session.

---

## Backup Status: ✅ COMPLETED — verified manually by the user (2026-07-12)

**Tasks 1 and 2 (database backup, theme/file backup) could not be performed from within this MCP session** — no backup/export/database-dump tool exists anywhere in the WordPress MCP toolset, and file-level access (SFTP/hosting panel) is unavailable here. That capability gap is unchanged and is recorded as-is further down this document for the record.

**The user has since confirmed, outside this session, that a full backup was taken and verified manually** (most likely via the "Manage" plugin, host control panel, or a backup plugin installed directly in wp-admin — the specific method was not reported back to this session). This session has no tool that can independently inspect or confirm a backup's existence, integrity, or restorability — the status below reflects the user's direct confirmation, not independent verification by Claude. If the backup method, location, or timestamp becomes known, this document should be updated to record it precisely (filename/location, backup method, exact timestamp — the mission's own required fields).

**Tasks 3 and 4 (configuration export, site-state capture) were completed** by this session and are recorded below — this remains a useful baseline snapshot to compare against post-migration.

---

## What was captured (Tasks 3–4)

### Environment / configuration
| Item | Value |
|---|---|
| WordPress version | 6.8.5 |
| PHP version | 8.2.30 |
| Active theme | Greenly Child v1.0 (Creative's Planet), parent Greenly v8.4 |
| Site title / tagline | Industrial Energy Pioneers Limited / "Cut Waste. Improve Profit. Fund the future" |
| Locale | en_GB |

### Active plugins (21 active / 9 inactive, 30 total)
Active: ACF Photo Gallery Field, Advanced Custom Fields **PRO** 6.8.5, Breadcrumb NavXT 7.5.1, CF Post Formats 1.3.1, Clear Cache For Me 2.5, Code Snippets 3.9.6, Contact Form 7 6.1.6, Easy MCP AI 1.7.9, Elementor 4.1.4, Envato Market 2.0.14, Essential Addons for Elementor 6.6.11, Greenly Theme Addons 8.4, Header Footer Builder for Elementor 1.2.4, Image Hotspot by DevVN 1.3.0, Image Optimization 1.7.6, JetSticky For Elementor 1.0.4, **Manage 1.0.7 (Elementor.com)**, MC4WP 4.13.1, Our Team Widget for Elementor 1.3.8, Smart Slider 3 3.5.1.38, Sucuri Security 2.7.4, Turbo Addons Elementor 1.9.1, Ultimate Addons for Elementor (UAE) 2.9.1, Unlimited Elements for Elementor 2.0.13, WPBakery Page Builder 8.7.2.

Inactive: Advanced Custom Fields (free) 6.8.5, Akismet 5.7, CoBlocks 3.1.17, Gravity Forms 2.6.7, Greenly Theme Setup Wizard 8.4.

**Notable delta since CMS-BOOT-001/002 (both earlier today):** a new plugin, **"Manage" v1.0.7 by Elementor.com**, is now active — it wasn't present in either prior verification pass. Its stated purpose is multi-site management via an Elementor.com account: "Safe updates, monitoring, and bulk actions." Elementor's Manage product typically includes pre-update backups and rollback as part of that feature set. **This is a real, promising lead for satisfying this mission's actual intent** — see Recommendation below — but it requires an Elementor.com account login (wp-admin/external-portal action) that this session cannot perform.

### Site state
| Item | Value |
|---|---|
| Homepage (`page_on_front`) | ID 959, "Home" |
| Posts page (`page_for_posts`) | 0 (none set) |
| Pages | 44 published, 2 draft (46 total) |
| Posts | 13 published, 2 draft, 3 auto-draft |
| Media | 54 PNG, 66 JPEG, 5 PDF (125 total) |
| `cspt-service` | 9 published |
| `cspt-portfolio` | 12 published |
| `cspt-team-member` | 6 published |
| Menus | Company (5 items), Footer Menu (3 items), Main Menu (9 items), Our Services (5 items), Top Menu Primary (9 items) |
| Menu location assignments | Only `creativesplanet-top` → "Top Menu Primary". `creativesplanet-footer` is **unassigned** (registered location, no menu attached) |
| Templates in use | `elementor_header_footer` (Elementor free's default template) confirmed on every 2026-redesign page sampled in `CMS-BOOT-002`; no active PHP template overrides found anywhere |

This matches CMS-BOOT-001/002 findings exactly except for the new "Manage" plugin — no other drift detected since this morning's verification passes.

---

## Rollback Procedure

**None exists yet.** With no database export and no file-level copy, there is currently no way to restore this site to its present state if something goes wrong during CMS implementation. This document is not a substitute for one.

---

## Verification

- ✅ Configuration snapshot (Task 3): captured and recorded above.
- ✅ Site-state snapshot (Task 4): captured and recorded above.
- ⚠️ Database backup (Task 1): **user-confirmed complete**, method/location/timestamp not reported to this session — not independently verifiable by Claude (no tool capable of it).
- ⚠️ Theme/file backup (Task 2): **user-confirmed complete**, same caveat as above.
- ✅ "Successful backup verified" (mission precondition): **satisfied per user confirmation, 2026-07-12.**

---

## Recommendation

# 🟢 GREEN — GO (backup precondition cleared)

The mission's precondition — *"No structural changes shall be made before a successful backup has been verified"* — is now satisfied per the user's direct confirmation that a full backup was taken and verified manually. This clears the mandatory gate blocking CMS-002.

**One open item, not a blocker:** the specific backup method, filename/location, and exact timestamp were not reported to this session, so this document can't record them precisely as the mission originally asked. Recommend confirming those three details for the record next time they're readily available (e.g. "Manage plugin backup, 2026-07-12 14:32, restore point ID X") — useful if a rollback is ever actually needed, but not worth blocking on.
