=== Notely ===
Contributors: mikeyott
Tags: notes, side notes, sidenotes, memo, post notes, page notes
Requires at least: 2.9.2
Tested up to: 3.4.1
Stable tag: trunk

Adds a new metabox into the posts and pages Admin sidebar for making notes.

== Description ==

Sometimes you might want to make some notes against a page or a post, this plugin simply allows that. Notes are only visible in the right sidebar when editing a page or post. see "Other Notes" if you also want to show notes on your theme.

== Installation ==

Install, activate, done.

== Other Notes ==

If you also want to have the notes to be displayed on your page or post in your theme, a little PHP will do the trick.

This will show your notes on your notes only if there are any:

echo get_post_meta($post->ID, 'notely', true);


Add a condition to do something depending on if a note is present or not:

if (post_custom('notely')) { 
    echo get_post_meta($post->ID, 'notely', true);
  } else {
    echo "No notes here.";
}


Add some HTML if you need:

if (post_custom('notely')) { 
    echo "<p>" . get_post_meta($post->ID, 'notely', true) . "</p>";
  } else {
    echo "<p>No notes here.</p>";
}

== Uninstall ==

Deactivate the plugin, delete if desired. Deactivating does not delete existing notes, so if you change your mind about it later all your notes will be restored.

== Official Web Site (and support) ==

<h3>Official website and support</h3>
<p><a href="http://www.thatwebguyblog.com/post/notely-for-wordpress-lets-you-make-notes-against-pages-and-posts/">That Web Guy</a></p>

== Changelog ==

= 1.0 =

* Tidied up code
* Updated readme

= 0.9 =

* Added notes to pages