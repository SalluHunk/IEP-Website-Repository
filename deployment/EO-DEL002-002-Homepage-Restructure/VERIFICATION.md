# EO-DEL002-002 — Verification

After the live run (§Deployment sequence, step 3) and cache purge (step 4):

## Structural checks (Claude will run these via cache-busted fetch)
- [ ] Fresh fetch of `/` shows 15 top-level sections in the new order: Hero → Commercial Challenge ("Waste is a margin leak") → Who We Help ("Built for energy-intensive industry") → Why IEP → Funding Capability → Methodology → **Services ("Core services")** → **Case Studies ("Featured case studies")** → **Technical Capability** → **Leadership** → Testimonials → CTA.
- [ ] "Core services" section renders the same 9-service, 3-category taxonomy as `/services/` — not the old 8-item list.
- [ ] "Book Opportunity Screening" CTA now appears at the end of the Services section, not the end of Methodology.
- [ ] Methodology section no longer contains the CTA text/button.
- [ ] Homepage response includes `<meta name="description" content="...">`.

## Visual checks (screenshots — desktop/tablet/mobile, per modified section)
- [ ] Services section: shortcode renders correctly, band styling on the middle category doesn't visually clash mid-homepage (this is the one thing to watch — the banding was designed for `/services/` as a standalone page; verify it still reads well embedded between other homepage sections).
- [ ] Section reordering reads naturally scrolling top to bottom — no jarring transition at the new Commercial-Challenge→Who-We-Help or Methodology→Services→Case-Studies→Technical-Capability→Leadership boundaries.
- [ ] Mobile: services grid and category bands don't break layout at narrow widths.

## Governance checks
- [ ] `_elementor_edit_mode` is still `builder` (confirmed by the script itself, but re-verify).
- [ ] No content was invented — every section still says what it said before, only position and the services-section implementation changed.

## If something looks wrong
Do not attempt a live fix under pressure. Per `POA-GOV-001`'s Escalation Model — stop, document what's wrong, and either restore from a WordPress page revision or ask for a targeted follow-up fix, rather than iterating live on production.
