# CreatorPress WordPress Theme

CreatorPress is a lightweight, modern WordPress theme built for creators, freelancers, consultants, coaches, designers, developers, and personal brands.

## Features

- Modern SaaS-inspired landing page design
- Tailwind CSS-powered styling
- Gutenberg-compatible sections
- Responsive mobile-first layout
- Dark mode toggle
- SEO-friendly semantic markup
- Minimal vanilla JavaScript
- Custom logo, menus, widgets, and post thumbnails
- Reusable homepage sections for future starter sites

## File Structure

- `style.css` — theme metadata and root stylesheet
- `functions.php` — theme setup, asset loading, menus, widgets, and customizer
- `header.php` / `footer.php` — site wrapper and responsive navigation
- `front-page.php` — homepage structure with reusable section template parts
- `template-homepage.php` — optional page template for a static homepage assignment
- `index.php`, `single.php`, `archive.php`, `page.php`, `search.php`, `404.php` — core templates
- `template-parts/sections/` — reusable homepage sections
- `template-parts/content/post-card.php` — blog card component
- `assets/css/tailwind.css` — Tailwind entry file
- `assets/css/style.css` — compiled stylesheet placeholder
- `assets/js/theme.js` — mobile menu and dark mode behavior
- `theme.json` — editor and block style settings
- `screenshot.png` — theme preview image for the WordPress dashboard

## Local Development

1. Copy this theme folder into your WordPress install under `wp-content/themes/creatorpress`.
2. Install dependencies:

```bash
cd "c:/Users/labko/MICHAL OneDrive/OneDrive/ΠΡΟΣΦΑΤΑ/FREELANCE CAMPUS/WEBSITE BUILD SKILL/FULL-STACK FILES/FULL-STACK PROJECTS/CREATORPRESS WORDPRESS THEME"
npm install
```

3. Build the CSS:

```bash
npm run build
```

4. Activate the theme in the WordPress dashboard.
5. (Optional) Create a new page, choose the “CreatorPress Homepage” template, and publish it.
6. Set that page as your static homepage in `Settings → Reading` if you want the sample homepage layout.
7. Use the Customizer to update logo, CTA text, and colors.
8. Edit the front page with Gutenberg and use reusable sections or page content.

## Tailwind Setup

- Tailwind config: `tailwind.config.js`
- PostCSS config: `postcss.config.js`
- Entry file: `assets/css/tailwind.css`
- Output CSS: `assets/css/style.css`

## Notes

- The theme is intentionally minimal and modular, so starter site packs can reuse the same framework.
- Use Gutenberg blocks for flexible content and keep the homepage sections available for design iteration.
- The dark mode toggle persists user preference with `localStorage`.
