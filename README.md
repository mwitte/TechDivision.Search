!!DEPRECATED!!

TechDivision.Search
===================

This package provides an interface for the [TechDivision.Neos.Search](https://github.com/mwitte/TechDivision.Neos.Search) package. There are two different
implementations provided:

### Solr Rest

This implementation uses the default php curl extension. In most cases you should use this provider. It works with
Apache Solr 4.x and 3.6.x

### Solr Extension

This implementation uses the solr php extension:

http://www.php.net/manual/en/book.solr.php
http://pecl.php.net/package/solr

Currently the php solr extension works only with Apache Solr 3.6.x !

Add other search backend
------------------------

The search backend is completely convertible. For adding a search backend(mysql, OpenSearchServer etc.) simply implement
the

	\TechDivision\Search\Provider\ProviderInterface

in your package. For using your own Provider with for example the TechDivision.Neos.Search package look into
the documentation of TechDivision.Neos.Search package.


Design decisions
----------------

I created a dedicated "search" package to get the opportunity to change the backend logic to another logic by
configuration. With this (for basic requirements) generic documents and fields are various backend solutions possible.
This hole package was created by test-driven-development with 100% code coverage. One main paradigm was "separation of
concerns" so there are many small classes with small methods.


Testing
-------

The TechDivision.Search is 100% test covered by unit and functional tests. Uncovered:

The method "initializeObject" in the class

	TechDivision\Search\Provider\Solr\Extension\Provider

It initializes the php solr extension's solr client which should be covered by the developers of the solr php extension.

The class

	TechDivision\Search\Provider\Solr\Rest\CurlClient

It initializes the php curl extension. There is really few logic. Probably i'll find a solution to test is in future.

There are some other methods uncovered, these methods contain no logic and are only for dependency injection by the
TYPO3 Flow framework. These should be covered by the framework an are ignored for code coverage as well.

For the functional tests is a solr server is required! In my opinion are unit tests significantly more useful then
functional tests.

The functional tests are currently not suitable, the last changes in the TYPO3 Flow framework made it nearly impossible
to cover the code with 100%. There is already an issue for that in forge to fix it.

[https://forge.typo3.org/issues/46974](https://forge.typo3.org/issues/46974)


Why this namespace?
-------------------

Until now this is a non-corporate project I made in my leisure time. I chose this namespace to participate at a company
internal contest.


Licence
-------

This belongs to the TYPO3 Flow package "TechDivision.Search"

It is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License,
either version 3 of the License, or (at your option) any later version.

Copyright (C) 2013 Matthias Witte
[http://www.matthias-witte.net](http://www.matthias-witte.net)
