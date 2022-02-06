<?php

namespace Package\Gemba\BuilderPattern;

class SampleDto
{
    use CreateClassHelper;

    /**
     * @param string[] $from
     * @param string[] $to
     * @param string[] $cc
     */
    public function __construct(
        private array $from,
        private array $to,
        private array $cc,
        private string $subject,
        private string $body
    ) {
        $this->shouldBeCalledFrom(SampleDtoBuilder::class);
    }

    /**
     * @return string[]
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    /**
     * @return string[]
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @return string[]
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    public function getSubject(): string
    {
        return $this->subject . PHP_EOL;
    }

    public function getBody(): string
    {
        return $this->body . PHP_EOL;
    }
}
