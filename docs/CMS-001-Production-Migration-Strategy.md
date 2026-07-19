---
id: CMS-001
title: Production Migration Strategy
document_type: Derived Repository Document — Implementation Blueprint
version: 1.0-Draft
status: Planning Only — Not Approved for Execution
repository_layer: Specification
owner: TBD
parent: CMS Specification (IEP-Phase6.5-CMS-Spec.md), PDC-001, CRN-001, CMS-BOOT-001, CMS-BOOT-002
last_updated: 2026-07-12
---

# CMS-001 — Production Migration Strategy

## Repository Metadata

- **Document ID:** CMS-001
- **Version:** 1.0-Draft
- **Status:** Planning only. This document defines strategy — it does not execute it. No WordPress content, CPTs, Field Groups, or templates were touched in producing this document.
- **Dependencies:**
  - Depends On: `PDC-001` (constitutional branding/positioning/homepage-narrative authority), `CRN-001` (approved client design/scope decisions), `IEP-Phase6.5-CMS-Spec.md` (content-model specification), `CMS-BOOT-001-Readiness-Report` (environment verification), `CMS-BOOT-002-Readiness-Report` (architecture verification)
  - Enables: the eventual CMS-002 execution mission(s) — not started, not scoped here

This document is implementation-independent by design: it says *what* should happen and *in what order*, not *how to click through it*. Field-level detail already lives in the CMS Specification and is referenced, not repeated in full, except where the migration strategy itself changes a recommendation from that spec.

---

## Section 1 — Current State Assessment

### Current CPTs
Three custom post types already exist, registered by the Greenly theme/Greenly Theme Addons (not by ACF, not REST-exposed):

| CPT slug | Label | Published items |
|---|---|---|
| `cspt-service` | Services | 9 |
| `cspt-portfolio` | Portfolio | 12 |
| `cspt-team-member` | Team Members | 6 |

No custom taxonomies exist yet. No CPT for Case Studies, Testimonials, Clients, Industries, Insights, FAQs, Downloads, KPIs, Funding Programs, or Global Settings exists in any form.

### Current static pages
46 pages total. 14 were rebuilt 2026-07-04/05 as the approved homepage-redesign set (Home, About IEP, Services, Industries, Leadership, Contact, Case Studies, Insights, Resources, Testimonials, Careers, Privacy Policy, Terms & Conditions, Cookie Policy), all built entirely as static Elementor page content. The remaining ~30 pages are legacy Envato demo-import content (Homepage 1–8, About Us 1–6, Project Style 1/2, Blog Classic/Grid, Our Team, FAQ, Our History, Services–Old, Contact–Old, Home–Old, plus unused WooCommerce stub pages with no WooCommerce installed).

### Current demo content
`cspt-service` and `cspt-portfolio` are confirmed (CMS-BOOT-002, live front-end inspection) to hold **leftover 2022 Envato demo content unrelated to IEP** — generic renewable-energy titles ("Wind Generators", "Solar As A Service") and generic project titles ("massive-deployment-of-solar-panels"). `cspt-team-member`'s current contents were not directly inspectable (not REST-exposed, no live loop found rendering it), so its relationship to the 7 real people shown on the Leadership page is unconfirmed. CRN-001's own approved Content Direction already states: *"Eliminate Greenly placeholder content. Replace demo copy with approved client content."* — this migration executes exactly that mandate for the CPT layer, not just the pages already redesigned.

