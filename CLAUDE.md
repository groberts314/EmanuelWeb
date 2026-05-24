# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Server-rendered PHP website for Emanuel Evangelical Lutheran Church (elclh.org) in La Habra, CA. No framework, no build pipeline for PHP, no test suite. Deployed to Apache shared hosting. Bootstrap 3.3.6 + jQuery 1.11.3 are pulled from CDN; site styles live in `css/emanuel.css`.

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

`app-code/sanitization.php` provides a `sanitize($inputs, $fields)` wrapper around `filter_var_array` — not currently `require_once`-d from any page in the repo (form-handling code lives elsewhere or hasn't shipped yet).

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

## Conventions worth knowing

- **PHP short tags** (`<?` and `<?=`) are used throughout — assume `short_open_tag = On` on the host.
- **Time zone:** anything date-comparing uses `new DateTimeZone('America/Los_Angeles')`. Don't use the server default.
- **Comments via `<?php /* ... */ ?>`** are the convention for keeping disabled HTML blocks around as future templates (e.g. alt video embeds, seasonal notices). Leave them; don't clean them up unless asked.
- **`error_reporting(E_ALL); ini_set('display_errors', 1);`** appears at the top of several pages. That's intentional for this site — production tolerates visible errors as an early-warning signal. Don't strip it.
- **No package manager, no lint/test/build commands.** Edits to `.php`/`.phtml` are live the moment they hit the server. The maintainer's local machine is Windows with no PHP runtime installed — don't try to verify via `php`, `php -S`, or `php -r`. Validate by careful reading; for risky changes, deploy to a quiet path on the host and check real behavior.
- **Production PHP version is 8.1.32.** Live `phpinfo()` is exposed at <https://elclh.org/diagnostics/phpinfo.php>. Note that `FILTER_SANITIZE_STRING` (used in `app-code/sanitization.php`) is deprecated as of 8.1 — leave it alone unless asked to address it.
- **`diagnostics/`** (gitignored, in working tree) holds ad-hoc DB/form/phpinfo probes — useful for debugging on the host but not part of the public site.
