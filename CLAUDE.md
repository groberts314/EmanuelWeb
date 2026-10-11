# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Server-rendered PHP website for Emanuel Evangelical Lutheran Church (elclh.org) in La Habra, CA — an [ELCA](https://elca.org) congregation in the [Pacific Synod](https://pacificsynod.org). No framework, no build pipeline for PHP, no test suite. Deployed to Apache shared hosting (DirectAdmin) via SFTP — see "Deployment" below. Bootstrap 3.3.6 + jQuery 1.11.3 are pulled from CDN; site styles live in `css/emanuel.css`.

The site has a single maintainer (the repo owner). `GEMINI.md` / `gemini.config.json` are context files for Gemini CLI; where they disagree with this file (e.g. `gemini.config.json` mentions NRSV 1989 + Oremus links), follow this file — the site actually uses NRSVUE on Bible Gateway.

Most commits in `git log` are *content* updates (weekly Bible readings, monthly newsletter/calendar drops, swapping the homepage worship video). Treat those as the dominant workflow — see "Common recurring updates" below.

## Architecture

### URL routing (Apache `.htaccess`)

`.htaccess` rewrites map friendly URLs onto root-level `.php` files:

- `/foo` → `foo.php`
- `/foo/YYYY/MM` → `foo.php?year=YYYY&month=MM` (used by `newsletter.php` and `sunday-school-online.php` for archive browsing)
- `ErrorDocument 404 /404.php`, `410 /410.php`
- All HTTP redirected to HTTPS

When adding a new page, just create `whatever.php` at the repo root and link to `/whatever`.

### Page composition

Each top-level `.php` page assembles a full HTML document by `require_once`-ing partials in this order:

1. `partials/head-metas.phtml` (charset, viewport)
2. Optional `partials/head-metas-social.phtml` (OG/Twitter — called via `display()` with a `$metadata` array of `title`/`description`)
3. `partials/head-includes.phtml` (Bootstrap CSS, Cinzel font, `/css/emanuel.min.css` with a `?version=YYYY-MM-DD_HHMM` cachebuster, favicon)
4. `partials/masthead-top-nav.phtml` (header + main nav — dropdown menu lives here)
5. Page-specific content
6. `partials/footer.phtml`
7. `partials/footer-includes.phtml` (jQuery + Bootstrap JS)

Pages use either `<div class="container homepage-v2">` (homepage) or `<div class="container layout-v2">` (everything else).

### Helpers (`app-code/helper-functions.php`)

Used pervasively by partials — most partials `require_once` this themselves:

- `display($template, $params)` — `extract($params)` then `include $template`. The standard way to render a partial with variables.
- `render($template, $params)` — same but returns the output as a string instead of echoing.
- `get(&$var, $default = null)` — safe `isset()` accessor, used everywhere to avoid undefined-variable notices on optional partial params.
- `date_sort_descending(&$array, $dateKey = 'dateTime')` — in-place sort.
- `is_date_in_range(...)`.

`app-code/sanitization.php` provides a `sanitize($inputs, $fields)` wrapper around `filter_var_array` — currently used only by `diagnostics/form-post-test.php` (not by any public page).

### Data sources

Different data lives in different places — there is no unified model layer:

- **`app-data/upcoming-events.php`** — PHP array literal of `{date, content, keepUntil?}` rendered by `partials/homepage-v2-upcoming-events.phtml`. Events auto-expire after their `date` (or `keepUntil` if set) in `America/Los_Angeles`. `content` is a HEREDOC of HTML.
- **`app-data/audio-files.json`** — JSON array of `{dateTime, path, prefix?, speaker?}` for `worship-audio.php`.
- **`app-data/sunday-school-online-videos.php`** — legacy PHP array (now superseded by the DB; kept as historical reference). `sunday-school-online.php` reads from MySQL via PDO (`sunday_school_online_videos` table), paginated by month.
- **`app-code/db-config.php`** — DB credentials. **Gitignored.** Required by anything that touches MySQL. If you don't have it locally, DB-backed pages will fatal — request from the site owner.

### Gitignored content directories

`.gitignore` excludes binary/media folders that live on the server but not in git: `audio/`, `calendars/`, `event-fliers/`, `forms/`, `images/`, `newsletters/`, `video/`, `sunday-school-files/`. Also `*.min.css`, `*.min.js`, `wp-*.php` (WordPress install lives alongside on the host), and `app-code/db-config.php`.

This means: if a page references e.g. `/calendars/calendar-2026-05.pdf` or `/images/...`, the file legitimately exists in production even though `git status` shows nothing. Don't recreate these.

### YouTube live-stream detection (`youtube-video-data.php`)

