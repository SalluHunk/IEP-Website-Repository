---
id: PRAR-001
title: Production Readiness Assessment Report
mission: Probe Beta-01 — Operation ASCENT, Burn 2
operation: ASCENT
purpose: Independent, adversarial production readiness audit of the live IEP Technology website
status: Assessment Complete
lifecycle: Materialized
last_updated: 2026-07-20
---

# PRAR-001 — Production Readiness Assessment Report

## Repository Position

**Depends On**
- Live WordPress state, verified directly across every page and subsystem checked in this report, 2026-07-20
- `docs/EO-ASC-001A-Hero-System-Production-Refinement-Report.md` (this probe re-verified, not assumed, that mission's changes are live)
- `missions/WCP-001-Progress-Register.md` (WP-01/03/04/05/09/10 — this probe re-checked several of that program's findings independently rather than inheriting them)

**Enables**
- Burn 2 success criteria: launch blockers must be resolved, high-priority issues addressed or consciously accepted, deferred items documented, before PRR-001 can proceed
- Any future launch-readiness review — this is the current authoritative assessment, superseding informal confidence from prior "validated" reports where this probe found otherwise

**Mission discipline note.** Per this probe's own mandate, prior approvals were not inherited. Several items previously reported as fully resolved elsewhere in this repository were re-checked from scratch; one (§2, Finding 1) turned out to be materially incomplete despite an earlier report's explicit claim that it had been "independently re-verified." This report states that plainly rather than quietly correcting the record.

---

## Production Readiness Assessment

### Overall Rating
**🔴 NOT READY** — two Launch Blockers found, one of them visitor-facing and reputationally serious.

### Launch Blockers

**🔴 1. Three of seven real team-member bio pages display leftover theme-vendor demo content — fake contact details and an unrelated business description — publicly live.**
`/team-member/praise-varughese/`, `/team-member/priya-saji/`, and `/team-member/saravanakumar-kandasamy/` each render a native-theme "About Me" block *above* the correct, real bio content, showing: phone `123456789`, email `info@creativesplanet.com` (the *theme vendor's own* demo address — CreativesPlanet authors the Greenly theme), and body text reading "More than 40 years ago, our company's namesake, LineThemes, pioneered a revolutionary sales training program for businesses of every size... a leader in sales and management training, with hundreds of training centers throughout North America." None of this relates to Industrial Energy Pioneers in any way. The three directors' pages (Andy Holgate, Dr Abhishek Asthana, Tim Griffiths) and the one team member created fresh during population (Vanessa Lengkang, who never had legacy demo data to begin with) are clean — this is not a site-wide template defect, it's 3 specific, real, unresolved records.

This directly contradicts an earlier claim in this repository (`missions/WCP-001-Progress-Register.md`, WP-03 v1.4) that "all 7 pages independently re-verified: correct real photo per person, old demo content gone, correct real bio text rendering." That verification checked the custom ACF-driven bio content and the featured image — it did not check this separate, theme-native Phone/Email/About-Me field group, which is a different data layer entirely (the same category of theme-native-vs-custom-field split WP-06 later discovered and documented for Testimonials, but never checked against Team Members). These pages are not linked from the main Leadership page (itself hardcoded, showing only 3 directors) or any primary navigation, but they are live, unauthenticated, and indexable by search engines under each person's real name.

**Recommendation:** Clear the theme-native Phone/Email/About-Me fields on posts 887, 888, 889 (Praise Varughese, Priya Saji, Saravanakumar Kandasamy), matching whatever real/blank state Andy Holgate's equivalent fields are now in, before launch.

**🔴 2. Thirteen unrelated Envato demo blog posts remain published and publicly indexable.**
Carried forward from `missions/WCP-001-Progress-Register.md` WP-10 (not newly found, but re-confirmed live in this pass): `wp_list_posts` shows 13 published Lorem-Ipsum/mismatched-industry blog posts (solar, HVAC, and food-industry demo content), reachable at their own real URLs, unrelated to IEP's actual business. One is literally titled "Brisket Lebrekas Alcatra Ground Round Sauage." The "Insights" nav item leads to a page that honestly says content is "coming soon," but these 13 posts sit outside that honest framing, live and crawlable regardless.

**Recommendation:** Move all 13 to draft (not delete — matches this repository's standing practice for every prior surplus-demo-content cleanup).

### High Priority Issues

**🟠 1. Contact form's Name field is not actually enforced as required, despite its placeholder implying it is.**
Inspected the live Contact Form 7 markup directly (not submitted, to avoid triggering a real notification to the site owner): "Your Name *" carries no `wpcf7-validates-as-required` class and no `aria-required="true"` attribute, unlike "Your Email *", which is correctly configured on both counts. A visitor can submit a fully anonymous inquiry with a blank name field despite the visible asterisk suggesting otherwise.

**🟠 2. This session's own EO-ASC-001A Hero copy overstates a credential.**
Applying the same adversarial standard to work done earlier in this same session: the new Hero paragraph says "Chartered Engineers" (plural). Checked against the Leadership page directly — of the 3 directors, only Dr Abhishek Asthana holds CEng (Chartered Engineer); Andy Holgate holds MIET (Member, not Chartered), and Tim Griffiths holds FCA (a Chartered *Accountant*, not an engineer). The plural overstates how many chartered engineers are on the team. Suggested correction: "Chartered-Engineer-led" or similar singular framing — not fixed in this report, since this probe's mandate is assessment, not further unrequested edits.

**🟠 3. Industries and Leadership listing pages don't link to their own real, working detail pages.**
Re-confirmed live (not assumed from the prior WP-09/WP-10 finding): `/industries/` has zero links to any of the 8 real `/industry-sector/{slug}/` pages; `/leadership/` is a separate hardcoded page showing only the 3 directors, with no links to any of the 7 real `/team-member/{slug}/` pages (including, notably, the 3 pages flagged as Launch Blocker 1 above — meaning even after that content is fixed, there's still no ordinary navigation path to it). The underlying pages work; the discovery path from primary navigation does not exist.

**🟠 4. Homepage's Case Studies teaser doesn't link to individual case studies.**
The dedicated `/case-studies/` page correctly links all 6 cards to their real detail pages (fixed in an earlier mission). The homepage's own teaser section, showing the same case studies, does not carry the same links — an inconsistency between two presentations of the same content on the same domain.

**🟠 5. No page except the homepage has a meta description.**
No SEO plugin is installed; the homepage's description was hand-added via a Code Snippet in an earlier mission. About, Services, Industries, Case Studies, Leadership, Testimonials, Insights, Contact, and Resources all have none — a real, if unglamorous, launch consideration for search and social-share presentation.

**🟠 6. A real typo in live bio copy.**
Dr Abhishek Asthana's bio reads "a wide rage of industrial sectors" — should read "range."

### Medium Priority Issues

**🟡 1. Heading hierarchy skip on the Contact page** (H1 → H3, no H2 in between) — a minor accessibility citation, not a blocking defect.

**🟡 2. "Website URL" field on the Contact form** is an unusual ask for a plain contact form (more typical of a lead-gen form) — not broken, just worth a product decision on whether it belongs.

### Deferred Improvements (Operation POLISH)

- Stray generic `linkedin.com` homepage link on Contact, alongside the correct company-page link.
- ~30 orphaned legacy Envato demo pages (Homepage 1–8, About Us 1–6, Blog Classic/Grid View, etc.) — confirmed genuinely unlinked from anywhere real, harmless but still live; candidate for a future cleanup pass.
- No durable rollback backup exists for the 2026-07-14 homepage restructure — informational, not visitor-facing.
- `[iep_related]` relationship shortcode (Case Study↔Industry↔Service data, built and verified correct) isn't placed on any live page yet — the data exists, the front-end surfacing doesn't.
- Two redundant inactive plugins (free "Advanced Custom Fields" alongside the active Pro version; Gravity Forms alongside the active Contact Form 7) — no functional impact, just unnecessary surface area.
- Screenshot-based visual QA tooling was non-functional throughout this session (and, per this repository's own record, throughout `EO-DEL002-001`, `EO-DEL002-002`, and WP-09/10 before it) — every check in this report is DOM/structural/direct-content verification, not pixel-based. A genuine manual visual pass is recommended before final sign-off, independent of this report's findings.

---

## Assessment by Objective

### 1. Executive Journey
Section order matches the site's own constitutional 12-stage model exactly, with no drift (re-confirmed live). The Hero-to-Executive-Brief-to-Confidence-Strip sequence now reads as one continuous zone following this session's EO-ASC-001A work (re-verified live, not assumed — cache had cleared and the new copy, credentials, and CTA label are genuinely rendering). The journey's weak points are downstream discovery paths, not the homepage sequence itself: real Trust-stage content (team bios, industry detail pages) exists but has no route from primary navigation, and — more seriously — some of that Trust-stage content is currently undermined by Launch Blocker 1 for any visitor who does reach it.

### 2. Content Integrity
The single most serious finding of this audit (Launch Blocker 1) is a content-integrity issue: real, professional bio content sitting directly beneath fake vendor-demo placeholder text on live, publicly-reachable pages. Beyond that: one confirmed typo, no other placeholder/Lorem-Ipsum content was found on any of the 14 primary real pages checked, and terminology was consistent across all pages reviewed (services, sectors, and credentials named the same way everywhere they appear, aside from Finding 🟠2 above).

### 3. Technical QA
Zero 404s across 29 real and CMS-driven pages checked directly. No horizontal-overflow or overlap issues found on the newly-modified Hero/Executive Brief section at any of 3 breakpoints. One real form-validation defect found (🟠1). Alt text present on all images checked; one heading-hierarchy citation (🟡1). CMS bindings for Case Studies, Industries, Testimonials, and Services are all confirmed working; Leadership's bindings work at the individual-page level but the listing page and 3 of 7 records have real content problems as detailed above. Performance was spot-checked (homepage ~219KB HTML, sub-second load in-session) with no red flags, but this was not a full Core Web Vitals audit — flagged as a gap, not a pass.

### 4. Production Readiness
See Launch Blockers, High Priority Issues, and Deferred Improvements above. Two 🔴 items are sufficient on their own to withhold a READY recommendation — both are visitor-facing, one is a genuine reputational risk (a prospective client could see the theme vendor's placeholder sales-training copy attached to a real engineer's name).

### 5. Architectural Integrity
No subsystem violates the approved 12-stage homepage architecture — confirmed directly, not assumed. No homepage section itself weakens the executive decision journey. The coherence gap is downstream of the homepage: several Trust/Evidence-stage destination pages (Industries, Leadership) are architecturally sound individually but structurally disconnected from the journey that's supposed to lead a visitor to them, and one of those destinations currently contains content that would actively damage trust rather than build it.

---

## Recommendation

**NOT READY**

Both Launch Blockers are narrowly scoped and mechanically straightforward to fix (clear 3 records' worth of leftover fields; move 13 posts to draft) — this is not a finding that the site's architecture or design is unsound, both of which held up well under adversarial review. It is a finding that specific, real content problems exist on live, reachable pages and should not go live in front of a first-time visitor or prospective client. Recommend resolving both 🔴 items and consciously deciding on each 🟠 item before Burn 2 is considered complete.

## Source References

**Primary Sources**
- Live WordPress state, verified directly page-by-page and record-by-record, 2026-07-20 — every finding in this report traces to a specific URL or database record checked in-session, not inferred from documentation
- Direct inspection of `cspt-team-member` records 884–889 and 1162 via their live rendered pages

**Related Repository Documents**
- `missions/WCP-001-Progress-Register.md` (WP-01, WP-03, WP-09, WP-10 — findings re-verified or corrected by this probe)
- `docs/EO-ASC-001A-Hero-System-Production-Refinement-Report.md` (re-verified live and lightly critiqued, §2 High Priority Issue 2)
- `docs/WCP-001-Operation-Horizon-Completion-Report.md` (13-junk-posts and unlinked-listing-pages items carried forward from its own open-issues table)
