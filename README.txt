=== Sea Winds — Custom WordPress Theme ===

A fully custom, page-builder-free theme for Sea Winds BTL Advertising LLC.
Pure PHP, CSS and JavaScript. No Elementor, no WoodMart, no external JS libraries.

-------------------------------------------------------------------------------
1. UPLOAD & INSTALL
-------------------------------------------------------------------------------
Option A — SFTP:
  1. Connect to your host via SFTP (host / user / password from your hosting panel).
  2. Navigate to: /wp-content/themes/
  3. Upload the entire `seawinds` folder (the folder that contains style.css).
  4. Confirm the path is: /wp-content/themes/seawinds/style.css

Option B — Admin ZIP upload:
  1. Zip the `seawinds` folder so the ZIP contains seawinds/style.css.
  2. WP Admin → Appearance → Themes → Add New → Upload Theme → choose the ZIP.

-------------------------------------------------------------------------------
2. ACTIVATE
-------------------------------------------------------------------------------
  WP Admin → Appearance → Themes → hover "Sea Winds" → Activate.

-------------------------------------------------------------------------------
3. AFTER ACTIVATION (one-time setup)
-------------------------------------------------------------------------------
  a) Permalinks: Settings → Permalinks → click "Save Changes" once. This flushes
     rewrite rules so /portfolio/, /project-cat/<term>/ and project URLs work.

  b) Create these Pages (Pages → Add New) using EXACTLY these slugs. The theme
     ships a template named page-<slug>.php for each, so the correct design
     loads AUTOMATICALLY by slug — you do NOT need to pick anything in the
     "Template" box. (The templates are also still selectable there if you ever
     want to assign one manually.)
        Title            Slug (must match exactly)
        --------------   -------------------------
        Home             (set as front page — see c)
        About            about-us
        Services         services
        Portfolio        portfolio
        Gallery          gallery
        Our Clients      our-clients
        Contact          contact-us
        Blog             blog

     IMPORTANT: the slug must match exactly (e.g. "about-us", not "about"),
     otherwise WordPress falls back to the generic page.php and the page will
     look empty. Edit the slug under the page title (Permalink) if needed.

  c) Set the homepage: Settings → Reading → "Your homepage displays" →
     A static page → Homepage = Home.
     (front-page.php is used automatically for the front page.)

  d) Menu: Appearance → Menus → create a menu, add the pages above in order
     (Home, About, Services, Portfolio, Gallery, Clients, Contact, Blog),
     and assign it to the "Primary Menu" location.
     (If no menu is set, the theme shows a sensible default menu automatically.)

  e) Logo/Favicon: replace /wp-content/themes/seawinds/assets/images/logo.png
     with the real horizontal logo (transparent PNG recommended).
     Optionally set a Site Icon under Appearance → Customize → Site Identity.

-------------------------------------------------------------------------------
4. ADDING PORTFOLIO / GALLERY PROJECTS
-------------------------------------------------------------------------------
  - A "Projects" menu appears in the dashboard.
  - Add New Project → set Title, Featured Image (used as the cover), assign a
    Project Category (e.g. Exhibition Stand, Signage, Graphics, Display Stands).
  - In the "Project Details" box, add gallery images: paste image URLs OR media
    attachment IDs, one per line. These fill the single-project photo grid and
    the fullscreen lightbox. The Gallery page pulls all projects automatically.

-------------------------------------------------------------------------------
5. CONTACT FORM
-------------------------------------------------------------------------------
  - Submissions email to: yash@seawindsadvertising.com (via wp_mail()).
  - For reliable delivery, install an SMTP plugin (e.g. WP Mail SMTP) and
    configure your sending account. Without SMTP some hosts silently drop mail.

-------------------------------------------------------------------------------
6. HERO VIDEO (later)
-------------------------------------------------------------------------------
  - In templates/hero.php there is a commented <video> block and the marker:
      <!-- HERO_VIDEO: replace this section with <video> tag when video is ready -->
  - Uncomment the <video> tag, point src to your MP4, and remove the placeholder.
  - Hero text lines are editable in templates/hero.php via the data-hero-lines
    attribute on #sw-hero (a JSON array).

-------------------------------------------------------------------------------
7. GOOGLE ANALYTICS (GA4)
-------------------------------------------------------------------------------
  - In header.php find:  <!-- GA4_PLACEHOLDER: paste your GA4 script here -->
  - Paste your GA4 gtag.js snippet directly below that comment.

-------------------------------------------------------------------------------
NOTES
-------------------------------------------------------------------------------
  - All animations respect the OS "Reduce Motion" setting.
  - Images have right-click/drag disabled site-wide (best-effort protection).
  - All internal links use WordPress functions, so they follow your domain.
