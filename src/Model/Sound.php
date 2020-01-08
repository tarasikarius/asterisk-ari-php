<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * A media file that may be played back.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Sound implements ModelInterface
{
    private ?string $text = null;

    private string $id;

    /**
     * @var array<int, FormatLangPair>
     */
    private array $formats;

    /**
     * Text description of the sound, usually the words spoken.
     *
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Sound's identifier.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * The formats and languages in which this sound is available.
     *
     * @return array<int, FormatLangPair>
     */
    public function getFormats(): array
    {
        return $this->formats;
    }
}
