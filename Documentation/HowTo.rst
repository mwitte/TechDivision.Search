===================
TechDivision.Search
===================

The TechDivision.Search package provides an interface for the TechDivision.Neos.Search package.
The default backend uses Apache Solr. This Solr implementation uses the php Solr extension:

http://www.php.net/manual/en/book.solr.php
http://pecl.php.net/package/solr


Add other search backend
------------------------

The search backend is completely convertible. For adding an other search backends(mysql, OpenSearchServer etc.)
simply implement the

\TechDivision\Search\Provider\ProviderInterface

in your package. For using your own Provider with for example the TechDivision.Neos.Search package look into
the documentation of TechDivision.Neos.Search package.


Design decisions
----------------

I created a dedicated "search" package to get the opportunity to change the backend logic to another logic by
configuration. With this (for basic requirements) generic documents and fields are various backend solutions possible.
This hole package was created by test-driven-development with 100% code coverage. One main paradigm was "separation of
concerns" so there are many small classes with small functions.


Testing
-------

The TechDivision.Search is 100% test covered by unit and functional tests. There are only three methods in the

TechDivision\Search\Provider\Solr\Provider

Two of this three methods are TYPO3 Flow concerned and one initializes the Solr client which should be covered by
the developers of the solr php extension.

For the functional tests a solr server is required.


Why this namespace?
-------------------

Until now this is a non-corporate project. I chose this namespace to participate at a company internal contest.


Licence
-------

This belongs to the TYPO3 Flow package "TechDivision.Search"

It is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License,
either version 3 of the License, or (at your option) any later version.

Copyright (C) 2013 Matthias Witte
http://www.matthias-witte.net