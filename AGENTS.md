# AGENTS.md — Jetpack Theme

Read [`README.md`](README.md) first. This file lists the conventions AI agents (Cursor, Claude Code, Codex, etc.) MUST follow when working in this repo.

## Conventions

- **Worktrees, not duplicate clones.** When asked to set up a second Studio site, use `git worktree add`, never a fresh `git clone`. See README -> [Advanced: parallel work with multiple Studio sites (worktrees)](README.md#advanced-parallel-work-with-multiple-studio-sites-worktrees).
- **`studio wp` prefix.** Never run bare `wp`. This site runs on Studio (PHP WASM + SQLite); a standalone `wp` binary will not work. See README -> [Studio quirks](README.md#studio-quirks-read-this).
- **FSE-first.** Prefer core blocks > template parts > `wp:group` wrappers > custom blocks. Don't reach for a custom block to add a wrapper div. See README -> [FSE / block-theme philosophy](README.md#fse--block-theme-philosophy) and [`.cursor/rules/fse-philosophy.mdc`](.cursor/rules/fse-philosophy.mdc).
- **Nav URLs are normalized at render.** `jetpack_get_menu()` in [`functions.php`](functions.php) pipes every menu item URL through `jetpack_normalize_local_url()`, which rewrites `localhost`/`127.0.0.1` URLs to the current `home_url()`. Don't double-prefix in templates and don't remove the filter — Studio assigns ports dynamically and stored absolute URLs in the menu would otherwise 404.
- **Don't track third-party code.** This repo is theme-only today. The Studio site root contains `akismet/`, `jetpack/` (the plugin), `twentytwentyfour/`, etc. — none of those belong in version control.
- **One Claude Code / Cursor session per worktree.** Open the agent in the worktree's theme folder so it sees only that branch's files and history.
- **TypeScript for new block code.** This is a TypeScript codebase (`.tsx` / `.ts`) and that's intentional — it matches the [WordPress core team's official recommendation](https://github.com/wordpress/gutenberg/blob/trunk/docs/reference-guides/interactivity-api/core-concepts/using-typescript.md) for Interactivity API blocks (which several blocks here use: `site-header`, `testimonials`, `faq`, `hero`, `blur-headline`). For new Interactivity API blocks: write `view.tsx` + `store.ts` with an explicit `interface XState` passed to `store<XState>(...)` and `getContext< { ... } >()` for typed context — model on [`src/blocks/site-header/store.ts`](src/blocks/site-header/store.ts). Plain `.jsx` / `.js` is acceptable for genuinely simple static blocks, but don't strip types from existing TS files. See README -> [Source language: TypeScript](README.md#source-language-typescript).

## Per-Studio-site context

Every Studio site root contains three Markdown files **scaffolded by Studio** (one level above this theme — they live in the WordPress install, not in this repo, because they describe the surrounding environment, not the theme):

- `<site-root>/STUDIO.md` — substantive Studio guide (SQLite vs MySQL, dynamic ports, `wp-config.php` quirks, debug logging, mu-plugins). **Read this for environment-specific guidance.**
- `<site-root>/AGENTS.md` — short AI pointer that redirects to `STUDIO.md`.
- `<site-root>/CLAUDE.md` — Claude-specific pointer (just `@AGENTS.md`).

If you are running in a context where these files are accessible, treat them as authoritative for Studio-environment questions and treat *this* file (the theme's `AGENTS.md`) as authoritative for theme-code questions.

## Skills and rules also available to you

- [`.cursor/rules/`](.cursor/rules/) — FSE philosophy, WordPress core block attribute gotchas. Cursor reads these automatically.
- `<site-root>/.claude/skills/` — Studio CLI, WP block development, WP block themes, WP plugin development, WP REST API, WP-CLI ops. Both Cursor and Claude Code can use these.

## When the user asks for a custom plugin

The repo is theme-only today. When the first custom plugin is needed, the repo restructures to live at `wp-content/` (mirroring the [Automattic/jetpack monorepo](https://github.com/Automattic/jetpack)). See README -> [Adding plugins (future)](README.md#adding-plugins-future) for the migration runbook. **Do not preemptively restructure** — only do the migration when there's an actual plugin to add.
