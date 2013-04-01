=======================
Com.TechDivision.Search
=======================

The TechDivision.Search package provides an interface for the Com.TechDivision.Neos.Search package.
The default backend uses Apache Solr. This Solr implementation uses the php Solr extension:

http://www.php.net/manual/en/book.solr.php
http://pecl.php.net/package/solr


Add other search backends
-------------------------

The search backend is completely convertible. For adding an other search backends(mysql, OpenSearchServer etc.)
simply implement the

\Com\TechDivision\Search\Provider\ProviderInterface

in your package. For using your own Provider with for example the Com.TechDivision.Neos.Search package look into
the documentation of Com.TechDivision.Neos.Search package.


Testing:
--------

The Com.TechDivision.Search is 100% test covered by unit and functional tests. There are only three methods in the

Com\TechDivision\Search\Provider\Solr\Provider

Two of this three methods are TYPO3 Flow concerned and one initializes the Solr client which should be covered by
the developers of the solr php extension.

For the functional tests a solr server is required.