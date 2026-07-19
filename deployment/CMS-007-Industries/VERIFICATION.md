# CMS-007 — Industries Module: Verification Checklist

## After Step 1 (ACF field group import)
- [ ] "Industry Sector Details" field group appears under Custom Fields → Field Groups
- [ ] All 4 fields present: Icon, Summary, Overview, Display Order
- [ ] Location rule shows it only applies to `cspt-industry-sector` posts

## After Step 2 (Code Snippet)
- [ ] Snippet shows as Active in Snippets list
- [ ] No PHP errors/warnings surfaced on any front-end page load

## After Step 3 (CPT registration)
- [ ] `wp_get_post_types` lists `cspt-industry-sector` with `rest_base: "industries"`
- [ ] `wp_list_cpt_items` with `rest_base: "industries"` returns an empty list (not `rest_no_route`) before Step 4

## After Step 4 (content population)
- [ ] All 8 sectors created with correct title, slug, icon, summary, display order (1–8)
- [ ] Overview intentionally blank for all 8 — confirm this wasn't accidentally auto-filled
- [ ] Each icon renders as a real glyph, not a blank/missing box — spot-check at least 2 via `getComputedStyle(el, '::before').content` (should not be `"none"`)

## After Step 5 (shortcode test)
- [ ] `[iep_industry_grid]` renders all 8 sectors, ordered 1–8, each card links to its own `/industry-sector/{slug}/` page
- [ ] Each detail page renders icon + title + summary, no broken layout from the blank Overview field
- [ ] Responsive: cards wrap sensibly at mobile (375px), tablet (768px), desktop (1280px)

## Frontend/Admin sanity
- [ ] Live Industries page (971) is unchanged unless/until Step 6 was explicitly done
- [ ] The 3 pre-existing broken icons on page 971 (fixed directly this session, not part of this package) are confirmed live: Water & Environment, "Industry challenges", "Relevant case studies" all show real icons
- [ ] No other CPT, page, or module was touched by this package
