# config.php

Probably one of the most important files in the application. This is where all ConfigProviders, ArrayProviders
and PhpFileProviders as passed in to seed COnfigAggregator with various types of configuration for consumption
by the ServiceManager instance. This is how you make you code available to ServiceManager and if you are using
Mezzio this is how you make your code available to Mezzio as well. Its slightly different for Laminas MVC since
the MVC uses Module.php files. The principle is the same however.

line 11
If laminas development mode is being used then this sets up the cache file to be used.

line 15
Creates ConfigAggregator instance and passes an array of Providers for consumption.

line 16
Was injected during the composer require for webinertia/webinertia-utils by the laminas/laminas-component-installer component.
This can also be done manually. I just prefer the automation.

line 22
Adds our App\ConfigProvider to wire our App "modules" dependencies into our future application.

line 30
Automatically merges any to be autoloaded confguration files matching the glob patterns.
These files should live in /config/autoload/ and have files names such as db.local.php. By doing this
we can setup a git ignore strategy as the repo level as prevent sensitive data from being pushed into
our public git repos.

line 33
Finally merges the master development.config.php file

line 34
Passes the $cacheConfig as the second argument so that ConfigAggregator knows where to look for the cache.
If found it will not execute any of the underlying merging and will just load the config from the cache file.

line 36
Returns the merged config for consumption by the ServiceManager.
