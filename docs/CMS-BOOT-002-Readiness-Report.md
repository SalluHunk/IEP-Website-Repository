# CMS-BOOT-002 — CMS Environment Finalization: Readiness Report

**Mission:** CMS-BOOT-002 (verification and architectural confirmation only — no content/field groups/CPTs created or modified)
**Date:** 2026-07-12
**Method:** WordPress MCP (REST + resources) + live front-end inspection via browser (public pages only, no admin/credentialed access). No SFTP/file access this session.
**Related:** [[project_phase65_cms]], [CMS-BOOT-001 report](CMS-BOOT-001-Readiness-Report.md) (prior verification pass — ACF Pro confirmed active there)

---

## 1. ACF License

⚠️ **Not verifiable via MCP.** License activation, Updates status, and activation warnings all live on wp-admin → Custom Fields → Updates — no REST/MCP surface exposes them, and this session has no browser-authenticated wp-admin access (entering admin credentials is outside what this session does). Needs a manual 30-second check by the user. Unchanged from CMS-BOOT-001.

---

## 2. Local JSON

⚠️ **Not verifiable** — `acf-json/` folder existence is a filesystem fact, not exposed via REST or wp-admin UI. No SFTP access this session.

**Recommendation (per mission instruction):** create `/wp-content/themes/greenly-child/acf-json/` once file access exists, and confirm it's writable by the web server. Save path = load path = that folder (ACF's default behavior when no custom filter overrides it — whether `greenly-child`'s `functions.php` already sets a custom path can't be confirmed without reading the file). Recommended as canonical field-group storage, consistent with [[project_phase65_cms]]'s existing recommendation.

---

## 3. Header Architecture — ✅ Determined

**Canonical source: the theme (Greenly Child), not any plugin.**

Confirmed directly from the live front end (checked on the homepage, `/portfolio/`, and `/services-old/` — all three, spanning both 2026-redesign and legacy demo content):

- `<body>` classes on every page include `ehf-template-greenly ehf-stylesheet-greenly-child manage-default` — Greenly's own bundled header/footer-via-Elementor management system, not a separate plugin.
- The nav markup itself renders with class `main-navigation cspt-navbar` — `cspt` is Greenly's own theme prefix (same prefix as `cspt-service`/`cspt-portfolio`/`cspt-team-member`), confirming theme-native markup, not a builder plugin's output.
- The header and its nav are **identical across every page checked**, both 2026-redesign pages and untouched legacy demo pages — one shared, global source, not a per-page override.
- That shared nav is driven by the real WordPress menu **"Top Menu Primary"** (ID 4), which is the only menu assigned to a registered theme location (`creativesplanet-top`), and its 9 items match the live header exactly (Home, About, Services, Industries, Case Studies, Leadership, Testimonials, Insights, Contact).

The two third-party header/footer-builder plugins flagged as redundant in CMS-BOOT-001 (Header Footer Builder for Elementor → `tahefobu_header`; Ultimate Addons for Elementor → `elementor-hf`) are confirmed **not in use** — both hold zero saved templates, and neither's expected markup signature appears on the live page.

---

## 4. Footer Architecture — ✅ Determined, and it's the main finding of this mission

**The footer is not centralized. It is duplicated per-page.**

