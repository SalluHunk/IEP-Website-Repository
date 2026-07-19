---
id: WCP-001-PROGRESS-REGISTER
title: WCP-001 — Website Completion Program — Progress Register
purpose: Single persistent tracking document for Operation Horizon / WCP-001, updated after every completed Work Package
status: Complete — all 11 Work Packages done, open items carried forward per each WP's own report
version: 1.0.0
owner: Engineering Corps (Claude) / Mission Control (user)
last_updated: 2026-07-19
---

# WCP-001 — Website Completion Program

**Directive:** Execution Order 001, Operation Horizon. Production phase — implement, materialize, validate and commit each Work Package sequentially; stop only at governance ambiguity, missing client content, repository conflict, or a confirmed production blocker.

## Overall Progress

```
█████████████████████ 100%  (11 of 11 complete)
```

| WP | Name | Status |
|----|------|--------|
| 01 | Homepage Finalization | ✅ Implemented, DB-verified — live-visual confirmation pending host cache purge |
| 02 | Technical Capability Experience | ✅ Implemented, DB-verified — live-visual confirmation pending host cache purge |
| 03 | Leadership CMS | ✅ Deployed and populated — all 7 real people live in `cspt-team-member`, DB-verified. `[iep_team_grid]` shortcode ready; swapping it into the live Leadership page is optional, user's call |
| 04 | Case Studies CMS | ✅ Deployed and populated — all 6 real case studies live in `cspt-portfolio`, DB-verified. 6 surplus demo posts moved to draft. Live-visual confirmation pending host cache purge. |
| 05 | Industries CMS | ✅ Deployed and populated — all 8 real sectors live in `cspt-industry-sector`, DB-verified, detail pages confirmed live. |
| 06 | Testimonials CMS | ✅ Deployed and populated — all 4 real testimonials live in `cspt-testimonial`, DB-verified. 1 surplus demo post moved to draft. `[iep_testimonial_grid]` shortcode ready but not yet visually spot-checked (grid-only, no individual pages to check against). |
| 07 | Downloads / Resources CMS | ✅ Deployed and verified — `cspt-resource` REST-visible, smoke test (create/populate/verify/delete) passed end to end. Zero real content, by design (see WP-07 report). Icon fix DB-confirmed, pending host cache purge for live-visual. |
| 08 | Technical Relationships | ✅ Deployed and fully verified — Services REST gap closed, all 3 relationship pairs populated and bidirectionally correct across all 23 relationship-bearing posts. Phantom-zero bug (found during verification) fixed, redeployed, and cleaned — `/relate/cleanup` confirmed idempotent (0 remaining issues on repeat call). |
| 09 | Homepage Journey Validation | ✅ Validated — section order matches `PDC-A001`'s 12-stage model exactly, no broken links, no responsive overflow at 3 breakpoints. Leadership section confirmed CMS-driven (a stale deferred note corrected). 3 real findings surfaced, not silently fixed: Case Studies section still hardcoded (now actionable), Hero/Trust-Metrics duplication (still open from WP-01), no durable rollback backup exists for the 2026-07-14 restructure. |
| 10 | Website Validation | ✅ Validated — zero broken links across all real pages, ~30 orphaned demo pages confirmed genuinely unlinked. 4 real findings surfaced: Industries/Leadership listing pages don't link to their own working detail pages, 13 junk demo blog posts remain published with no real Insights feature built, sitewide meta-description gap (only homepage has one), a stray generic LinkedIn link on Contact. CLAUDE.md's page count (30) and plugin list are stale — noted, not edited. |
| 11 | Repository Validation | ✅ Validated — all 9 deployed CMS packages structurally consistent; POA-META-001's governance registry accurate. 2 real findings surfaced: two unrelated documents both claim `id: CMS-001` (a genuine numbering collision), and the root `README.md` is severely stale (still says "no content mission is active" despite 10 of 11 WPs now complete). Not edited — flagged for Mission Control. |

---

## 🟢 Blocker A — RESOLVED to a path (2026-07-15): no SFTP available, proceeding via deployment packages

