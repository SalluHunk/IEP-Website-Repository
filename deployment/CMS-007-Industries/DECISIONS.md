# CMS-007 — Industries Module: Decisions

## New CPT registered, not a repurposed legacy one

Confirmed live before deciding: no `cspt-industry`-equivalent Greenly demo CPT exists. `/industry/`, `/sector/`, `/sectors/` all returned 404; only the normal `/industries/` Page (971) exists, and it uses the `elementor_header_footer` page template, not a CPT archive template. Registering `cspt-industry-sector` fresh doesn't violate the repository's standing rule against parallel/duplicate post types — nothing existing is being duplicated, unlike if a second Case-Studies-style CPT had been invented after `cspt-portfolio` was already found.

## CPT + individual detail pages, not a grid-only or repeater-field approach — Mission Control's explicit choice

The live page's 8 cards have no "read more" links and no embedded developer note implying sub-pages (unlike Case Studies' page 978, which explicitly named its target CPT). This was a genuine architecture fork, not a default — presented as an explicit choice (grid-only like Services / CPT with detail pages / simple repeater field, no CPT) rather than assumed. Mission Control chose CPT with individual detail pages, for future expansion. This package implements that choice; the resulting `/industry-sector/{slug}/` pages currently show only icon/title/summary (Overview is blank) since no page has content to justify more yet — see below.

## Overview field ships blank for all 8 sectors

Checked all reviewed sources (live page 971, `New Website Proposed Content AH ver2 2026 06 09.docx`, the brochure PDF's outline) for richer per-sector narrative beyond the existing one-line card description — none exists. The field is included in the schema (ready for real content later) but deliberately not filled with generic or templated text to make the new detail pages feel more substantial than the evidence supports. Same anti-fabrication principle applied to Case Studies' Client/Address fields and Leadership's LinkedIn URLs.

## Icons verified empirically against the site's actual Font Awesome 5.15.3 bundle, not assumed

This is the third time an icon-name mismatch has been found on this site this session (2 on the Case Studies page in WP-04, 3 more discovered on this very Industries page while researching WP-05's content). Rather than repeat the mistake a fourth time, every icon in this package's migration table was tested live via `getComputedStyle(el, '::before').content` (a real CSS rule present → some string; nothing matching → `"none"`) before being used — including confirming the site's Font Awesome version itself (5.15.3, from the actual `<link>` tags on a live page fetch) rather than assuming from memory or current Font Awesome documentation, which now defaults to FA6 naming.

## No relationship wiring to Services or Case Studies

Deliberately out of scope here. `missions/WCP-001-Progress-Register.md` names WP-08 ("Technical Relationships") as the mission for cross-linking Industries ↔ Services ↔ Case Studies, explicitly gated on WP-04–07's content existing first. Building partial relationship fields now would pre-empt that mission's own design work (e.g. whether the relationship is a taxonomy, an ACF relationship field, or something else) without the full picture of what WP-06/07 (Testimonials, Downloads) end up needing too.

## `template_redirect` bypass applied preemptively, not after finding a bug

CMS-006 (Case Studies) discovered mid-deployment that a legacy CPT's demo template could hardcode content independent of `post_content`, requiring an emergency fix. This is a brand-new CPT with no legacy template to fight — but the theme's *generic* fallback `single.php` (whatever it renders for an unrecognized CPT) was untested, so the same `template_redirect` short-circuit used in CMS-006 is applied from the start here, and new posts default their `post_content` to `[iep_industry_single]` automatically via a `save_post` hook — avoiding a repeat of needing a second deployment round to fix a demo/fallback-template surprise.
