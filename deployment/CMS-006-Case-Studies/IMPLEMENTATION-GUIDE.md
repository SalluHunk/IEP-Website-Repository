# CMS-006 — Case Studies Module: Implementation Guide

All steps below are wp-admin actions. None require SFTP, SSH, or file-system access.

## Step 1 — Import the ACF field group

1. wp-admin → **Custom Fields → Tools**
2. Under "Import Field Groups", choose `acf-json/group_case_study_fields.json`
3. Click **Import** — this creates a field group called "Case Study Details" attached to `cspt-portfolio`
4. Confirm it appears under **Custom Fields → Field Groups**

## Step 2 — Install the Code Snippet

1. wp-admin → **Snippets → Add New**
2. Title: `CMS-006 — Case Study REST + Shortcodes`
3. Paste the full contents of `php/case-study-helper-functions.php`
4. Leave "Only run on specific pages" / front-end-only options unset — this needs to run everywhere (REST retrofit applies globally; shortcodes need to render on the front end)
5. **Activate**

## Step 3 — Verify the REST retrofit worked

Ask whoever has MCP/tooling access to check: `wp_list_cpt_items` with `rest_base: "case-studies"` should now return the 12 published `cspt-portfolio` demo items, instead of `rest_no_route`. Also check `wp_get_taxonomies` now lists `portfolio-category` with `rest_base: "case-study-sectors"`. If both work, future sessions can read/write this CPT directly — closing the original blocker for this module for good.

## Step 4 — Identify which of the 12 demo posts to repurpose

The 12 existing `cspt-portfolio` demo posts (all Envato Lorem Ipsum / solar-panel stock content, unrelated to IEP) and which 6 this package repurposes:

| Current demo slug | Action | New slug | Real case study |
|---|---|---|---|
| `so-to-deliberately-dender` | **Migrate** | `plastic-packaging-manufacturer` | 1. Plastic Packaging Manufacturer |
| `massive-deployment-of-solar-panels` | **Migrate** | `urban-brewery-wastewater-to-energy` | 2. Urban Brewery — Wastewater & Biogas |
| `solar-heaters-on-roof-top` | **Migrate** | `aluminium-recycling-plant` | 3. Aluminium Recycling Plant |
| `swedish-mega-project` | **Migrate** | `specialist-brick-manufacturing` | 4. Specialist Brick Manufacturing |
| `consectetur-adipiscing` | **Migrate** | `brewers-spent-grain-circular-use` | 5. Brewer's Spent Grain — Circular Use |
| `supportour-technicians` | **Migrate** | `net-zero-brewery-design` | 6. Net-Zero Brewery Design |
| `solar-panel-in-row-house` | Unpublish (draft) | — unchanged — | surplus demo, no 7th real case study exists |
| `individual-houses-villas` | Unpublish (draft) | — unchanged — | surplus demo |
| `powerful-equipment` | Unpublish (draft) | — unchanged — | surplus demo |
| `eco-project-tunis` | Unpublish (draft) | — unchanged — | surplus demo |
| `solar-roof-project` | Unpublish (draft) | — unchanged — | surplus demo |
| `wind-project-dewas` | Unpublish (draft) | — unchanged — | surplus demo |

The specific demo→real mapping (which of the 12 becomes which case study) is arbitrary — none of the demo posts have any real content worth preserving — so this table just assigns them in the order both lists were encountered. Match by the **current slug** shown above, not by post ID (IDs weren't knowable until Step 3's REST retrofit was live).

## Step 5 — Populate the 6 real records

For each of the 6 posts above: use the authenticated endpoint (`POST /wp-json/iep-cms/v1/case-study/{id}` with header `X-IEP-CMS-Key: <the key in case-study-helper-functions.php>`) or edit directly in wp-admin. Content below is migrated from the live Case Studies page (978, already-approved summary/commercial-impact copy) and `New Website Proposed Content AH ver2 2026 06 09.docx` §2 (Primary Source, Verified — Challenge/Solution/Results narrative). Where the live page's figure is more refined than the source document (e.g. Case Study 4's fuel-saving figure), the live page's figure is used — see `DECISIONS.md`.

**Also clear the featured image** (`featured_media: 0`) on all 6 — the demo posts' existing stock solar-panel photos (`img-04.jpg`/`img-05.jpg`) would misrepresent an unrelated industrial process; no real project photography exists to replace them with (see `DECISIONS.md`).

### 1. Plastic Packaging Manufacturer (`plastic-packaging-manufacturer`)
- **Sector:** Manufacturing · **Icon:** `fas fa-industry` · **Display Order:** 1
- **Summary Snapshot:** Natural gas consumed oxidising VOCs via two RTOs. ≈£60,000/yr savings, ~48-month payback.
- **Challenge:** Large quantities of natural gas consumed in thermal oxidation of VOC emissions.
- **Solution:** Heat recovery integration for curing room and office heating systems.
- **Results:** Reduced electricity consumption / Reduced gas consumption / Lower CO₂ emissions
- **Commercial Impact:** ~£60,000 annual savings; payback ~48 months

