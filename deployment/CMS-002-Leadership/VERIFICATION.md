# CMS-002 — Leadership Module: Verification Checklist

Run through this after each deployment step in `IMPLEMENTATION-GUIDE.md`.

## After Step 1 (ACF field group import)
- [ ] "Team Member Details" field group appears under Custom Fields → Field Groups
- [ ] All 7 fields present: Job Title, Qualifications, Biography, Team Group, Profile Image, Display Order, LinkedIn URL
- [ ] Location rule shows it only applies to `cspt-team-member` posts

## After Step 2 (Code Snippet)
- [ ] Snippet shows as Active in Snippets list
- [ ] No PHP errors/warnings surfaced on any front-end page load (check a normal page, not just Leadership)

## After Step 3 (REST retrofit)
- [ ] `wp_get_post_types` (or equivalent REST check) now lists `cspt-team-member` with `rest_base: "team-members"`
- [ ] `wp_list_cpt_items` with `rest_base: "team-members"` returns real items, not `rest_no_route`

## After Step 4 (content population)
- [ ] All 7 people have all fields filled per the migration table (Qualifications intentionally blank for the 4 Team members — matches live content)
- [ ] Photos display correctly (Profile Image field resolves to the correct existing Media Library image)
- [ ] Display Order matches the live page's current order (1–7 as listed)

## After Step 5 (shortcode test)
- [ ] `[iep_team_grid]` on a test page renders all 7 people, Directors group first, Team group second
- [ ] Each Director shows: photo, name, "Director — [qualifications]", biography
- [ ] Each Team member shows: photo, name, job title, biography (no qualifications line, since none exists)
- [ ] `[iep_team_grid group="director"]` shows only the 3 directors
- [ ] `[iep_team_grid group="team"]` shows only the 4 team members
- [ ] Responsive: cards wrap sensibly at mobile width (375px), tablet (768px), desktop (1280px) — no overlap or overflow

## Frontend/Admin sanity (mission's own Task 6 requirements)
- [ ] Existing Leadership page design is unchanged unless/until the user explicitly does Step 6
- [ ] Editing a team member's fields in wp-admin (Custom Fields on the post edit screen) works and saves correctly
- [ ] No other CPT, page, or module was touched by this package
