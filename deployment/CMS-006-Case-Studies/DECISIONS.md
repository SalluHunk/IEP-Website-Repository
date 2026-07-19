# CMS-006 — Case Studies Module: Decisions

Every judgment call in this package, with reasoning. Read this before deploying or before changing the field model.

## Target CPT: `cspt-portfolio`, not a new `cspt-case-study`

Not invented this session — the live Case Studies page (978) contains its own embedded developer note: *"Individual case-study detail pages to be built as Greenly portfolio (cspt-portfolio) entries."* This was confirmed against the live `/portfolio/` archive, which exists and already contains 12 published demo posts (Envato Lorem Ipsum, solar-panel stock content — "Swedish Mega Project," "Massive Deployment Of Solar Panels," etc.), same unregistered-REST-route blocker `cspt-team-member` had before CMS-002. Registering a *new* CPT here would have violated the repository's own standing rule against parallel/duplicate post types (first laid down in CMS-002's blocker analysis).

## No Client or Address fields

The demo template's single-post layout (checked live, one real example fetched: `/portfolio/swedish-mega-project/`) has "About the project" meta fields for Date, Client, Category, and Address. This package's field group omits Client and Address entirely. Reason: `New Website Proposed Content AH ver2 2026 06 09.docx` §2 is headed, verbatim, **"2. ANONYMISED CASE STUDIES (MINIMUM SIX)"** — every one of the 6 real case studies is identified only by an anonymised sector descriptor ("Plastic Packaging Manufacturer," "Urban Brewery," etc.), never a real company name, and no address exists for any of them. Adding Client/Address fields and leaving them blank would silently invite someone to fill in a fabricated company name or address later, defeating a confidentiality requirement stated explicitly in a Primary Source — so the fields aren't offered at all, not left empty.

## Icon, not photo

The demo template's single-post layout has a featured image per post; the live Case Studies page (978) instead represents each project with a Font Awesome icon on its card (`fa-industry`, `fa-beer-mug-empty`, `fa-recycle`, `fa-fire`, `fa-wheat-awn`, `fa-leaf`). This package's field group adds an Icon field and does not add a photo field, for two reasons: (1) it matches the already-approved, already-live visual pattern exactly, and (2) no real project photography exists — CRN-001 lists "final hero imagery" as an open decision, and nothing in any reviewed source suggests per-case-study photography exists or is planned. The demo posts' own featured images (generic Envato solar-panel stock photos) are explicitly cleared during migration (Step 5) rather than kept, since keeping a mismatched stock photo on an unrelated real case study (e.g. a solar-panel image on "Plastic Packaging Manufacturer") would be actively misleading — worse than having no image at all.

## Sector taxonomy: 3 terms, reusing the existing `portfolio-category` taxonomy

The demo taxonomy terms (Solar, Sun, Energy) are artifacts of the Envato solar-panel demo content and don't describe any real IEP work — not reused. Three new terms are seeded instead: **Food & Beverage**, **Manufacturing**, **Construction Materials** — these are not invented; they're the exact section headings the content source document (§3, "INDUSTRIAL SECTORS LIST (ANONYMISED)") uses to group its own anonymised sector list, and they cover all 6 real case studies without a remainder (3 Food & Beverage, 2 Manufacturing, 1 Construction Materials). This package retrofits REST support onto the *existing* `portfolio-category` taxonomy (same technique CMS-005A used to register `service_category` from scratch) rather than creating a second, parallel taxonomy.

## Results as a plain textarea, not an ACF repeater

Each case study's Results section is 3–4 short bullet points. A repeater field would model this more "correctly," but this package's own precedent (`CMS-002`'s Biography/Qualifications) favours plain fields over structured sub-fields where the content is short and stable. One newline-delimited textarea, split into `<li>` elements at render time by `[iep_case_study_single]`, avoids an extra field-group complexity layer for content that doesn't need per-item metadata (no icons, links, or ordering within the list itself).

## 12 demo posts, only 6 real case studies — 6 moved to draft, not deleted

The opposite ratio from CMS-002 (7 real people, only 6 demo slots, one new post created). Here there are twice as many demo posts as real case studies. This package migrates 6 and moves the other 6 to `draft` status via a dedicated `/unpublish` endpoint route — deliberately *not* a permanent delete. Permanently deleting content is outside this session's standing authority regardless of how clearly unwanted the Lorem Ipsum content is; draft status is fully reversible and keeps the decision to permanently remove them with the user, at their own discretion, whenever they choose.

## Live page 978's card copy treated as more current than the 2026-06-09 content document, where the two differ

One real, resolved conflict, in the same spirit as `PDC-001` Article VI's colour-palette conflict: the content document's Case Study 4 (Specialist Brick Manufacturing) has an explicit unresolved placeholder — *"Substantial annual fuel cost reduction Quantify??"* — while the live, already-published Case Studies page shows a specific resolved figure, **£84,000/yr**. Since the live page is more recent (published) and represents content the client has already seen and approved, its figure is used for Commercial Impact, not the document's placeholder. Same treatment applied to Case Study 3 (Aluminium Recycling), where the document says "six-figure" and the live page specifies **≈£150,000/yr** — the live page's more precise figure is used, folded together with the document's fuller "grant funding secured and project approved" language which the live page's shorter card copy omits for space.

## REST retrofit included as part of this package, not a separate mission

Same reasoning as CMS-002: the Code Snippet includes a small, standard, low-risk WordPress technique (hooking `init` at priority 20 to set `show_in_rest`/`rest_base` on already-registered types) for both the CPT and its taxonomy, alongside the shortcodes. This directly closes the same root-cause blocker documented in `missions/WCP-001-Progress-Register.md` Blocker A, and — like CMS-002 — retrofits existing types rather than registering new ones, so it doesn't create anything new or duplicate anything.
