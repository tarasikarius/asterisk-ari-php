<?php

/**
 * The JSONMapper library needs the full name path of
 * a class, so there are no imports used instead.
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models;

/**
 * Details of a Stasis application.
 *
 * @package NgVoice\AriClient\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Application implements ModelInterface
{
    /**
     * Name of this application
     *
     * @var string
     */
    private $name;

    /**
     * {tech}/{resource} for endpoints subscribed to.
     *
     * @var string[]
     */
    private $endpoint_ids;

    /**
     * Id's for channels subscribed to.
     *
     * @var string[]
     */
    private $channel_ids;

    /**
     * Names of the devices subscribed to.
     *
     * @var string[]
     */
    private $device_names;

    /**
     * Event types not sent to the application.
     *
     * @var \NgVoice\AriClient\Models\Message\Message[]
     */
    private $events_disallowed;

    /**
     * Id's for bridges subscribed to.
     *
     * @var string[]
     */
    private $bridge_ids;

    /**
     * Event types sent to the application.
     *
     * @var \NgVoice\AriClient\Models\Message\Message[]
     */
    private $events_allowed;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string[]
     */
    public function getEndpointIds(): array
    {
        return $this->endpoint_ids;
    }

    /**
     * @param string[] $endpoint_ids
     */
    public function setEndpointIds(array $endpoint_ids): void
    {
        $this->endpoint_ids = $endpoint_ids;
    }

    /**
     * @return string[]
     */
    public function getChannelIds(): array
    {
        return $this->channel_ids;
    }

    /**
     * @param string[] $channel_ids
     */
    public function setChannelIds(array $channel_ids): void
    {
        $this->channel_ids = $channel_ids;
    }

    /**
     * @return string[]
     */
    public function getDeviceNames(): array
    {
        return $this->device_names;
    }

    /**
     * @param string[] $device_names
     */
    public function setDeviceNames(array $device_names): void
    {
        $this->device_names = $device_names;
    }

    /**
     * @return \NgVoice\AriClient\Models\Message\Message[]
     */
    public function getEventsDisallowed(): array
    {
        return $this->events_disallowed;
    }

    /**
     * @param \NgVoice\AriClient\Models\Message\Message[] $events_disallowed
     */
    public function setEventsDisallowed(array $events_disallowed): void
    {
        $this->events_disallowed = $events_disallowed;
    }

    /**
     * @return string[]
     */
    public function getBridgeIds(): array
    {
        return $this->bridge_ids;
    }

    /**
     * @param string[] $bridge_ids
     */
    public function setBridgeIds(array $bridge_ids): void
    {
        $this->bridge_ids = $bridge_ids;
    }

    /**
     * @return \NgVoice\AriClient\Models\Message\Message[]
     */
    public function getEventsAllowed(): array
    {
        return $this->events_allowed;
    }

    /**
     * @param \NgVoice\AriClient\Models\Message\Message[] $events_allowed
     */
    public function setEventsAllowed(array $events_allowed): void
    {
        $this->events_allowed = $events_allowed;
    }
}
