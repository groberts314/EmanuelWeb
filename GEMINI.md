# Gemini Developer Context - Emanuel Lutheran Church (elclh.org)

This file provides critical structural and style guidelines for Gemini when assisting with the development, content automation, and maintenance of the Emanuel Evangelical Lutheran Church website codebase.

## ⛪ Church Context & Liturgical Style
- **Project Target:** Emanuel Lutheran Church website (La Habra, CA). 
- **Denominational Alignment:** Emanuel is a congregation of the Evangelical Lutheran Church in America ([ELCA](https://elca.org)), situated within the [Pacific Synod](https://pacificsynod.org).
- **Bible Translation Baseline:** New Revised Standard Version Updated Edition (NRSVUE) via Bible Gateway parameters, matching the active congregation materials.

## 🛠️ Local Environment & Tech Stack
- **Local Staging Environment:** Docker Compose cluster running an official `php:8.1-apache` server image linked directly to the local folder assets.
- **Local Access Gateways:** 
  - Custom PHP Site: `http://localhost:9080` (With `mod_rewrite` and `.htaccess` overrides enabled natively).
  - WordPress/MySQL Sandbox: `http://localhost:9090` (For future platform practice and exploration).
- **Search Utility:** Native system `ripgrep` (rg) is installed globally on the host Windows machine paths.

## 🚀 Git & Deployment Boundaries
- **Deployment Strategy:** Manual SFTP deployment via FileZilla GUI. 
- **AI Automation Limits:** Gemini is permitted to analyze local files, create branches, stage files, and run local commits. 
- **NO DIRECT LIVE ACCESS:** Gemini does not have live production server access keys. All modified files are strictly reviewed locally via browser refresh at `http://localhost:9080` and `git diff` before being manually uploaded into production.
