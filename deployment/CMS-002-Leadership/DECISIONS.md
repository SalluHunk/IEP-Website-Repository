# CMS-002 — Leadership Module: Decisions

Every judgment call in this package, with reasoning. Read this before deploying or before changing the field model.

## Fields excluded from the mission brief's example list

The brief (`docs/CMS-002 — Leadership Module.md`) listed 9 candidate fields: Job Title, Qualifications, Biography, LinkedIn, Profile Image, Display Order, Featured Flag, Areas of Expertise, Credentials. This package ships 7 fields (6 of those 9, plus one new one). Two were excluded:

- **Featured Flag** — no verified content justifies it. All 7 people currently appear on the live Leadership page; there's no "featured subset" concept anywhere in the real content, CRN-001, or PDC-001. Adding a flag with no use for it yet would be exactly the kind of unrequested feature CMS-005's own DECISIONS.md warned against (native-feature duplication / no verified content). Same call CMS-005 made for its own excluded fields.
- **Areas of Expertise** — the mission brief's own note in `CMS-002-Leadership-Module-Report.md` flagged this as mapping to a "Technology taxonomy," but no such taxonomy exists yet (same situation CMS-005 hit for Industry/Technology relationship fields). More importantly: the real content doesn't cleanly decompose into discrete tags — each person's expertise is already fully expressed in their Qualifications and Biography text. Adding a parallel taxonomy would either duplicate that text or require inventing categorisation the client hasn't provided.

## Credentials not split from Qualifications

`CMS-002-Leadership-Module-Report.md` (the prior blocked-execution attempt) explicitly flagged this as "a genuine improvement, not just duplication — but a content-modeling decision for whoever builds the field group, not something to silently decide." Now that real content for all 7 people is in hand: the three directors' post-nominals mix academic degrees and professional memberships in one string each (e.g. "CEng, FEI, FIET, FHEA, PhD, MEng, MRes, BEng"), with no delimiter or existing convention distinguishing which letters are which category. Splitting this now would mean inventing a categorisation scheme not present in the source content — so this package keeps it as one field, matching what's actually live. If the client wants a real split in the future, that's a content decision for them to make explicitly, not one to infer from the letters themselves.

## New field added beyond the brief: "Team Group"

Not in the mission's example list. Added because the live Leadership page has a real, meaningful structural distinction — three Directors get one visual treatment (job title + qualifications inline, longer bio), four Team members get a lighter one (job title alone, shorter bio) — across two visually separate page sections ("Directors", "The team"). Without this field, the shortcode would have to either flatten everyone into one list (losing real information architecture the client has already approved) or hard-code which post IDs belong to which group (fragile, breaks if a record is re-created). A single select field is the smallest fix that preserves the real, live structure.

## LinkedIn field shipped but left blank for all 7 people

The field exists (matches the brief's example list, costs nothing to include) but every real record ships with it empty. CRN-001 lists "LinkedIn integration approach" as an explicitly open, unresolved client decision — inventing or guessing at LinkedIn URLs would be fabricating content Article X (Project Constraints) rules against.

## REST retrofit included as part of this package, not a separate mission

The Code Snippet includes a small, standard, low-risk WordPress technique (hooking `init` at priority 20 to set `show_in_rest`/`rest_base` on an already-registered CPT) alongside the shortcode. This wasn't explicitly asked for in the mission brief, but it directly closes the root cause of the blocker documented in `CMS-002-Leadership-Module-Report.md` and re-confirmed live under WCP-001 — and unlike registering a *new* CPT (which the Repository Rules forbid), retrofitting REST support onto the *existing* CPT doesn't create anything new or duplicate anything. Flagged here rather than silently bundled in without explanation.

## Photo images: reused, not re-uploaded

All 7 people's photos already exist in the Media Library (confirmed via the live page's image widgets) — the migration table references existing attachment IDs. No new media uploads are part of this package.
