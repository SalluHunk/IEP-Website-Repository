# CMS-008 — Testimonials Module: Verification Checklist

## After Step 1 (ACF field group import)
- [ ] "Testimonial Details" field group appears under Custom Fields → Field Groups
- [ ] All 5 fields present: Quote, Company Logo, Person Name, Person Role, Person Photo, Display Order
- [ ] Location rule shows it only applies to `cspt-testimonial` posts

## After Step 2 (Code Snippet)
- [ ] Snippet shows as Active in Snippets list
- [ ] Confirm scope is "Run everywhere," not front-end-only (CMS-007 lesson — check this explicitly, don't assume)
- [ ] No PHP errors/warnings surfaced on any front-end page load

## After Step 3 (CPT REST check)
- [ ] `wp_get_post_types` lists `cspt-testimonial` with `rest_base: "testimonials-cpt"`
- [ ] Note whether existing items were found (pre-existing demo content) or the type was empty (freshly registered) — record which branch actually applied on this site

## After Step 4 (content population)
- [ ] All 4 testimonials created/populated with correct post title (company name), quote, person name/role, logo
- [ ] Kim Beighton (Harsco Environmental) has her real photo attached (Media ID 1053)
- [ ] The other 3 (Shailesh Divani, Guy Armitage, Alex Farrer) have Person Photo left blank — confirm this wasn't accidentally filled with a placeholder
- [ ] Display Order matches 1–4 as listed

## After Step 5 (shortcode test)
- [ ] `[iep_testimonial_grid]` renders all 4 testimonials, ordered 1–4
- [ ] Each card shows: logo, full multi-paragraph quote, avatar (real photo for Kim Beighton, correct 2-letter initials for the other 3), name, and "{role} · {company}" line
- [ ] Responsive: cards wrap sensibly at mobile (375px), tablet (768px), desktop (1280px)

## Frontend/Admin sanity
- [ ] Live Testimonials page (1062) is unchanged unless/until Step 6 was explicitly done
- [ ] Editing a testimonial's fields in wp-admin works and saves correctly
- [ ] No other CPT, page, or module was touched by this package
