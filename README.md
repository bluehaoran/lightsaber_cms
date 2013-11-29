lightsaber_cms
==============
Haoran's new CMS. Every Jedi should build their own lightsaber, every web coder their own CMS. This is mine.

Codename: CTVTY (Hebrew for 'I write')

This is Haoran's new CMS. It's super simple. 

Although website CAN be like a web (e.g. a standard Wiki), most webpages, and the way most people want to think
about webpages, is hierarchial--like a standard directory structure. For this majority case, we can leverage
something we use every day: a file-system. If we need to do something tricky, then we can set up symlinks.

Files are kept as plain-text, and can be text-snippets, Markdown files, HTML, or even PHP. This lets us use a
standard VCS to store revisions.

We generate the Menu structure based on the directory structure.

Directory Structure
-------------------
Should be obvious, but maybe it isn't.
* /app/		- Source files
* /database/	- Repository for flat-file database (most likely SQLite)
* /content/	- Contains the content for the website.
* /public/	- Access point for the app, and where generated static-pages are kept.
* /vendor/	- Repository for External libraries



