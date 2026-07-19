# CMS-008 — Testimonials Module: Decisions

## Grid/wall display only, no individual detail pages — Mission Control's explicit choice

Presented as an explicit fork, same discipline as WP-05: grid-only vs. grid + individual detail pages. Mission Control chose grid-only this time — testimonials are quotes meant to be read together as social proof, not standalone pages, and unlike Case Studies (which had a dev note implying sub-pages), nothing here implies visitors need to read one testimonial in isolation.

## Adaptive CPT registration — checks existence at runtime rather than guessing

The wp-admin sidebar already showed a "Testimonials" menu item before this package was built, strongly suggesting `cspt-testimonial` already exists as a theme-registered CPT. But CMS-006 already proved once that a plausible-sounding guessed CPT slug for a module (`cspt-case-study`) turned out not to exist — the real one was `cspt-portfolio`. Rather than repeat that mistake in either direction (assuming it exists when it doesn't, or registering a duplicate when it does), this package's Code Snippet checks `post_type_exists('cspt-testimonial')` at runtime and takes the correct action either way: retrofits REST support if it's already there, registers it fresh if it isn't. This is a new, more robust pattern than CMS-002/006/007 used (which each committed to one assumption based on prior research) — worth reusing for any future module where CPT existence isn't 100% independently confirmed before writing the deployment package.

## Person Photo left blank for 3 of 4 real testimonials

Checked the live page directly: only Kim Beighton (Harsco Environmental) has a real photo; the other 3 (Shailesh Divani, Guy Armitage, Alex Farrer) show a 2-letter initials avatar instead — no photo exists for them anywhere in the Media Library or any reviewed source. The field is left blank for those 3 rather than searching for or generating a substitute photo, and `[iep_testimonial_grid]` reproduces the exact same initials-fallback behaviour already live, computed from `person_name` at render time — not a separate manually-entered "initials" field, so it can never drift out of sync with the actual name.

## Post title = company name, not person name

Matches the precedent set by Case Studies (post title = project/case identifier) and Portfolio, rather than Leadership's precedent (post title = person name) — testimonials are fundamentally organized by *which client* is speaking, and the live page itself uses the company logo as the primary visual identifier of each card, with the person as supporting detail underneath. `person_name` and `person_role` are separate fields precisely so the shortcode can render "Person — Role · Company" without the company name being duplicated inside a text field.

## The theme's own native field group was checked before concluding this package's fields were additive, not duplicate

A live diagnostic (`acf_get_field_groups()`/`acf_get_fields()`) run during a wp-admin UI investigation revealed `cspt-testimonial` already has a theme-native ACF field group, "Greenly - Testimonial Details" (Company Name, Testimonial Title, Link on Company Name, Star Ratings — all shallow marketing fields, `local: "php"`, registered by the theme/UAE integration itself, not this package). Confirmed it has **no overlap** with this package's fields — no quote text field, no person identity fields, no photo field — so `group_iep_testimonial_v1` fills a real gap rather than duplicating existing capability. If a future module's ACF field group turns out to genuinely overlap an existing one, that would be a real conflict needing a decision (extend the existing group vs. keep separate, per CMS-005A's own precedent for that exact question) — this isn't that case.

## Recommendation letter PDFs noted but not wired into the CMS

Two of the four testimonials (Ultra Tough Ltd, York Handmade) have actual signed recommendation letter PDFs already sitting in the Media Library (`Recommendation-letter-from-Ultra-Tough-250310-1.pdf`, ID 694; `York-Handmade-Reference.pdf`, ID 691) — real corroborating evidence for these testimonials' authenticity, found while sourcing content for this package. Not added as a CMS field or "download the letter" link — that's a new feature nobody asked for, out of this module's scope. Flagged here so a future session doesn't have to rediscover it if a "download reference" feature is ever requested.
