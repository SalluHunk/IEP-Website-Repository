# CMS-002 — Leadership Module: Implementation Guide

All steps below are wp-admin actions. None require SFTP, SSH, or file-system access.

## Step 1 — Import the ACF field group

1. wp-admin → **Custom Fields → Tools**
2. Under "Import Field Groups", choose `acf-json/group_team_member_fields.json`
3. Click **Import** — this creates a field group called "Team Member Details" attached to `cspt-team-member`
4. Confirm it appears under **Custom Fields → Field Groups**

## Step 2 — Install the Code Snippet

1. wp-admin → **Snippets → Add New**
2. Title: `CMS-002 — Team Member REST + Shortcode`
3. Paste the full contents of `php/team-helper-functions.php`
4. Leave "Only run on specific pages" / front-end-only options unset — this needs to run everywhere (REST retrofit applies globally; shortcode needs to render on the front end)
5. **Activate**

## Step 3 — Verify the REST retrofit worked

Ask whoever has MCP/tooling access to check: `wp_list_cpt_items` with `rest_base: "team-members"` should now return the 7 (or however many are published) `cspt-team-member` items, instead of `rest_no_route`. If this works, future sessions can read/write this CPT directly — closing the original blocker for this module for good.

## Step 4 — Populate the 7 real records

For each person below: open their existing `cspt-team-member` post in wp-admin (or create it if it doesn't exist yet) and fill in the new ACF fields with this real content, migrated directly from the live Leadership page (972) on 2026-07-15. Nothing here is invented — verify against `https://iep.technology/leadership/` if in doubt.

| # | Name (post title) | Team Group | Job Title | Qualifications | Biography | Profile Image (existing Media ID) | Display Order |
|---|---|---|---|---|---|---|---|
| 1 | Andy Holgate | Director | Director | BEng (Hons), MIET | 25+ years in environmental sciences, engineering and manufacturing.<br>**Expertise:** design and delivery of complex energy & utilities projects.<br>**Value:** practical solutions that work in real operating environments. | 1033 (`andy-holgate-mono.jpg`) | 1 |
| 2 | Dr Abhishek Asthana | Director | Director | CEng, FEI, FIET, FHEA, PhD, MEng, MRes, BEng | **Expertise:** energy engineering and grant funding.<br>**Value:** turning 'should work' into 'does work' with credible validation. | 1034 (`abhishek-asthana-mono.jpg`) | 2 |
| 3 | Tim Griffiths | Director | Director | BSc, FCA | Chartered Accountant and former CEO/CFO; raised over $3bn for large-scale projects internationally.<br>**Value:** the financial weight to help upgrades get approved and implemented. | 1035 (`tim-griffiths-mono.jpg`) | 3 |
| 4 | Praise Varughese | Team | Mechanical Engineer | (none shown live) | MSc Advanced Mechanical Engineering. CAD, sustainability, energy management. | 519 (`PRAISE-VARUGHESE.jpg`) | 4 |
| 5 | Priya Saji | Team | Electrical Engineer | (none shown live) | MSc Advanced Engineering. Project management, electrical circuit design, CAD. | 582 (`PriyaSaji.jpg`) | 5 |
| 6 | Saravanakumar Kandasamy | Team | Mechanical Engineer | (none shown live) | MSc Automotive Engineering. CFD, FEA, thermo-fluid system modelling. | 598 (`saravanakumar.jpg`) | 6 |
| 7 | Vanessa Lengkang | Team | Chemical Engineer | (none shown live) | BEng Chemical Engineering. Process flow diagrams, Aspen Plus. | 600 (`vanessa.jpg`) | 7 |

**LinkedIn URL:** leave blank for all 7 — no real URLs exist anywhere in current content (see `DECISIONS.md` and CRN-001's own open-decision list).

## Step 5 — Test the shortcode

Add a Shortcode widget somewhere out of the way (a draft page, or a staging area of the Leadership page) with `[iep_team_grid]` and confirm all 7 people render correctly, grouped and ordered as above. Use `[iep_team_grid group="director"]` or `[iep_team_grid group="team"]` to render just one group if needed.

## Step 6 — Swap the live Leadership page (optional, your call)

Only once Step 5 looks right: on the Leadership page (972), the existing Directors/Team sections are hand-typed Elementor widgets — replacing them with the shortcode is optional, not required by this package. If you want to do it, back up the page's current design first (Elementor has its own revision history) — see `ROLLBACK.md`.
