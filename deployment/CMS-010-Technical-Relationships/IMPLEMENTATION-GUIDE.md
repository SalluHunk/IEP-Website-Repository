# CMS-010 — Technical Relationships Module: Implementation Guide

All steps below are wp-admin actions. None require SFTP, SSH, or file-system access. No ACF JSON import step — field registration is bundled into the Code Snippet.

## Step 1 — Install the Code Snippet

1. wp-admin → **Snippets → Add New**
2. Title: `CMS-010 — Technical Relationships (Services REST + relationship fields + endpoints)`
3. Paste the full contents of `php/relationship-helper-functions.php`
4. Leave "Only run on specific pages" unset — **must run everywhere**, including wp-admin (CMS-007's lesson)
5. **Activate**

## Step 2 — Verify the Services REST gap is closed

Ask whoever has MCP/tooling access to check: `wp_get_post_types` should now list `cspt-service` with `rest_base: "services-cpt"` (it was completely absent before this package). Also confirm `GET /iep-cms/v1/services` (with the `X-IEP-CMS-Key` header) returns all 9 real services with their post IDs — needed for Step 4/5 below.

## Step 3 — Verify all 6 relationship fields registered

wp-admin → open any Case Study, Industry Sector, or Service post → confirm a new field group appears ("Case Study Relationships (CMS-010)" / "Industry Sector Relationships (CMS-010)" / "Service Relationships (CMS-010)") alongside the existing content field group, not replacing it.

## Step 4 — Populate Case Study ↔ Industry Sector (no Services dependency — can run immediately)

Call `POST /iep-cms/v1/relate/case-study-industry` once per case study:

| Case Study (id) | industry_ids |
|---|---|
| Plastic Packaging Manufacturer (863) | [1211] (Packaging) |
| Urban Brewery – Wastewater and Biogas (864) | [1209, 1213] (Food & Beverage, Water & Environment) |
| Aluminium Recycling Plant (865) | [1212, 1214] (Energy-Intensive Manufacturing, Waste & Circular Economy) |
| Specialist Brick Manufacturing (866) | [1208] (Construction Materials) |
| Brewer's Spent Grain – Circular Use (867) | [1209, 1214] (Food & Beverage, Waste & Circular Economy) |
| Net-Zero Brewery Design (868) | [1209] (Food & Beverage) |

Each call also auto-updates the named Industry Sector's own `related_case_studies` field — no separate reverse-direction call needed.

Note: Pharmaceuticals (1210) and FMCG Manufacturing (1207) end up with zero related case studies. That's honest, not a bug — no case study evidences either sector.

## Step 5 — Populate Case Study ↔ Service (requires Step 2's Service IDs)

First call `GET /iep-cms/v1/services` to get real post IDs for these 9 titles, then call `POST /iep-cms/v1/relate/case-study-service` once per row:

| Case Study (id) | Services (by title — look up IDs in Step 2) |
|---|---|
| Plastic Packaging Manufacturer (863) | Energy, Utilities & Process Efficiency |
| Urban Brewery – Wastewater and Biogas (864) | Water, Wastewater & Circular Resource Management; Low-carbon & Resilient Energy Systems |
| Aluminium Recycling Plant (865) | Energy, Utilities & Process Efficiency; Funding, Procurement & Project Delivery |
| Specialist Brick Manufacturing (866) | Energy, Utilities & Process Efficiency; Funding, Procurement & Project Delivery |
| Brewer's Spent Grain – Circular Use (867) | Water, Wastewater & Circular Resource Management |
| Net-Zero Brewery Design (868) | Low-carbon & Resilient Energy Systems; Engineering Design, Feasibility & Investment Case |

Each traced to that case study's own live Challenge/Solution/Results text — see `DECISIONS.md` for the specific quotes each mapping is grounded in.

## Step 6 — Populate Industry Sector ↔ Service (editorial synthesis — read `DECISIONS.md` first)

| Industry Sector (id) | Services (by title) |
|---|---|
| Waste & Circular Economy (1214) | Water, Wastewater & Circular Resource Management; Technology Innovation & R&D Support |
| Water & Environment (1213) | Water, Wastewater & Circular Resource Management; Energy, Utilities & Process Efficiency |
| Energy-Intensive Manufacturing (1212) | Energy, Utilities & Process Efficiency; Low-carbon & Resilient Energy Systems; Opportunity Screening & Diagnostic Review |
| Packaging (1211) | Energy, Utilities & Process Efficiency; Product Design & Optimisation (incl. CFD, FEA and experimental analysis) |
| Pharmaceuticals (1210) | Energy, Utilities & Process Efficiency; AI-enabled Monitoring, Assurance & Continuous Improvement |
| Food & Beverage (1209) | Water, Wastewater & Circular Resource Management; Low-carbon & Resilient Energy Systems; Funding, Procurement & Project Delivery |
| Construction Materials (1208) | Energy, Utilities & Process Efficiency; Funding, Procurement & Project Delivery |
| FMCG Manufacturing (1207) | Energy, Utilities & Process Efficiency; Product Design & Optimisation (incl. CFD, FEA and experimental analysis) |

This table is reasoned judgment, not sourced from any client document — confirm with Mission Control before treating it as final, or adjust freely (it's just data in a relationship field, no code changes needed to change it).

## Step 7 — Test the shortcode

Add `[iep_related type="industries"]` (or `services`/`case_studies`) to a Case Study, Industry Sector, or Service detail page and confirm the correct chip-row of linked, clickable items renders.

## Step 8 — Nothing swapped into live pages (optional, your call)

This package doesn't add `[iep_related]` to any existing detail-page template. Doing so is optional — see `ROLLBACK.md` if you do this and want to undo it.
