# CMS-002 — Leadership Module

## Mission

Implement the first production CMS module.

Target:

Existing Team Member CPT

Objective:

Convert the existing Leadership section from static Elementor content into ACF-driven dynamic content.

Repository Rules

- Reuse the existing CPT.
- Do not create a new Team Member post type.
- Extend existing content.
- Preserve URLs.
- Preserve IDs.
- No SEO changes.

Tasks

1. Audit existing Team Member fields.

2. Compare against the CMS specification.

3. Create only the missing ACF fields.

Examples:

- Job Title
- Qualifications
- Biography
- LinkedIn
- Profile Image
- Display Order
- Featured Flag
- Areas of Expertise
- Credentials

(Only if not already present.)

4. Populate one existing Team Member record using the real current website content.

5. Update the Leadership template to read from ACF fields instead of hard-coded Elementor text.

6. Verify:

- Frontend renders correctly.
- Editing works from WordPress Admin.
- Existing design remains unchanged.

7. Do not modify any other module.

Deliverable

Return:

- Fields created
- Template updated
- Verification results
- Remaining gaps

Stop.