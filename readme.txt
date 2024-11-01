=== Webcam Comment ===
Contributors: Krankenhaus
Tags: webcam, cam, comment, webcam comment, thumbnail,avatar, upload, attach, image, picture
Requires at least: 2.61
Tested up to: 2.7
Stable tag: 0.2

Lets the user attach webcam images to comments

== Description ==

Lets visitors easily grab webcam images of themselves directly on the site, and add that image to a comment. It will then show up as a thumbnail next to the comment and will show a bigger image when clicked.

Features:
* Let's the user attach and remove an image to the comment
* Skinnable GUI (normal .png's)

Requirements:
* Flash Player
* Javascript
* "Avatars" ("Show Avatars" must be activated from the "Discussion Settings")
* And of course a webcam

== Installation ==


1. Download the plugin and unzip.
2. Upload the "camcomment" folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Go to "Settings"->"Discussion" and under "Avatars", make sure that "Show Avatars" is checked
5. Users posting comments should now click the "Click to attach webcam image >> " button in the comment form

== Frequently Asked Questions ==

= Can I change the position of the attach-button in my comment form? =

Yes. You can change some settings in camcomment.php. It is also possible to change the text of the button.

= Can I change the size of the thumbnail? =

Yes, you can change the size in camcomment.php. Make sure that the proportions stay the same (width/height ratio).

= Can I change the size of the full size images? =

No, not at this moment.

= Why can't my visitors attach images? =

To use the plugin the clients browser must support both Flash and Javascript.

= My visitors only gets a black screen in the webcam window! =

Tell them to right click the webcam window and go to Settings. In here they should be able to find their cam.

= I can't see any images! =

Make sure that you've enabled Avatars. Also make sure that the plugin directory contains the subdirectory "camcommentimages", and that subdirectory contains the subdirectory "thumbs".

= Your design of the GUI sucks! How do I change it? =

Just edit the images in the "graphics" directory.

== Known Bugs ==

* Sometimes the page keeps loading and loading, even though everything is already loaded
* Language files (.mo) seem to crash the plugin (shows a white page when sending the comment)

== Latest update ==
The repository doesn't include empty directories on download for some reason, so the directory to keep the images in was missing. Also, the was an error in the paths.

