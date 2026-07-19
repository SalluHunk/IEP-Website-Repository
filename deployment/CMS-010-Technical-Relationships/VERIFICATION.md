# CMS-010 — Technical Relationships Module: Verification Checklist

## After Step 1 (Code Snippet)
- [ ] Snippet shows as Active in Snippets list
- [ ] Confirm scope is "Run everywhere," not front-end-only
- [ ] No PHP errors/warnings surfaced on any front-end or wp-admin page load

## After Step 2 (Services REST gap)
- [ ] `wp_get_post_types` lists `cspt-service` with `rest_base: "services-cpt"` (previously absent entirely)
- [ ] `GET /iep-cms/v1/services` (with `X-IEP-CMS-Key`) returns exactly 9 items, matching the titles in `CMS-005A-Service-Taxonomy-Deployment-Report.md`
- [ ] Existing Services page (`/services/`) and `[iep_services_by_category]` still render correctly — unaffected by the REST retrofit (REST visibility doesn't change front-end shortcode behaviour)

## After Step 3 (field registration)
- [ ] "Case Study Relationships (CMS-010)" appears on Case Study edit screens, alongside (not replacing) CMS-006's "Case Study Details"
- [ ] "Industry Sector Relationships (CMS-010)" appears on Industry Sector edit screens, alongside CMS-007's "Industry Sector Details"
- [ ] "Service Relationships (CMS-010)" appears on Service edit screens, alongside CMS-005's "Service Details" and CMS-005A's "Service Icon"

## After Step 4 (Case Study ↔ Industry Sector)
- [ ] All 6 case studies show correct `related_industries` via `GET /iep-cms/v1/relate/{case_study_id}`
- [ ] All 8 industry sectors show correct `related_case_studies` via the same endpoint (reverse sync worked) — Pharmaceuticals and FMCG Manufacturing correctly show an empty array, not an error
- [ ] Spot-check one case study in wp-admin: the Relationship field UI shows the correct linked Industry Sector post(s) by name

## After Step 5 (Case Study ↔ Service)
- [ ] All 6 case studies show correct `related_services`
- [ ] Reverse sync confirmed on at least 2 services (their `related_case_studies` includes the expected case study IDs)

## After Step 6 (Industry Sector ↔ Service)
- [ ] All 8 industry sectors show correct `related_services`
- [ ] Reverse sync confirmed on at least 2 services

## Bidirectional sync correctness (test at least once, not just assumed)
- [ ] Pick one case study, call `/relate/case-study-industry` again with a *different* industry_ids array (e.g. drop one, add another) — confirm the old industry's `related_case_studies` no longer includes this case study, and the new one does. This proves the diff-based sync (not just additive) actually works.

## After Step 7 (shortcode test)
- [ ] `[iep_related type="industries"]` on a Case Study page renders the correct linked Industry Sector chips, each clicking through to the right `/industry-sector/{slug}/` page
- [ ] `[iep_related type="services"]` on a Case Study page renders correctly (once Step 5 is done)
- [ ] `[iep_related type="case_studies"]` on an Industry Sector page renders correctly
- [ ] A post with zero relationships (e.g. Pharmaceuticals' `related_case_studies`) renders nothing (empty string), not a broken/empty visible block

## Frontend/Admin sanity
- [ ] No existing page (Case Studies, Industries, Services, Testimonials) was visually changed by this package — everything here is additive infrastructure
- [ ] Testimonials genuinely untouched — no relationship field added to `cspt-testimonial`, confirmed by checking its edit screen shows no new "CMS-010" field group
