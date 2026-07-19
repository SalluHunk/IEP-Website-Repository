# OPERATION HORIZON

# CMS-005A — Service Taxonomy & Information Architecture

Mission Type

Repository-driven CMS Architecture

Mission Status

APPROVED

Purpose

Introduce a reusable Service Category taxonomy that governs how engineering services are organised, queried and presented throughout the website.

This mission improves the information architecture without altering the approved service portfolio or repository content.

The taxonomy shall become the authoritative organisational layer between CMS content and presentation.

--------------------------------------------------

Mission Objectives

1. Create a reusable Service Category taxonomy.

2. Assign every existing service to exactly one category.

3. Replace the current flat nine-card layout with three engineering capability sections generated dynamically from the taxonomy.

4. Preserve complete repository integrity.

5. Future-proof the CMS for filtering, landing pages, related services and API usage.

--------------------------------------------------

Architectural Principle

Presentation shall never determine structure.

Repository metadata shall determine presentation.

Implementation model:

Repository
        ↓
Service Category Taxonomy
        ↓
Display Order
        ↓
Dynamic Template
        ↓
Website

--------------------------------------------------

Repository Rules

The following SHALL NOT change:

• Service titles

• Service URLs

• Service content

• ACF field structure (except approved additions)

• CONTENT repository

• Constitutional documents

• Existing shortcode architecture

This mission affects presentation architecture only.

--------------------------------------------------

CMS Architecture

Create a taxonomy:

Service Category

Slug:

service_category

Public:

Yes

Hierarchical:

Yes

REST Enabled:

Yes

--------------------------------------------------

Create the following taxonomy terms

1.

Engineering Systems

Description

Integrated engineering solutions improving industrial performance, resource efficiency and sustainable infrastructure.

--------------------------------------------------

2.

Project Development & Delivery

Description

Engineering support throughout the project lifecycle from opportunity assessment through design, funding and delivery.

--------------------------------------------------

3.

Advanced Engineering & Innovation

Description

Specialist engineering capability supporting optimisation, technology development and continuous operational improvement.

--------------------------------------------------

Assign Services

Engineering Systems

• Energy, Utilities & Process Efficiency

• Water, Wastewater & Circular Resource Management

• Low-carbon & Resilient Energy Systems

--------------------------------------------------

Project Development & Delivery

• Opportunity Screening & Diagnostic Review

• Engineering Design, Feasibility & Investment Case

• Funding, Procurement & Project Delivery

--------------------------------------------------

Advanced Engineering & Innovation

• Product Design & Optimisation
(CFD, FEA & Experimental Analysis)

• AI-enabled Monitoring, Assurance & Continuous Improvement

• Technology Innovation & R&D Support

--------------------------------------------------

Display Order

Introduce an integer ACF field:

Display Order

Purpose

Controls ordering inside each category.

Rendering sequence:

Category

↓

Display Order ASC

↓

Render Cards

No hardcoded ordering.

--------------------------------------------------

Archive Template

Replace the current flat layout.

Render:

Category Heading

↓

Category Description

↓

Service Grid

Repeat automatically for every taxonomy term.

The archive must dynamically respond to CMS changes.

--------------------------------------------------

Visual Design

Maintain existing design language.

Reuse:

• typography

• spacing

• card styling

• hover behaviour

• responsive behaviour

Only change the information architecture.

--------------------------------------------------

Engineering Tone

Section headings and descriptions should reflect an industrial engineering consultancy rather than a corporate consulting firm.

Avoid corporate language.

Avoid marketing clichés.

Use engineering terminology consistent with the approved repository.

--------------------------------------------------

Future Compatibility

The taxonomy must support future use cases:

• related services

• industry landing pages

• search filters

• REST API

• navigation generation

• sitemap generation

• knowledge graph relationships

No additional code changes should be required to support these capabilities.

--------------------------------------------------

Verification

Confirm:

✓ Taxonomy created

✓ Three terms created

✓ Nine services categorised

✓ Display order functioning

✓ Archive generated dynamically

✓ No duplicated services

✓ Responsive layouts verified

✓ Existing URLs preserved

✓ Repository alignment maintained

--------------------------------------------------

Documentation

Create:

CMS-ARCH-001-Service-Taxonomy.md

Document:

Purpose

Architecture

Taxonomy Structure

Relationships

Rendering Flow

Future Extensions

Repository Dependencies

--------------------------------------------------

Deployment Report

Create:

CMS-005A-Service-Taxonomy-Deployment-Report.md

Include:

Summary

Implementation

Verification

Responsive Testing

Repository Compliance

Future Benefits

Client Value Delivered

Operational Status

Recommendation

--------------------------------------------------

Mission Success

Success is achieved when:

The Services page becomes repository-driven, taxonomy-driven and fully dynamic.

Presentation is governed entirely by metadata rather than hardcoded logic.

The architecture remains fully aligned with PDC-001, PDC-A001 and the CONTENT repository.

Materialise all required files.

Stop.