- Legacy/demo pages (Home – Old, Our Team, Services – Old, the Portfolio archive, etc.) use the theme's real native footer (`.site-footer` / `#colophon` / `.footer-wrap`).
- Every 2026-redesign page inspected (Services 970, Leadership 972, Case Studies 978 — confirmed directly in each page's `_elementor_data`) **injects page-scoped CSS that hides the theme's native footer** (`body.page-id-970 .site-footer, #colophon, .footer-wrap, .cspt-page-title-wrap, .cspt-page-header { display:none !important; }`) and then **hand-rebuilds an entirely separate footer from scratch inside its own Elementor JSON** — logo, tagline, LinkedIn link, a "Services" link column, an "Industries" link column, a Contact block, and a copyright bar. This exact structure is copy-pasted, with only tiny wording differences, into every single redesign page's own content data.
- The WordPress "Footer Menu" (ID 28) — the thing you'd expect to be the real footer's data source — is **not used by anything**. It holds 3 dead demo placeholder items ("Privacy Policy" / "Legal Terms" / "Support", all linking to `#`) and is correctly left unassigned from the theme's registered `creativesplanet-footer` location.

**Can the duplicate footer-builder plugins be safely removed?** Based on evidence (zero saved templates in either, and the live footer coming from neither), removal looks safe — **but per mission instruction, nothing has been deleted.** This is a flag for the user to action, not an action taken.

**Why this matters for the CMS build:** a CMS-driven footer (e.g. Services links pulled live from the `cspt-service` CPT) cannot be wired in cleanly while the footer is hardcoded independently into every page. This needs a decision — consolidate into one template part before CMS-driven footer content is attempted — not because anything is broken today, but because the current duplication will fight any single-source-of-truth footer.

---

## 5. Elementor Strategy — Recorded as Canonical

Confirmed and documented per mission instruction:

> **Elementor FREE is the approved page builder. Elementor Pro will NOT be required.**
> Dynamic functionality will instead use: ACF Pro, WordPress template hierarchy, PHP template overrides, and shortcodes where appropriate.

This is not just a policy decision — it's already how the live site works. Every one of the 14 new 2026-redesign pages was built entirely in Elementor **free** (no Pro widgets, no Theme Builder, no dynamic tags in use anywhere inspected). The precedent is real, not hypothetical. What's missing today is the ACF Pro / template-hierarchy layer actually driving any of that content dynamically — right now every page's content, including the footer, is static hand-authored Elementor JSON.

---

## 6. Existing Content Types — Gap Analysis

| CPT | Published | Live sample checked | Finding |
|---|---|---|---|
| `cspt-service` | 9 | `/services-old/` | Generic Envato solar/renewable demo titles ("Energy panels", "Wind Generators", "Solar As A Service", "Solar PV Systems"...) — unrelated to IEP's real 5 service lines (Energy Management, Sustainability & Net Zero, Industrial Engineering, Consultancy & Advisory, Training & Development). **Demo content, not usable as-is.** |
| `cspt-portfolio` | 12 | `/portfolio/` archive | Generic Envato demo titles (`so-to-deliberately-dender`, `massive-deployment-of-solar-panels`, `solar-heaters-on-roof-top`...). **Demo content, not usable as-is.** But the live Case Studies page (978) itself already states the intent in its own copy: *"Individual case-study detail pages to be built as Greenly portfolio (cspt-portfolio) entries"* — confirming this CPT **is** the agreed target for real case-study content; it just hasn't been populated yet. |
| `cspt-team-member` | 6 | No live loop found to sample | Could not directly inspect current entries (not REST-exposed, no obvious live archive/loop rendering it). What's confirmed instead: the real team bios (7 people — Andy Holgate, Dr Abhishek Asthana, Tim Griffiths, Praise Varughese, Priya Saji, Saravanakumar Kandasamy, Vanessa Lengkang) are currently **hand-authored as static Elementor widgets directly inside the Leadership page** (972), not pulled from this CPT at all. |

**The cross-cutting gap:** none of the three CPTs currently render anywhere in the live 2026 redesign. All real content — services, team, case studies — exists today as hand-duplicated static markup inside individual pages' Elementor JSON. This is precisely the "pages should never contain hardcoded information" problem the CMS mandate was written to solve ([[project_phase65_cms]]). The build isn't starting from a half-populated CMS that needs light cleanup — it's starting from **zero live integration**, with the CPT shells present but full of unrelated demo data that should be treated as disposable, not migrated.

---

## 7. Existing Templates

| Page (sample) | `template` field |
|---|---|
| Services (970) | `elementor_header_footer` |
| Leadership (972) | `elementor_header_footer` |
| Case Studies (978) | `elementor_header_footer` |
| Home – Old (10) | `elementor_header_footer` |

`elementor_header_footer` is Elementor free's own built-in "Default" page template — it keeps the theme's header/footer wrapper active and gives Elementor full control of the content area. Every page checked uses it; nothing in this sample uses a page-specific custom `page-*.php` PHP template. Combined with the pattern above, the entire live site is currently 100% Elementor-page-builder-driven with zero active PHP template overrides. Whether unused custom PHP templates already sit in the theme's files (dormant, not assigned to any page) can't be ruled out without SFTP access — but none are in use today.

---

## 8. Repository Decision — CMS Implementation Strategy

Recorded per mission instruction, for the repository record:

1. **Elementor Free + ACF Pro is the official technology stack.** Elementor Pro is explicitly not required and will not be purchased for this purpose. Dynamic content will be delivered via ACF Pro fields consumed by WordPress's native template hierarchy, hand-coded PHP template overrides in `greenly-child`, and shortcodes where a template override isn't practical.
2. **Repository-first implementation remains the governing methodology** — this document, [[project_phase65_cms]], and the CMS-BOOT-001 report together form the record any future build session should read before touching wp-admin.
3. **Future implementation shall extend existing assets before creating new ones** — concretely, this means: reuse the existing `cspt-service` / `cspt-portfolio` / `cspt-team-member` CPTs (replace their demo content, don't re-register new post types alongside them), and reuse the theme's native `ehf-template-greenly` header (don't add a fourth header mechanism). The footer is the one area needing an explicit consolidation decision before extension, per Section 4 above.

---

## 9. Gap Analysis Summary

1. ACF license/activation status — unverified, needs manual wp-admin check (unchanged from CMS-BOOT-001).
2. Local JSON folder/path — unverified, needs SFTP access (unchanged from CMS-BOOT-001).
3. **Footer is duplicated across every 2026-redesign page**, not centralized — needs a consolidation decision before CMS-driven footer content can be wired in cleanly.
4. Two redundant header/footer-builder plugins confirmed unused (zero templates each) — safe-to-remove by evidence, not yet actioned (removal is out of scope for a verification-only mission).
5. **All three existing CPTs hold unrelated Envato demo content**, not real IEP data — treat as needing full replacement, not migration.
6. **None of the three CPTs currently render on any live page** — the CMS build starts from zero integration, not partial integration.
7. No active PHP template overrides exist anywhere on the live site today — the "PHP template overrides" plank of the agreed strategy (Section 5) is greenfield, and still blocked on the same SFTP access gap recorded in CMS-BOOT-001.

---

## 10. Recommendation

# 🟡 YELLOW — Architecture is now understood; two decisions needed before build starts

Nothing found here blocks starting CPT/field-group work in wp-admin (ACF Pro is active per CMS-BOOT-001, and both the header and footer mechanisms are now fully identified — no more architectural ambiguity). This stays YELLOW rather than moving to GREEN because two concrete, scoped items remain before implementation should begin in earnest:

1. **Decide the footer consolidation approach** — continue per-page duplication (fragile, fights CMS-driven content) vs. consolidate into one theme template part (needs the still-blocked SFTP access to execute, though the *decision* itself doesn't).
2. **Confirm the existing CPT content is disposable** — get explicit sign-off that the 27 published demo items across the three CPTs (9 services + 12 portfolio + 6 team members) will be replaced with real content rather than preserved, since the current data has no relationship to IEP's actual business.

**No implementation occurred.** No field groups, CPTs, taxonomies, or content were created or modified during this verification.
