# CMS-005 — Verification Checklist

## Fields import correctly
- [ ] "Service Details" field group appears in Custom Fields → Field Groups with 9 fields (Executive Summary, Full Description, Key Benefits, Related Case Studies, CTA Text, CTA Link, Display Order, Featured Service, SEO Summary).
- [ ] Location rule reads `Post Type equals cspt-service`.
- [ ] Fields appear on the edit screen for existing `cspt-service` items.

## Existing CPT reused
- [ ] No new post type was registered — `cspt-service` is still the only Services post type in the system.
- [ ] Post count for `cspt-service` is still 9, all 9 migrated to the v1.1 catalogue's approved titles (no Draft items expected under v1.1 — see `IMPLEMENTATION-GUIDE.md`'s "Demo content disposition") unless a deliberate deletion decision was separately made and recorded.
- [ ] All 9 titles match `MIGRATION-REPORT-v1.1.md`'s catalogue exactly (including "&" and parenthetical wording, e.g. "Product Design & Optimisation (incl. CFD, FEA and experimental analysis)").

## No URL changes
- [ ] The live Services page URL (`/services/`, page ID 970) is unchanged.
- [ ] Individual `cspt-service` item permalinks are unchanged (migrating field content on existing items doesn't change their slugs — confirm none were accidentally renamed).

## Service renders correctly
- [ ] `[iep_services_grid]` on the Services page renders all 9 approved services, in `display_order`, each showing title (Executive Summary will be blank until sourced — confirm this renders cleanly with no broken layout, per the shortcode's `if ( $summary )` guard).
- [ ] Visual appearance is consistent with the original icon-box row (card styling, spacing) — some visual difference is expected since icons aren't part of this field model (see `DECISIONS.md`); confirm this is acceptable or note it for a follow-up.
- [ ] N/A for v1.1: the `featured="1"` filtered/unfiltered two-row split from v1.0 doesn't apply — no primary/secondary distinction exists in the approved catalogue (see `DECISIONS.md`'s v1.1 addendum). Revisit only if the client specifies one.

## Related services function
- [ ] `related_case_studies` field is present and editable on each service, even though it has nothing real to relate to yet (per `DECISIONS.md` §4 — `cspt-portfolio` still holds demo content). Confirm the field itself works mechanically (can select/save a relationship), not that it shows meaningful results yet.
- [ ] No PHP error occurs when a service has an empty `related_case_studies` value.

## No Elementor conflicts
- [ ] The Elementor editor still opens normally on the Services page after Step 5's edit.
- [ ] The Shortcode widget renders live in the Elementor preview, not just on the published front end.
- [ ] No new Elementor admin notices appear.

## No PHP warnings (implied by "No Elementor conflicts" but worth its own check)
- [ ] No fatal errors or warnings after Step 3's Code Snippet activation.
- [ ] No fatal errors after Step 4's migration or Step 5's page edit.

## Sign-off
- [ ] All 9 services individually confirmed against the v1.1 migration table.
- [ ] No demo/draft items remain — all 9 slots hold approved v1.1 titles.
- [ ] Any unchecked box has a written note in `CHANGELOG.md`.