**SFTP investigation concluded 2026-07-15.** The host is GoDaddy Managed WordPress (confirmed via the user's FileZilla config — real host `zmm.c7d.myftpupload.com`, not WP Engine as earlier assumed). GoDaddy's restricted panel only allows creating a single FTP account whose password can't be viewed or edited after creation, and offers no SSH-key option. The user offered to paste the password into chat each session — declined, as a standing rule independent of consent (handling a live credential in plain text through this session's context isn't something explicit authorization changes). **No SFTP path exists for this engagement, full stop.**

This turned out not to matter as much as it first appeared to: the actual write-side blocker (CPTs like `cspt-team-member` having no REST route) can be fixed **without any file access at all** — a small, standard WordPress technique (retrofitting `show_in_rest`/`rest_base` onto an already-registered CPT via an `init` hook) installs as a normal Code Snippet through wp-admin, which the user already has access to. Combined with ACF's own JSON import tool (also wp-admin, no file access) and the native post editor, the full CMS-003/004/005 deployment-package pattern covers this completely. **Proceeding on path 2 from the original three options below.**

### Original findings (superseded by the above, kept for the record)

This was a **production blocker** under WCP-001's own stop conditions, not a task-level obstacle to route around.

**What was tested, right now, not assumed from memory:**
- `wp_get_post_types` (REST-registered types only) returns no `cspt-*` types at all — only `post`, `page`, `attachment`, and theme/plugin scaffolding types.
- `wp_list_cpt_items` against `cspt-team-member`, `cspt-service`, `cspt-testimonial`, `cspt-case-study` all return `rest_no_route` — these post types exist in the database (per `CMS-002-Leadership-Module-Report.md`'s prior findings, e.g. 6 published `cspt-team-member` items) but have no REST route, so **no MCP tool can read or write them.**
- Registering a brand-new CPT (needed for Case Studies/Industries if they don't already exist as legacy `cspt-*` types) requires the same PHP registration step this session cannot perform.

**Root cause:** `show_in_rest` is off for these post types, and fixing it (or registering new CPTs) requires editing theme/plugin PHP — which requires either SFTP/hosting file access (not wired up this session, confirmed in `CLAUDE.md`) or a human working directly in wp-admin. This was first hit in `CMS-BOOT-001`, reconfirmed in `CMS-002`'s execution report (2026-07-12), and reconfirmed again live just now (2026-07-14) — it has not changed.

**What this blocks:** WP-03 (Leadership), WP-04 (Case Studies), WP-05 (Industries), WP-06 (Testimonials), and WP-08 (relationship-wiring, which has nothing to relate until 03–06 exist). **This is 4 of the 11 Work Packages, roughly hard-blocked**, plus WP-08 downstream of them.

**WP-07 (Downloads/Resources) is only partially caught by this** — WordPress's native `Media` (attachment) post type **is** REST-exposed, so PDF uploads, categorisation via Media, and a resources listing built on Posts/Pages + Media could proceed without a new CPT. Worth scoping separately from 03–06.

**The proven workaround pattern (already used successfully for CMS-003 and CMS-004, and prepared-but-unapplied for CMS-005):** Claude prepares a full deployment package — ACF field-group JSON, PHP helper/shortcode files (Code-Snippets-deployable), implementation guide, verification checklist, rollback plan — and a human applies it via Code Snippets or SFTP. CMS-003 (Global Settings) and CMS-004 (Footer) both reached production this way. CMS-005 (Services) is packaged and ready but not yet applied.

**Recommended path forward (not decided unilaterally — flagging per WCP-001's own governance rules):**
1. Wire up SFTP/hosting file access for this engagement, so `show_in_rest` can be fixed directly and future CMS work stops hitting this wall repeatedly, **or**
2. Continue the CMS-003/004/005 pattern: Claude prepares full deployment packages for WP-03–07 (code + content + docs) ready for manual application, without claiming they're "live" until a human applies them and confirms, **or**
3. Reorder the backlog — do WP-02, WP-09, WP-10, WP-11 (no CPT dependency) now, defer WP-03–08 until (1) or (2) is actioned.

**No fabricated workaround was attempted** (e.g. inventing a parallel REST-exposed CPT, or writing CMS content into an unrelated post type) — this would violate the repository's own standing rule against parallel/duplicate post types, first laid down in the CMS-002 mission.

---

## WP-01 — Homepage Finalization — Execution Report

### Executive Summary
Completed both concrete tasks from the WP-01 brief: hero headline copy corrected, and the Executive Confidence Strip trimmed and tightened. Implemented directly against the live `_elementor_data` for page 959, independently re-verified after push. Live visual confirmation is pending a host cache purge for this specific change (same mechanical dependency as every prior direct-DB Elementor push this engagement — not a new issue).

### Completed Work
1. **Hero headline:** `Fund the investment.` → `Fund the future.` (widget `9199a96`) — aligns the H1 with the page's own `<title>` meta, which already said "Fund the future" before this edit (a pre-existing inconsistency, now resolved).
2. **Executive Confidence Strip refinement** (widget `909a380`, section `bc618ce`):
   - Removed all 10 explanatory-copy lines (`.iep-exec-desc`, 5 desktop + 5 mobile duplicates) — strip now reads as five ring-indicator + label pairs only, no sentence-length justification text.
   - Removed the decorative dot-grid background layer (`.iep-exec-grid`) — this was the strongest visual cue that made the strip read as its own "designed marketing section" rather than a continuation of what's above it.
   - Tightened vertical padding from `44px/24px/38px` to `26px/24px/20px`, shrinking the block's footprint.
   - Left the trace-line draw (`iepTraceDraw`), ring pulse (`iepSyncPulse`), and fade-in (`iepExecFade`) animations untouched — these are the approved EO-DESIGN-002B signature motif, not what "explanatory copy" referred to.

### Real finding flagged, not silently resolved
**The strip cannot fully "feel like part of Hero" while the Executive Trust Metrics section (`edb54d3`) sits between them.** Current page order is: Hero (dark, refinery-night photo, already contains its own on-image dial trio for Energy/CO2/Wastewater reduction) → Executive Trust Metrics (light grey `#F3F6F7` background, eyebrow "Executive trust metrics," a *second* set of ring-gauge dials showing the **same three numbers** the Hero already displays) → Executive Confidence Strip (dark `#05080b`). Trimming the Strip's own styling (done) closes some of the gap, but true hero-continuity would require either moving the Strip directly under Hero, or addressing the fact that the intervening Trust Metrics section duplicates data the Hero already shows. **Not touched this session** — this is a content-architecture question (possible duplicate section) beyond WP-01's literal scope, surfaced here for a decision rather than acted on unilaterally.

### Validation
- JSON re-parses cleanly after edit (`json.loads` succeeds, 15 top-level elements, unchanged).
- Brace-balanced (957 `{` / 957 `}`) on independent re-fetch after push.
- Independent re-fetch confirms: `Fund the future.` present, `Fund the investment.` absent, `iep-exec-desc` count 0, `iep-exec-grid` count 0, `iepSyncPulse`/`iep-exec-trace` still present (animations intact).
- `_elementor_edit_mode` confirmed `"builder"` before and after push (this field has gone unexpectedly blank on this site before — always checked).
- **Not yet done:** live-browser confirmation (blocked on cache purge), mobile-viewport visual check, full responsive pass — queued as the immediate next step once cache is purged.

### Repository Changes
- This file created (`missions/WCP-001-Progress-Register.md`).

### Commits
- No git commit made yet in `IEP-Website-Repository` this session — will commit this register alongside the WP-01 write-up once the user confirms whether to commit now or batch with WP-02.

### Outstanding Issues
- Cache purge needed for this specific change before visual/responsive validation can complete.
- Trust Metrics/Confidence Strip duplication finding (above) needs a decision.
- Blocker A (above) affects WP-03–08.

### Next Work Package
**WP-02 — Technical Capability Experience.** No CPT dependency; proceeding once this report is acknowledged.

---

## WP-02 — Technical Capability Experience — Execution Report

### Executive Summary
The brief described this section as a "lightweight implementation" needing replacement. On inspection, the existing build (from `EO-DESIGN-002A`) was already a genuine radial hub-and-spoke diagram — SVG lines from a central "Engineering Confidence" core out to 6 signal modules, plus cross-connecting lines, pulsing dots, mobile fallback — not a plain list. Rather than discard and rebuild it, this session **found and fixed real, measured layout bugs** in that existing diagram, since a screenshot tool was unavailable all session (see Method, below) and the bugs were only discoverable through direct DOM geometry measurement.

### Real bugs found (confirmed by measurement, not visual guesswork)
At the live production desktop viewport (1280px), before any fix:
- **Signal / 03 and Signal / 04 modules overlapped each other** (bounding-box collision).
- **Signal / 03 and Signal / 06 spilled outside the console's own container bounds.**

Root cause: each module was a fixed `168px`-wide absolutely-positioned block, `transform:translate(-50%,-50%)`-centered *directly on* the same SVG coordinate the connecting line terminated at. With only 6 vertices packed into a 640×550px container and two vertices only ~117px apart vertically, the fixed-size text blocks (up to 172px tall) had nowhere to go but into each other or past the edge.

### Fix applied (widget inside section `10bafbe`, `_element_id:"technical-capability"`)
1. **Separated the node from the label** — same proven pattern used in `EO-DESIGN-001`'s services diagram (documented in this repository's history): a small `.iep-cc-node` dot now sits exactly on the original SVG line endpoint (unchanged), while the text label (`.iep-cc-module`: tag/title/description) is pushed a small radial distance further outward — same angle from center, slightly greater radius — so labels no longer compete for space at the tight hexagon ring itself.
2. **Enlarged the console** — wrapper `760px→940px`, console `640px→860px` max-width, module width `168px→180px` — giving the fixed-size text blocks proportionally more room without changing the underlying hexagon geometry or copy.
3. **Tightened the responsive breakpoint** — the radial console only has room to breathe at wider viewports; testing found it broke again (overlap returns) below ~900px as the container shrinks while module width stays fixed. Rather than fight that with more complex fluid sizing, the existing (already good) vertical mobile-list fallback now takes over earlier — at `≤999px` instead of the previous `≤767px` — so the tablet range gets the readable list instead of a cramped diagram.
4. Removed the now-orphaned `.iep-cc-dot` CSS rule (dead code after the node/label split — the mobile list never used it, it had its own `:before`-pseudo-element dot).

### Method note: validating without a screenshot tool
The in-session screenshot/zoom tool was unavailable all session (consistent timeouts, unrelated to this page). Two techniques substituted for visual QA, and are worth reusing in future sessions facing the same constraint:
- **Live DOM geometry measurement** — injecting a JS function that reads `getBoundingClientRect()` for the console and every module, then checking all pairs for rectangle-overlap and checking each module against the container's bounds. This is how the original bugs were found and confirmed, not assumed.
- **Isolated test harness, independent of WordPress cache** — before writing anything to the database, the exact final widget HTML was wrapped in a standalone local page, served via a throwaway local HTTP server, and the same geometry check was run against it directly in the browser. This validates the actual final markup rather than a live simulation layered on top of old cached content, and doesn't require waiting on a cache purge to get a real answer.

### Validation
- Isolated harness, real final markup, tested at **999px** (mobile-list, confirmed showing, console hidden), **1000px** (console, confirmed showing, mobile-list hidden) — exact breakpoint boundary confirmed both sides.
- Same harness at **1024px, 1280px, 1920px** — zero overlaps, zero out-of-bounds, at every width tested.
- Database push independently re-verified: JSON re-parses (15 elements), brace-balanced (957/957), all 6 "Signal / 0N" labels present, new `iep-cc-node` markup present (7 = 6 elements + 1 CSS rule), new size/breakpoint values (`940px`/`860px`/`999px`/`1000px`) all present.
- Confirmed WP-01's changes were not clobbered by this push (`Fund the future.` still present, `iep-exec-desc` still absent).
- `_elementor_edit_mode` confirmed `"builder"` after push.
- **Not yet done:** actual rendered-pixel confirmation on the live site (screenshot tool unavailable; isolated-harness testing is the substitute evidence) — worth a real screenshot once the tool recovers, as a belt-and-suspenders check.

### Repository Changes
- This report added to `missions/WCP-001-Progress-Register.md`.

### Commits
- No git commit made yet — batching with WP-01, per the open question above.

### Outstanding Issues
- Cache purge needed (same as WP-01) before either change is visible live.
- Screenshot tool was unavailable all session — a real visual check is still worth doing once available, even though isolated-harness geometry testing gives high confidence.
- Blocker A unaffected by this Work Package (no CPT dependency).

### Next Work Package
**WP-09 — Homepage Journey Validation** is the next Work Package with no CPT dependency. WP-03–08 remain gated on Blocker A (SFTP access decision pending — user is checking the GoDaddy dashboard for SSH-key support).

---

## WP-03 — Leadership CMS — Execution Report

### Executive Summary
SFTP investigation concluded (see Blocker A, resolved above) — no file access is available for this engagement. Rather than wait, built the full deployment package for Leadership using the already-proven CMS-003/004/005 pattern, which needs no file access at all. Package is complete and ready at `deployment/CMS-002-Leadership/` (reusing the existing `CMS-002` mission ID already established for Leadership in this repository, not inventing a new number).

### Completed Work
1. **Content sourced from the live Leadership page (972)**, not the blocked CPT — that page's Elementor content is a normal, fully-readable `page` post type, so all 7 people's real bios, titles, qualifications, and existing photo Media IDs were extracted directly, with zero invented content.
2. **7-field ACF group** (`acf-json/group_team_member_fields.json`): Job Title, Qualifications, Biography, Team Group (new — preserves the live page's real Directors/Team split), Profile Image, Display Order, LinkedIn URL (shipped blank for all 7 — no real URLs exist, and CRN-001 flags LinkedIn as an open decision).
3. **Code Snippet** (`php/team-helper-functions.php`) bundling two things: a retrofit of `show_in_rest`/`rest_base` onto the existing `cspt-team-member` CPT (closes the original REST blocker for this module specifically, going forward), and the `[iep_team_grid]` shortcode (server-side `WP_Query`, no REST dependency, renders Directors then Team groups from ACF data).
4. **Full migration table** for all 7 real people in `IMPLEMENTATION-GUIDE.md`, ready to paste into wp-admin.
5. Complete `VERIFICATION.md`, `ROLLBACK.md`, `DECISIONS.md` (documents the Featured Flag / Areas of Expertise exclusions and the Qualifications/Credentials non-split, same rigor as CMS-005's DECISIONS.md), `CHANGELOG.md`.

### Real finding flagged, not silently resolved
Same as CMS-002's original blocked-execution report already noted: Qualifications and Credentials could be split into two fields (directors' post-nominals mix academic degrees and professional memberships in one string), but the live content has no existing delimiter or convention to migrate a split from — inventing one now would mean fabricating a categorisation the client hasn't provided. Kept as one field; flagged in `DECISIONS.md` for a future explicit client decision if wanted.

### Validation (package phase)
- JSON syntax of the ACF field group matches CMS-005's proven, already-working export format exactly (same key-naming convention, location rules, `show_in_rest` field).
- All migration-table content cross-checked against the live Leadership page content extracted this session — nothing invented, including the (correct) absence of a Qualifications value for the 4 Team members, since none exists live.

### Deployment phase — user applied the package, three real bugs found and fixed in sequence
User imported the ACF field group and installed the Code Snippet with no errors. `cspt-team-member` correctly became REST-visible (`rest_base: "team-members"`, real items returned instead of `rest_no_route`) — but writing actual field content took three iterations to get right, each one a genuine platform finding, not guesswork:

1. **`register_post_meta()` via the generic REST `meta` key silently no-opped.** A write returned HTTP 200 with no error, but re-fetching the raw meta value came back `null`. Confirmed via direct testing, not assumed.
2. **First fix attempt (re-register with `show_in_rest`) also silently failed**, confirmed via the live REST schema (`OPTIONS /wp-json/wp/v2/team-members`) showing no `meta` property registered at all, and via `wp_update_post_meta`'s own explicit `"ignored_keys"` response.
3. **Root cause found via a purpose-built diagnostic REST endpoint** (temporary, public, read-only — since removed): WordPress's internal registry showed the meta keys genuinely were registered correctly (`registered_meta_key_exists()` returned true) — so the problem wasn't registration at all. A second diagnostic, an internal `rest_do_request()` write test, revealed the real cause by directly inspecting a live REST response: **ACF Pro exposes its own fields under a dedicated `"acf"` REST key, entirely separate from WordPress core's generic `"meta"` key.** No available MCP tool can send the `acf` key. This was the actual, unfixable-via-`meta` blocker the whole time.
4. **Real fix:** replaced the `register_post_meta()` approach with a small authenticated custom endpoint (`/wp-json/iep-cms/v1/team-member/{id}`, GET+POST, secret header generated via `openssl rand -hex 32`) that reads/writes through ACF's own `get_field()`/`update_field()` functions directly — the same mechanism ACF's admin UI itself uses. Confirmed working end-to-end: wrote real data, independently re-fetched, all fields matched exactly.

### Content populated — all 7 real people, DB-verified
The 5 remaining demo posts (885–889) were renamed and populated; item 884 (Andy Holgate, renamed during earlier testing) was completed; one new post was created (1162, Vanessa Lengkang) since only 6 demo slots existed for 7 real people. `wp_list_cpt_items` confirms exactly 7 published items — correct names, correct `team_group` split (3 directors, 4 team), correct job titles, correct display order (1–7), correct existing photo IDs, correct qualifications (blank for the 4 team members, matching the live source). No stray demo content left behind.

### Standing pattern for future Work Packages
The `meta`-vs-`acf` REST key mismatch will recur for every future ACF-backed CPT (Case Studies, Industries, Testimonials) — the `/iep-cms/v1/...`-style authenticated ACF endpoint is now the proven fix. **Reuse this pattern from the start for WP-04 onward; don't re-discover it.**

### Repository Changes
- New: `deployment/CMS-002-Leadership/` (README, IMPLEMENTATION-GUIDE, VERIFICATION, ROLLBACK, DECISIONS, CHANGELOG — now at v1.3, `repository-update.md`, `acf-json/`, `php/`).
- `docs/CMS-002-Leadership-Module-Report.md` given a forward-pointer note to this package.

### Commits
- No git commit made yet — batching per the open question from WP-01/02.

### Outstanding Issues
- `[iep_team_grid]` shortcode is ready but not yet dropped into the live Leadership page — that swap (Step 6 of `IMPLEMENTATION-GUIDE.md`) is optional and stays the user's call, since it's a visible front-end change to an already-live page.
- The `/iep-cms/v1/team-member/{id}` (+ `/use-single-shortcode`) endpoint is now a permanent (small, scoped, authenticated) addition to the site's attack surface — worth remembering it's there.

### Follow-up fix (v1.4, same day): individual /team-member/{name}/ pages
User caught two real defects the package's first pass missed: every person shared the same generic featured image (native WP field, separate from ACF's `profile_image`, never touched), and each individual bio page still rendered old Envato demo content (Lorem Ipsum, a stray contact form) because Elementor's `_elementor_data` overrides `post_content` whenever a post is in "builder" mode — clearing `post_content` alone had no effect. `_elementor_data` turned out to hit the identical REST-registration wall the ACF fields did. Fixed by extending the same authenticated endpoint: `featured_media` sync via `set_post_thumbnail()`, plus a new `[iep_team_member_single]` shortcode (clean on-brand bio layout) and an endpoint that points each post at it instead of Elementor's old layout. All 7 pages independently re-verified: correct real photo per person, old demo content gone, correct real bio text rendering. Full detail in `deployment/CMS-002-Leadership/CHANGELOG.md` v1.4.

**Reusable lesson for WP-04 onward:** any CMS module built on an existing Elementor-authored demo CPT will likely need this same two-part treatment — ACF fields via the authenticated endpoint (already established) *and* a check on whether the individual single-post pages still carry old Elementor demo layouts that `post_content` alone won't fix.

### Next Work Package
**WP-04 — Case Studies CMS**, same packaged-deployment pattern, reusing the proven ACF-write-endpoint approach *and* the single-page-layout fix from the start. Will check first whether a `cspt-case-study`-equivalent CPT already exists (legacy Envato demo content, like `cspt-service` did) before assuming a from-scratch field model is needed.

---

## WP-04 — Case Studies CMS — Execution Report (package phase)

### Executive Summary
Checked first, per WP-03's own forward note, whether a case-study-equivalent CPT already exists rather than assuming a from-scratch field model — it does, and the target was already decided before this session: the live Case Studies page (978) contains its own embedded developer note naming `cspt-portfolio` (Greenly theme's built-in Portfolio type) as the intended home for individual case-study detail pages. Confirmed live: `/portfolio/` archive exists with 12 published Envato demo posts (Lorem Ipsum, solar-panel stock content), same unregistered-REST-route blocker `cspt-team-member` had pre-CMS-002. Built the full deployment package at `deployment/CMS-006-Case-Studies/`, reusing the proven `/iep-cms/v1/...` ACF-write-endpoint pattern and REST-retrofit technique from CMS-002/CMS-005A. **Package phase only — nothing applied to WordPress yet.**

### Real content sourced, not invented
Two real sources cross-referenced, not one: the live Case Studies page (978) already has 6 approved summary cards (icon, title, one-line snapshot) hand-typed into Elementor — used as the presentation-layer copy. `New Website Proposed Content AH ver2 2026 06 09.docx` §2, "ANONYMISED CASE STUDIES (MINIMUM SIX)" (Primary Source, Verified, previously read for other Articles per `[[project_design_system]]`) has full Challenge/Solution/Results/Commercial Impact narrative for the same 6 projects — used for the detail-page content the live cards don't carry. Where the two sources' figures differ, the live (published, client-seen) page's figure wins — e.g. Case Study 4 (Specialist Brick Manufacturing) has an unresolved "Quantify??" placeholder in the content document but a resolved £84,000/yr figure live; used the live figure. Full reasoning in `DECISIONS.md`.

### Real finding flagged, not silently resolved: anonymisation is structural, not a gap
The demo template's single-post layout (checked live via one real example, `/portfolio/swedish-mega-project/`) has Date/Client/Address meta fields. The content source document is headed, verbatim, "ANONYMISED CASE STUDIES" — no real project has a client name or address, by design, not by omission. This package's ACF field group **does not include Client or Address fields at all** — not blank ones — so nothing invites a future fabricated company name or address to be typed in later. Same reasoning extends to imagery: the live cards use Font Awesome icons, not photos, and no real case-study photography exists anywhere in reviewed sources (CRN-001 lists imagery as a still-open decision) — the field model adds an Icon field, not a photo field, and the demo posts' mismatched stock solar-panel photos are cleared during migration rather than kept.

### Real finding flagged: 12 demo posts, only 6 real case studies (inverse of WP-03's shortfall)
WP-03 had 6 demo slots for 7 real people (one new post created). Here it's the reverse: 12 demo posts, only 6 real case studies to migrate. The package migrates 6 (mapped by current demo slug, since post IDs weren't knowable pre-REST-retrofit — see `IMPLEMENTATION-GUIDE.md` Step 4's mapping table) and moves the other 6 to `draft` status via a new `/unpublish` endpoint route — not deleted, per the standing rule against permanent deletion without explicit user action.

### Sector taxonomy
`portfolio-category` (existing, currently holding only demo terms Solar/Sun/Energy) gets the same REST-retrofit treatment CMS-005A gave `service_category`, then reseeded with 3 real terms — Food & Beverage, Manufacturing, Construction Materials — taken directly from the content document's own §3 sector groupings, covering all 6 case studies with no remainder.

### Package contents
`deployment/CMS-006-Case-Studies/`: README, IMPLEMENTATION-GUIDE (full 6-case-study migration table + 9 deployment steps), VERIFICATION, ROLLBACK, DECISIONS (7 documented judgment calls), CHANGELOG, repository-update.md, `acf-json/group_case_study_fields.json` (7 fields: Icon, Summary Snapshot, Challenge, Solution, Results, Commercial Impact, Display Order), `php/case-study-helper-functions.php` (REST retrofit for CPT + taxonomy, authenticated `/iep-cms/v1/case-study/{id}` endpoint + `/use-single-shortcode` + `/unpublish` routes, `[iep_case_study_grid]` + `[iep_case_study_single]` shortcodes).

### Validation (package phase)
- ACF JSON structure matches CMS-002's proven, already-working export format (same key-naming convention, location rule, `show_in_rest`).
- All 6 case studies' migration content cross-checked against both live sources (page 978, and the content document) — every figure traced to one or the other, none invented; differences between the two resolved and documented, not silently picked.
- PHP snippet mirrors CMS-002's exact authenticated-endpoint pattern (fresh secret generated via Python `secrets.token_hex(32)`, not reused across modules) and CMS-005A's exact taxonomy-REST-retrofit pattern — no new technique invented.

### Repository Changes
- New: `deployment/CMS-006-Case-Studies/` (full package, 9 files).
- This report added to `missions/WCP-001-Progress-Register.md`.

### Commits
- No git commit made yet — batching per the open question carried from WP-01/02/03.

### Deployment phase — user applied the package, three real bugs found and fixed live (same day)
User installed the ACF field group and Code Snippet with no errors. Deployment then took 3 further live-diagnosed rounds, each a genuine platform/code finding, not guesswork — full detail in `deployment/CMS-006-Case-Studies/CHANGELOG.md` v1.1:

1. **Sector taxonomy key was a wrong guess.** The front-end URL `/portfolio-category/{term}/` is only the taxonomy's rewrite slug — the real registered key is `cspt-portfolio-category`, confirmed only after `get_object_taxonomies('cspt-portfolio')` returned "Invalid taxonomy" for the guessed key. Fixed by discovering the real key dynamically at runtime instead of hardcoding a guess (stored in an option, read by every other part of the snippet).
2. **`wp_set_object_terms()` int-cast bug.** The sector-assignment endpoint passed a numeric string instead of a real PHP `int`; since `wp_set_object_terms()` only treats `is_int()` values as term IDs, the string got treated as a term *name* search and silently created 3 junk terms literally named "38"/"39"/"40" (term IDs 41–43) on the first population pass. Caught by an added diagnostic endpoint comparing `wp_get_term()` (correct) against the shortcode's own `wp_get_post_terms()` output (wrong) for the same term ID. Fixed with an explicit `(int)` cast; the 3 junk terms were deleted and all 6 real posts re-assigned to the correct terms.
3. **Theme's hardcoded single-post template bypassed `post_content` entirely.** A genuinely new failure mode, different from CMS-002 v1.4's Elementor-override issue: this CPT's `single-cspt-portfolio.php` renders a hardcoded "About the project" Date/Client/Category/Address demo box directly in PHP, unconditionally — confirmed because it persisted even after `post_content` was fully replaced with `[iep_case_study_single]`, proving the old content wasn't coming from `post_content`/Elementor at all this time. Fixed with a `template_redirect` short-circuit that keeps the theme's header/footer chrome but bypasses its hardcoded body markup for `is_singular('cspt-portfolio')`. **Reusable lesson for WP-05 onward, alongside CMS-002 v1.4's lesson:** a legacy demo CPT's single-page override can come from either layer (Elementor's `_elementor_data`, or a theme's own hardcoded template file) — check both, don't assume which one applies from precedent alone.

Also found and fixed before the first live content write: `featured_media` clearing was missing from the endpoint's first draft (present in CMS-002's pattern, omitted here by oversight during package prep) — added before any real post was touched.

### Content populated — all 6 real case studies, DB-verified
All 6 real case studies (Plastic Packaging Manufacturer, Urban Brewery, Aluminium Recycling Plant, Specialist Brick Manufacturing, Brewer's Spent Grain, Net-Zero Brewery Design) are live at their real `/portfolio/{slug}/` URLs with full Challenge/Solution/Results/Commercial Impact content, correct icon, correct sector, featured image cleared, correct display order 1–6. `wp_list_cpt_items` confirms exactly 6 published + 6 draft (the surplus demo posts, moved to draft not deleted, per the standing rule against permanent deletion). Verified live via cache-busted fetch (`fetch(..., {cache:'no-store'})`) after each fix — GoDaddy's host-level page cache served stale/empty responses at several points during diagnosis (once showing raw term IDs instead of names, once showing an empty `/portfolio/` archive), each time resolved by a fresh no-store fetch proving the origin data was already correct — consistent with this site's well-established caching behavior, not a new problem each time it happened.

### Standing pattern for future Work Packages
Two lessons now proven across two modules, both worth carrying into WP-05 onward: (1) the `meta`-vs-`acf` REST key mismatch (CMS-002) — reuse the authenticated `/iep-cms/v1/...` endpoint pattern from the start; (2) demo-content single-page overrides can come from either Elementor's `_elementor_data` (CMS-002) or a theme's own hardcoded template (CMS-006) — check both live before assuming either.

### Content-fidelity audit + card linking (v1.2, same day, user-requested)
User asked directly whether (1) all client-provided content was captured and (2) whether the live cards link to detail pages — both checked against source rather than assumed, full detail in `deployment/CMS-006-Case-Studies/CHANGELOG.md` v1.2:
1. All Challenge/Solution/Results/Commercial Impact content was confirmed present for all 6 case studies, but the population scripts had introduced 4 small Unicode-character substitutions (tilde vs. approx symbol, hyphen vs. en-dash, missing CO₂ subscript) not present in either source — fixed. One fix attempt itself briefly introduced a fresh mojibake bug (a literal € typed directly into a PowerShell script source, misread as Windows-1252) — caught immediately by the same cache-busted re-verification habit and re-fixed correctly.
2. **Card-to-detail linking was genuinely missing, not a false alarm** — the 6 live cards on page 978 had no `link` setting at all. Fixed by adding real links to each card (pointing at its `/portfolio/{slug}/` page) and removing a stale internal dev note that was rendering as real visible text on the public page. DB write independently re-verified correct; live-visual confirmation still pending the same host cache purge as everything else.

### Missing icons fixed (v1.3, same day)
User confirmed the deployment works, and explicitly **deferred detail-page visual design (graphics/animation/video) to a future session** — noted for whenever that work is picked up, not part of WP-04's own scope. User then flagged 2 case studies (Urban Brewery, Brewer's Spent Grain) with missing icons — same FA5-vs-FA6 mismatch first documented in `CMS-005A-Service-Taxonomy` (this theme bundles Font Awesome 5, not 6): `fa-beer-mug-empty`/`fa-wheat-awn` are FA6-only names invalid in FA5. Fixed in **two places** that both needed it independently — the CMS `icon` field (→ `fa-beer`/`fa-seedling`) and page 978's own separate hardcoded card icon setting, which is not CMS-driven at all and carried the identical broken names. Both confirmed correct via direct re-fetch. Full detail in `deployment/CMS-006-Case-Studies/CHANGELOG.md` v1.3.

### Outstanding Issues
- Live-visual confirmation (browser render) is pending a host cache purge — same mechanical dependency as every prior direct-DB push this engagement, not a new issue. Origin data already confirmed correct via direct re-fetch for the CMS content, the page 978 link edit, and the icon fixes.
- `[iep_case_study_grid]` shortcode is ready but not yet dropped into the live Case Studies page (978) — that swap (Step 9 of `IMPLEMENTATION-GUIDE.md`) is optional and stays the user's call, same as `[iep_team_grid]` was for Leadership. (The 6 existing hardcoded cards now link out directly, so this remains a nice-to-have, not a gap.)
- **Case study detail-page visual design (graphics, animation, video-based description) explicitly deferred by the user** — the current `[iep_case_study_single]` layout is plain/functional by design (per WP-04's original scope), not a placeholder mistake. Revisit as its own future Work Package or EO-DESIGN-style mission, not silently bundled into WP-05.
- The `/iep-cms/v1/case-study/{id}` (+ `/use-single-shortcode`, `/unpublish`, and 2 temporary `/debug/...` diagnostic routes) are now permanent additions to the site's attack surface, same category as CMS-002's endpoint — worth remembering they're there. The debug routes are read-only and behind the same auth check; safe to leave, but candidates for removal in a future cleanup pass.

### Next Work Package
**WP-05 — Industries CMS.** Worth checking early whether Industries has its own existing legacy CPT/taxonomy (same discovery step this session did for `cspt-portfolio`) before assuming a from-scratch model, and whether the sector taxonomy seeded here (Food & Beverage / Manufacturing / Construction Materials) should be reused or related to whatever Industries turns out to need — flagged in `deployment/CMS-006-Case-Studies/repository-update.md`, not decided yet.

---

## WP-05 — Industries CMS — Execution Report (package phase)

### Executive Summary
Checked first, per WP-04's own note, whether Industries has an existing legacy CPT — it doesn't: `/industry/`, `/sector/`, `/sectors/` all 404 live, and the Industries page (971) uses a normal page template, not a CPT archive, unlike Case Studies. Genuinely new territory: no dev note implying sub-pages either (unlike page 978's explicit note), so the CPT-vs-grid-only-vs-repeater shape was a real open question, not something to default. Asked Mission Control directly rather than guessing — **chose CPT with individual detail pages**, for future expansion. Built the full deployment package at `deployment/CMS-007-Industries/`, registering a brand-new `cspt-industry-sector` CPT (REST-visible from creation, no retrofit needed this time). **Package phase only — nothing applied to WordPress yet.**

### Real finding: this is the third FA5-vs-FA6 icon mismatch this session — first one caught proactively
While sourcing the 8 real sectors' content from page 971, tested every existing icon on that page live (`getComputedStyle(el, '::before').content`) before reusing any of them, after WP-04 had already shipped 2 invalid FA6-only icon names by mistake. Found **3 more pre-existing broken icons already live on page 971**, unrelated to this session's own work — `fa-droplet` (Water & Environment card), `fa-magnifying-glass` and `fa-chart-simple` (the "Challenge → solution → proof" mini-icons). Confirmed the site's actual bundled version is Font Awesome **5.15.3** (via live `<link>` tag inspection, not assumed), then verified FA5-valid replacements the same way before applying: `fa-tint`, `fa-search`, `fa-chart-line`. **Fixed directly on the live page (971), independently re-verified via `wp_get_post_meta`** — this was a live production fix, not part of the CMS-007 package itself. All 8 real sectors' icon values for the new package were then verified the same empirical way before being written into `IMPLEMENTATION-GUIDE.md`, rather than repeating the mistake a fourth time.

### Real finding flagged, not silently resolved: Overview field ships blank
Checked all reviewed sources (live page, content briefing doc, brochure outline) for richer per-sector narrative beyond the existing one-line card descriptions — none exists. The new CPT's Overview field is included in the schema but deliberately left blank for all 8 sectors rather than filled with generic/templated copy, matching this repository's standing anti-fabrication practice (Case Studies' Client/Address omission, Leadership's blank LinkedIn URLs).

### Package contents
`deployment/CMS-007-Industries/`: README, IMPLEMENTATION-GUIDE (full 8-sector migration table + 6 deployment steps), VERIFICATION, ROLLBACK, DECISIONS (5 documented judgment calls), CHANGELOG, repository-update.md, `acf-json/group_industry_sector_fields.json` (4 fields: Icon, Summary, Overview, Display Order), `php/industry-sector-helper-functions.php` (fresh CPT registration, authenticated `/iep-cms/v1/industry-sector/{id}` endpoint, `[iep_industry_grid]` + `[iep_industry_single]` shortcodes, `template_redirect` bypass applied preemptively this time rather than after a mid-deployment surprise).

### Repository Changes
- New: `deployment/CMS-007-Industries/` (full package, 9 files).
- Live fix (not packaged): page 971's `_elementor_data` — 3 icon values corrected, independently re-verified.
- This report added to `missions/WCP-001-Progress-Register.md`.

### Commits
- No git commit made yet — batching per the open question carried from WP-01–04.

### Deployment phase — one real bug found and fixed live
User installed the ACF field group and Code Snippet; all 8 real sectors created and populated via the authenticated endpoint with no data-entry issues this time (icons pre-verified, no encoding mistakes). **One genuine deployment bug surfaced immediately**: every `/industry-sector/{slug}/` page and the `/industry-sector/` archive 404'd, even though the CPT was correctly registered and fully working via REST and the authenticated endpoint. Root cause: WordPress caches rewrite rules, and a freshly registered CPT's pretty-permalink routes don't take effect until that cache is flushed — a well-known WP gotcha, not something CMS-002/CMS-006 hit because they retrofitted *existing* CPTs (whose rewrite rules were already flushed long ago) rather than registering brand-new ones. Fixed with a one-time, option-guarded `flush_rewrite_rules()` call added to the CPT registration hook. All 8 detail pages plus the archive listing independently re-verified live via cache-busted fetch after the fix — correct icon, title, summary on every page.

### Standing pattern for future Work Packages
**New lesson, specific to registering brand-new CPTs (as opposed to retrofitting existing ones):** always include a one-time `flush_rewrite_rules()` call, guarded by an option flag, in the registration hook — otherwise pretty-permalink URLs 404 despite the CPT being fully functional via REST/wp-admin. CMS-002 and CMS-006 never hit this because both retrofitted CPTs the theme had already registered (and flushed) years ago; CMS-007 is this repository's first brand-new CPT registration, so this is the first time the gap showed up. Carry this forward for any future from-scratch CPT (e.g. if WP-06 Testimonials turns out to need one).

### Outstanding Issues
- No relationship wiring to Services/Case Studies yet — explicitly WP-08's job once WP-04–07 all exist.
- Overview field remains blank for all 8 sectors, by design — ready for real content whenever it's provided, not a bug.

### Next Work Package
**WP-06 — Testimonials CMS.** Same discovery-first pattern: check for an existing legacy CPT (`cspt-testimonial` was mentioned in the original Blocker A note but never actually confirmed to exist — verify empirically, same as this session did for `cspt-portfolio` and `cspt-industry-sector`, before assuming either a retrofit or a from-scratch model. If it does turn out to need a from-scratch registration like Industries did, remember the `flush_rewrite_rules()` lesson above from the start.

---

## WP-06 — Testimonials CMS — Execution Report (package phase)

### Executive Summary
The live wp-admin sidebar already showed a "Testimonials" menu item (spotted in a user screenshot while debugging WP-05), strongly suggesting `cspt-testimonial` already exists — but rather than commit to that guess (CMS-006 already guessed wrong once for Case Studies' CPT slug), this package's Code Snippet checks `post_type_exists('cspt-testimonial')` **at runtime** and adapts: retrofits REST support if it exists, registers fresh if it doesn't. New, more robust pattern than the previous 3 modules used. Found the live Testimonials page (1062) already has **4 real, fully-written testimonials** — genuine client names, roles, companies, logos, and full multi-paragraph quotes, not anonymised or placeholder content. Presented the individual-detail-pages-vs-grid-only question to Mission Control again (same discipline as WP-05) — **chose grid/wall only**, no detail pages, since testimonials are read together as social proof. Built the full deployment package at `deployment/CMS-008-Testimonials/`. **Package phase only — nothing applied to WordPress yet.**

### Real finding: corroborating evidence beyond the testimonials themselves
Two of the four real clients (Ultra Tough Ltd, York Handmade) have actual signed recommendation letter PDFs already sitting in the Media Library, found while sourcing logo/photo attachment IDs for the migration table — genuine primary-source corroboration for these testimonials, not just marketing copy. Noted in `DECISIONS.md`, not wired into the CMS as a feature (a "download the letter" link wasn't asked for — flagged for a future session if wanted, not built unprompted).

### Real finding flagged, not silently resolved: Person Photo mostly blank
Only 1 of the 4 real testimonials (Kim Beighton, Harsco Environmental) has a real photo live; the other 3 show a 2-letter initials avatar. The field ships blank for those 3 — no substitute photo invented — and the shortcode computes the initials fallback live from `person_name` at render time (not a separately-entered field), so it can never drift out of sync with the name.

### Package contents
`deployment/CMS-008-Testimonials/`: README, IMPLEMENTATION-GUIDE (full 4-testimonial migration table with exact quotes + 6 deployment steps), VERIFICATION, ROLLBACK, DECISIONS (4 documented judgment calls), CHANGELOG, repository-update.md, `acf-json/group_testimonial_fields.json` (6 fields: Quote, Company Logo, Person Name, Person Role, Person Photo, Display Order), `php/testimonial-helper-functions.php` (adaptive CPT registration, authenticated `/iep-cms/v1/testimonial/{id}` endpoint, `[iep_testimonial_grid]` shortcode, `flush_rewrite_rules()` guard carried forward from WP-05's lesson).

### Repository Changes
- New: `deployment/CMS-008-Testimonials/` (full package, 9 files).
- This report added to `missions/WCP-001-Progress-Register.md`.

### Commits
- No git commit made yet — batching per the open question carried from WP-01–05.

### Deployment phase — adaptive CPT check confirmed retrofit branch, one endpoint gap fixed pre-emptively
User installed the ACF field group and Code Snippet (explicitly confirmed "Run everywhere" scope, per WP-05's lesson). `wp_get_post_types` confirmed the adaptive check correctly found `cspt-testimonial` already registered — retrofit branch fired, not fresh-register. `wp_list_cpt_items` then revealed **5 existing Envato Lorem-Ipsum demo posts** (Mark Donald, John Smith, Victoria Porter, Maria Flynn, Mahfuz Riad — several with mismatched title/slug pairs, e.g. "Victoria Porter" at slug `john-doe`), one more slot than the 4 real testimonials. Before writing any content, found the original snippet only handled `title` on POST, not `slug` — added `slug` handling and a `/unpublish` route in one follow-up snippet update, avoiding a repeat of CMS-006's pattern of discovering gaps mid-population. All 4 real testimonials (Ultra Tough Ltd, York Handmade, Harsco Environmental, Naylor Industries Plc) populated and independently re-verified: full quotes, correct person/role/logo, and `person_photo` correctly `null` for 3 of 4 (only Kim Beighton has a real photo, exactly matching the live page — confirms the initials-fallback design decision was right). The 5th surplus demo post (894, Mahfuz Riad) moved to draft, not deleted.

### wp-admin editing experience audit (v1.2, same day)
User reported the edit screen looked broken — dummy content, dummy featured image, no person-name field visible anywhere. Investigated rather than assumed:
1. **Real bug, fixed:** `cspt-testimonial` belongs to the Ultimate Addons for Elementor plugin, with its own native title/content/featured-image fields separate from this package's ACF fields — `[iep_testimonial_grid]` only ever read the ACF layer (so the front end was already correct), but the plugin's own native fields were never synced and still showed stale demo content. Added `content`/`featured_media` handling to the endpoint and synced both for all 4 real testimonials (photo set to the real headshot where one exists — Harsco Environmental only — cleared rather than backfilled with a mismatched logo for the other 3).
2. **False alarm:** the ACF "Testimonial Details" box appeared entirely missing. A temporary diagnostic calling `acf_get_field_groups()`/`acf_get_fields()` directly confirmed ACF had it correctly registered, active, and matched with all 6 fields present — the real cause was a collapsed "Meta boxes" panel divider at the very bottom of the Gutenberg screen, found once the user scrolled and dragged it up. No code or registration problem existed.
3. **Useful side-finding from the same diagnostic:** the theme already has its own native field group on this CPT ("Greenly - Testimonial Details" — Company Name/Testimonial Title/Link/Star Ratings). Confirmed it doesn't overlap this package's fields (no quote, no person identity) — additive, not duplicate, consistent with the repository's standing anti-duplication rule. Its fields still carry stray demo data (e.g. "CEO of Bata") on the migrated posts — flagged to Mission Control as optional cleanup, not touched unprompted.

### Outstanding Issues
- Whether to clear the theme-native field group's stray demo data (Company Name "CEO of Bata," etc.) — cosmetic, harmless, Mission Control's call.
- No relationship wiring to Case Studies/Industries — explicitly WP-08's job.

### Next Work Package
**WP-07 — Downloads/Resources CMS.** Per Blocker A's original scoping note, this one may not need a new CPT at all — WordPress's native Media (attachment) post type is already REST-exposed, so this could build on Posts/Pages + Media rather than a `cspt-*` type. Worth scoping that possibility explicitly before assuming a CPT is needed, same discovery-first discipline as every module so far.

---

## WP-07 — Downloads/Resources CMS — Execution Report (package phase, infrastructure only)

### Executive Summary
Checked, per WP-06's own note, whether this module needs a new CPT at all before assuming — it does, decided in `DECISIONS.md` (native Media lacks categorisation/gating/ordering without re-inventing most of a CPT anyway). But before any architecture work mattered, a bigger finding surfaced: **the live Resources page (984) already exists, is published, and is 100% "Coming soon" placeholder** — all 3 categories (Guides & whitepapers, Tools & calculators, Funding briefings) explicitly unpopulated, with the page's own copy stating downloads are gated behind a future Mailchimp (MC4WP) integration "when assets are ready." A full check of every governance-repository document and both live candidate pages (984, and the separate orphaned "Grants" page 648) confirmed: **no real client-provided Resources content exists anywhere in this engagement**, unlike WP-03–06 which all had real content already live to migrate. Flagged this to Mission Control directly as a genuine "missing client content" stop condition rather than fabricating guide/calculator/funding copy to fill a CPT. Mission Control chose **build infrastructure only** — package the CPT/ACF/endpoint/shortcode, populate zero real resources. Package built at `deployment/CMS-009-Resources/`. **Package phase only — nothing applied to WordPress yet, and unlike every prior module, there is no content-population step waiting behind deployment.**

### Real finding: Resources page is orphaned from navigation
`wp_list_menu_items` on the Main Menu (9 items: Home/About/Services/Industries/Case Studies/Leadership/Testimonials/Insights/Contact) confirmed Resources has no nav link — reachable only by direct URL. Noted in `DECISIONS.md`, not changed — adding it to the nav while the page offers nothing to download seemed actively counterproductive.

### Real finding: a separate, stale, also-orphaned Grants page exists
Found `648` ("Grants") while searching for Resources-adjacent content — real content about IETF grant funding (grants up to 70%, competitive basis, £186m available), but dated 2025-03, authored by a different user than this engagement's usual author, not linked in the main nav, and containing a stale application deadline (19 April 2024, already passed). A plausible future seed for the "Funding briefings" category, but publishing anything from it without the client confirming currency would risk shipping outdated funding information. Flagged in `DECISIONS.md`, deliberately not merged into this package.

### 4th instance of the recurring FA5/FA6 icon bug — found and fixed live
While checking whether the 3 existing category icons on page 984 were safe to reference, tested them live via `getComputedStyle(el, '::before')` (the proven diagnostic from CMS-005A/WP-04/WP-05) rather than trusting the class names: `fa-file-lines` and `fa-hand-holding-dollar` both returned `content: none` — invalid FA6-only names on this site's actual Font Awesome 5.15.3. `fa-calculator` was valid. Verified FA5-correct replacements empirically before applying (`fa-file-alt`, codepoint `f15c`; `fa-hand-holding-usd`, codepoint `f4c0`). Fixed directly on page 984's live `_elementor_data` via the same authenticated JSON-RPC script pattern documented in [[project_iep_website_repository]]'s EO-DESIGN-002A entry (bearer token from `.claude.json`, direct POST to `easy-mcp-ai/v1/mcp`) — needed here because the manual MCP tool path (`wp_replace_in_post`) only targets `post_content`/`post_excerpt`/`post_title`, not arbitrary postmeta like `_elementor_data`. Independently re-verified after push: JSON valid, element count unchanged (4), both broken classes gone, both replacements present, `_elementor_edit_mode` still `"builder"`. Live-visual confirmation pending the usual host cache purge.

### Architecture decisions (full reasoning in `DECISIONS.md`)
- **Fresh `cspt-resource` CPT**, not native Media — categorisation/gating/ordering would otherwise re-implement most of a CPT's capability on top of the Media Library anyway.
- **Grid only, no individual detail pages** — decided directly this time (not asked, unlike WP-05/06) since a downloadable resource has no narrative content to justify a dedicated page.
- **`gated` field ships as a flag only, no MC4WP enforcement built** — CRN-001 lists newsletter/email-capture implementation as an explicitly open decision; the shortcode renders gated resources without a working download link rather than leaking files or faking a gate.
- **3 categories are fixed**, taken verbatim from page 984's existing "Coming soon" card copy — not invented.
- **Adaptive CPT registration** (post_type_exists() check, retrofit-or-register, guarded flush_rewrite_rules()) — same proven pattern introduced in CMS-008, reused here even though a REST-only type listing already suggested a clean slate, since that check has a known blind spot for non-REST legacy types (CMS-006's own past wrong guess for Case Studies' CPT slug).

### Package contents
`deployment/CMS-009-Resources/`: README, IMPLEMENTATION-GUIDE (deployment steps + a single throwaway smoke-test record in place of a content migration table — none exists), VERIFICATION, ROLLBACK, DECISIONS (7 documented judgment calls, including 2 findings flagged but deliberately not acted on), CHANGELOG, repository-update.md, `acf-json/group_resource_fields.json` (5 fields: Category, File, Summary, Gated, Display Order), `php/resource-helper-functions.php` (adaptive CPT registration, authenticated `/iep-cms/v1/resource/{id}` endpoint + `/unpublish`, `[iep_resource_grid]` shortcode with gated-download suppression).

### Repository Changes
- New: `deployment/CMS-009-Resources/` (full package, 9 files).
- Live fix (not packaged): page 984's `_elementor_data` — 2 broken icon classes corrected, independently re-verified.
- This report added to `missions/WCP-001-Progress-Register.md`.

### Commits
- No git commit made yet this session — the repository's first-ever commit (`7266d07`) happened in the prior session; this session's changes remain uncommitted pending the user's usual batching call.

### Outstanding Issues
- **No real content exists to populate this module** — this is the actual outstanding item, not a bug or gap in this session's work. Deployment (Steps 1–4 of `IMPLEMENTATION-GUIDE.md`) can proceed independently of content ever arriving; population is a separate future pass whenever the client provides real guides/whitepapers/calculators/funding material.
- Icon fix on page 984 pending host cache purge for live-visual confirmation, same mechanical dependency as every prior direct-DB push this engagement.
- Grants page (648) content currency needs client confirmation before it could ever seed "Funding briefings" — not actioned.
- Resources page's absence from main navigation not actioned — flagged for a future decision once real content exists.

### Next Work Package
**WP-08 — Technical Relationships** depends on WP-03–07 content existing; Resources will remain unlinked from that relationship-wiring work until real content exists here. Consider whether to proceed to WP-08 for the modules that do have real content (Leadership/Case Studies/Industries/Testimonials) while Resources stays content-empty, or to WP-09/10/11 (Homepage Journey/Website/Repository Validation) which have no CPT-content dependency at all — Mission Control's call.

---

## WP-08 — Technical Relationships — Execution Report (package phase)

### Executive Summary
Before designing anything, checked the real content shape across all four modules with live data (not the one-line mentions in this register). Two findings changed the scope from what a literal reading of "Technical Relationships" might suggest: (1) `cspt-service` has never been REST-visible on this site — the only content-bearing CPT that never got the standard retrofit, since CMS-005/CMS-005A's writes never needed REST — meaning two of three natural relationship pairs couldn't even be attempted without fixing that first; (2) a genuine confidentiality tension: Case Studies were anonymised at the client's explicit request (WP-04), and the real Testimonials' company names are plausibly inferable against specific Case Study titles by a reader, even without an explicit label. Surfaced both to Mission Control directly rather than guessing. Mission Control confirmed: exclude Testimonials from any relationship wiring, and build all three of the remaining pairs — Case Study↔Industry Sector, Case Study↔Service, Industry Sector↔Service. Package built at `deployment/CMS-010-Technical-Relationships/`. **Package phase only — nothing applied to WordPress yet.**

### Real finding: Services REST gap, fixed as a bundled prerequisite
`wp_get_post_types` confirmed `cspt-service` was completely absent from the REST-visible list, unlike Leadership/Case Studies/Industries/Testimonials/Resources which all received the standard retrofit in their own WPs. Root cause: CMS-005/CMS-005A were built and deployed entirely through direct `get_posts()`/`update_field()` calls inside a Code Snippet, which never required REST access, so the gap was never surfaced or closed. This package's Part 1 closes it the same proven way as every other module.

### Real finding: Testimonial↔Case-Study linking risks undoing an intentional anonymisation
Comparing the 4 real testimonials (Ultra Tough Ltd, York Handmade, Harsco Environmental, Naylor Industries Plc) against the 6 real case study titles (Plastic Packaging Manufacturer, Urban Brewery, Aluminium Recycling Plant, Specialist Brick Manufacturing, Brewer's Spent Grain, Net-Zero Brewery Design), some pairings read as plausibly inferable by a visitor even without any explicit label — and the case studies were anonymised specifically because the source content document is headed "ANONYMISED CASE STUDIES." Deliberately did not record or assert any specific pairing anywhere, even informally, since writing one down would itself be a step toward de-anonymising regardless of publication. Presented the yes/no question to Mission Control rather than deciding either way. **Mission Control confirmed: keep Testimonials and Case Studies unlinked.**

### Relationship mapping — two pairs evidence-grounded, one flagged as editorial synthesis
- **Case Study ↔ Industry Sector**: grounded in each case study's existing `cspt-portfolio-category` assignment (from WP-04) plus explicit title/content language where that adds a real second link (e.g. "Recycling Plant" → Waste & Circular Economy; "Circular Use" → Waste & Circular Economy). All 6 case studies mapped; Pharmaceuticals and FMCG Manufacturing correctly end up with zero linked case studies — no fabrication to force a match.
- **Case Study ↔ Service**: each link traced to specific quoted text in that case study's own Challenge/Solution/Results content (e.g. "government funding secured" → Funding, Procurement & Project Delivery). Full quotes recorded in `DECISIONS.md`. Capped at 2 services per case study — conservative, not exhaustive.
- **Industry Sector ↔ Service**: checked exhaustively — no source document in the repository maps this. Flagged directly to Mission Control as editorial synthesis rather than sourced fact before building it; Mission Control explicitly authorized proceeding anyway with that understood. Every reference to this table in the package's own copy (README, IMPLEMENTATION-GUIDE, the ACF field's own instructions text) states this plainly, not just in this register.

### Technical implementation
- 6 relationship fields (ACF `relationship` type, `return_format: id`) registered via `acf_add_local_field_group()` — same PHP-registration pattern CMS-005A used for "Service Icon," each in its own field group so nothing collides with CMS-002/005/006/007/008's existing groups.
- Genuinely bidirectional sync (`iep_sync_relationship()`) — diffs the new value against the previous one on every write and applies both additions and removals to the reverse side, not just appends. Deliberately built this way from the start rather than accepting a simpler additive-only sync that would accumulate stale relationships after any future correction.
- 3 authenticated `/iep-cms/v1/relate/...` endpoints (one per pair) plus a read endpoint and a minimal `/iep-cms/v1/service(s)` read path (Part 1's REST fix companion).
- `[iep_related type="industries|services|case_studies"]` shortcode — generic across all 3 relationship types, not swapped into any live page.

### Real finding, noted not fixed: stale demo meta still present on Case Study posts
While reading full case study content for the mapping work, found each of the 6 posts still carries inert Envato demo postmeta from before WP-04 (`cspt-portfolio-details_client: "Envato Group, US"`, a matching fake address, a stray Lorem-Ipsum short description) — harmless since WP-04's `template_redirect` bypass means nothing ever reads or displays it, but never cleaned up. Out of scope for this package (unrelated to relationships); flagged in `DECISIONS.md` for a future cleanup pass.

### Package contents
`deployment/CMS-010-Technical-Relationships/`: README, IMPLEMENTATION-GUIDE (deployment steps + all 3 migration tables with real post IDs for Case Study↔Industry, title-based lookup instructions for the two Services-touching pairs since Service IDs aren't knowable until the REST fix is live), VERIFICATION, ROLLBACK, DECISIONS (8 documented judgment calls including full evidentiary quotes), CHANGELOG, repository-update.md, `php/relationship-helper-functions.php` (Services REST retrofit, 6 field registrations, 3 bidirectional-sync endpoints, `[iep_related]` shortcode). No `acf-json/` — fields are PHP-registered.

### Repository Changes
- New: `deployment/CMS-010-Technical-Relationships/` (full package, 7 files).
- This report added to `missions/WCP-001-Progress-Register.md`.

### Commits
- No git commit made yet this session — remains uncommitted pending the user's usual batching call.

### Outstanding Issues
- Case Study↔Industry Sector can populate the moment the snippet is installed — no further dependency.
- Case Study↔Service and Industry↔Service population requires looking up real Service post IDs via the newly-added `/iep-cms/v1/services` endpoint first (Step 5/6 of `IMPLEMENTATION-GUIDE.md`) — cannot be done until the snippet is live.
- Industry Sector↔Service is editorial synthesis — worth a Mission Control review pass once it's populated, distinct in confidence level from the other two evidence-grounded pairs.
- `[iep_related]` shortcode isn't placed on any live detail page yet — relationships will exist in data but won't be visible to a visitor until that placement decision is made (flagged for whoever scopes WP-09).
- Stale Envato demo meta on the 6 Case Study posts, found but not fixed (see above).

### Next Work Package
**WP-09 — Homepage Journey Validation**, **WP-10 — Website Validation**, or **WP-11 — Repository Validation** all have no CPT-content dependency and could proceed regardless of WP-07/08's deployment status — Mission Control's call on ordering. Alternatively, deploy WP-07/WP-08's packages first via wp-admin so all of WP-03–08 reach a consistent "live" state before validation work begins.

---

## WP-07 + WP-08 — Deployment Verification (2026-07-19, same day)

User deployed both packages via wp-admin. Verified independently rather than trusting the "installed" report at face value — one real bug found in the process.

**WP-07 (Resources) — verified clean.** `cspt-resource` confirmed REST-visible (`resources-cpt`). Ran the Step 4 smoke test end to end: created a `TEST — delete me` record, populated all 5 fields via `/iep-cms/v1/resource/{id}` POST, independently re-fetched to confirm every value round-tripped correctly, then deleted it (trash, per the guide). `wp_list_cpt_items` confirms 0 published resources, as expected. The `fa-file-lines`/`fa-hand-holding-dollar` icon fix from the WP-07 report is confirmed correct in the database but **still shows the old broken icons live** — pending the same host cache purge every direct-DB push on this site has always needed, not a new issue.

**WP-08 (Technical Relationships) — deployed, one real bug found and fixed in the package, redeployment pending.** `cspt-service` confirmed REST-visible (`services-cpt`, all 9 real services returned with correct titles/IDs). Populated all 3 relationship pairs using the real IDs discovered at verification time (full detail in `deployment/CMS-010-Technical-Relationships/CHANGELOG.md` v1.1). **Bug found via independent re-verification** (cache-busted requests, not trusting the write responses): `Services.related_case_studies` — one of the 3 pairs' 6 reverse-field directions — got a phantom leading `0` written into every array that received at least one relationship (5 of 9 services affected). Root cause: `get_field()` on this site returns `false` for a never-before-saved `relationship` field, and the original `(array) $val ?: array()` cast turns that into `array(false)` → `array(0)` after `intval()`, not an empty array. The other two reverse-field directions (`Industries.related_case_studies`, `Services.related_industries`) came out clean. Also correctly distinguished a separate, unrelated **caching artifact** during this same diagnostic pass — an un-busted repeat GET to `/relate/863` returned a stale cached `null` for fields that were actually already set correctly (confirmed via `x-gateway-cache-status: MISS` on the cache-busted retry) — flagged as a false alarm rather than conflated with the real bug.

**Fix already written into the package** (`iep_normalize_ids()` helper + a new idempotent `/relate/cleanup` endpoint), **not yet redeployed** — the live site is still running the snippet that produced the 5 polluted records. Case Study↔Industry Sector and Case Study↔Service's *forward* fields, and Industry Sector↔Service entirely, are all confirmed correct and unaffected. **Outstanding**: paste the updated `php/relationship-helper-functions.php` into the existing Code Snippet, then call `POST /relate/cleanup` once to correct the 5 known-polluted records — full instructions in the package's `CHANGELOG.md` v1.1 entry.

### Redeployment and final cleanup (same day, WP-08 now fully clean)

User pasted the updated snippet — first attempt introduced a genuine PHP syntax error during the copy (`cspt-service` disappeared entirely from `wp_get_post_types`, confirming the whole snippet had gone inactive, consistent with Code Snippets' safe-mode auto-deactivation on a fatal error — plausibly smart-quote corruption during paste, given how many escaped apostrophes the file contains). User found and fixed the syntax error themselves; `cspt-service` reappeared in the REST-visible list, confirming the snippet was running again before calling `/relate/cleanup`, rather than assuming a paste had worked.

`POST /relate/cleanup` cleaned exactly the 5 predicted records (876, 878, 879, 880, 881 — `Services.related_case_studies`) and nothing else: `[0, 863, 865, 866] → [863, 865, 866]`, `[0, 864, 867] → [864, 867]`, `[0, 864, 868] → [864, 868]`, `[0, 868] → [868]`, `[0, 865, 866] → [865, 866]`. A repeat call returned `cleaned_count: 0`, confirming genuine idempotency. All 23 relationship-bearing posts (6 Case Studies, 8 Industries, 9 Services) independently re-fetched via cache-busted requests (`x-gateway-cache-status: MISS` on every read) and cross-checked against the original mapping tables in `deployment/CMS-010-Technical-Relationships/IMPLEMENTATION-GUIDE.md` — every forward and reverse value matches exactly, both directions, on all 3 pairs. **WP-08 is now fully deployed, populated, and verified clean.**

---

## WP-09 — Homepage Journey Validation — Execution Report

### Executive Summary
No prior WP-09 spec existed beyond its one-line name in this register. Found the actual governing document before designing any checks: `PDC-A001` (First Constitutional Amendment) establishes an authoritative **12-stage homepage narrative**, and a follow-up implementation mission (`EO-DEL002-002-Homepage-Restructure`, 2026-07-14) already corrected the ordering drift `PDC-A001` had flagged, plus left a documented **Drift Resolution Register** (D-01 through D-10) recording exactly what was fixed and what was deliberately deferred. Rather than re-derive a validation scope from scratch, used that register as the checklist: confirm no regression on what was fixed, check whether anything deferred is now actionable given WP-03–08's progress since, and check what that mission's own tooling gaps (screenshot capture) prevented it from confirming.

### Section order — validated against `PDC-A001`, no regression
Extracted the live homepage's actual rendered section sequence via DOM order (eyebrow + heading pairs, not raw JSON): Executive Trust → Commercial Challenge → Who We Help → Why IEP → Funding & Investment → Our Process (Methodology) → Engineering Capability (Services) → Featured Case Studies → Engineering Confidence (Technical Capability) → Leadership → Testimonials. Matches `PDC-A001`'s 12-stage model exactly (Call To Action, the 12th stage, confirmed separately as the final CTA section). 5 days after `EO-DEL002-002`'s restructure, no drift has crept back in.

### Real finding: D-05's "Leadership hardcoded" note is stale — already resolved, not documented as such
`EO-DEL002-002`'s Drift Resolution Register (D-05) stated Case Studies and Leadership excerpts on the homepage "remain hardcoded... deferred" as of 2026-07-14. Checked directly rather than trusting that note: the homepage's Leadership section actually contains a live `[iep_team_grid group="director"]` shortcode, and it correctly renders all 3 real directors (Andy Holgate, Dr Abhishek Asthana, Tim Griffiths) with real photos — genuinely CMS-driven, sourced from WP-03's `cspt-team-member` data. Nobody had gone back to update D-05's status after WP-03 shipped and someone (unclear exactly when) wired this shortcode in. Corrected here, same spirit as `EO-DEL002-002`'s own correction of the stale "3 H1s" finding from the mission before it.

### Real finding: Case Studies section is still hardcoded — D-05 accurate here, and now actionable
Confirmed the homepage's "Featured case studies" section has no `[iep_case_study_grid]` or similar shortcode anywhere in `_elementor_data` — the Plastic Packaging Manufacturer / Urban Brewery card content is static text, and neither card links to its own detail page (only a single "View all case studies" link at the section's end). This was correctly deferred by `EO-DEL002-002` at the time (`cspt-portfolio` had no REST access yet) — but WP-04 has since made that data fully CMS-driven and REST-accessible, with a working `[iep_case_study_grid]` shortcode ready and unused. **Not swapped in here** — same "optional, your call" discipline as every prior shortcode-into-live-page decision in this program, since it's a visible content change to an already-live homepage section, not a validation-scope action.

### Real finding, still open: Hero / Executive Trust Metrics duplication (WP-01)
Re-checked WP-01's own flagged finding from 5 days ago — still exactly as described. Hero shows Energy cost reduction 25%, CO2 emission reduction 10–40%, Wastewater cost reduction 20–80%, and Savings identified £50k–£1m+; the very next section ("Executive trust metrics") repeats all 4 numbers verbatim. Nothing has changed here since WP-01 surfaced it — still a real, unresolved content-architecture question, not re-litigated further this session (WP-01 already made the case for why it needs a decision, not a re-analysis).

### Real finding: no durable rollback path exists for the 2026-07-14 homepage restructure
`EO-DEL002-002` itself flagged this as an unconfirmed risk ("the restructure script's DB backup write did not appear in a post-deployment meta check... not re-diagnosed"). Checked directly: `_iep_homepage_restructure_backup` post meta on page 959 genuinely does not exist (`null`), and no `homepage-parsed.json` backup file was ever committed to the repository's `deployment/EO-DEL002-002-Homepage-Restructure/` package (only `README.md`, `VERIFICATION.md`, `ROLLBACK.md`, and the two PHP scripts exist there). If the M2 reorder or M4 CTA move ever needed reverting, the only path left is Elementor's own revision history, if it hasn't expired — not something to fix retroactively now (a backup taken today wouldn't represent the pre-restructure state anyway, and 5 days of further edits have layered on top since), but worth knowing this safety net doesn't exist.

### Links and responsive behaviour — clean
All 13 unique internal links on the homepage (nav, footer, in-page CTAs) resolve HTTP 200 — none broken. No horizontal overflow at mobile (375px), tablet (768px), or desktop (1280px) — matches `EO-DEL002-002`'s own verification, no regression.

### Screenshot tooling — still non-functional, 3rd consecutive session to hit this
Same failure mode `EO-DEL002-001` and `EO-DEL002-002` both recorded — `computer` (screenshot) timed out on repeated attempts across viewport changes. All verification in this report is DOM/structural, not pixel-based, consistent with those two prior reports' own disclosed limitation. Worth a manual visual QA pass whenever screenshot tooling is next confirmed working.

### `[iep_related]` (WP-08) not placed anywhere — noted, not actioned
Per `deployment/CMS-010-Technical-Relationships/repository-update.md`'s own forward-pointer to whoever scoped WP-09: relationship data (Case Study↔Industry↔Service) exists and is correct, but nothing on the live site surfaces it to a visitor yet. Not a homepage-specific gap (it would belong on Case Study/Industry/Service detail pages, not the homepage itself) — noted here for completeness, real scope is a future decision, not this WP's to make.

### Repository Changes
- This report added to `missions/WCP-001-Progress-Register.md`.
- No live site changes made this WP — validation only, consistent with the WP's own name.

### Commits
- No git commit made yet this session — remains uncommitted pending the user's usual batching call.

### Outstanding Issues
- Case Studies section on the homepage could now go CMS-driven (WP-04 unblocked it) — implementation decision, not made here.
- Hero/Trust Metrics duplication (WP-01) still needs a decision.
- No durable rollback backup for the 2026-07-14 homepage restructure — informational, not actioned.
- Screenshot tooling still non-functional — recommend a manual visual QA pass when available.

### Next Work Package
**WP-10 — Website Validation** and **WP-11 — Repository Validation** remain — no CPT dependency, Mission Control's call on which next.

---

## WP-10 — Website Validation — Execution Report

### Executive Summary
No prior WP-10 spec existed beyond its name. Scoped it as the site-wide counterpart to WP-09 (which covered only the homepage): crawl every real, in-nav page for broken links, confirm the site's large orphaned-demo-page inventory is genuinely inert, check basic SEO hygiene, and do a lightweight plugin/site-health pass. Found the full page inventory first rather than assuming CLAUDE.md's documented count was current — it wasn't (46 total pages live, not the ~30 CLAUDE.md describes; worth a documentation-accuracy note, not corrected here since editing CLAUDE.md wasn't asked for).

### Links — clean across all real content pages
Crawled Home (from WP-09), About, Services, Industries, Case Studies, Leadership, Testimonials, Contact, and Insights — every unique internal link across all of them (nav, footer, in-page CTAs, Case Studies' 6 detail-page links) resolves HTTP 200. Two directly-tested sample CMS detail pages (`/industry-sector/food-beverage/`, `/team-member/andy-holgate/`) also resolve 200, confirming WP-03/WP-05's individual detail pages are genuinely live, not just DB-correct.

### Real finding: Industries and Leadership listing pages don't link to their own working detail pages
Same discoverability gap WP-09 found for the homepage's Case Studies teaser, but here it's the actual dedicated listing pages a visitor reaches from primary nav. `/industries/` (971) and `/leadership/` (972) are still the original hardcoded Elementor pages — neither links to any of the real, live `/industry-sector/{slug}/` or `/team-member/{slug}/` detail pages, even though both sets of detail pages work perfectly at their direct URLs (WP-05, WP-03 v1.4). This is the exact "optional page swap" both those WPs' own `IMPLEMENTATION-GUIDE.md`s flagged as unactioned — confirmed still true, not fixed here (visible content change to a live page, same "your call" discipline as every prior shortcode swap in this program).

### Real finding: ~30 orphaned demo pages confirmed genuinely unlinked
Cross-referenced every link gathered from all 8 real pages against the ~30 published-but-not-in-nav pages (Homepage 1–8, About Us 1–6, Blog Classic/Grid View, Project Style 1/2, Services – Old, Our Team, FAQ, Our History, Contact Us – Old, Shop/Cart/Checkout/My account, etc.) — none of the orphaned pages appear in any real page's link set. They're genuinely dead weight (publicly reachable by direct URL, indexable, but not part of the visitor journey), matching `CLAUDE.md`'s existing characterization, though its stated count (30) is now stale — 46 pages actually exist. Not actioned (unpublishing ~30 pages is a real content decision, not a validation-scope action) — flagged for a future cleanup mission if wanted.

### Real finding, more significant: 13 junk demo blog posts remain published, "Insights" is a self-documented placeholder
The "Insights" nav item (page 983) reads as broken at first glance — nearly empty, no article list — but it's actually an intentional placeholder: its own live copy states "🔴 Articles coming soon. This page will list published Insights — configure a post grid here... or set this as the Posts page once real articles replace the demo content." Same honest "coming soon" pattern as the original Resources page before WP-07. **The real problem is upstream of that placeholder**: `wp_get_site_settings` confirms `page_for_posts: 0` (unset) — `CLAUDE.md`'s documented "Posts page: ID 14" is stale/wrong; page 14 ("Industry News") is actually a draft, not the configured posts page, not live at all. Meanwhile `wp_list_posts` shows **13 published Envato Lorem-Ipsum demo blog posts** (fake solar/HVAC/food-industry content, mismatched to IEP's actual business — one literally titled "Brisket Lebrekas Alcatra Ground Round Sauage") sitting live at their own individual URLs, unlinked from any real page but publicly indexable — and confirmed, incidentally, to leak into at least one "Recent Posts" sidebar widget elsewhere on the site (observed earlier this session during unrelated verification work). Not unpublished here — bulk-moving 13 posts to draft is a real content decision worth flagging and confirming, not something to do silently mid-validation, but worth prioritizing given it's live junk content on a real client domain, not just an inert orphaned page.

### Minor finding: a stray generic LinkedIn link
The Contact page's link set includes both `https://uk.linkedin.com/company/iepltd` (the correct company page, used everywhere else on the site) and a bare `https://www.linkedin.com/` (LinkedIn's own homepage) — likely a default/unconfigured social-icon widget specific to that page's template variant. Low severity, noted not fixed.

### SEO: meta-description gap is sitewide, not just historical
`EO-DEL002-002` added a meta description to the homepage only (M6), explicitly because no SEO plugin exists on this site. Confirmed via direct fetch of all 10 real pages' raw HTML: only the homepage has a `<meta name="description">` tag — the other 9 (About, Services, Industries, Case Studies, Leadership, Testimonials, Insights, Contact, Resources) have none. Page `<title>` tags are all sane and correctly formatted (`{Page} – Industrial Energy Pioneers Limited`) across every real page — no broken/generic titles found.

### Site health: plugin list mostly clean, a few low-priority items
`wp_list_plugins` (30 total) shows no obviously malicious or broken plugins. A few real, low-priority findings: **Akismet (spam protection) is inactive** while Contact Form 7 is active and presumably collecting public submissions — a plausible real gap, not confirmed as actually needed (Sucuri may cover some of this). Three inactive-but-installed redundant plugins add unnecessary surface area without providing value: free "Advanced Custom Fields" (superseded entirely by the active ACF PRO), Gravity Forms (Contact Form 7 is the one actually in use), and CoBlocks (unused Gutenberg blocks). None of these were toggled — plugin activation state changes affect site behaviour broadly and weren't asked for. `CLAUDE.md`'s "Other active plugins of note" list is incomplete against the live list (e.g. Ultimate Addons for Elementor — which WP-06 already found owns `cspt-testimonial` — and Clear Cache For Me, directly relevant to this engagement's own cache-purge workflow, aren't mentioned there) — noted for documentation accuracy, not edited without being asked.

### Repository Changes
- This report added to `missions/WCP-001-Progress-Register.md`.
- No live site changes made this WP — validation only, consistent with the WP's own name and WP-09's precedent.

### Commits
- No git commit made yet this session — remains uncommitted pending the user's usual batching call.

### Outstanding Issues
- Industries and Leadership listing pages could link to their real detail pages — implementation decision, not made here.
- 13 junk demo blog posts live and indexable — worth a decision on whether to move them to draft (same pattern as every prior demo-content cleanup in this program), given it's live content on the production domain, not just an inert page.
- ~30 orphaned demo pages confirmed harmless but still live — candidate for a future cleanup mission, not urgent.
- Sitewide meta-description gap — would need either a Code-Snippet-based per-page description mechanism (same pattern as the homepage's) or an actual SEO plugin, a real architecture decision.
- `CLAUDE.md` page count and plugin list are stale — flagged, not edited (wasn't asked to update it).

### Next Work Package
**WP-11 — Repository Validation** is the last remaining Work Package — no CPT dependency.

---

## WP-11 — Repository Validation — Execution Report

### Executive Summary
Last remaining Work Package. Scoped as an internal-consistency audit of the governance repository itself, distinct from WP-09/10's live-site focus: deployment package structural completeness, cross-reference integrity in the core governing documents, and whether `POA-META-001`'s registry (established specifically to prevent silent drift in the governance-document family) is actually being kept current. Found two real issues, one of them significant enough to affect how a future session — human or AI — orients itself in this repository.

### Deployment package completeness — consistent, one structural outlier
All 9 CMS-numbered packages deployed this program (`CMS-002` through `CMS-010`, excluding `005A`) carry the full standard file set: README, IMPLEMENTATION-GUIDE, VERIFICATION, ROLLBACK, CHANGELOG, `repository-update.md` (`CMS-003`/`CMS-004` lack `DECISIONS.md`, but they predate that convention — `CMS-005` was the first package to introduce it — not a defect, just an earlier era). **`CMS-005A-Service-Taxonomy` is a real structural outlier**: only `README.md`, `IMPLEMENTATION-GUIDE.md`, and `php/` exist in its deployment package — no `VERIFICATION.md`, `ROLLBACK.md`, `CHANGELOG.md`, `DECISIONS.md`, or `repository-update.md`. Nothing is actually lost — `docs/CMS-005A-Service-Taxonomy-Deployment-Report.md` independently covers verification, changelog-equivalent history, and decisions in full — but the module's own deployment package doesn't follow the same self-contained convention every other module uses, worth normalizing if `CMS-005A` is ever revisited.

### `POA-META-001` registry — accurate, not stale
Cross-checked the registry's claimed contents (`POA-GOV-001`, `POA-CASE-001`) against a live repository search for every `POA-GOV-*`/`case-law/*` file — exact match, nothing unregistered, nothing missing. The registry's own maintenance workflow (§6: register every new `POA-GOV`/`POA-CASE` document at materialization time) has evidently been followed correctly since `POA-META-001` itself was created.

### Real finding: two documents both claim `id: CMS-001` — a genuine numbering collision
`docs/CMS-001-CMS-Architecture.md` (front matter `id: CMS-001`, "CMS Architecture," `status: Placeholder`, dated 2026-07-05 — one of the original repository-materialization skeleton files, explicitly referenced as a `KNOWLEDGE-SOURCES-001` "Child" and in `README.md`'s own Read Order) and `docs/CMS-001-Production-Migration-Strategy.md` (front matter `id: CMS-001`, "Production Migration Strategy," `status: Planning Only — Not Approved for Execution`, dated 2026-07-12 — a real, substantive planning document) independently claim the identical repository ID. Neither document's own content acknowledges the other exists. Not renamed/renumbered here — deciding which one keeps `CMS-001` (or whether both get renumbered) is Mission Control's call, not a validation-scope action, especially since the CMS work that actually shipped (`CMS-002` onward) uses a different, unambiguous per-module numbering scheme that doesn't depend on resolving this collision.

### Real finding, most significant: root `README.md` is severely stale
Still dated 2026-07-05, `status: Draft`, version `0.1.0` — the repository's very first materialization output, never updated since. Its own text states **"Current Sprint: Not yet assigned"** and **"Current Mission: Not yet assigned... No content mission is active yet."** This is flatly wrong as of today: `PDC-001` has been Frozen since AQR-006, `PDC-A001` amended it, a full governance/case-law layer (`POA-GOV`/`POA-CASE`/`POA-META`) was added, and `WCP-001`/"Operation Horizon" — an 11-Work-Package program with this document as its own tracker — has been running since 2026-07-18 and is now complete. A new reader (human or AI) opening `README.md` first, exactly as its own "Read Order" section instructs, would be actively misled about the repository's actual state. Every file `README.md`'s Read Order points to (`PDC-001`, `DL-001`, `DSS-001`, `DDR-001`, `CMS-001-CMS-Architecture.md`, `SEO-001`) does exist — the collision above aside, nothing in the Read Order is broken, just badly out of date about program status. Not edited here — a full README rewrite is a real editorial decision (what to say about `WCP-001`'s completion, whether to restructure the Read Order to include the governance layer and `missions/WCP-001-Progress-Register.md`) worth Mission Control's input, not something to do silently as a validation finding.

### Git status — uncommitted work remains, consistent with every prior WP this session
`git status` confirms: `missions/WCP-001-Progress-Register.md` modified, `deployment/CMS-009-Resources/` and `deployment/CMS-010-Technical-Relationships/` untracked. Same "batch and commit later" pattern noted at the end of every WP this session — not actioned here either, per the standing rule that commits happen only when explicitly asked for.

### Repository Changes
- This report added to `missions/WCP-001-Progress-Register.md`.
- No other repository files changed this WP — validation only.

### Commits
- No git commit made yet this session.

### Outstanding Issues
- `CMS-001` ID collision needs a decision (rename one, or both).
- Root `README.md` needs a full rewrite to reflect current repository/program state — flagged as the single most impactful documentation fix available, since it's every new reader's entry point.
- `CMS-005A`'s deployment package is missing the standard verification/rollback/changelog/decisions files (content exists elsewhere, just not in the expected location).
- All uncommitted work from this session (WP-07 through WP-11, ~20 files) still needs a git commit — Mission Control's call on timing, per the established pattern.

---

## WCP-001 — Program Complete (2026-07-19)

All 11 Work Packages are now done. Summary of what shipped this program ("Operation Horizon"):

- **CMS content modules deployed and populated**: Leadership (WP-03), Case Studies (WP-04), Industries (WP-05), Testimonials (WP-06) — all real client content, DB-verified.
- **Resources (WP-07)**: infrastructure-only, by design — no real client content exists yet to populate.
- **Technical Relationships (WP-08)**: Case Study↔Industry, Case Study↔Service, and Industry↔Service all wired and bidirectionally verified; Testimonials deliberately excluded on confidentiality grounds.
- **Homepage (WP-01, WP-02, WP-09)**: finalized, validated against `PDC-A001`'s 12-stage constitutional model — no drift found.
- **Website-wide validation (WP-10)** and **repository validation (WP-11)** close out the program with a clear-eyed account of what's genuinely clean versus what's a real, disclosed open item — not a claim that everything is perfect.

**Open items carried forward, not silently dropped** (full detail in each WP's own report above): Hero/Trust-Metrics duplication (WP-01/09), homepage Case Studies section and the Industries/Leadership listing pages still not linked to their own CMS detail pages (WP-09/10), 13 junk demo blog posts live on production (WP-10), sitewide meta-description gap (WP-10), the `CMS-001` ID collision and stale root `README.md` (WP-11), and the entire session's work still uncommitted to git. None of these block calling the program complete — they're the honest punch list for whatever comes next.

**Consolidated completion report**: `docs/WCP-001-Operation-Horizon-Completion-Report.md` — a standalone synthesis of all 11 Work Packages for anyone orienting to this program without reading the full register above.