JSON endpoint that scrapes the church's YouTube channel page to detect a live stream and falls back to the latest "worship"-titled video via the channel RSS feed. Returns `{status, isLive, title, iframeUrl, watchUrl}`. Currently not wired into any page (the homepage hardcodes the iframe `src` — see below).

## Common recurring updates

These are the bread-and-butter edits. Match the commit-message style in `git log` (`feat: Bible readings for Sunday, ...`, `feat: update default homepage video to ...`, `feat: updates for <Month Year>`).

### Weekly Bible readings

Edit `partials/homepage-v2-bible-readings.phtml` — change the Sunday date, liturgical day name, and the four readings (First Reading, Psalm, Second Reading, Gospel). Each link is a `biblegateway.com/passage/?search=...&version=NRSVUE` URL with the passage URL-encoded.

- **Source:** Revised Common Lectionary at <https://lectionary.library.vanderbilt.edu/>. During the season after Pentecost, use the **Alternate track** first reading + psalm (e.g. Isaiah 25:1-9 / Psalm 23, *not* the semicontinuous Exodus 32 / Psalm 106). Other calendars (e.g. Sola Publishing) use different verse ranges — Vanderbilt wins.
- **Day name:** the church uses "Nth Sunday After Pentecost" wording, never "Proper NN" (which is what Vanderbilt shows). Increment last week's N and confirm with a web search for `"<date>" "<Nth> Sunday after Pentecost"`.
- **Format:** the standard four-reading layout (e.g. as of commit `5dd7a9d`). Occasionally a week gets a special variant (e.g. `ded7a61`, Blessing of the Animals: extra readings list, ELCA logo commented out) — revert to the standard layout the following week.
- **Commit:** `feat: Bible readings for Sunday, <Month D, YYYY>` (one line, no body for routine weeks), then deploy just that file: `python scripts/deploy.py --go partials/homepage-v2-bible-readings.phtml`.

### Default homepage worship video

In `index.php`, update the `src` of the `#youtube-iframe` inside `.fluid-width-video-wrapper` to `https://www.youtube-nocookie.com/embed/<VIDEO_ID>`. The surrounding `<?php /* ... */ ?>` blocks are alternative embed snippets kept around as templates — leave them commented.

### Upcoming events

Edit `app-data/upcoming-events.php`. Keys are sequential ints; entries are `{date: 'YYYY-MM-DD', content: HEREDOC of `.event-detail` divs}`. Past events auto-hide based on current Pacific Time. Optional `keepUntil` extends visibility for multi-day events.

### Monthly newsletter & calendar rollover

Two separate constants gate the "what is the latest issue?" logic:

- **`newsletter.php`** — bump `$latestIssueYear` and `$latestIssueMonth` (lines ~12–13). Drop `newsletters/newsletter-YYYY-MM.pdf` and `images/newsletter/newsletter-YYYY-MM.jpg` into the (gitignored) folders on the server.
- **`calendar.php`** — bump `$transitionDate` (line ~19) to the first day of the new month. Drop `calendars/calendar-YYYY-MM.pdf` and `images/calendars/calendar-YYYY-MM.jpg` on the server.

The PDF/JPG drops happen out-of-band (FTP/server upload), not via git.

### Cachebusting CSS/JS

When `css/emanuel.css` changes and gets minified, bump the `?version=...` query string in `partials/head-includes.phtml`. Same pattern for `js/home.js?v=...` in `index.php`. Use `YYYY-MM-DD_HHMM` format to match existing strings.

## Deployment

`scripts/deploy.py` uploads over SFTP (`sftp.elclh.org`, web root `/domains/elclh.org/public_html`). It is stateless: each run compares every deployable file **as committed at `HEAD`** against the live server copy and uploads only the ones that differ (CRLF/LF-only differences are ignored). Run from the repo root:

```
python scripts/deploy.py                      # dry run: list differing files
python scripts/deploy.py --go                 # upload all differing files
python scripts/deploy.py --go path/a.php ...  # only the listed files
```

