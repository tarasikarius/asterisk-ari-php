<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection The [EA] plugin for PhpStorm doesn't know
 * about the noinspection annotation.
 * @noinspection ClassMockingCorrectnessInspection We are using a dependency to hook
 * onto classes before the tests in order to remove the 'final' class keyword. This makes
 * the classes extendable for PhpUnit and therefore testable.
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelConnectedLine;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelConnectedLineTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelConnectedLineTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelConnectedLine $channelConnectedLine
         */
        $channelConnectedLine = Helper::mapOntoAriEvent(
            ChannelConnectedLine::class,
            [
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelConnectedLine->getChannel());
    }
}
