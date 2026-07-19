# OPERATION ORDER
Mission: BACKUP-001

Objective

Create a complete rollback point before any CMS implementation begins.

This mission is mandatory.

No structural changes shall be made before a successful backup has been verified.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Tasks

1.

Create a full WordPress database backup.

Verify the backup completed successfully.

Record:

• timestamp

• backup method

• backup filename/location

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

2.

Backup theme assets.

Include at minimum:

• active child theme

• active parent theme (if modified)

• custom PHP templates

• custom CSS

• functions.php

• any custom scripts

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

3.

Export current WordPress configuration where practical.

Document:

• active plugins

• plugin versions

• active theme

• WordPress version

• PHP version

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

4.

Capture the current website state.

Record:

• Homepage ID

• Menu assignments

• Existing CPT counts

• Existing templates

This becomes the production baseline.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

5.

Repository

Create:

BACKUP-001-Production-Baseline.md

Include:

• timestamp

• environment

• backup summary

• rollback procedure

• verification status

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Deliverable

Return only:

Backup Status

Verification

Go / No-Go

Do not modify WordPress beyond creating backups.

Stop.