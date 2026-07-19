# CMS-010 — Technical Relationships Module: Decisions

## Testimonials excluded — presented to Mission Control before building anything, not assumed

Case Studies were deliberately anonymised at the client's request (`New Website Proposed Content AH ver2 2026 06 09.docx` §2 is headed verbatim "ANONYMISED CASE STUDIES" — see WP-04's own `DECISIONS.md`, which is why that module has no Client/Address fields at all, not just blank ones). Looking at the real Testimonials (Ultra Tough Ltd, York Handmade, Harsco Environmental, Naylor Industries Plc) against the real Case Study titles (Plastic Packaging Manufacturer, Urban Brewery, Aluminium Recycling Plant, Specialist Brick Manufacturing, Brewer's Spent Grain, Net-Zero Brewery Design), some pairings are plausibly inferable by a reader even without an explicit label (e.g. a specialist-materials testimonial next to a specialist-materials case study). Deliberately not asserting or recording any specific pairing anywhere in this repository, even informally — doing so would itself partially de-anonymise the case studies regardless of whether it were ever published. Presented the yes/no question directly to Mission Control rather than deciding either way. **Mission Control chose: keep them separate.** No `related_case_studies`/`related_testimonials` field exists on `cspt-testimonial`, and this package never queries or writes to it.

## Services REST gap — fixed as a prerequisite, not a separate ask

`wp_get_post_types` confirmed `cspt-service` was the only content-bearing CPT on this site never retrofitted for REST access. This wasn't a judgment call — every other module needed the same fix and got it as a matter of course; Services simply hadn't needed it yet because CMS-005/CMS-005A's writes all happened through a Code-Snippet-internal `get_posts()`/`update_field()` path that never required REST. Two of this package's three relationship pairs touch Services, so the fix is bundled in rather than treated as optional.

## Fields registered in PHP, not via ACF JSON import

Every relationship field is an *addition* to an existing CPT's data model, not a new CPT's primary field set — the same shape as CMS-005A's "Service Icon" field, which set the precedent for registering additive fields via `acf_add_local_field_group()` inside the Code Snippet rather than a separate ACF Tools JSON import. Reusing that precedent here removes a deployment step (no JSON import needed) and, more importantly, guarantees each new field group is physically separate from CMS-002/005/006/007/008's own groups — nothing here can collide with or overwrite an existing group's configuration.

## Genuinely bidirectional, not just additive

`iep_sync_relationship()` computes a diff (added vs. removed) against the *previous* value of the "from" field every time it's called, and applies both additions and removals to the reverse side. A simpler "always append to the reverse field" approach would accumulate stale relationships forever once anything is ever corrected or re-scoped — diffing against the prior state was worth the extra code to avoid that failure mode from day one, rather than discovering it later the way several prior modules discovered gaps only after deployment.

## Case Study ↔ Industry Sector — grounded in existing categorisation + explicit title/content language, not invented

Every case study already carries a `cspt-portfolio-category` term (Food & Beverage / Manufacturing / Construction Materials, 3 terms) from WP-04. That 3-term taxonomy is coarser than the 8 real Industry Sectors, so this mapping refines it using the case study's own title/content wherever the existing category alone is ambiguous — never contradicting the existing category, only adding a second link where the content clearly supports one:
- **Plastic Packaging Manufacturer** (category: Manufacturing) → **Packaging** — the company's own name is unambiguous.
- **Urban Brewery** (category: Food & Beverage) → **Food & Beverage** (exact) + **Water & Environment** — the entire case study is about wastewater treatment cost reduction; the content is literally about water/environment, not just brewing.
- **Aluminium Recycling Plant** (category: Manufacturing) → **Energy-Intensive Manufacturing** (high-temperature furnace exhaust) + **Waste & Circular Economy** (the company's own name is "Recycling Plant").
- **Specialist Brick Manufacturing** (category: Construction Materials) → **Construction Materials** (exact).
- **Brewer's Spent Grain – Circular Use** (category: Food & Beverage) → **Food & Beverage** (exact) + **Waste & Circular Economy** (the case study's own title says "Circular Use"; content describes protein recovery and "zero waste operation").
- **Net-Zero Brewery Design** (category: Food & Beverage) → **Food & Beverage** (exact) only — kept to a single link since, unlike the other two brewery case studies, nothing in its text specifically evidences a second sector beyond brewing itself.

Pharmaceuticals and FMCG Manufacturing end up with zero related case studies — correct and honest, not a gap to fill. No case study evidences either sector; inventing a link would be worse than leaving it empty.

## Case Study ↔ Service — traced to specific text in each case study, not the case study's category

Each link below quotes the exact phrase it's grounded in:
- **Plastic Packaging Manufacturer** → *Energy, Utilities & Process Efficiency* — "Large quantities of natural gas consumed in thermal oxidation," "Heat recovery integration."
- **Urban Brewery** → *Water, Wastewater & Circular Resource Management* — the entire challenge is wastewater treatment cost; *Low-carbon & Resilient Energy Systems* — "Up to 20% biogas substitution in boilers."
- **Aluminium Recycling Plant** → *Energy, Utilities & Process Efficiency* — "waste heat recovery technology"; *Funding, Procurement & Project Delivery* — "grant funding secured and project approved."
- **Specialist Brick Manufacturing** → *Energy, Utilities & Process Efficiency* — "heat recovery strategy"; *Funding, Procurement & Project Delivery* — "government funding secured."
- **Brewer's Spent Grain** → *Water, Wastewater & Circular Resource Management* — near-verbatim match to the case study's own title ("Circular Use") and its "biomass fuel production" content.
- **Net-Zero Brewery Design** → *Low-carbon & Resilient Energy Systems* — "zero-net-carbon thermal energy," "100% renewable/recovered thermal"; *Engineering Design, Feasibility & Investment Case* — this is explicitly a design-phase case study for a new facility, not a retrofit.

Deliberately conservative — capped at 2 services per case study, keeping only the most directly textually-evidenced matches rather than exhaustively linking every plausible service. A future session could add more if a case study's content is re-read more generously, but starting narrow and evidenced beats starting broad and guessed.

## Industry Sector ↔ Service — explicitly editorial synthesis, not sourced from client content

Checked exhaustively before building this pairing: no source document in the repository (live pages, `CONTENT-001-Services/*`, `CRN-001`, `PDC-001`, the brochure, the questionnaire) maps which services apply to which of the 8 industry sectors. This is not a migration of existing evidence the way the other two pairs are — it's reasoned domain judgment about which of IEP's 9 real services would typically be relevant to which of the 8 real sectors they say they serve, informed by general engineering-consultancy practice (e.g. every sector gets *Energy, Utilities & Process Efficiency* since that's IEP's most universally-applicable service; water-intensive sectors get *Water, Wastewater & Circular Resource Management*; sectors with heavier product/process specificity get *Product Design & Optimisation*). Presented this limitation directly to Mission Control before building it — Mission Control explicitly authorized building it anyway, understanding it as synthesis rather than sourced fact. Recommend a review pass against this table once real content exists to check it against (e.g. if `CONTENT-001-Services`-style per-sector briefs are ever produced). Nothing here is presented as a client claim anywhere in the package's own copy — every reference to this table (README, IMPLEMENTATION-GUIDE, the ACF field's own `instructions` text) explicitly flags it as editorial.

## No relationship wiring for Resources or Leadership

Resources (WP-07) shipped with zero real content — nothing exists yet to relate to anything. Leadership (WP-03) is organized by person, not by sector/service, and nothing in any reviewed source implies a "this person worked on this project/sector" relationship the client has asked for — building one would be inventing a claim about which named individual did which specific work, a materially different (and much more sensitive) kind of fact than "this project relates to this sector," and not something to guess at.

## Stale demo meta noticed on Case Study posts, not touched — out of this package's scope

While reading full case study content, found each of the 6 posts still carries old Envato demo postmeta that was never cleared: `cspt-portfolio-details_client: "Envato Group, US"`, `cspt-portfolio-details_address: "2946 Angus Road, NY"`, and a stray Lorem-Ipsum `cspt-short-description` field. These are inert — WP-04's `template_redirect` bypass means the theme's hardcoded template that would have displayed them never runs for this CPT, and nothing in this package or `[iep_case_study_single]` reads them. Not fixed here, since it's unrelated to relationships and touching WP-04's already-verified-correct case study posts for an unrelated cleanup would be scope creep. Flagged here so a future cleanup pass doesn't have to rediscover it.