- Uncommitted edits are never deployed — commit first. It warns about dirty working trees and unpushed commits.
- It never deletes anything on the server, and never touches gitignored media folders. Dev-only files (`CLAUDE.md`, `GEMINI.md`, `README.md`, `docker-compose.yml`, `gemini.config.json`, `.gitignore`, `.editorconfig`, `scripts/`, `.vscode/`) are excluded. `css/emanuel.min.css` (gitignored) is compared from the working tree.
- Auth: username and password are read from Windows Credential Manager via Python `keyring` (service `elclh-sftp`; setup commands in the script's docstring). This repo is **public** — never put credentials, usernames, or other account details in committed files. Requires `pip install --user paramiko keyring`. Never ask for the password in chat. Key-based auth was tried and the host rejects it (no SSH Keys page in DirectAdmin; `~/.ssh/authorized_keys` ignored) — don't retry.
- The server host key is pinned in the script (`SHA256:ctLU2bd…`); a mismatch aborts.
- Always do a dry run first and inspect any unexpected file before `--go` — download the remote copy and diff it, since hand edits on the server do happen.
- The maintainer sometimes still uploads by hand with FileZilla; that's fine, the comparison handles it.

### Known server quirks

- **`.htaccess`** was reconciled in Oct 2026 (git and server match). A year-only `/page/YYYY` rule that once lived only on the server was an abandoned yearly-archive experiment (along with a server-only `the-good-news.php`, since deleted) — archives use `/page/YYYY/MM`; don't reintroduce it.
- **`index.php` gets overwritten by WordPress.** The host-managed WordPress install shares the web root (`wp-*.php` files, gitignored). Major WP core updates (not the minor ones) ship a full file set and replace our `index.php` with WP's; the dated `wp-index-YYYY-MM-DD.php` files on the server are the maintainer's past cleanups. Symptom: the homepage turns into WordPress. Fix: a dry run shows `changed index.php`; `python scripts/deploy.py --go index.php` restores it. Don't move or reconfigure the WP install — the host manages it.
- `partials/head-metas.phtml` and `partials/homepage-v2-sunday-school-online-promo.phtml` differ only cosmetically (blank line, commented code, indentation) — harmless to deploy.

## Local development

`docker-compose.yml` runs a local stack: the site on `php:8.1-apache` at <http://localhost:9080> (repo mounted at `/var/www/html`, `mod_rewrite` + `AllowOverride All` enabled — the `localhost` exemption in `.htaccess` exists for this), plus a MySQL 8 + WordPress sandbox at <http://localhost:9090> for experimentation. DB-backed pages need `app-code/db-config.php`, which isn't in git. `ripgrep` is installed on the host.

## Conventions worth knowing

- **Whitespace (see `.editorconfig`):** 2-space indentation, no tabs, no trailing whitespace, and every file ends with exactly one newline (GitHub flags a missing one). Markdown is exempt from trailing-whitespace trimming. When copying a file's content from an older commit, check its ending: `git show` output piped through `sed` keeps whatever ending the old version had.
- **PHP short tags** (`<?` and `<?=`) are used throughout — assume `short_open_tag = On` on the host.
- **Time zone:** anything date-comparing uses `new DateTimeZone('America/Los_Angeles')`. Don't use the server default.
- **Comments via `<?php /* ... */ ?>`** are the convention for keeping disabled HTML blocks around as future templates (e.g. alt video embeds, seasonal notices). Leave them; don't clean them up unless asked.
- **`error_reporting(E_ALL); ini_set('display_errors', 1);`** appears at the top of several pages. That's intentional for this site — production tolerates visible errors as an early-warning signal. Don't strip it.
- **No package manager, no lint/test/build commands.** Edits to `.php`/`.phtml` are live the moment they hit the server. The maintainer's Windows machine has no host PHP — don't call `php` directly. To verify, use the Docker stack (e.g. `docker exec elclh-local php -l <file>`, or load <http://localhost:9080>). The maintainer doesn't keep Docker Desktop running routinely — for risky changes (`.htaccess`, shared partials, PHP logic), ask them to start it rather than skipping the test; for routine content edits, careful reading is enough. To test the HTTPS redirect locally (which `.htaccess` skips for `localhost`), send a non-localhost Host header: `curl -H "Host: elclh.org" http://localhost:9080/...`.
- **Production PHP version is 8.1.32.** Live `phpinfo()` is at <https://elclh.org/diagnostics/phpinfo.php> (behind HTTP basic auth — ask the maintainer to check it). `app-code/sanitization.php` uses `FILTER_SANITIZE_FULL_SPECIAL_CHARS` (replaced the deprecated `FILTER_SANITIZE_STRING` in Oct 2026; it HTML-encodes rather than strips tags). Since that file is untracked, upload changes to it directly over SFTP — `deploy.py` won't.
- **`diagnostics/` and `app-code/sanitization.php` are intentionally kept out of the public repo** (excluded locally via `.git/info/exclude`, not `.gitignore`). They exist locally and on the server, uploaded by hand. `diagnostics/` holds ad-hoc DB/form/phpinfo probes and is password-protected on the server via DirectAdmin (HTTP basic auth; credentials in Windows Credential Manager under `keyring` service `elclh-diagnostics` — read them with Python `keyring`, never print them, and don't echo page bodies like phpinfo/DB rows into the transcript; GETting `form-post-test.php` is safe, POSTing it sends an email). Never commit them; `deploy.py` won't touch them since they're untracked.