### Current Elementor usage
100% of the live 2026-redesign pages are built with Elementor **free** (`elementor_header_footer` template — Elementor's default page template, theme header/footer active, content area fully Elementor-controlled). No Elementor Pro, no Theme Builder, no dynamic tags in use anywhere. All content — service descriptions, case study summaries, team bios, KPIs — is hand-authored directly inside each page's `_elementor_data` JSON, not pulled from any CPT.

### Current footer situation
Not centralized. Every 2026-redesign page hides the theme's native footer via injected page-scoped CSS and rebuilds an entire duplicate footer (logo, Services links, Industries links, Contact block, copyright) inside its own Elementor JSON. The WordPress "Footer Menu" that would logically hold this data is unused (3 dead placeholder items). This was the central finding of CMS-BOOT-002.

### Current content duplication
Two forms, both confirmed directly:
1. **Cross-page duplication** — the footer block above, plus repeated CTA sections ("Stop the margin leak. Start the conversation.") appearing near-verbatim on Services, Leadership, and Case Studies pages.
2. **Content/CPT duplication** — real content (services, team bios, case study summaries) exists as static markup on pages *while structurally identical CPTs sit empty of real data beside them*. This is the core problem the CMS migration solves: the site already "knows" its content shape (via the CMS Spec) and already has real content (on the pages) — the two just aren't connected yet.

---

## Section 2 — Target State

### A platform update since the Spec was written
`IEP-Phase6.5-CMS-Spec.md` (2026-07-05) was written against **free ACF**, and several of its field recommendations are explicit workarounds for that (fixed Text-field slots instead of Repeater, a dedicated Settings page instead of an Options Page). CMS-BOOT-001 (2026-07-12) confirmed **ACF Pro is now installed and active**. The target state below assumes ACF Pro's native Repeater, Flexible Content, Clone, and Options Page features are used **where the original spec's field notes flagged a free-tier workaround** — this is a strict quality upgrade over the original spec, not a scope change, and every field this affects is called out per-module in Section 4.

### Target architecture, module by module
- **Dynamic Services** — `service` content (reusing `cspt-service`, see Section 4) rendered on the Services page and any future service single/archive views, with Benefits and Process now as true ACF Pro Repeater fields instead of fixed Text slots.
- **Dynamic Case Studies** — `case_study`-equivalent content (reusing `cspt-portfolio`, see Section 4) with the full relationship model: Industry, Testimonial, Download, KPI, Technology.
- **Dynamic Leadership** — `team_member` content (reusing `cspt-team-member`) rendered on the Leadership page, replacing the current hand-authored bios.
- **Dynamic Testimonials** — new `testimonial` CPT, with a Permission gate field before any client quote can publish.
- **Dynamic Clients** — new `client` CPT, driving the homepage logo carousel via a Featured flag.
- **Dynamic Resources** — merges into Downloads per the Spec's own open recommendation (see Section 4, Downloads).
- **Dynamic Downloads** — new `download` CPT, Access Level field modeled (Public/Gated) even though the MC4WP email-gate integration itself is not being built in this phase.
- **Global Site Settings** — with ACF Pro now active, this becomes a genuine **Options Page** (not the Spec's dedicated-page workaround) holding company info, footer content, and the Contact-Forms lookup table — and, critically, **this is also the mechanism that finally centralizes the footer** (Section 1's core finding).
- **Relationship model** — as specified in `IEP-Phase6.5-CMS-Spec.md`'s Relationship Architecture diagram, unchanged: Industry as the hub connecting Service, Case Study, FAQ, and Client; Case Study as the hub connecting Testimonial, KPI, Download, and Technology; Team Member and Funding Program each attaching to Technology (taxonomy) and Case Study/Service respectively.

### Explicitly out of target state for this document
Industries, Insights, FAQs, KPI Library, Technology Library, and Funding Program Library are part of the full CMS Spec but are **not required** for the first migration phases this document sequences (Section 5). They remain part of the target architecture; their migration modules are included in Section 4 for completeness but ranked lower in Section 5.

---

## Section 3 — Migration Principles

1. **Preserve before replacing.** Every existing page ID, URL, and published Elementor page stays live and functioning until its CMS-driven replacement is verified — never delete-then-rebuild.
2. **Extend before rebuilding.** Where a usable asset already exists (`cspt-service`, `cspt-portfolio`, `cspt-team-member`), add ACF field groups to it and replace its content — do not register a parallel `service`/`case_study`/`team_member` CPT alongside it. This directly continues CMS-BOOT-002's Repository Decision #3.
3. **One module at a time.** No module's migration begins until the prior module has been verified live (Section 7's success criteria) and, where relevant, its rollback path confirmed usable.
4. **Never break the live site.** All CMS-driven replacement work happens on draft/staged content first; a page only cuts over from static Elementor content to dynamic CMS content in a single, verifiable, reversible step.
5. **No bulk migration without verification.** Content is entered/verified per-item, not bulk-imported unreviewed — this matters especially because the existing CPTs currently hold demo content that must not be mistaken for real data during any bulk operation.
6. **Repository remains the governing authority.** This document, the CMS Spec, and the two CMS-BOOT reports are the source of truth for what gets built; wp-admin changes that diverge from them get reconciled back into the repository, not left undocumented.

