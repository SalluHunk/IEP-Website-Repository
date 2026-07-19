# CMS-010 — Technical Relationships Module: Changelog

## v1.0 (2026-07-19)
- Initial deployment package. Builds 3 bidirectional relationship pairs across real content: Case Study ↔ Industry Sector, Case Study ↔ Service, Industry Sector ↔ Service.
- **Testimonials deliberately excluded** — presented directly to Mission Control as a fork given Case Studies' anonymisation, rather than assumed either way. Mission Control chose to keep them separate.
- **Prerequisite fix bundled in**: `cspt-service` retrofitted for REST access (`rest_base: services-cpt`) — the only content-bearing CPT on this site that had never received this treatment, since CMS-005/CMS-005A's writes never needed REST.
- 6 relationship fields registered in PHP via `acf_add_local_field_group()` (CMS-005A's precedent for additive fields), each in its own field group, none touching CMS-002/005/006/007/008's existing groups.
- Genuinely bidirectional sync (`iep_sync_relationship()`) — diffs against the previous value on every write, so removed relationships are cleared on both sides, not just accumulated.
- Case Study ↔ Industry Sector and Case Study ↔ Service mapping tables are evidence-grounded — every link traced to the case study's existing category assignment or specific quoted text from its own Challenge/Solution/Results content (full quotes in `DECISIONS.md`).
- Industry Sector ↔ Service is explicitly flagged, in the package's own copy (not just this changelog), as editorial synthesis — no source document maps this; Mission Control authorized building it anyway with that limitation understood.
- `[iep_related type="industries|services|case_studies"]` shortcode for displaying relationships on detail pages — not swapped into any live page by this package.
- Not yet applied to WordPress — package phase only. Case Study↔Industry Sector can populate immediately once the snippet is live; the two Services-touching pairs additionally require looking up real Service post IDs via the newly-added `/iep-cms/v1/services` endpoint first.

## v1.1 (2026-07-19, same day) — deployed, real bug found and fixed during population
User installed the Code Snippet; `cspt-service` correctly became REST-visible (`rest_base: services-cpt`, 9 real services confirmed). All 3 relationship pairs populated via the endpoints using the real IDs discovered at deployment time.

**Real bug found via independent re-verification, not assumed correct from the write response**: `Services.related_case_studies` — one specific reverse-field direction, out of the 3 pairs' 6 total field directions — came back polluted with a leading phantom `0` in every array that received at least one write (`876: [0, 863, 865, 866]`, `878: [0, 864, 867]`, `879: [0, 864, 868]`, `880: [0, 868]`, `881: [0, 865, 866]`). Confirmed via cache-busted requests (`x-gateway-cache-status: MISS`) that this was real stored data, not a caching artifact — a separate, genuinely stale cached response on an un-busted repeat request to `/relate/863` earlier in the same diagnostic session (showing `null` for fields that were actually already set correctly) *was* a caching artifact, and was correctly distinguished from the real bug rather than conflated with it.

**Root cause**: `get_field()` on this site returns `false` for a `relationship` field that has never been saved before. The original `(array) get_field(...) ?: array()` cast turns `false` into `array(false)` (PHP's scalar-to-array cast wraps a single falsy scalar rather than producing an empty array), which `intval()`-maps to `array(0)` — a phantom zero silently written into the very first sync of any previously-untouched reverse field. Only `Services.related_case_studies` was affected in practice (not `Industries.related_case_studies` or `Services.related_industries`, the other two reverse directions) — plausibly because those two happened to read back an already-array-shaped empty value rather than a scalar `false` at the point they were first touched; the exact ACF-internal reason wasn't fully pinned down, but the fix doesn't depend on knowing why — it removes the failure mode outright regardless of what `get_field()` returns for "empty."

**Fix**: replaced the cast with a new `iep_normalize_ids()` helper that treats anything not already a real array as empty, and drops any non-positive entry from real arrays too — used everywhere `iep_sync_relationship()` reads a relationship field. Added a one-time, idempotent `/relate/cleanup` POST route that re-normalizes every relationship field across all 3 CPTs and reports what it changed, to fix the 5 already-polluted service records without needing to re-run the full population (re-running the same population calls wouldn't have fixed it — the diff-based sync only rewrites a reverse field when the *from* side's value actually changes, and the from-side values were already correct).

**Status as of this entry: fix written into this package's `php/relationship-helper-functions.php`, not yet redeployed.** The live site is still running the v1.0 snippet with the 5 known-polluted records in place — `related_industries`/`related_services` on all 6 Case Studies and all 8 Industries are already correct and unaffected (confirmed clean via cache-busted reads); only `Services.related_case_studies` needs the fix + one `/relate/cleanup` call once the corrected snippet is pasted in.

## v1.2 (2026-07-19, same day) — redeployed, cleaned, fully verified

First redeployment attempt introduced a genuine PHP syntax error during copy-paste into Code Snippets — the entire snippet went inactive (confirmed via `cspt-service` disappearing completely from `wp_get_post_types`, not just the custom routes 404ing), consistent with Code Snippets' built-in safe-mode auto-deactivation on a fatal error. Plausible cause: smart-quote autocorrection during paste, given how many escaped apostrophes (`\'`) the file's ACF `instructions` strings contain. User found and fixed the syntax error; `cspt-service` reappeared in the REST-visible list, checked before assuming the paste had worked this time.

Called `POST /relate/cleanup` once: cleaned exactly the 5 predicted records and nothing else —

| Service | Before | After |
|---|---|---|
| 876 (Energy, Utilities & Process Efficiency) | `[0, 863, 865, 866]` | `[863, 865, 866]` |
| 878 (Water, Wastewater & Circular Resource Management) | `[0, 864, 867]` | `[864, 867]` |
| 879 (Low-carbon & Resilient Energy Systems) | `[0, 864, 868]` | `[864, 868]` |
| 880 (Engineering Design, Feasibility & Investment Case) | `[0, 868]` | `[868]` |
| 881 (Funding, Procurement & Project Delivery) | `[0, 865, 866]` | `[865, 866]` |

A repeat call to `/relate/cleanup` returned `cleaned_count: 0` — confirms genuine idempotency, not a lucky one-off. All 23 relationship-bearing posts independently re-fetched via cache-busted requests (`x-gateway-cache-status: MISS` confirmed on every read, ruling out stale-cache false positives) and cross-checked against every row of `IMPLEMENTATION-GUIDE.md`'s 3 mapping tables — every forward and reverse value matches exactly. **Module complete: deployed, populated, and verified clean.**

**Reusable lesson**: on this site, `get_field()`'s "no value yet" representation for a `relationship` field is `false`, not `null` or `[]` — any future custom endpoint reading a possibly-never-set ACF field of this type should normalize defensively (`is_array($val) ? ... : []`) rather than relying on a `(array)` cast, which silently wraps non-array scalars into a single-element array instead of producing an empty one.
