# CMS-007 — Industries Module: Changelog

## v1.0 (2026-07-18)
- Initial deployment package. Registers a brand-new `cspt-industry-sector` CPT (no pre-existing Greenly demo CPT covers Industries — confirmed via live 404 tests on `/industry/`, `/sector/`, `/sectors/`).
- Mission Control chose "CPT with individual detail pages" over grid-only or repeater-field alternatives, presented as an explicit architecture question rather than assumed — see `DECISIONS.md`.
- ACF field group: Icon, Summary, Overview (ships blank — no richer source content exists), Display Order (4 fields).
- PHP Code Snippet: fresh CPT registration (REST-visible from creation, no retrofit needed), authenticated `/iep-cms/v1/industry-sector/{id}` endpoint, `[iep_industry_grid]` and `[iep_industry_single]` shortcodes, `template_redirect` bypass applied preemptively (lesson carried forward from CMS-006's mid-deployment fix).
- Full migration table for all 8 real sectors (FMCG Manufacturing, Construction Materials, Food & Beverage, Pharmaceuticals, Packaging, Energy-Intensive Manufacturing, Water & Environment, Waste & Circular Economy), sourced from the live, already-approved Industries page (971).
- All 8 icon values empirically verified against the site's actual Font Awesome 5.15.3 bundle before inclusion — third occurrence of this exact FA5-vs-FA6 mismatch this session, first time caught proactively instead of after the fact.
- **Related, but not part of this package:** 3 pre-existing broken icons on the live Industries page itself (971) were found and fixed directly during this research (`fa-droplet`→`fa-tint`, `fa-magnifying-glass`→`fa-search`, `fa-chart-simple`→`fa-chart-line`). Recorded in `missions/WCP-001-Progress-Register.md`'s WP-05 entry, not in this changelog's version history, since it predates and is independent of this package.
- Not yet applied to WordPress — package phase only.

## v1.1 (2026-07-18, same day) — deployed to production
- User installed the ACF field group and Code Snippet; all 8 real industry sector posts created and populated via the authenticated endpoint.
- **One live-diagnosed fix needed:** individual `/industry-sector/{slug}/` pages and the `/industry-sector/` archive both 404'd immediately after deployment, despite the CPT being correctly registered and REST-visible (`wp_get_post_types` and the authenticated endpoint both worked). Root cause: WordPress caches rewrite rules, and a newly registered CPT's pretty-permalink routes don't take effect until that cache is flushed (`flush_rewrite_rules()`) or someone visits Settings → Permalinks and saves. Fixed by adding a one-time, option-guarded `flush_rewrite_rules()` call to Part 1's `init` hook — deliberately guarded (not called unconditionally on every page load, which is a well-known WordPress performance anti-pattern).
- All 8 individual detail pages and the archive listing verified live via cache-busted fetch after the fix: correct icon, title, and summary render on every page, `[iep_industry_single]`'s bypass template works correctly (no theme fallback-template surprise, unlike CMS-006's mid-deployment discovery).
- See `missions/WCP-001-Progress-Register.md` for the full WP-05 deployment report.
