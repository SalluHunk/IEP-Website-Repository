# CMS-007 — Industries Module: Implementation Guide

All steps below are wp-admin actions. None require SFTP, SSH, or file-system access.

## Step 1 — Import the ACF field group

1. wp-admin → **Custom Fields → Tools**
2. Under "Import Field Groups", choose `acf-json/group_industry_sector_fields.json`
3. Click **Import** — creates a field group called "Industry Sector Details" attached to `cspt-industry-sector`
4. Confirm it appears under **Custom Fields → Field Groups**

## Step 2 — Install the Code Snippet

1. wp-admin → **Snippets → Add New**
2. Title: `CMS-007 — Industry Sector CPT + Shortcodes`
3. Paste the full contents of `php/industry-sector-helper-functions.php`
4. Leave "Only run on specific pages" unset — needs to run everywhere
5. **Activate**

## Step 3 — Verify the CPT registered correctly

Ask whoever has MCP/tooling access to check: `wp_get_post_types` should now list `cspt-industry-sector` with `rest_base: "industries"`. Since this is a brand-new CPT (not a retrofit), there should be zero items until Step 4.

## Step 4 — Create and populate the 8 real records

Create 8 new `cspt-industry-sector` posts (via the REST API/authenticated endpoint, or directly in wp-admin) with this content, migrated verbatim from the live Industries page (971):

| # | Title | Slug | Icon (verified FA5) | Summary | Display Order |
|---|---|---|---|---|---|
| 1 | FMCG Manufacturing | `fmcg-manufacturing` | `fas fa-industry` | High-throughput production where energy is a core operating cost. | 1 |
| 2 | Construction Materials | `construction-materials` | `fas fa-hard-hat` | Kilns, furnaces and high-temperature process heat. | 2 |
| 3 | Food & Beverage | `food-beverage` | `fas fa-utensils` | Breweries, distilleries and processing with heavy utilities demand. | 3 |
| 4 | Pharmaceuticals | `pharmaceuticals` | `fas fa-flask` | Tightly controlled processes with significant thermal loads. | 4 |
| 5 | Packaging | `packaging` | `fas fa-box` | Thermal oxidation, curing and heat-intensive lines. | 5 |
| 6 | Energy-Intensive Manufacturing | `energy-intensive-manufacturing` | `fas fa-bolt` | Sites where energy directly drives competitiveness. | 6 |
| 7 | Water & Environment | `water-environment` | `fas fa-tint` | Wastewater treatment, water reuse and resource recovery. | 7 |
| 8 | Waste & Circular Economy | `waste-circular-economy` | `fas fa-recycle` | Waste-to-energy, resource recovery and alternative fuels. | 8 |

**Overview field: leave blank for all 8.** No richer per-sector narrative exists in any reviewed source — see `DECISIONS.md`. Do not invent expanded copy to fill the detail page; it will render correctly with just the icon, title and summary until real content is provided.

**Icons:** all 8 values above were empirically verified live against this site's actual Font Awesome 5.15.3 bundle (`getComputedStyle(el, '::before').content` test) before being listed here — do not substitute a different icon name without the same verification, per the lesson in `DECISIONS.md`.

## Step 5 — Test the shortcodes

Add a Shortcode widget somewhere out of the way with `[iep_industry_grid]` and confirm all 8 sectors render, icon + title + summary, ordered 1–8, each linking to its own `/industry-sector/{slug}/` page. Visit a few of those pages directly and confirm `[iep_industry_single]` renders correctly (icon, title, summary — no Overview shown, since it's blank, which is expected).

## Step 6 — Swap the live Industries page (optional, your call)

Page 971's 8 hardcoded cards already show correct, approved copy and don't strictly need to change. Replacing them with `[iep_industry_grid]` (so each card links through to its detail page) is optional — see `ROLLBACK.md` if you do this and want to undo it.
