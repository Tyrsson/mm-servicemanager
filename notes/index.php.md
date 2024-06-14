# Index.php

Of course this is a standard entry file to the application.

line 12
Sets the directory

line 13
Requires composer autoloader

line 18
Creates an anonymous function to scope the code to the function scope instead of the global scope

line 20 (reference /config/container.php, /config/config.php)
Requires the config/container.php file.

line 25
Queries the ServiceManager for an instance of the \App\Application class.
The ->get() call will run the ApplicationFactory and return the instance, as well as store an instance in the ServiceManager
in case its called again.

line 29
Calls $app->run() which would start application execution.
