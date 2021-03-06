=== Smart Team Work  ===
Contributors: batmoo, danielbachhuber, sbressler, automattic
Donate link: http://editflow.org/contribute/
Tags: Smart Team Work , workflow, editorial, newsroom, management, journalism, post status, custom status, notifications, email, comments, editorial comments, usergroups, calendars, editorial calendar, story budget
Requires at least: 4.5
Requires PHP: 5.4
Tested up to: 5.0.3
Stable tag: 0.9

Redefining your editorial workflow.

## Installation

The easiest way to install this plugin is to go to Add New in the Plugins section of your blog admin and search for "Smart Team WorkFlow." On the far right side of the search results, click "Install."

If the automatic process above fails, follow these simple steps to do a manual install:

1. Extract the contents of the zip file into your `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Write and enjoy the merits of a structured editorial workflow!

## Frequently Asked Questions

**Does Smart Team WorkFlow  work with multisite?**

Yep, in the sense that you can activate Smart Team WorkFlow on each subsite. smart Team WorkFlowdoesn't yet offer the ability to manage content across a network of sites.

**smart Team WorkFlowdoesn't do X, Y, and Z. That makes me sad.**

For support questions, feedback and ideas, please use the [WordPress.org forums](http://wordpress.org/tags/edit-flow?forum_id=10), which we look at often. For everything else, say [hello@editflow.org](mailto:hello@editflow.org).

## Screenshots

1. The calendar is a convenient month-by-month look at your content. Filter to specific statuses or categories to drill down.
2. Custom statuses allow you to define the key stages of your workflow.
3. Editorial comments allow for private discussion between writers and editors on a post-by-post basis.
4. Keep track of the important details with editorial metadata.
5. View all of your upcoming posts with the more traditional story budget view, and hit the print button to take it to your planning meeting.

## Upgrade Notice

**0.9**
Bump minimum version of PHP to 5.4. Start implementation of Block Editor compatible elements, various improvements and bugfixes.

**0.8.3**
Improvements and bugfixes.

**0.8.2**
Minor enhancements and bug fixes, translation updates.

**0.8.1**
Added Composer support.

**0.8**
Final readme and versioning changes for v0.8

**0.7.5**
New localizations; myriad of bug fixes

**0.7.4**
Support for non-Latin characters in custom statuses and editorial metadata; various bug fixes

**0.7.3**
Support PHP 5.2.x by removing the anonymous functions we mistakenly added

**0.7.2**
Contributors and other users without the 'publish_posts' capability can access custom statuses.

**0.7.1**
Enhancements and bug fixes, including defaulting to the proper date in the calendar and an Italian localization.

**0.7**
Complete rewrite into a modular architecture. Lots of polish added. Important note: If upgrading from pre-v0.6, please upgrade to v0.6.5 first

**0.6.5**
Fixes an issue where the post timestamp would be set as soon as a custom status was used.

**0.6.4**
Number of minor fixes and improvements, including proper support for bulk editing custom statuses, a 'Clear' link for clearing date editorial metadata, and better respect for user roles and capabilities in Story Budget.

**0.6.3**
Restored email notifications to old delivery method instead of queueing with WP cron because of reliability issues. Added option to see unpublished content on story budget and editorial calendar.

**0.6.2**
Two bug fixes: post titles should properly appear in email notifications, and bulk editing no longer deletes editorial metadata.

**0.6.1**
Proper support for custom post types. We removed the option to enable/disable Custom Statuses for Pages from the Settings page. Custom Statuses are enabled by default for Pages. To remove support for statuses, please see readme.

**0.6**
New features, including story budget and editorial metadata, a completely rewritten calendar view, and many bug fixes, including one for editorial comments appearing in the admin.

## Changelog

**0.9 (January 10, 2018)**
* Feature: Block Editor compatibility for Custom Status element. Props [rinatkhaziev](https://github.com/rinatkhaziev). See [BLOCKS.md](BLOCKS.md) for details.
* Feature: new filter `stworkflow_calendar_item_html` for Calendar element that allows to print custom markup for each day.
* UI Improvement: start removing arbitrary colors and conform to WP Color guide. A collective effort.
* UI Improvement: Add [NO ACCESS] and [NO EMAIL] to the list of notified users to indicate that a user doesn't have the access to the post and that a user doesn't have an email set,respectively. Props [WPprodigy](https://github.com/WPprodigy), [jerclarke](https://github.com/jerclarke).

**0.8.3 (June 14, 2018)**
* UI Improvement: Made primary buttons on Settings screen consistent with WordPress UI. Props [cojennin](https://github.com/cojennin).
* UI Improvement: Display who particularly was notified about an editorial comment. Props [goodguyry](https://github.com/goodguyry), [WPprodigy](https://github.com/WPprodigy)
* Improvement: Updated Russian translation and documentation. Props [achumakov](https://github.com/achumakov).
* Improvement: Eliminate a few cases of raw SQL queries in favor of `date_query`. Props [justnorris](https://github.com/justnorris).
* Improvement: Cache calendar items for each user individually to prevent potential cache pollution. Props [justnorris](https://github.com/justnorris).
* Improvement: various i18n updates.
* Improvement: Move stworkflow_story_budget_posts_query_args filter down to allow overriding the date query in Story Budget element.
* Improvement: Limit results in Calendar to 200 per page, potentially saving from trouble on websites with large amount of content.
* Improvement: Don’t generate rewrite rules for notepad as they're unused.
* Improvement: Support modifying HTML output of a Calendar day via stworkflow_pre_calendar_single_date_item_html filter. Props [cklosowski](https://github.com/cklosowski).

**0.8.2 (Sept. 16, 2016)**
* Improvement: Updated Spanish localization thanks to [moucho](https://github.com/moucho)
* Improvement: New Swedish localization thanks to [Warpsmith](https://github.com/Warpsmith)
* Improvement: Japanese localization 100% on [translate.wordpress.org](https://translate.wordpress.org/locale/ja/default/wp-plugins/edit-flow)
* Improvement: Updated Brazilian Portuguese translation. Props [arthurdapaz](https://github.com/arthurdapaz)
* Improvement: Internationalization improvements in settings and calendar. Props [robertsky](https://github.com/robertsky)
* Improvement: Corrections made to Brazilian Portuguese translation. Props [angelosds](https://github.com/angelosds)
* Improvement: Updates Travis CI to support containerization, PHP 7 and HHVM
* Bug fix: Fix PHP warning in class-element.php. Props [jeremyclarke](https://github.com/jeremyclarke)
* Bug fix: Add label to Dashboard Notes so it displays as "Dashboard Notes" when exporting
* Bug fix: Clean up PHP code to comply with PHP Strict Standards
* Bug fix: Removed deprecated get_currentuserinfo. Props [kraftbj](https://github.com/kraftbj)
* Bug fix: Adding $post param to preview_post_link filter to fix PHP warning. Props [micahwave](https://github.com/micahwave)
* Bug fix: Calendar current_user_can capability check corrected. Props [keg](https://github.com/keg)
* Bug fix: Clean up custom status timestamp fix and add unit tests to test different cases of the hack
* Bug fix: Fix error messaging for element settings pages. Props [natebot](https://github.com/natebot)
* Bug fix: Add check on user-settings.php to prevent error. Props [paulabbott](paulabbott)
* Bug fix: Add check for empty author when sending notification. Props [petenelson](https://github.com/petenelson)
* Bug fix: Remove PHP4 constructor from screen options. Props [mjangda](https://github.com/mjangda)

**0.8.1 (Apr 13, 2016)**
* New German localization thanks to [Circleview](https://github.com/Circleview)
* New Spanish localization thanks to Andrew Kurtis from [Web Hosting Hub](http://www.webhostinghub.com/).
* Performance improvements for the calendar, custom statuses, and editorial metadata
* Bug fix: Show "(no title)" on the calendar when a post doesn't have a title.
* Bug fix: Persist the future date position of a post on the calendar when a post is updated.

**0.8 (Dec 19, 2013)**
* New feature: Dashboard Notepad. Editors and admins can use a notepad widget on the dashboard to leave instructions, important announcements, etc. for every WordPress user.
* New feature: Double-click to create a new post on the calendar, or edit the details associated with an existing post. Thanks [bbrooks](https://github.com/bbrooks) and [cojennin](https://github.com/cojennin)
* Post subscriptions are now saved via AJAX, which means you can add or remove subscribers without hitting "Save Post". This is especially useful for editorial comments. Thanks [cojennin](https://github.com/cojennin)
* Subscribe to a post's updates using a quick "Follow" link on Manage Posts, the Calendar, or Story Budget.
* Assign a date and time to editorial metadata's date field. Thanks [cojennin](https://github.com/cojennin)
* Modify which filters are used on the calendar and story budget, or add your own. Thanks [cojennin](https://github.com/cojennin)
* Scheduled publication time is now included in relevant email notifications. Props [mattoperry](https://github.com/mattoperry)
* Calendar and story budget element descriptions link to their respective pages in the admin for usability. Props [rgalindo05](https://github.com/rgalindo05)
* New Russian localization thanks to [te-st.ru](https://github.com/Teplitsa)
* Updated Japanese localization thanks to [naokomc](https://github.com/naokomc)
* Updated Dutch localization thanks to [kardotim](https://github.com/kardotim)
* Bug fix: User group selection no longer appears in network admin.
* Improved slug generation when changing title of Drafts thanks to [natebot](https://github.com/natebot)
* Bug fix: Permalink slugs are now editable after initial save. Props [nickdaugherty](https://github.com/nickdaugherty)
* Bug fix: Permit calendar filters to be properly reset.
* Bug fix: Posts, pages, custom post types, etc. can now be previewed correctly.
* Bug fix: Fix Strict Standards PHP notice with add_caps_to_role(). Props [azizur](https://github.com/azizur)
* Bug fix: PHP compatability issue. Props [ziz](https://github.com/ziz).
* Bug fix: Correct calendar encoding. Props [willvanwazer](https://github.com/willvanwazer)
* Bug fix: Check for $screen in filter_manage_posts_column. Props [styledev](https://github.com/styledev).
* Bug fix: Correct smart Team WorkFlowicon size. Props [Fstop](https://github.com/FStop).
* Improvement: Add editorial metadata to the Posts screen. Props [drrobotnik](https://github.com/drrobotnik)
* Improvement: Visual support for MP6. Props [keoshi](https://github.com/keoshi).
* Bug fix: Catch WP_Error returning with get_terms(). Props [paulgibbs](https://github.com/paulgibbs)
* Improvement: Better unit testing with PHPUnit thanks to [willvanwazer](https://github.com/willvanwazer) and [mbijon](https://github.com/mbijon)
* Bug fix: Correctly close out list item in editorial comments. Props [jkovis](https://github.com/jkovis)

The following folks did some tremendous work helping with the release of smart Team WorkFlowv0.8: [azizur](https://github.com/azizur), [bbrooks](https://github.com/bbrooks), [danielbachhuber](https://github.com/danielbachhuber), [drrobotnik](https://github.com/drrobotnik), [Fstop](https://github.com/FStop), [jkovis](https://github.com/jkovis), [kardotim](https://github.com/kardotim), [keoshi](https://github.com/keoshi) [mattoperry](https://github.com/mattoperry), [mbijon](https://github.com/mbijon), [naokomc](https://github.com/naokom, [natebot](https://github.com/natebot), [nickdaugherty](https://github.com/nickdaugherty), [paulgibbs](https://github.com/paulgibbs), [rgalindo05](https://github.com/rgalindo05), [te-st.ru](https://github.com/Teplitsa), [willvanwazer](https://github.com/willvanwazer), [ziz](https://github.com/ziz).

**0.7.6 (Jan. 30, 2018)**
* Bug fix for 3.4.2 compatibility.

**0.7.5 (Jan. 29, 2018)**
* New Japanese localization thanks to [naokomc](https://github.com/naokomc)
* New French localization thanks to [boris-hocde](https://github.com/boris-hocde)
* Allow custom post statuses to be completely disabled for a post type, preventing situations where 'draft' posts could disappear when the draft status was deleted.
* Better implementation of the hack we have to employ for editable slugs in the post edit screen. Thanks [cojennin](https://github.com/cojennin) for the assist.
* Editorial metadata names can now be up to 200 characters (instead of 20 previously). Props [cojennin](https://github.com/cojennin)
* Bug fix: Load elements on 'init' so the strings associated with each class can be properly translated
* Bug fix: Pagination functional again when filtering to a post type
* Bug fix: Pre-PHP 5.2.9 array_unique() compatibility
* Bug fix: Respect the timezone when indicating which day is Today
* Bug fix: Calendar should work for all post types, regardless of which are supposed to be added to it

**0.7.4 (Nov. 21, 2018)**
* Added 'Scheduled' as one of the statuses you see in the 'Posts At A Glance' widget. 'Private' and other core statuses can be added with a filter
* Sort posts on the Manage Posts view by visible editorial metadata date fields
* Modify email notifications with two filters
* Bug fix: Proper support for unicode characters in custom status and editorial metadata descriptions
* Bug fix: Show the proper last modified value on the story budget when the server's timezone is not set to GMT. Props [danls](https://github.com/danls)
* Bug fix: Make the jQuery UI theme for smart Team WorkFlowmore specific so it doesn't conflict with core modals
* Bug fix: Use the proper singlular label for a post type when generating notification text
* Bug fix: Post slug now updates when the post has a custom status.
* Bug fix: When determining whether a user can change a post's status, check the 'edit_posts' cap for the post type.

**0.7.3 (Jul. 3, 2012)**
* Bug fix: Support PHP 5.2.x by removing the anonymous functions we mistakenly added
* Bug fix: Only update user's Story Budget saved filters when the Story Budget is being viewed, to avoid other views setting the filter values

**0.7.2 (Jul. 3, 2012)**
* Users without the 'publish_posts' capability can now use and change custom statuses. Props [Daniel Chesterton](https://github.com/dchesterton)
* Support for trashing posts from the calendar. Thanks [Dan York](https://github.com/danyork) for the idea and a bit of code
* Updated codebase to use PHP5-style OOP references
* Fixed some script and stylesheet references that had a double '//' in the URI path
* New `st_workflow_supported_element_post_types_args` filter allows you to enable custom statuses and other elements for private post types

**0.7.1 (Apr. 11, 2018)**
* Show the year on the calendar and story budget if it's not the current year
* Allow users to save post subscriptions the first time they save the post. This also fixes the bug where a user wouldn't be subscribed until they saved the post twice
* Changed the behavior of notifications for the user changing a status or leaving a comment. Previously, they'd receive an email with the action they just performed; now they do not. This can be changed with a filter
* New Italian localization thanks to Luca Patané
* Bug fix: Auto-subscribe the post author to their posts by default but make it filterable
* Bug fix: Only show authors in the user dropdown for the calendar and the story budget. This new behavior can be filtered out however
* Bug fix: Metaboxes are registered with proper priority. Props benbalter
* Bug fix: If a user hasn't ever opened the calendar before, the date should default to today, not the Unix Epoch
* Bug fix: Prevent editorial metadata filters from stomping on others' uses by actually returning the original value when we don't want to manipulate it
* Bug fix: Specify a max-width on `<select>` dropdowns in the calendar and story budget so long values don't break formatting

**0.7 (Jan. 9, 2018)**
* Entire plugin was rewritten into a modular architecture (e.g. each feature is broken into a element you can enable or disable). One point of the modular architecture is to make it much easier for others to contribute new features. For the end user, there’s a brand new settings page where you can manage your elements. Each element then registers a configuration view for element settings. Most have options to choose which post types you’d like it activated for, along with other configuration options.
* Calendar is far more functional. Content is viewed in a six week view by default, and number of weeks is configurable in screen options. Posts can be dragged and dropped between dates. Click on a post title to get the details about the post, including editorial metadata.
* Custom statuses can be drag and drop ordered with AJAX. All statuses (including core ‘draft’ and ‘pending’) can be edited or deleted.
* Editorial Metadata terms can be ordered with AJAX. Terms can be made “viewable” and then will be displayed on the manage posts view and calendar if enabled.
* Story Budget shows “viewable” editorial metadata and fixes a few bugs, including not showing posts in a subcategory of a parent category.
* Notifications/subscriptions are filtered so you can disable the auto-subscribing of authors or editorial commenters.
* Important note: If upgrading from pre-v0.6, please upgrade to v0.6.5 first to ensure all of your data remains intact.
* [Read the full release post](http://editflow.org/2012/01/09/edit-flow-v0-7-modular-architecture-monthly-calendar-and-sortable-statuses/)

**0.6.5 (Sept. 19, 2018)**
* Bug fix: Workaround for a bug in core where the timestamp is set when a post is saved with a custom status. Instead, we update the timestamp on publish to current time if a custom post date hasn't been set. Thanks saomay for [help tracking the bug down](http://wordpress.org/support/topic/plugin-edit-flow-custom-statuses-create-timestamp-problem/).

**0.6.4 (Jul. 22, 2018)**
* Display unpublished custom statuses inline with the post title, per WordPress standard UI
* New number type for editorial metadata, so you can have fields like "Word Count"
* Dropped the admin option for disabling custom statuses on posts. It didn't work, and this is handled by post_type_supports()
* Add a 'Clear' link to editorial metadata date fields to allow user to easily clear the input
* Bug fix: Proper support for bulk editing custom statuses
* Bug fix: Contributor saving a new post respects the default custom status, instead of reverting to 'draft' as the post status
* Bug fix: Better respect for user roles and capabilities in Story Budget
* Bug fix: Custom statuses in Quick Edit now work as you'd expect them
* Bug fix: Show all taxonomy terms (most likely categories) on the Story Budget, regardless of whether they include published content
* Bug fix: If there are no editorial metadata fields available, a message will display instead of leaving an empty post meta box

**0.6.3 (Mar. 21, 2018)**
* Restored email notifications to old delivery method instead of queueing with WP cron because of reliability issues.
* Better approach to including files so smart Team WorkFlowworks properly on Windows systems.
* Option to see all unpublished content on story budget and editorial calendar with a filter to include scheduled posts as unpublished content.

**0.6.2 (Jan. 26, 2018)**
* Bug fix: Post Titles were broken in email notifications. (Thanks kfawcett and madguy000!)
* Bug fix: Bulk editing any post types would cause editorial metadata to occasionally be deleted. (Thanks meganknight!)

**0.6.1 (Jan. 9, 2018)**
* Custom Post Type support for custom post statuses, editorial metadata, editorial comments, notifications, (Thanks to all who requested this!)
* Added search and filtering tools for user and usergroup lists
* Email notifications are now queued to improve performance and avoid issues with spam
* Posts in calendar now have a unique classname based on the status (Thanks [erikajurney](http://wordpress.org/support/profile/erikajurney))
* The "Posts I'm Following" widget has a cleaner look
* Bug fix: Users without JavaScript no longer see the status dropdown
* Bug fix: Users with JavaScript no longer see the respond button for editorial comments
* Bug fix: Contributors should not have the ability to publish through Quick Edit
* Bug fix: Proper i18n support (Thanks Beto Frega and others)
* Bug fix: Editorial Comments issue in IE (Thanks [asecondwill](http://wordpress.org/support/profile/asecondwill) and James Skaggs)
* Bug fix: Always email admin feature was not working (Thanks [nicomollet](http://wordpress.org/support/profile/nicomollet))
* Bug fix: Notifications for scheduled posts did not include links (Thanks [erikajurney](http://wordpress.org/support/profile/erikajurney))

**0.6 (Nov. 9, 2018)**
* New feature: Editorial Metadata. Previously, smart Team WorkFlowhad 'due date', 'location' and 'description', as available editorial metadata. We've expanded this functionality to be completely customizable; admins can add any number of editorial metadata with the following types: checkbox, date, location, paragraph, text, or user dropdown.
* New feature: Story Budget. View all of your upcoming posts in a more traditional story budget view. Posts are grouped by category, and view can be filtered by post status, category, user, or limited to a date range. Hit the print button to take it on the go.
* Completely rewritten calendar view now saves filter state on a user by user basis. Also, highlights current day, and displays status and time for each post.
* Temporarily disabled QuickPitch widget until we rewrite it to support editorial metadata.
* Bug fix: Editorial comments should no longer show up in the stock Recent Comments widget or in the comments view in the WordPress Admin. The comment count number should also be correct.
* Bug fix: Duplicate custom post statuses and usergroups are handled in more sane ways (aka creating, editing, and deleting should work as expected)

**0.5.3 (Oct. 6, 2018)**
* Fixes issue where default Custom Statuses and User Groups were returning even after being deleted

**0.5.1 (Jul. 29, 2018)**
* Editorial calendar improvements: filter by category or author
* QuickPitch stories get default status instead of pitch status
* No email notifications for “Auto Draft” post status
* Backwards compatibility with WordPress 2.9.x

**0.5 (Jul. 3, 2018)**
* Calendar view for visualizing and spec assignments at a glance
* Improvements for WordPress 3.0 compatibility

**0.4**
* Users that edit a post automatically get subscribed to that post (only if they have the manage subscriptions capability)
* smart Team WorkFlowautomatically hides editorial comments if the plugin is disabled
* Moved default custom status additions to upgrade function so they don't get added every time you activate
* Bug fix: remove editorial comments from comments feed

**0.3.3 (Feb. 4, 2018)**
* Added tooltips with descriptions to the Status dropdown and Status Filter links. Thanks to [Gil Namur](http://lifeasahuman.com) for the great idea!
* Fixed the issue where subscribed users/usergroups were not receiving notifications

**0.3.2 (Jan. 28, 2018)**
* Fixed fatal error if notifications were disabled

**0.3.1**
* Small bug fixes

**0.3**
* *Note:* smart Team WorkFlownow requires 2.9+
* Notification emails on status change now have specific subject lines messages based on action taken
* Action links in comment notifications now take the user to the comment form; i.e. clicking reply link in the email will focus on the comment text box and reply to the message
* Usergroups!
* Assign users and usergroups that should be notified of post updates
* Removed notify by role option since it's redundant because of usergroups
* Added "Always notify admin option"
* Added option to hide the status dropdown on Post and Page edit pages (default set to show)
* Added option to globally disable QuickPitch widget
* Bug fix: Custom Status names cannot be longer than 20 chars
* Bug fix: Deleted users are removed as subscribers from posts
* Bug fix: Blank menu items should now be sorta hidden

**0.2**
* Custom Statuses are now supported for pages
* Editorial Comments (with threading)
* Email Notifications (on post status change and editorial comment)
* Additional Post metadata
* Quick Pitch Dashboard widget
* Bug fix: sorting issue on Manage Posts page (Mad props to David Smith from Columbia U.)
* Other bug fixes
* Better localization support

**0.1.5**
* Ability to assign custom statuses to posts