### 2. Urban Brewery — Wastewater & Biogas (`urban-brewery-wastewater-to-energy`)
- **Sector:** Food & Beverage · **Icon:** `fas fa-beer-mug-empty` · **Display Order:** 2
- **Summary Snapshot:** Effluent charges set to rise ≈€750,000/yr; cut to <€100,000/yr; potential benefit > €700,000.
- **Challenge:** A major urban brewery faced an increase in wastewater treatment costs of approximately €750,000 per year following changes to municipal charging arrangements.
- **Solution:** We designed a containerised anaerobic digestion solution integrated with existing steam generation infrastructure.
- **Results:** Wastewater costs reduced from ~€750,000/year to <€100,000/year / Up to 20% biogas substitution in boilers / Natural gas costs reduced by 8–10% / Investment approved
- **Commercial Impact:** Potential annual benefit > €700,000

### 3. Aluminium Recycling Plant (`aluminium-recycling-plant`)
- **Sector:** Manufacturing · **Icon:** `fas fa-recycle` · **Display Order:** 3
- **Summary Snapshot:** High-temperature furnace exhaust vented to atmosphere; six-figure fuel savings (≈£150,000/yr); grant secured.
- **Challenge:** High-temperature furnace exhaust gases vented to atmosphere after failed previous recovery attempts.
- **Solution:** Specialist waste heat recovery technology and advanced controls strategy.
- **Results:** Significant waste heat recovery / Reduced fuel consumption / Improved operational reliability
- **Commercial Impact:** Six-figure annual fuel savings (≈£150,000/yr); grant funding secured and project approved

### 4. Specialist Brick Manufacturing (`specialist-brick-manufacturing`)
- **Sector:** Construction Materials · **Icon:** `fas fa-fire` · **Display Order:** 4
- **Summary Snapshot:** Twin-kiln exhaust deemed too challenging to recover; £84,000/yr fuel reduction; dryer gas eliminated; grant secured.
- **Challenge:** Twin-kiln operation prevented conventional heat recovery approaches.
- **Solution:** Process integration study and bespoke automated heat recovery strategy.
- **Results:** Reduced natural gas consumption / Improved process efficiency / Enhanced asset life
- **Commercial Impact:** £84,000/yr fuel cost reduction; government funding secured

### 5. Brewer's Spent Grain — Circular Use (`brewers-spent-grain-circular-use`)
- **Sector:** Food & Beverage · **Icon:** `fas fa-wheat-awn` · **Display Order:** 5
- **Summary Snapshot:** Low-value disposal of spent grain; 35% recovered as protein; 75% lower gas demand; ~80% carbon reduction.
- **Challenge:** Low-value disposal route for brewer's spent grain.
- **Solution:** Protein recovery plus biomass fuel production.
- **Results:** 35% recovered as high-value protein ingredient / 75% reduction in natural gas demand / Zero waste operation / ~80% carbon reduction
- **Commercial Impact:** Dual revenue generation plus major fuel cost savings

### 6. Net-Zero Brewery Design (`net-zero-brewery-design`)
- **Sector:** Food & Beverage · **Icon:** `fas fa-leaf` · **Display Order:** 6
- **Summary Snapshot:** Greenfield brewery with zero-net-carbon thermal energy; 100% renewable/recovered thermal; 5–7 MW; 800m³ storage.
- **Challenge:** Design a new brewery with zero-net-carbon thermal energy generation.
- **Solution:** Solar thermal collectors, thermal storage, waste heat recovery and electrification strategy.
- **Results:** 100% thermal demand supplied from renewable and recovered sources / 5–7 MW thermal capacity / 800m³ thermal storage system
- **Commercial Impact:** Elimination of long-term fossil fuel dependency and carbon costs

## Step 6 — Point each migrated post's single-page rendering at the new shortcode

For each of the 6 migrated posts, call `POST /wp-json/iep-cms/v1/case-study/{id}/use-single-shortcode` — this sets `post_content` to `[iep_case_study_single]` so the individual `/portfolio/{slug}/` page renders the real Challenge/Solution/Results layout instead of the demo template's Date/Client/Address fields. **Verify per-post whether the demo content was Elementor-authored (`_elementor_data` present + `_elementor_edit_mode = builder`) before assuming this alone is enough** — CMS-002 v1.4 found Elementor's stored layout silently overrides `post_content` when present; if that's true here too, `_elementor_edit_mode` also needs clearing (the endpoint already does this) and `_elementor_data` should be left in place but confirmed inert.

## Step 7 — Unpublish the 6 surplus demo posts

For each of the 6 non-migrated demo posts listed in Step 4, call `POST /wp-json/iep-cms/v1/case-study/{id}/unpublish` (moves to draft — reversible, not a permanent delete).

## Step 8 — Test the shortcodes

Add a Shortcode widget somewhere out of the way with `[iep_case_study_grid]` and confirm all 6 real case studies render, grouped by icon/summary, ordered 1–6. Visit each of the 6 real `/portfolio/{slug}/` URLs directly and confirm `[iep_case_study_single]` renders the full Challenge/Solution/Results/Commercial Impact layout, not the old demo "About the project" box.

## Step 9 — Swap the live Case Studies page (optional, your call)

Page 978's 6 hardcoded Elementor cards already show the correct approved copy and don't strictly need to change. If you want the cards to link through to real detail pages instead of being static, that requires either (a) adding a link to each existing icon-box widget pointing at the matching `/portfolio/{slug}/` URL from Step 4's table (smallest change, keeps the existing hardcoded cards), or (b) replacing the whole card section with `[iep_case_study_grid]` (bigger change, matches Leadership's precedent). Neither is required by this package — see `ROLLBACK.md` if you do (a) or (b) and want to undo it.
