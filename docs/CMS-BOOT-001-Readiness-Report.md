# CMS-BOOT-001 — ACF Pro Environment Verification: Readiness Report

**Mission:** CMS-BOOT-001 (verification only — no field groups created, no CPTs registered, no content modified)
**Date:** 2026-07-12
**Method:** Live inspection via WordPress MCP (`wordpress` server, REST + resource endpoints). No SFTP/file access this session — see Known Gaps.
**Related:** [[project_phase65_cms]] (Phase 6.5 CMS spec — this report supersedes its 2026-07-05 "no ACF Pro" finding)

---

## 1. ACF Pro Verification

| Check | Result |
|---|---|
| Installed | ✅ Yes — `advanced-custom-fields-pro/acf.php`, v6.8.5 |
| Activated | ✅ Yes — status `active` |
| Free ACF present but inactive | ✅ Correct hygiene — `advanced-custom-fields/acf.php` v6.8.5 installed but `inactive`, avoiding the classic free+Pro conflict |
| Latest compatible version | ✅ 6.8.5 **is** current latest (released 2026-06-30, per ACF's own changelog). Requires WP 6.2+/PHP 7.4+ — this site runs WP 6.8.5 / PHP 8.2.30, well above minimums. |
| License active | ⚠️ **Not verifiable via MCP.** License key/activation state lives on the wp-admin → Custom Fields → Updates screen (or in the `options` table) — no REST/MCP surface exposes it. Recommend a manual 30-second check before build. |
| Activation issues | ⚠️ No errors surfaced through any tool used, but this session cannot see PHP error logs or admin notices — absence of evidence isn't confirmation. |

**This is the headline change since the 2026-07-05 session:** ACF Pro is now installed and active. That was the primary RED blocker recorded in `IEP-Phase6.5-CMS-Spec.md` — it is resolved.

---

## 2. ACF Feature Availability

All of the following are **native to ACF Pro 6.8.5** and unlocked by the plugin edition itself — confirmed by plugin identity, not by opening the field-group UI (no wp-admin browser access this session):

- Options Pages ✅
- Repeater Fields ✅
- Flexible Content ✅
- Clone Fields ✅
- Relationship Fields ✅
- Gallery Fields ✅
- Group Fields ✅

None of the free-tier workarounds documented in the Phase 6.5 spec (dedicated Settings page instead of Options Page, fixed Text fields instead of Repeater) are needed anymore.

---

## 3. Local JSON

| Check | Result |
|---|---|
| Enabled | ⚠️ Not verifiable — Local JSON is a filesystem feature (writes to an `acf-json/` folder, togglable only via a PHP filter in theme code), not exposed via wp-admin UI or REST. |
| Save path / Load path | ⚠️ Not verifiable without file access to `greenly-child` |
| Repository compatibility | N/A pending the above |

**Recommendation:** Yes — Local JSON should become the canonical storage for field groups once file access exists. It's the standard practice for version-controlled ACF builds and fits this project's existing preference for hand-coded, repo-tracked theme work over admin-only configuration ([[project_design_system]]). This is a recommendation for when the SFTP blocker clears, not a confirmed current state.

---

## 4. Existing Content Audit (inventory only)

**Pages:** 46 total.
- Live 2026 redesign set (published 2026-07-04/05, front page = ID 959 "Home" per `page_on_front`): Home, About IEP, Services, Industries, Leadership, Contact, Case Studies, Insights, Resources, Testimonials, Careers, Privacy Policy, Terms & Conditions, Cookie Policy — 14 pages.
- Also live, older: Quality Management (669), Grants (648).
- Legacy Envato demo content still published: Homepage 1–8, About Us 1–6, Project Style 1/2, Blog Classic/Grid View, Our Team, FAQ, Our History, Services–Old, Contact–Old, Home–Old (ID 10), plus unused WooCommerce stub pages (Cart, Checkout, My Account, Shop — no WooCommerce plugin is installed, so these are dead).
- Drafts: Privacy Policy – Old (3), Industry News (14).

**Posts:** 15 total — 13 published, 2 drafts. The 13 published are 2018–2019 Lorem-ipsum Envato demo blog content (generic "Duis mollis…" body text), not real IEP content. One title ("Growth of Clean Energy Part of Solution, Not a Problem") is duplicated under two different slugs/dates.

**Custom Post Types** (registered by Greenly/Greenly Addons, none REST-exposed — confirmed again this session):
- `cspt-service` (Services) — 9 published
- `cspt-portfolio` (Portfolio) — 12 published
- `cspt-team-member` (Team Members) — 6 published

**Taxonomies:** only core `category`/`post_tag` plus block-editor internals (`nav_menu`, `wp_pattern_category`). No custom taxonomies exist yet for Services/Portfolio/Team Member — confirms the Phase 6.5 spec's proposed Technology/Industry/Funding libraries are still greenfield.

**Menus:** 5 registered — Company (5 items), Footer Menu (3 items), Main Menu (9 items), Our Services (5 items), Top Menu Primary (9 items). See Risks — only one is assigned to a theme location.

**Elementor Templates ("My Templates" library):** 4 items — 3 auto-generated "Default Kit" entries + 1 orphaned draft ("Grants-template-to-transfer"). No saved Section/Page/Popup templates exist.

---

## 5. Elementor Audit

| Check | Result |
|---|---|
| Elementor version | 4.1.4, active |
| Elementor Pro | ❌ Not installed — confirms 2026-07-05 finding, unchanged |
| Theme Builder templates | None — feature unavailable without Pro |
| Dynamic Tag support (ACF↔Elementor) | ❌ Not available. Free Elementor's built-in dynamic tags don't cover ACF fields; that bridge normally comes from Elementor Pro or a third-party integration (e.g. Essential Addons **Pro**). Only the **free** tier of Essential Addons for Elementor is installed (v6.6.11) — its free tier does not include ACF dynamic-tag mapping. |
| Compatibility with ACF | No activation-level conflicts found. Plugins coexist fine; the specific "auto-populate templates per CPT" capability remains architecturally blocked, exactly as the Phase 6.5 spec already concluded — still requires the hand-coded PHP template path, still gated on SFTP access. |

---

## 6. Theme Audit

| Check | Result |
|---|---|
| Active theme | Greenly Child v1.0 (Creative's Planet) |
| Child theme present | ✅ Yes, correctly structured against parent Greenly v8.4 (installed, inactive) |
| Template overrides supported | Yes, by nature of being a classic (non-FSE) PHP theme — this is a WordPress-core capability, not something requiring live verification |
| Existing custom PHP templates | ⚠️ **Not verifiable this session** — requires file/SFTP access, which per this project's working rules is not wired up. `wp_list_templates` was not usable, as expected (it requires a block/FSE theme; Greenly Child is classic). |

---

## 7. Plugin Compatibility

29 plugins total, 21 active / 8 inactive.

- **ACF-adjacent:** ACF Pro (active) + ACF Photo Gallery Field (active, compatible extension). Free ACF correctly left inactive. No conflicts.
- **Page builders:** Elementor (free) **and** WPBakery Page Builder are both active simultaneously — known/intentional per project conventions, restated here for completeness.
- **Elementor add-ons:** seven active at once — Essential Addons for Elementor, JetSticky, Header Footer Builder for Elementor (turbo addons), Ultimate Addons for Elementor (Brainstorm Force), Turbo Addons Elementor, Unlimited Elements for Elementor, plus core Elementor. Notably **two separate header/footer-builder systems are active** (`tahefobu_header`/`tahefobu_footer` from Header Footer Builder for Elementor, and `elementor-hf` from Ultimate Addons for Elementor) — and both currently have **zero saved templates**. See Risks.
- **SEO:** No dedicated SEO plugin (Yoast/RankMath/AIOSEO) is active. Likely routed through Easy MCP AI's own SEO tooling or currently unmanaged — flagging, not new (matches the still-placeholder `SEO-001` doc in this repo).
- **Caching:** No active caching plugin (W3TC/WP Super Cache/WP Rocket/LiteSpeed). "Clear Cache For Me" is active but targets cache plugins that aren't installed, so it's currently a no-op at the plugin level. Any caching is host-level (not visible via this MCP).
- **Forms:** Contact Form 7 active (matches CLAUDE.md); Gravity Forms installed but inactive — unused leftover.
- **Security:** Sucuri Security active (matches CLAUDE.md); Akismet installed but inactive.

No functional conflicts detected. The real risk here is **redundancy/bloat** (duplicate header/footer builders, two page builders, an inactive forms plugin) rather than breakage.

---

## 8. Performance Baseline

| Metric | Value |
|---|---|
| WordPress version | 6.8.5 |
| PHP version | 8.2.30 |
| Memory limit | ⚠️ Not exposed by any available MCP tool/resource |
| Upload limit | ⚠️ Not exposed |
| Active page cache | None detected at plugin level |
| Object cache | ⚠️ Not determinable via MCP |
| OPcache | ⚠️ Not determinable via MCP |

WP/PHP versions are both current and comfortably exceed ACF Pro's minimum requirements. The four unresolved rows all require wp-admin **Site Health → Info → Server** or direct server/SFTP access — none of this is REST-exposed. This is the same access gap already on record.

---

## 9. Risks

1. **ACF Pro license/activation status unverified** — confirm manually in wp-admin before build (Custom Fields → Updates).
2. **Local JSON state/path unknown** — blocks confirming version-controlled field-group storage until file access exists.
3. **Footer theme location has no menu assigned.** The theme registers two nav locations (`creativesplanet-top`, `creativesplanet-footer`); only the top one is filled (by "Top Menu Primary"). A menu literally named "Footer Menu" exists but isn't assigned to the footer location — likely a live gap, worth confirming before wiring CMS-driven footer content into it.
4. **Two redundant header/footer-builder plugins active, both empty.** Unclear which (if either) actually controls the live header/footer. Confirm before building CPT-aware header/footer templates against either system.
5. **No Elementor Pro / no ACF↔Elementor dynamic-tag bridge** — the "dynamic templates auto-populate per post" goal remains blocked exactly as the Phase 6.5 spec already concluded; the agreed hand-coded-PHP-template path is unaffected by today's findings but still needs SFTP access to start.
6. **Legacy Envato demo content still live** — 20+ demo pages and 13 Lorem-ipsum blog posts remain published. Not a technical blocker for CMS work, but will visually/structurally collide with new CPT-driven content if not addressed at some point. Out of scope for this mission.
7. **Performance baseline mostly unverifiable** — cannot rule out a server-side memory/upload constraint affecting heavier field types (Repeater/Flexible Content) at scale until Site Health or server access is available.

---

## 10. Recommendation

# 🟡 YELLOW — Minor issues, largely ready

The blocker that was RED on 2026-07-05 (no ACF Pro) is **resolved** — ACF Pro is installed, active, current, and unlocks every Pro field type the CMS spec needs. CPT/taxonomy/field-group registration work can proceed in wp-admin now.

Not GREEN because of unresolved unknowns, none of which require re-architecting anything:
- ACF license/Local JSON state need a quick manual wp-admin check (5 minutes).
- The hand-coded PHP template layer remains blocked on SFTP access — unchanged from prior finding, not a new problem.
- The header/footer builder redundancy and unassigned footer menu location should be clarified before CMS content gets wired into either system, to avoid building against the wrong target.

**No implementation has occurred.** No field groups, CPTs, taxonomies, or content were created or modified during this verification.
