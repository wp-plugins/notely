=== Notely ===
Contributors: mikeyott
Tags: notes, side notes, sidenotes, memo, post notes, page notes
Requires at least: 2.9.2
Tested up to: 4.1
Stable tag: trunk

Adds a new metabox into the posts and pages Admin sidebar for making notes.

== Description ==

Sometimes you might want to make some notes against a page or a post, this plugin simply allows that. By default notes are only visible in the right sidebar when editing a page or post, but you can also show notes on the front end (see the readme file).

== Installation ==

Install, activate, done.

== Other Notes ==

If you also want to have the notes to be displayed on your page or post in your theme, a little PHP will do the trick.

<strong>This will show your notes on your notes only if there are any:</strong>

<pre>
echo get_post_meta($post->ID, 'notely', true);
</pre>

<strong>Add a condition to do something depending on if a note is present or not:</strong>

<pre>
if (post_custom('notely')) { 
    echo get_post_meta($post->ID, 'notely', true);
  } else {
    echo "No notes here.";
}
</pre>

<strong>Add some HTML if you need:</strong>

<pre>
if (post_custom('notely')) { 
    echo "<strong>" . get_post_meta($post->ID, 'notely', true) . "</strong>";
  } else {
    echo "<strong>No notes here.</strong>";
}
</pre>

== Uninstall ==

Deactivate the plugin, delete if desired. Deactivating does not delete existing notes, so if you change your mind about it later all your notes will be restored.

== Official Web Site (and support) ==

<h3>Official website and support</h3>
<p><a href="http://www.thatwebguyblog.com/post/notely-for-wordpress-lets-you-make-notes-against-pages-and-posts/">That Web Guy</a></p>

== Changelog ==

= 1.2 =

* Removed invalid (incomplete) callback function that was throwing an error

= 1.1 =

* Notes on Woo Commerce products

= 1.0 =

* Tidied up code
* Updated readme

= 0.9 =

* Added notes to pages