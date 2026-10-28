# HESIS Design Breakdown

Built from "Hesis HP Layout [BUILD for MATT PDFcomp].ai" (the PDF-compatible
Illustrator file, October 2026) and "Homepage content - V2.docx" on
`cb-js-skeleton2026` (native blocks, no ACF). Logo, tile icons, photography and
the five accreditation badges were lifted straight from that file; colours and
Poppins weights were read from its vectors and fonts.

Read `CLAUDE.md` first - it is the skeleton's own rulebook (no Sass, no Bootstrap,
Grid-based `.row`/`.col-*`, `.grid` for card layouts, tokens in `src/css/tokens.css`).
This file only adds what is specific to HESIS.

## Implementation Decisions

- Every page opens with a CB Hero. `body.has-hero` (set in `inc/setup.php`) lets
  the fixed header start transparent and flip to white on scroll
  (`src/css/header.css`, `src/js/header-scroll.js`). Pages without a hero get a
  solid header from load.
- Blocks were generated with the **CBP Block Builder** plugin (sidecar
  `.block-builder.json` in each block folder), then `render.php` and
  `src/blocks/{slug}.css` were hand-finished. Re-editing fields in the builder
  rewrites `src/edit.js` and `block.json` only; `render.php` is yours.
- Grid: `offset-*` classes set an absolute `grid-column-start`, so they cannot
  follow a spanning column in the same row - size the columns to add up to 12
  instead (see `footer.php`).
- Curved edges are 120vw masked pseudo-elements (`.curve-bottom` in
  `src/css/components.css`, the sectors block's own `.sectors__curve`, the
  footer's `::before`). The parent carries `overflow-x: clip`.
- Carousels are Swiper 11 from the jsDelivr CDN, registered in `inc/enqueue.php`
  and only enqueued when a block has added an init with
  `wp_add_inline_script( 'swiper', ... )`. Fade-ups and the logo marquee use the
  vendored GSAP (smooth-scroll module).
- Icons are inline SVG from `img/icons/` via `get_icon()`. The ten `icon-*.svg`
  files are the design's own tile icons (coral disc included, drawn in
  `currentColor`); the plain-named ones are generic line icons that get a disc
  from CSS. Service tiles take an icon slug, or an uploaded image to override it.
- `img/logo.svg` is the brand logo as vectors from the design file, with the
  tagline outlined. `cb_hesis2026_logo_svg()` inlines it with colour classes.
- The "We are an andwis group company" section is the shared `[andwis_block]`
  shortcode from the `cbp-andwisco` plugin, dropped in as a core Shortcode block;
  only its CTA colour is overridden (`src/css/forms.css`).
- Copy style: plain hyphens, never em or en dashes. `cb_hesis2026_plain_hyphens()`
  in `inc/helpers.php` reverts what `wptexturize()` does.

## Tokens

`src/css/tokens.css` is the source of truth; `theme.json` is generated from it.
Colours read from the design file's vector fills:

| Token | Value | Used for |
| --- | --- | --- |
| `--col-navy` | `#1f2441` | stats band, footer, outline buttons |
| `--col-charcoal` | `#1d1d1d` | accreditation band, hero fallback |
| `--col-orange` | `#ef7c23` | primary buttons, kickers, testimonials band |
| `--col-coral` | `#eb5a3d` | service tile icons, sectors curve, CTA band |
| `--col-coral-light` | `#fef4eb` | sectors accordion |
| `--col-grey-50` | `#f5f5f5` | case study cards |
| `--col-grey-100` | `#f0f0f0` | services and LinkedIn bands |

Font: Poppins, self-hosted in `fonts/` (400-800), declared in `src/css/typography.css`.

## Content Model

| Post type | Slug | Renders through | Notes |
| --- | --- | --- | --- |
| `service` | `/services/{slug}/` | `page.php` | Built from blocks. |
| `sector` | `/sectors/{slug}/` | `page.php` | Built from blocks. A CB Sectors row with no link links to the Sector post of the same name. |
| `case_study` | `/case-studies/{slug}/` | `single-case_study.php` | Taxonomies `case_study_sector` (card kicker) and `case_study_service` (card tags). Cards via `cb_hesis2026_case_study_card()`. |

## Blocks (homepage order)

1. **CB Hero** - kicker, heading, intro, two CTAs, background image with focal point, optional bottom curve.
2. **CB Accreditations** - label + gallery of logos on the charcoal band; marquee when they overflow; carries the white curve into the page.
3. **CB Image Text** - copy + circular photo with optional second circle and rotating dot ring. Image left/right.
4. **CB Service Tiles** - repeater of tiles (icon slug or image, title, link) in a `.grid`, text link under.
5. **CB Stats** - repeater of value/label on navy.
6. **CB Sectors** - photo background, coral curve, cream `<details>` accordion (one open at a time via a shared `name`).
7. **CB Case Studies** - Swiper of the latest N `case_study` posts.
8. **CB Testimonials** - orange band, Swiper of quote cards two-up.
9. **CB LinkedIn** - manual repeater of post cards until a feed is agreed.
10. `[andwis_block]` shortcode.
11. **CB CTA** - coral band, heading, office line + phone from Site-Wide Settings, navy button. Goes last: the footer curve rises into it.

## Site-Wide Settings

`inc/options.php`: email, phone, Client Portal URL (header pill, hidden when blank),
footer tagline, offices repeater (footer Contact column), social URLs, legal
disclosure, tracking IDs and raw script slots (CookieYes goes in Head).

## Still needed from the client

- Accreditation marks still missing: LPCB (BRE only publishes an 86px sample;
  licensees get artwork from marketing@bregroup.com), NSI Gold and NICEIC
  Approved Contractor (both issued through the member portals). FIA, BAFE, Gas
  Safe, dhf and REFCOM are currently the bodies' corporate logos from their
  public sites; the member/registered-organisation versions (BAFE's carries the
  registration ID) should replace them once HESIS supplies them.
- LinkedIn feed approach and the company page URL; social URLs for the footer.
- Office addresses, legal entity details, Client Portal URL, cookie consent script.
- Real case study copy; the three entries carry the design's titles and photos only.
- Footer tagline year: the design says "since 1990", the content doc "since 2007".

## Seeding

`wp-content/uploads/cb-seed/seed-native.php` (outside the theme, not committed)
built the local homepage, pages, sectors, services, case studies, menus and
options; `gen-blocks.php` alongside it generated the blocks through the builder.
Both are idempotent (`wp eval-file`).
