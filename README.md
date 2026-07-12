---
id: README
title: IEP Website Repository
purpose: Entry point and orientation guide for the repository
status: Draft
version: 0.1.0
owner: TBD
last_updated: 2026-07-05
---

# IEP Website Repository

## Repository Purpose
This repository is the single source of truth for the IEP Website project and the primary knowledge base for AI-assisted development. It exists to hold project documentation, mission briefs, reference material, assets, and a changelog in one structured, versioned location — rather than scattered across chat threads, local files, and the live site itself.

## Read Order
Suggested order for a new reader (human or AI) getting oriented in this repository:
1. `README.md` (this file)
2. `docs/PDC-001-Project-Design-Constitution.md`
3. `docs/DL-001-Design-Language.md`
4. `docs/DSS-001-Design-System-Specification.md`
5. `docs/DDR-001-Design-Decision-Register.md`
6. `docs/CMS-001-CMS-Architecture.md`
7. `docs/SEO-001-Performance-and-SEO.md`
8. `missions/AGENTS.md`, then the active `missions/CLAUDE-###-*.md` files
9. `changelog/CHANGELOG.md` for recent history

## Current Sprint
_Not yet assigned._ See `missions/` once mission files are populated.

## Current Mission
_Not yet assigned._ This repository has just been materialized (Mission IEP-RM-001 — Repository Materialization). No content mission is active yet.

## Repository Philosophy
- **Single source of truth.** Project decisions, design language, CMS architecture, and mission history live here — not only in chat history or the live WordPress install.
- **Structured for AI-assisted development.** Every document carries consistent front matter (title, purpose, status, version, owner, last updated) so both humans and AI agents can reliably locate and trust the current state of any given topic.
- **Decisions are recorded, not just made.** Significant design and architecture decisions are expected to land in the Design Decision Register, not only in conversation.
- **Documentation before implementation.** Docs and mission briefs are expected to precede large implementation efforts, not follow them.
- **Placeholders are honest.** An empty or placeholder section says so explicitly rather than being silently absent — this repository was materialized structure-first, content-second, by design (per Mission IEP-RM-001).