---

## Section 4 — Module Migration Plan

### Services
- **Current Source:** Static Elementor content on the Services page (970); `cspt-service` CPT exists (9 published) but holds unrelated demo content and is not consumed by any live page.
- **Target CMS:** `cspt-service`, extended with the Spec's Service field group (Hero Title/Image, Summary, Detailed Description, Benefits, Process, Industries, Related Case Studies, Downloads, FAQs, CTA, SEO). Benefits/Process as ACF Pro Repeater (upgrade from the Spec's fixed-Text-field workaround).
- **Migration Method:** Add the field group to the existing CPT. Replace its 9 demo items with the 5 real service lines already live on the Services page (Energy Management, Sustainability & Net Zero, Industrial Engineering, Consultancy & Advisory, Training & Development), then rebuild the Services page's relevant sections to pull from the CPT instead of the static icon-box widgets.
- **Dependencies:** None blocking for a first pass (Industries/Downloads/FAQs relationship fields can be added empty and populated once those modules exist).
- **Risk:** Low-medium — `cspt-service` is not REST-exposed, so this MCP-based tooling cannot list/edit its items directly today; all content entry happens in wp-admin until/unless `show_in_rest` is enabled on the CPT registration (a PHP-level change, gated on the same SFTP access noted in CMS-BOOT-001).
- **Rollback:** Trivial — the current Services page Elementor content is untouched until the dynamic version is verified; reverting is switching the page's rendered section back to its existing static markup (already there, nothing to restore).
- **Priority:** High.

