---
id: WCP-001-PROGRESS-REGISTER
title: WCP-001 — Website Completion Program — Progress Register
purpose: Single persistent tracking document for Operation Horizon / WCP-001, updated after every completed Work Package
status: Active
version: 0.8.0
owner: Engineering Corps (Claude) / Mission Control (user)
last_updated: 2026-07-18
---

# WCP-001 — Website Completion Program

**Directive:** Execution Order 001, Operation Horizon. Production phase — implement, materialize, validate and commit each Work Package sequentially; stop only at governance ambiguity, missing client content, repository conflict, or a confirmed production blocker.

## Overall Progress

```
██████████░░░░░░░░░░ 55%  (6 of 11 complete; Blocker A resolved to a proven, repeatable pattern)
```

| WP | Name | Status |
|----|------|--------|
| 01 | Homepage Finalization | ✅ Implemented, DB-verified — live-visual confirmation pending host cache purge |
| 02 | Technical Capability Experience | ✅ Implemented, DB-verified — live-visual confirmation pending host cache purge |
| 03 | Leadership CMS | ✅ Deployed and populated — all 7 real people live in `cspt-team-member`, DB-verified. `[iep_team_grid]` shortcode ready; swapping it into the live Leadership page is optional, user's call |
| 04 | Case Studies CMS | ✅ Deployed and populated — all 6 real case studies live in `cspt-portfolio`, DB-verified. 6 surplus demo posts moved to draft. Live-visual confirmation pending host cache purge. |
| 05 | Industries CMS | ✅ Deployed and populated — all 8 real sectors live in `cspt-industry-sector`, DB-verified, detail pages confirmed live. |
| 06 | Testimonials CMS | ✅ Deployed and populated — all 4 real testimonials live in `cspt-testimonial`, DB-verified. 1 surplus demo post moved to draft. `[iep_testimonial_grid]` shortcode ready but not yet visually spot-checked (grid-only, no individual pages to check against). |
| 07 | Downloads / Resources CMS | ⏳ Pending — may not need a new CPT (native Media is REST-exposed) |
| 08 | Technical Relationships | ⏳ Pending (depends on 03–07 content existing) |
| 09 | Homepage Journey Validation | ⏳ Pending |
| 10 | Website Validation | ⏳ Pending |
| 11 | Repository Validation | ⏳ Pending |

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
