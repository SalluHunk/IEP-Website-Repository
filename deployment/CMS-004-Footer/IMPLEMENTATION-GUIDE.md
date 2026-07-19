# CMS-004 — Implementation Guide

## Architecture

**Current footer source:** split. The theme's real footer (`.site-footer`/`#colophon`/`.footer-wrap`, Greenly-native) still serves legacy/demo pages. Every one of the 14 2026-redesign pages instead hides that real footer with page-scoped injected CSS and hand-rebuilds an entire duplicate footer as static Elementor widgets inside its own content — confirmed directly on Services (970), Leadership (972), and Case Studies (978).

**Target footer source:** one canonical `greenly-child/footer.php`, rendered through the theme's normal `get_footer()` call — meaning every page, redesigned or legacy, gets the same footer automatically, with nothing page-specific left to maintain.

**Dynamic data flow:** `footer.php` → `iep_get_global_setting()` / `iep_get_global_image_url()` (from `CMS-003`) → ACF Options Page `global-settings` → rendered logo, tagline, LinkedIn, address, email, phone, copyright. Footer navigation (Services/Industries link columns, legal links) is not stored on the Options Page at all — it's sourced from three dedicated WordPress menus instead (see Navigation, below).

**Dependency on Global Settings:** hard dependency for the text/image fields (see `README.md`); no dependency for navigation, which uses WP's native menu system instead.

**Future extensibility:** because this is now real PHP reading from a real settings store, adding a newsletter signup (MC4WP), a Default Social Image use in `<meta>` tags, or additional legal text is a small, contained change to `footer.php` later — not a per-page Elementor edit repeated 14 times.

## Navigation: WordPress Menus, not an ACF Repeater

**Recommendation: WordPress Menus.** Reasoning:
- It's the WordPress-native, purpose-built mechanism for exactly this — a list of labeled links — and it's the same mechanism already driving the site's header nav (`CMS-BOOT-002` confirmed the header uses `wp_nav_menu()` against a real WP menu). Using it for the footer too means one consistent navigation architecture for the whole site, not two.
- The site's editors already use this screen — 5 menus exist today (Appearance → Menus is not a new concept for whoever maintains this site).
- WP menu items can point directly at any post type by ID — including `cspt-service`/`cspt-portfolio` — without needing an ACF Relationship field. If/when the Services CPT gets real content (per `CMS-001`'s sequencing), the same footer menu can be updated to link to real service pages instead of the static `/services/` anchor it uses today, with zero code change.
- An ACF Repeater would duplicate what WP Menus already does natively, require editors to learn a second, less-standard interface, and lose the built-in drag-and-drop reordering Appearance → Menus already provides.

Two existing menus were checked and rejected as reuse candidates — see `README.md`'s "What's reused vs. newly created" section. Three new menus are the right call here, not a shortcut.

**Preserving today's exact behavior:** today's Services and Industries footer links all point at the same two URLs (`/services/`, `/industries/`) regardless of link label — they're not yet deep links to individual items. The new menus should be built the same way for now (Custom Link items, same URLs, same labels), to guarantee zero behavior change. Deep-linking to real CPT items is future work, not part of this package.

---

## Deployment order

Deploy in this exact order. Doing it out of order either breaks the site temporarily or silently no-ops.

### Step 1 — Confirm CMS-003 is deployed and reviewed
Check `CMS-003-Global-Settings/VERIFICATION.md` is fully signed off. Do not proceed until it is.

### Step 2 — Deploy the footer helper functions (Code Snippet)
wp-admin → Snippets → Add New → `CMS-004 — Footer Helper Functions` → paste `php/footer-helper-functions.php` → run **Everywhere** → Activate. This registers the three menu locations `footer.php` needs — nothing visible changes yet.

### Step 3 — Create the three footer menus
Appearance → Menus → create three new menus:
- **Footer — Services**, assigned to the "Footer — Services" location. Add 4 Custom Link items: "Energy studies," "Grant funding," "Project delivery," "Decarbonisation" — all pointing at `https://iep.technology/services/` (matches today's live footer exactly).
- **Footer — Industries**, assigned to the "Footer — Industries" location. Add 4 Custom Link items: "Manufacturing," "Food & Beverage," "Pharmaceuticals," "Packaging" — all pointing at `https://iep.technology/industries/`.
- **Footer — Legal Links**, assigned to the "Footer — Legal Links" location. Add 5 items linking to the real existing pages: Privacy Policy (`/privacy-policy/`), Terms & Conditions (`/terms-conditions/`), Cookie Policy (`/cookie-policy/`), Careers (`/careers/`), Resources (`/resources/`).

### Step 4 — Deploy footer.php (requires file/SFTP access)
Place `php/footer.php` at `greenly-child/footer.php`. If a `footer.php` already exists there, back it up first (copy it somewhere safe, don't delete it) before overwriting.

### Step 5 — Verify on a page NOT yet cleaned up
Visit a legacy/demo page (one that never had the hide-footer CSS injected, e.g. one of the "Homepage" demo pages) and confirm the new dynamic footer renders correctly there. This proves `footer.php` itself works, independent of the cleanup step.

### Step 6 — Run the cleanup script, ONE page at a time
Deploy `php/one-time-remove-duplicate-footers.php` as a Code Snippet (admin-only, safe by default — see the file's own header comment for exactly how the dry-run/live flags work). For each of the 14 page IDs (959, 965, 970, 971, 972, 973, 978, 979, 980, 981, 982, 983, 984, 1062):
1. Visit `/wp-admin/?iep_footer_cleanup_page=<id>` first (dry run) — confirm it reports removing exactly one `hide_footer_style` and one `footer_section` entry.
2. Visit `/wp-admin/?iep_footer_cleanup_page=<id>&iep_footer_cleanup_live=1` to apply it.
3. Immediately load that page's live URL in a new tab and visually confirm: the new dynamic footer renders, no duplicate footer appears, nothing else on the page changed.
4. Only move to the next page ID once the current one is confirmed clean.

### Step 7 — Delete the cleanup snippet
Once all 14 pages are confirmed clean, delete the Code Snippet from Step 6 entirely — it's single-use, not meant to stay active.

### Step 8 — Full verification pass
Run through `VERIFICATION.md` in full before considering this module done.