### Portfolio / Case Studies
- **Current Source:** Static Elementor content on the Case Studies page (978), which explicitly states in its own copy that individual detail pages are intended to be `cspt-portfolio` entries. `cspt-portfolio` exists (12 published) but holds unrelated demo content.
- **Target CMS:** `cspt-portfolio`, extended with the Spec's Case Study field group (Industry, Client Name, Location, Challenge/Solution/Implementation/Results, Financial Savings, CO₂ Reduction, Payback, Gallery, Testimonials, Downloads, Technologies, Featured, SEO, KPIs).
- **Migration Method:** Add the field group to the existing CPT. Migrate the 6 real case studies already summarized on the live Case Studies page (Plastic Packaging Manufacturer, Urban Brewery, Aluminium Recycling Plant, Specialist Brick Manufacturing, Brewer's Spent Grain, Net-Zero Brewery Design) into `cspt-portfolio` items, replacing the 12 demo entries. Build single-item detail pages once the template layer exists (Section 7 of the CMS Spec).
- **Dependencies:** Full value requires the Industry, Testimonial, KPI, and Download modules below — this module can start immediately with core fields, but its "automatically shows animated KPIs" and "related testimonial" behaviors wait on those modules.
- **Risk:** Medium — highest relationship-model complexity of any module; also not REST-exposed, same wp-admin-only editing constraint as Services.
- **Rollback:** Same pattern as Services — static Case Studies page content is untouched until verified.
- **Priority:** High (matches the Spec's own ⭐ highest-priority flag) — but sequenced *after* Leadership in Section 5, for reasons explained there.

### Leadership
- **Current Source:** 7 real people hand-authored as static Elementor widgets on the Leadership page (972). `cspt-team-member` exists (6 published) but is not consumed by any live page and its current contents are unverified.
- **Target CMS:** `cspt-team-member`, extended with the Spec's Team Member field group (Designation, Qualifications, Photo, Biography, Achievements, Expertise, LinkedIn, Email, Phone, Display Order). Achievements as ACF Pro Repeater (upgrade from the Spec's fixed-Text-field workaround).
- **Migration Method:** Add the field group. Verify/reconcile the 6 existing published items against the 7 people currently live on the Leadership page (a discrepancy needs resolving — either an 8th item is missing or one of the 6 items is stale/demo data). Rebuild the Leadership page's team sections to pull from the CPT.
- **Dependencies:** None — Expertise/Technology taxonomy can be added empty and populated later.
- **Risk:** Low — no cross-CPT relationships required for a working first version; the only open question is the 6-vs-7 count reconciliation above.
- **Rollback:** Static Leadership page content untouched until verified.
- **Priority:** High — see Section 8 for why this is the recommended first module.

### Testimonials
- **Current Source:** A live "Testimonials" page (1062) exists in the page inventory but its content was not inspected during CMS-BOOT-001/002 — treat its current build method as unconfirmed rather than assumed static.
- **Target CMS:** New `testimonial` CPT per the Spec (Client, Company, Industry, Photo, Quote, Rating, Project relationship, Permission gate, Featured, Display Order).
- **Migration Method:** Register new CPT (no existing asset to extend — none of the three current CPTs cover this). Populate from whatever real testimonial content exists on the live Testimonials page once inspected.
- **Dependencies:** Project relationship depends on Case Studies existing as a queryable CPT (can be added empty and back-filled).
- **Risk:** Low — small, flat content model; the only real risk is the unverified Permission/consent status of any quotes being migrated (do not publish a client quote without confirmed permission, per the Spec's own Permission field).
- **Rollback:** Trivial — new CPT, no existing page structure depends on it yet.
- **Priority:** Medium.

### Clients
- **Current Source:** None identified — no dedicated Clients page or content was found in the CMS-BOOT-001/002 page/CPT inventory.
- **Target CMS:** New `client` CPT per the Spec (Company, Logo, Industry, Website, Description, Projects relationship, Display Order, Featured).
- **Migration Method:** Register new CPT. Content does not yet exist anywhere on the live site — this is net-new content creation, not migration, and needs client input before it can be populated.
- **Dependencies:** Needs client-supplied logos and permission-to-display confirmation before any items are Featured (same consent caution as Testimonials).
- **Risk:** Low technically, but blocked on content availability, not architecture.
- **Rollback:** N/A — nothing live depends on this yet.
- **Priority:** Low (blocked on content, not sequencing).

### Insights
- **Current Source:** A live "Insights" page (983) exists; content/build method not inspected.
- **Target CMS:** New lightweight `insight` CPT per the Spec (LinkedIn Post URL, cached title/excerpt/thumbnail, date, Featured). Sync method: manual paste-in, per the Spec's own recommendation — not RSS or the LinkedIn API.
- **Migration Method:** Register new CPT. Editorial workflow: paste LinkedIn URL, fill title/excerpt/thumbnail by hand per post.
- **Dependencies:** None.
- **Risk:** Low.
- **Rollback:** N/A — new CPT.
- **Priority:** Low.

### Downloads (absorbing Resources)
- **Current Source:** A live "Resources" page (984) exists; content/build method not inspected. No download-tracking CPT exists.
- **Target CMS:** New `download` CPT per the Spec, with a Category taxonomy term distinguishing "Resources" (whitepapers/guides/brochures) from case-study-linked downloads, per the Spec's own recommendation to merge rather than build two parallel CPTs.
- **Migration Method:** Register new CPT with Category taxonomy. Populate from real files once the live Resources page's actual content is confirmed.
- **Dependencies:** None blocking; Access Level (Public/Gated) field is modeled now but the MC4WP gating integration itself is out of scope for this phase.
- **Risk:** Low.
- **Rollback:** N/A — new CPT.
- **Priority:** Medium.

### Global Settings
- **Current Source:** None — company info, footer content, and CTA form references are currently hardcoded per-page (this is what causes the footer duplication finding in CMS-BOOT-002).
- **Target CMS:** ACF Pro **Options Page** (upgrade from the Spec's dedicated-page workaround, now that ACF Pro is active) holding Phone/Email/Address/LinkedIn/Footer text/Copyright/Company Registration/VAT, plus the Contact-Forms purpose-to-ID lookup table.
- **Migration Method:** Build the Options Page and field group. Migrate the footer content currently duplicated across every 2026-redesign page into it, then convert each page's footer section to reference the Options Page instead of its own hardcoded copy — this is the concrete fix for CMS-BOOT-002's central finding, and needs a decision on whether the eventual footer is delivered as a shared Elementor template part or a PHP `get_template_part()` include once file access exists.
- **Dependencies:** None technically — but this module's footer-consolidation piece is explicitly the "decision needed before build" item flagged in CMS-BOOT-002.
- **Risk:** Medium — touches every live page's footer at once by nature (a shared source is the point), so this is the one module where "never break the live site" (Principle 4) needs the most care: stage the Options Page and new shared footer fully, verify on one page, then roll out.
- **Rollback:** Keep each page's current hardcoded footer markup in place (commented out or otherwise recoverable) until the shared version is verified across all pages, not just one.
- **Priority:** High — but sequenced deliberately in Section 5, not first, because it touches every page at once.

---

## Section 5 — Implementation Sequence

**Recommended order: Leadership → Global Settings → Services → Downloads → Testimonials → Case Studies → Clients / Insights (parallel, low priority).**

Reasoning:
1. **Leadership first** — lowest relationship complexity, an existing CPT with real content already live to migrate from, and a single page's blast radius if something needs correcting. It's the cleanest possible proof that "editors can update content without touching Elementor" (Section 7) actually works end-to-end before anything more complex is attempted. See Section 8 for the full case.
2. **Global Settings second** — once one module (Leadership) has proven the CPT-to-page pipeline works, fixing the footer duplication is the next highest-leverage, lowest-relationship-dependency item, and every subsequent module benefits from having a working Options Page and centralized footer before it ships its own content.
3. **Services third** — existing CPT, existing real content, no hard relationship dependencies for a first pass (Industries/Downloads/FAQs can attach later).
4. **Downloads fourth** — needed before Case Studies can use its Downloads relationship field meaningfully, and before Services' Downloads field is anything but empty.
5. **Testimonials fifth** — same reasoning: needed before Case Studies' Testimonial relationship is meaningful.
6. **Case Studies sixth** — the Spec's stated highest-priority module, deliberately sequenced after its dependencies (Downloads, Testimonials) exist, rather than first, so its relationship fields are meaningful on day one instead of empty.
7. **Clients and Insights last, in parallel** — both are content-blocked (Clients needs client-supplied logos/permissions; Insights needs an editorial workflow decision) rather than architecture-blocked, so they can proceed independently once content is available, without gating anything else.

Industries, FAQs, KPI Library, Technology Library, and Funding Program Library are not sequenced in this phase — they are enrichment layers on top of the six modules above and should be scoped in a follow-up mission once the core six are live and verified.

---

## Section 6 — Risk Register

| Risk | Description | Mitigation |
|---|---|---|
| Broken links | Cutting a page over to CMS-driven content mid-edit could break its own URL or internal links to it. | Principle 4 — stage and verify before cutover; never edit the live page directly. |
| Demo content exposure | `cspt-service`/`cspt-portfolio` currently hold Envato demo items; if REST access were ever enabled on them before content is replaced, demo content could become publicly queryable/visible. | Replace demo content as part of the same migration step that adds the field group — never leave a REST-exposed CPT holding demo data. |
| Template conflicts | Elementor-authored page sections and future PHP template overrides (per the CMS Spec's template architecture) both targeting the same content risks double-rendering or style conflicts. | Confirmed via CMS-BOOT-002: no PHP template overrides exist yet, so there is no current conflict — but this must be re-checked the moment SFTP access lands and template work begins. |
| Footer duplication | Already confirmed live (CMS-BOOT-002) — every 2026 page hardcodes its own footer copy. | Addressed directly by the Global Settings module (Section 4); sequenced second specifically to limit how many pages inherit the old pattern before it's fixed. |
| Relationship integrity | ACF Relationship fields are one-directional per side (per the Spec) — a broken or one-sided relationship (e.g. a Case Study pointing to a Testimonial that doesn't point back) silently degrades the "related content" experience without erroring. | Verify both sides of every relationship as part of each module's content entry, not just the side being actively edited. |
| Caching | No active page-cache plugin was found (CMS-BOOT-001), but host-level caching (e.g. WP Engine EverCache) can't be ruled out. Dynamic CMS content changes may not appear immediately if such caching exists. | Verify content updates render live immediately after each module's cutover; if stale content is observed, that's the signal a cache layer exists and needs a purge step added to the editorial workflow. |
| Non-REST CPT editing constraint | `cspt-service`/`cspt-portfolio`/`cspt-team-member` are not REST-exposed, so this MCP-based tooling cannot list or edit their items directly — all content entry for the three "extend existing asset" modules happens manually in wp-admin. | Either accept wp-admin-only editing for these three modules, or flip `show_in_rest` on their registration once SFTP/file access exists (a small, low-risk PHP change) to bring them into the same tooling as everything else. |
| Consent/permission on migrated quotes | Testimonials and Clients both involve displaying a third party's name/quote/logo publicly. | Never publish a migrated Testimonial or Client item without the Permission/consent field explicitly confirmed true — do not assume historic display implies current consent. |

---

## Section 7 — Success Criteria

- **No broken URLs.** Every page's URL and every existing internal/external link to it continues to resolve after its module's migration.
- **No data loss.** No real content (the 5 services, 6 case studies, 7 leadership bios, or any other verified-real content) is deleted or overwritten before its CMS-driven replacement is confirmed live and correct.
- **Editors can update content without Elementor.** The concrete test: a non-technical editor can change a team member's bio, add a new service, or update a case study's figures entirely through wp-admin's post-edit screen, with the change appearing on the live page — without opening the Elementor editor.
- **Repository remains consistent.** This document, the CMS Spec, and the CMS-BOOT reports stay in sync with what's actually built — any divergence discovered during execution gets reconciled back into the repository, not left undocumented (Migration Principle 6).
- **Demo content is fully retired.** Zero Envato/Greenly placeholder items remain published in any of the three existing CPTs once their respective modules are marked complete.
- **Footer is single-sourced.** Once the Global Settings module is complete, no page contains its own hardcoded copy of the footer — all pages render from the one shared source.

---

## Section 8 — Recommended First Module

# Leadership

**Reasoning:**

The Spec itself flags Case Studies as highest business priority, and that priority is not disputed here — but "highest business value" and "safest first module" are different questions, and Migration Principle 3 ("one module at a time") means the first module chosen sets the pattern every later one inherits.

Leadership wins on every safety dimension:
- **Existing asset, real content already live** — unlike Clients or Insights, there's nothing to source from scratch; unlike Testimonials, there's no unresolved consent question; unlike Services, the CPT-to-page pipeline hasn't been proven yet on anything.
- **Zero relationship dependencies.** Case Studies needs Industry, Testimonial, KPI, and Download to exist before its relationship fields mean anything. Leadership needs none of that — Expertise/Technology is the only relationship field, and it's optional at launch.
- **Single-page blast radius.** Only the Leadership page consumes this content. If something needs correcting mid-migration, exactly one page is affected — compare to Global Settings, which by design touches every page at once (which is precisely why Global Settings is sequenced second, not first: it needs one proven module ahead of it before taking on that wider blast radius).
- **Directly demonstrates the core success criterion.** "Editors can update content without Elementor" (Section 7) is most convincingly proven on the simplest possible content type — a name, title, photo, and biography — before attempting it on something with six relationship fields and financial figures.

Recommendation: implement Leadership first, verify all of Section 7's success criteria against it specifically, and only then proceed to Global Settings and the rest of the sequence in Section 5.

---

## Repository Alignment

This document derives from and remains consistent with:
- **`PDC-001`** — no architectural decision here conflicts with the constitutional branding, positioning, or homepage-narrative articles; Global Settings' footer consolidation exists specifically to protect the approved brand consistency PDC-001 Article VI establishes.
- **`IEP-Phase6.5-CMS-Spec.md`** — this document does not redefine any field-level content model; it sequences and derisks the Spec's own module list, and upgrades three named workarounds (Repeater fields, Options Page) now that ACF Pro is confirmed active.
- **`CRN-001`** — directly executes the approved Content Direction ("Eliminate Greenly placeholder content. Replace demo copy with approved client content") and respects the approved Scope Decision that CMS work follows ACF Pro and homepage-redesign completion — both now confirmed complete per CMS-BOOT-001/002. Sprint 2 approval status itself is not confirmed in any source available to this document and should be verified before execution begins.
- **`CMS-BOOT-001`** — ACF Pro's active status is the basis for every "upgrade over the Spec" noted in Sections 2 and 4.
- **`CMS-BOOT-002`** — the footer-duplication finding, the "CPTs exist but render nowhere" finding, and the confirmed header/footer architecture are the direct basis for this document's Current State Assessment, the Global Settings module, and the "extend before rebuilding" principle.

---

## Stop

This document defines strategy only. No execution mission (CMS-002 or otherwise) has been started or scoped beyond what Section 5 sequences. Do not begin implementation from this document alone — it requires explicit sign-off, plus resolution of the open items already on record (Sector-vs-Industry, Insights sync method, Resources-vs-Downloads merge — all in the CMS Spec's own Open Decisions; and the two decisions CMS-BOOT-002 flagged: footer consolidation approach, and confirming the 27 published demo CPT items are disposable).
