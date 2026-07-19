# CMS-008 — Testimonials Module: Implementation Guide

All steps below are wp-admin actions. None require SFTP, SSH, or file-system access.

## Step 1 — Import the ACF field group

1. wp-admin → **Custom Fields → Tools**
2. Under "Import Field Groups", choose `acf-json/group_testimonial_fields.json`
3. Click **Import** — creates a field group called "Testimonial Details" attached to `cspt-testimonial`
4. Confirm it appears under **Custom Fields → Field Groups**

## Step 2 — Install the Code Snippet

1. wp-admin → **Snippets → Add New**
2. Title: `CMS-008 — Testimonial CPT + Grid Shortcode`
3. Paste the full contents of `php/testimonial-helper-functions.php`
4. Leave "Only run on specific pages" unset — **must run everywhere**, including wp-admin (a prior module's menu didn't appear in the sidebar until this was corrected — see CMS-007's lessons)
5. **Activate**

## Step 3 — Verify the CPT is REST-visible

Ask whoever has MCP/tooling access to check: `wp_get_post_types` should list `cspt-testimonial` with `rest_base: "testimonials-cpt"`. Also check `wp_list_cpt_items` with that `rest_base` — if any existing demo/placeholder items appear, note them (see Step 4).

## Step 4 — Identify existing content, then create/populate the 4 real records

Check whether `cspt-testimonial` already has any published items (demo content, empty placeholders, or something else) before creating new posts — if it does, decide whether to repurpose existing slots (same pattern as CMS-002/CMS-006) or add 4 new ones alongside. Either way, populate with this content, migrated verbatim from the live Testimonials page (1062):

### 1. Ultra Tough Ltd
- **Post title:** Ultra Tough Ltd · **Company Logo:** Media ID 1058 · **Display Order:** 1
- **Person Name:** Shailesh Divani · **Person Role:** Director · **Person Photo:** none (initials "SD" — leave blank)
- **Quote:**
  > "I am pleased to provide this letter of recommendation for Industrial Energy Pioneers (IEP) in recognition of their outstanding work in conducting an energy efficiency feasibility study for Ultra Tough.
  >
  > IEP's team demonstrated exceptional professionalism and expertise throughout the entire study. They successfully secured a substantial grant from the Industrial Energy Transformation Fund, which made a major contribution to the costs of the study.
  >
  > Furthermore, the study was executed on time and within budget, reflecting IEP's commitment to efficiency and financial discipline. Their thorough analysis and insightful recommendations were instrumental in guiding our Board in making informed decisions about the company's future energy strategy.
  >
  > Given our experience with IEP, I have no hesitation in recommending them to other organisations seeking expert guidance in energy efficiency studies and grant funding opportunities."

### 2. York Handmade
- **Post title:** York Handmade · **Company Logo:** Media ID 1059 · **Display Order:** 2
- **Person Name:** Guy Armitage · **Person Role:** Managing Director · **Person Photo:** none (initials "GA" — leave blank)
- **Quote:**
  > "We appointed Dr Abhishek Asthana, Director – Industrial Energy Pioneers (IEP) Ltd., to advise us on making an application to the Industrial Energy Transformation Fund (IETF) for a grant towards a feasibility study to consider energy efficiency measures we could adopt. Thanks to IEP's expertise in preparing the documentation, our application was successful, and the grant was awarded in the competition.
  >
  > IEP's engineering team are very knowledgeable and resourceful. They have designed the optimum energy efficiency solution for our site, striking the perfect balance between technological limits and financial returns which offers the best value for money.
  >
  > IEP have helped us plan the project financially and have supported us throughout the grant claim process to ensure that the claims are prepared on time and the payments received without hassles. This has been extremely valuable for a small company like ours with limited manpower and spare resources.
  >
  > We strongly recommend Dr Abhishek Asthana and his team at Industrial Energy Pioneers."

### 3. Harsco Environmental
- **Post title:** Harsco Environmental · **Company Logo:** Media ID 1060 · **Display Order:** 3
- **Person Name:** Kim Beighton · **Person Role:** Project Coordinator · **Person Photo:** Media ID 1053 (real photo — the only one of the 4)
- **Quote:**
  > "Dr Abhishek Asthana, Director of Industrial Energy Pioneers (IEP), helped us get grant funding from the government's Industrial Energy Transformation Fund (IETF) to carry out a detailed techno-economic feasibility study of energy efficiency at our Rotherham SteelPhalt site. His team of expert energy engineers helped us identify the largest energy savings under challenging operational constraints. They supported us fully throughout our journey, managing the project and grant claims, and making the whole experience extremely smooth and simple.
  >
  > It was a pleasure working with Abhishek and his team. For my first government-based project, it was definitely an eye opener, and I really appreciated that he took the lead and the time to explain everything when I was unsure.
  >
  > I highly recommend them for energy efficiency and decarbonisation projects."

### 4. Naylor Industries Plc
- **Post title:** Naylor Industries Plc · **Company Logo:** Media ID 1061 · **Display Order:** 4
- **Person Name:** Alex Farrer · **Person Role:** Group EHS Officer · **Person Photo:** none (initials "AF" — leave blank)
- **Quote:**
  > "We appointed Dr. Abhishek Asthana and his team to guide us through the process of applying for a feasibility study grant from the Industrial Energy Transformation Fund (IETF) aimed at exploring potential energy efficiency measures for our organization. Thanks to his expertise and attention to detail, our application was successful, and we were awarded the grant.
  >
  > Dr. Asthana and his team have since completed the feasibility study, delivering insightful recommendations tailored to our site's specific needs. Their innovative approach struck the perfect balance between technological feasibility and financial viability, ensuring that our investment will yield maximum returns.
  >
  > Based on our positive experience working with Dr. Asthana's team, we wholeheartedly recommend their services to other organizations seeking to improve their energy efficiency and sustainability practices."

## Step 5 — Test the shortcode

Add a Shortcode widget somewhere out of the way with `[iep_testimonial_grid]` and confirm all 4 testimonials render: logo, full quote, and person block (Kim Beighton with a real photo, the other 3 with correct 2-letter initials — not a blank avatar, not a placeholder image), ordered 1–4.

## Step 6 — Swap the live Testimonials page (optional, your call)

Page 1062's 4 hardcoded cards already show correct, approved copy and don't strictly need to change. Replacing them with `[iep_testimonial_grid]` is optional — see `ROLLBACK.md` if you do this and want to undo it.
