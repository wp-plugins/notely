=== Notely ===
Contributors: mikeyott
Tags: notes, side notes, sidenotes, memo, post notes, page notes
Requires at least: 2.9.2
Tested up to: 4.2.2
Stable tag: trunk

Adds a new metabox into the admin sidebar on Posts, Pages and WooCommerce Products (if activated) for making notes.

== Description ==

For when you might want to make notes on a post, page or product in Wordpress admin, this plug-in simply allows that.

== Installation ==

Install, activate, done.

== Other Notes ==

If you also want to have the notes to be displayed on the front-end, a little PHP will do the trick.

<strong>This will show the notes for the page/post/product you are currently viewing:</strong>

<pre>
if (post_custom('notely')) {
    echo get_post_meta($post->ID, 'notely', true);
  } else {
    echo "No notes here.";
}
</pre>

== Uninstall ==

Deactivate the plugin, delete if desired. Deactivating does not delete existing notes from the database, so if you reactivate the plug-in later all your notes will be restored.

<h3>Official website and support</h3>
<p><a href="https://wordpress.org/support/plugin/notely">Notely at Wordpress</a></p>

== Changelog ==

= 1.3 =

* Notes now show in admin columns.
* Option to make notes in admin columns always visible or show only when button is toggled.
* Option to change the note icon colour displayed in admin columns.


= 1.2 =

* Removed invalid (incomplete) callback function that was throwing an error

= 1.1 =

* Notes on Woo Commerce products

= 1.0 =

* Tidied up code
* Updated readme

= 0.9 =

* Added notes to pages
