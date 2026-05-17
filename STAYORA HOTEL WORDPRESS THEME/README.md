# Stayora

Stayora is a premium hotel, villa, and resort WordPress theme built for boutique accommodation brands. It includes custom post types for accommodations and attractions, booking form support, responsive sections, and full Gutenberg compatibility.

## Installation

1. Copy the theme folder to `wp-content/themes/stayora`.
2. In WordPress admin, go to **Appearance > Themes**.
3. Activate the `Stayora` theme.
4. Configure your site under **Appearance > Customize** and assign the `Primary Navigation`, `Footer Main`, `Footer Legal Links`, and `Mobile Navigation` menus.

## Build CSS Assets

This theme uses Tailwind CSS to generate its frontend stylesheet.

From the theme root run:

```bash
npm install
npm run build
```

This generates `assets/css/stayora.css` from `tailwind.css`.

## Theme Structure

- `index.php` — Fallback theme template
- `front-page.php` — Homepage layout
- `single.php` / `archive.php` — Blog and listing templates
- `templates/archive-accommodation.php` — Accommodation archive output
- `templates/single-accommodation.php` — Accommodation single page
- `template-parts/sections/` — Homepage section components
- `template-parts/accommodation/` — Accommodation card and single page components
- `template-parts/booking/` — Booking templates
- `inc/` — Theme setup, enqueue, custom post types, customizer and helper logic

## Recommended Setup

- Create accommodations under the `Accommodations` custom post type.
- Add featured images and gallery IDs for each accommodation.
- Assign room type and amenity taxonomies to control filters and listing display.
- Add nearby attractions in the `Attractions` custom post type.

## Notes

- If you do not want to use the integrated booking UI, the theme supports a plugin bridge for MotoPress, Amelia, FluentBooking, and WooCommerce.
- The theme is translation-ready via the `languages/` folder.

## Troubleshooting

- If your styles do not appear, make sure `assets/css/stayora.css` exists and that `npm run build` completed successfully.
- If a template part is missing, verify the `template-parts/` folders were preserved when installing the theme.
