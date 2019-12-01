# Asterisk REST Interface (ARI) Client

Client implementation of the Asterisk REST Interface and simple Stasis
application development library.

The idea is to make ARI calls safe and easy. Therefore, we wanted to get rid of 
JSON parsing in our application code. Instead, we aim to make it as easy as possible 
for anyone to talk to ARI without 
worrying about an implementation of a client stub. We already did the work for you :)

[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=security_rating)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=coverage)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)

[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=sqale_index)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=ncloc)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)

![Licence](https://img.shields.io/badge/licence-MIT-blue.svg)

![](images/AriClientSketch.png)

## Prerequisites
Download and install composer from the following link

https://getcomposer.org/download/

## Installing

##### Composer
Please run the following command to add the library to your project

`composer require ng-voice/asterisk-ari-client`

While installing, you might run into composer errors concerning missing php extensions.
There are several ways to install them, depending on your operating system
(e.g. `apt install php7.3-mbstring`). You might need to install php-dev first and
then install and enable the extension via pecl.

##### Asterisk
You will have to start an Asterisk instance and configure it in order to use ARI.
The official Asterisk documentation shows you how to do so. 

https://wiki.asterisk.org/wiki/display/AST/Asterisk+Configuration+for+ARI

Alternatively use our Dockerfile to fire up Asterisk from Deployment section below.

## Examples

#### REST Clients
Talk to your asterisk instance by the given RestClients.
All requests and responses are mapped onto objects that are easy to understand.

Following example originates a call using the Channels resource of the
Asterisk REST Interface.

    <?php

    declare(strict_types=1);

    use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
    use NgVoice\AriClient\RestClient\ResourceClient\Channels;
    use NgVoice\AriClient\RestClient\Settings as AriRestClientSettings;
    
    require_once __DIR__ . '/vendor/autoload.php';
    
    // Of course inject your own REST client settings here.
    $ariChannelsRestClient = new Channels(
        new AriRestClientSettings('asterisk', 'asterisk')
    );
    
    try {
        // Call the specified number
        $originatedChannel = $ariChannelsRestClient->originate(
            'PJSIP/+4940123456789',
            [
                'app' => 'MyExampleStasisApp'
            ]
        );
    } catch (AsteriskRestInterfaceException $e) {
        echo "Error occurred: {$e->getMessage()}\n";
    }
    
    echo "The originated channel has the ID '{$originatedChannel->getId()}'\n";


#### Web socket client

Connects to Asterisk and subscribes to a 
Stasis application running on your Asterisk instance. Following example shows 
how to define an application and how to handle a specific incoming event, which
is related to the application.

In this case we are handling a `StasisStart` event.
    
    <?php
    
    declare(strict_types=1);
    
    // TODO: Change to your own project namespace.
    namespace My\Own\Project\Namespace;
    
    use NgVoice\AriClient\StasisApplicationInterface;
    use NgVoice\AriClient\Models\Message\StasisStart;
    
    /**
     * Write your own Stasis application class that must implement the
     * StasisApplicationInterface.
     *
     * This application will register automatically in Asterisk as
     * soon as you start a WebSocketClient (@see the worker script example).
     *
     * @package My\Own\Project\Namespace
     *
     * @author Lukas Stermann <lukas@ng-voice.com>
     */
    class MyExampleStasisApp implements StasisApplicationInterface
    {
        /**
         * To declare an ARI event handler function, name it after
         * the occurring Asterisk event you want to handle and add
         * the prefix 'onAriEvent'. The only parameter is the object
         * representation of the event, provided by this library.
         * The function MUST also be public and non-static.
         *
         * Of course you can define any other functions within this class
         * that do not handle incoming ARI events (leave out the prefix ;-)).
         * Think of your Stasis application class as a data structure
         * encapsulating your application logic.
         *
         * The StasisStart event for example is triggered for
         * channels when they enter your application.
         *
         * @param StasisStart $stasisStart The Asterisk event,
         * telling you that a channel has entered your application.
         */
        public function onAriEventStasisStart(StasisStart $stasisStart): void
        {
            echo 'This is the channels StasisStart event handler triggered by '
                . "channel '{$stasisStart->getChannel()->getId()}' :-)\n";
        }
    }



Write a PHP script to start your WebSocketClient worker process.
This is a blocking process! For production, you should use a process manager to run it in
the background. We recommend 'supervisor' for linux.

    <?php

    declare(strict_types=1);
    
    use NgVoice\AriClient\WebSocketClient\Settings as AriWebSocketClientSettings;
    use NgVoice\AriClient\WebSocketClient\Factory as AriWebSocketClientFactory;
    
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/vendor/ng-voice/asterisk-ari-client/examples/MyExampleStasisApp.php';
    
    /*
     * Initialize an ARI web socket client to
     * listen for incoming Asterisk events.
     *
     * Of course inject your own web socket settings here.
     */
    $ariWebSocketClient = AriWebSocketClientFactory::create(
        new AriWebSocketClientSettings('asterisk', 'asterisk'),
        new MyExampleStasisApp()
    );
    
    $ariWebSocketClient->start();



You can find a detailed example in the `examples` directory.

## Debug logs
To debug your ARI communication, this client library ships with a simple debug log switch.
Simply en-/disable it in the `debug_mode.yaml` file located in the root directory
of this project.

The logs will appear on STDOUT.

## Running the tests

### Unit tests

`composer test`

### Coding style tests

For code sniffing

`composer lint `

For static code analysis

`composer sca`

## Deployment

We added the Dockerfile in the `docker/asterisk/` directory where you can also find some 
example configuration files for your own Asterisk instance.

Preferably use the provided Dockerfile in this library to compile your own 
Asterisk container.
    
    cd docker/asterisk
    docker build -t --build-arg asterisk_version=16.2.1 asterisk:latest .
    docker run -d --name some-asterisk -p 8088:8088 -p 5060:5060 -p 5060:5060/udp asterisk:latest

    !!! PLEASE NOTE !!!
    Compiling Asterisk sometimes is bound to the hardware you are compiling it on.
    Right now we compile an own container for every machine we run Asterisk on,
    to make sure it will work.
    Alternatively you can set generic compiler flags at your own risk.

## Licence

##### MIT © ng-voice GmbH (2019)

![](images/ng-voice-logo.png)

## Contact
ng-voice is happy to help! Feel free to send us a message.
We'd also like to hear about your application ideas and use cases :)

Lukas Stermann (lukas@ng-voice.com)

Ahmad Hussain  (ahmad@ng-voice.com)