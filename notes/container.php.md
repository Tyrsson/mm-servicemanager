# Container.php

line 8
Initializes the container by first requiring the /config.php file to be evaluated which runs ConfigAggregator.
Since our \App\ConfigProvider class is being passed into ConfigAggregator it invokes our ConfigProvider and merges it with
the other config that is passed to the ConfigAggregator. At this point ALL application, and vendor ConfigProviders are read and the config
is merged, with Providers registered later winning. That means if any config shares exact keys the latter registered (passed) config is
what will be used by the application. This strategy is what allows service replacements.

line 10
Sets up the configuration by passing the correct level of the array that ServiceManager can consume.
You can find all of the supported keys and the services they map to here:
[Configuring ServiceManager](https://docs.laminas.dev/laminas-servicemanager/v4/configuring-the-service-manager/)

line 11
This line is usually a stumbling block for people new to Laminas. This line is what creates the "config" service.
It is what allows access to the entire merged config within factories. It is itself a service but since its simple an array of
merged config there is no need for a factory.

line 14
returns the ServiceManager instance after seeding it with the merged configuration returned by ConfigAggregator.
