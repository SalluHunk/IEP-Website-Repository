# CMS-006 — Case Studies Module: Verification Checklist

Run through this after each deployment step in `IMPLEMENTATION-GUIDE.md`.

## After Step 1 (ACF field group import)
- [ ] "Case Study Details" field group appears under Custom Fields → Field Groups
- [ ] All 7 fields present: Icon, Summary Snapshot, Challenge, Solution, Results, Commercial Impact, Display Order
- [ ] Location rule shows it only applies to `cspt-portfolio` posts

## After Step 2 (Code Snippet)
- [ ] Snippet shows as Active in Snippets list
- [ ] No PHP errors/warnings surfaced on any front-end page load (check a normal page, not just Case Studies or Portfolio)

## After Step 3 (REST retrofit)
- [ ] `wp_get_post_types` now lists `cspt-portfolio` with `rest_base: "case-studies"`
- [ ] `wp_get_taxonomies` now lists `portfolio-category` with `rest_base: "case-study-sectors"`
- [ ] `wp_list_cpt_items` with `rest_base: "case-studies"` returns the 12 demo items, not `rest_no_route`

## After Steps 4–5 (identification + content population)
- [ ] All 6 real case studies have all fields filled per the migration table in `IMPLEMENTATION-GUIDE.md`
- [ ] Slugs updated to the new real-project slugs (not left as the old demo slugs)
- [ ] Sector taxonomy term assigned correctly per case study (Food & Beverage / Manufacturing / Construction Materials)
- [ ] Featured image cleared on all 6 (no leftover Envato stock solar-panel photo)
- [ ] Display Order matches 1–6 as listed

## After Step 6 (single-page shortcode redirect)
- [ ] Each of the 6 migrated posts' `post_content` is `[iep_case_study_single]`
- [ ] Checked whether `_elementor_data` exists on this CPT before/after — if it does and still overrides `post_content`, `_elementor_edit_mode` was cleared (endpoint already does this) and the single-page layout renders correctly regardless

## After Step 7 (surplus unpublish)
- [ ] All 6 non-migrated demo posts show `status: draft`, not `publish`
- [ ] `/portfolio/` archive no longer shows any of the 6 unpublished demo posts
- [ ] The 6 real case studies do NOT yet appear on `/portfolio/` if they haven't been fully populated — re-check after Step 5 completes

## After Step 8 (shortcode test)
- [ ] `[iep_case_study_grid]` on a test page renders all 6 real case studies, icon + title + summary snapshot, ordered 1–6, each linking to its real `/portfolio/{slug}/` URL
- [ ] `[iep_case_study_grid sector="food-beverage"]` (or matching slug) filters correctly
- [ ] Each of the 6 `/portfolio/{slug}/` single pages renders: back link, icon, title, sector, summary, Challenge, Solution, Results (bulleted), Commercial Impact — not the old demo "About the project" Date/Client/Address box
- [ ] Responsive: cards and single-page layout read sensibly at mobile (375px), tablet (768px), desktop (1280px)

## Frontend/Admin sanity
- [ ] Live Case Studies page (978) is unchanged unless/until the user explicitly does Step 9
- [ ] Editing a case study's fields in wp-admin (Custom Fields on the post edit screen) works and saves correctly
- [ ] No other CPT, page, or module was touched by this package
