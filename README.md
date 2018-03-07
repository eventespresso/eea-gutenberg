## EE Gutenberg Integration Experimentation Plugin

Please note this is not a production ready add-on for Event Espresso 4.  We're simply using this to experiment with the new [Gutenberg](https://github.com/WordPress/gutenberg) editor coming to WordPress in the near future.

The experiments we do within this plugin will help shape the next version of our editors in EE4 and when Gutenberg ships with WordPress we hope to have ready to go blocks for it.  Over time, successful experiments done in this plugin will make their way into EE4 core.

> **Note** It probably goes without saying, but using this plugin requires that you also have the [Gutenberg](https://github.com/WordPress/gutenberg) plugin installed and active for your site.

## Usage

### Shortcode Conversions

#### `[ESPRESSO_EVENTS]`

Currently there's a very basic Event List block available for posts and page post types that replaces the `[ESPRESSO_EVENTS]` shortcode.  You can also paste `[ESPRESSO_EVENTS]` into a text block and it will automatically convert to an event list block.

### EE CPT Editors

EE uses custom admin routes (events, venues, contacts) and Gutenberg can be enabled on them by simply appending `&eegb` to the url.  When adding a new event with Gutenberg enabled, there is a default template that will load a ticket editor block and a venue block.  Both blocks are just shells right now.

**Be aware that saving an event while it is being edited in Gutenberg could result in loss of any attached event meta data.  Things are not fully wired up yet.** 
