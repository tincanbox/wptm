<?php

/*

index.php
  The main template.
  If your Theme provides its own templates, index.php must be present.
comments.php
  The comments template.
front-page.php
  The front page template.
home.php
  The home page template, which is the front page by default.
  If you use a static front page this is the template for the page with the latest posts.
single.php
  The single post template. Used when a single post is queried.
  For this and all other query templates, index.php is used if the query template is not present.
single-{post-type}.php
  The single post template used when a single post from a custom post type is queried.
  For example, single-book.php would be used for displaying single posts from the custom post type named "book".
  index.php is used if the query template for the custom post type is not present.
page.php
  The page template. Used when an individual Page is queried.
category.php
  The category template. Used when a category is queried.
tag.php
  The tag template. Used when a tag is queried.
taxonomy.php
  The term template. Used when a term in a custom taxonomy is queried.
author.php
  The author template. Used when an author is queried.
date.php
  The date/time template. Used when a date or time is queried. Year, month, day, hour, minute, second.
archive.php
  The archive template. Used when a category, author, or date is queried.
  Note that this template will be overridden by category.php, author.php, and date.php for their respective query types.
search.php
  The search results template. Used when a search is performed.
attachment.php
  Attachment template. Used when viewing a single attachment.
image.php
  Image attachment template. Used when viewing a single image attachment. If not present, attachment.php will be used.
404.php
  The 404 Not Found template. Used when WordPress cannot find a post or page that matches the query.

 */


include(dirname(__FILE__).'/home.php');
