> **2026-07-15 update:** this report's blocker is resolved to a deployment path. See `deployment/CMS-002-Leadership/` for a complete, ready-to-apply package (ACF fields + Code Snippet + real 7-person migration table) built on the exact findings below — nothing here was wrong, it just needed the CMS-003/004/005 packaged-deployment pattern instead of direct MCP execution. Not yet applied to WordPress as of this note.

# CMS-002 — Leadership Module: Execution Report

**Mission:** CMS-002 — Leadership Module (implement the first production CMS module: `cspt-team-member`)
**Date:** 2026-07-12
**Result: 🔴 Blocked at execution — nothing created or modified.** This is not a partial success dressed up — every write-side task hit a confirmed, tested platform wall. What follows is honest about what happened, what I prepared instead, and what a human needs to do to actually finish this.

---

## What actually happened

I tested the blocker live rather than assuming it from memory: `wp_get_post_types` still shows `cspt-team-member` with no REST route, and calling `wp_list_cpt_items` against it returns `No REST API route found for post type "cspt-team-member"` — confirmed at the moment this mission ran, not just inherited from `CMS-BOOT-001`/`002`.

**This blocks every write-side task in the mission:**
- **Task 1 (audit existing fields)** — I cannot read what fields, if any, already exist on the 6 published `cspt-team-member` items. No MCP tool can reach a non-REST-exposed post type's data.
- **Task 3 (create ACF fields)** — ACF Pro's Field Groups screen is a wp-admin UI action. I have no browser session logged into wp-admin, and I won't enter admin credentials to get one (that's outside what I do, by design — see this session's standing rules). There's also no MCP tool that manages ACF field-group registration directly.
- **Task 4 (populate one record)** — same wall: no way to write to a `cspt-team-member` item without either REST access or wp-admin access.
- **Task 5 (update the Leadership template)** — blocked twice over: no Elementor Pro / no ACF↔Elementor dynamic-tag bridge (confirmed in `CMS-BOOT-002`) to make an Elementor **free** widget read from an ACF field even if one existed, and no SFTP access to hand-code a PHP template instead.

**Important distinction:** none of this is blocked for a *human* working directly in wp-admin. `show_in_rest` (the REST-exposure setting) only affects programmatic/API access — the wp-admin post-edit screen and ACF's Field Groups screen work regardless of it. The block is specific to this session's tooling, not to the mission itself. Per the Repository Rules ("do not create a new Team Member post type"), the correct fix is enabling REST on the existing CPT (a small code change, still gated on the SFTP access noted since `CMS-BOOT-001`) or doing this round of content work by hand in wp-admin — not working around it with a parallel CPT.

Per the mission's own Repository Rules and Task 7 ("do not modify any other module"), I did not attempt a workaround that would violate those rules (e.g. registering a new post type, or writing to an unrelated REST-exposed type as a substitute).

---

## What I could still do without WordPress write access

### Task 2 — Compared against the CMS specification

The mission's example field list and `IEP-Phase6.5-CMS-Spec.md`'s `team_member` field list mostly line up, with naming differences and two genuinely new fields:

| Mission's field | Spec's equivalent | Note |
|---|---|---|
| Job Title | Designation | same concept, renamed |
| Qualifications | Qualifications | same |
| Biography | Biography | same |
| LinkedIn | LinkedIn | same |
| Profile Image | Photo | same concept, renamed |
| Display Order | Display Order | same |
| Areas of Expertise | Expertise | same concept, renamed (Technology taxonomy) |
| Featured Flag | *(not in spec)* | new — no Team Member Featured flag existed in the original spec (Case Study/Testimonial/Client had one, Team Member didn't) |
| Credentials | *(not in spec)* | new, and possibly redundant with Qualifications — see below |
| *(not listed, but in spec)* | Email, Phone, Achievements | the mission's list says "Examples," so these aren't excluded — recommend carrying them over rather than dropping them |

**Open question worth flagging, not resolving unilaterally:** "Qualifications" and "Credentials" as separate fields could be a meaningful split — the real content (below) shows people with both academic degrees (BEng, PhD, MEng) and professional memberships/chartered status (CEng, FEI, FIET, MIET) mixed together in one line today. Splitting them would be a genuine improvement, not just duplication — but it's a content-modeling decision for whoever builds the field group, not something to silently decide here.

### Task 4 (prepared, not executed) — real content for one record

Since I can't write it, here's the real content for **Andy Holgate**, ready to paste into wp-admin the moment someone creates the field group — sourced directly from the live Leadership page (confirmed in `CMS-BOOT-002`, not invented):

| Field | Value |
|---|---|
| Name (post title) | Andy Holgate |
| Job Title | Director |
| Qualifications | BEng (Hons), MIET |
| Biography | 25+ years in environmental sciences, engineering and manufacturing. Expertise: design and delivery of complex energy & utilities projects. Value: practical solutions that work in real operating environments. |
| Profile Image | `andy-holgate-mono.jpg` (media ID 1033, already uploaded) |
| Display Order | 1 (appears first on the live page) |

The other 6 people on the live Leadership page (Dr Abhishek Asthana, Tim Griffiths, Praise Varughese, Priya Saji, Saravanakumar Kandasamy, Vanessa Lengkang) have their content in the same page and can be migrated the same way once the field group exists — not duplicated here to keep this report to the one record the mission asked for.

### Task 6 — Verification results

- ✅ **Existing design remains unchanged** — trivially true, since nothing was touched.
- ⚠️ **Frontend renders correctly** — not applicable; no CMS-driven content exists yet to render.
- ⚠️ **Editing works from WordPress Admin** — not verified; requires a human to actually try it once the field group exists.

### Task 7 — No other module was touched

Confirmed by the fact that no write calls of any kind succeeded or were attempted beyond the read-only checks documented above.

---

## Deliverable

- **Fields created:** none. Blocked — no REST route on `cspt-team-member`, no wp-admin access this session.
- **Template updated:** none. Blocked — no Elementor Pro/ACF dynamic-tag bridge, no SFTP for a PHP template alternative.
- **Verification results:** design unchanged (trivially, nothing was touched); frontend/admin-editing verification not applicable yet.
- **Remaining gaps, in the order they need resolving:**
  1. Someone needs to do this round of work directly in wp-admin (create the field group, populate content) — that path is open right now, today, independent of any code/SFTP work.
  2. Longer-term fix so this MCP tooling can do it directly next time: enable `show_in_rest` on `cspt-team-member`'s registration (small PHP change) — still gated on the SFTP access open since `CMS-BOOT-001`.
  3. The Qualifications-vs-Credentials split (above) needs a decision before the field group is built, not after.
  4. The template layer (Task 5) has no resolution path at all without either purchasing Elementor Pro or getting SFTP access for a hand-coded PHP template — this was already the agreed strategy in `CMS-001`, just reconfirmed as still blocked.

**Stop.** No CPTs, field groups, content, or templates were created or modified.
