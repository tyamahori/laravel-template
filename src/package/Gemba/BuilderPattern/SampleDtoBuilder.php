<?php

namespace Package\Gemba\BuilderPattern;

use LogicException;

class SampleDtoBuilder
{
    /**
     * @var string[]
     */
    private array $from = [];

    /**
     * @var string[]
     */
    private array $to = [];

    /**
     * @var string[]
     */
    private array $cc = [];

    /**
     * @var null|string
     */
    private ?string $subject;

    /**
     * @var null|string
     */
    private ?string $body;

    /**
     * @param string ...$from
     * @return $this
     */
    public function setFrom(string ...$from): self
    {
        return $this->copy('from', $from);
    }

    /**
     * @param string ...$to
     * @return $this
     */
    public function setTo(string ...$to): self
    {
        return $this->copy('to', $to);
    }

    /**
     * @param string ...$cc
     * @return $this
     */
    public function setCc(string ...$cc): self
    {
        return $this->copy('cc', $cc);
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject(string $subject): self
    {
        return $this->copy('subject', $subject);
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody(string $body): self
    {
        return $this->copy('body', $body);
    }

    /**
     * @return SampleDto
     */
    public function build(): SampleDto
    {
        $this->assertAtLeastOneFromAddress();
        $this->assertAtLeastOneRecipientAddress();
        $this->assertSubjectIsProvided();
        $this->assertThatBodyIsSpecified();

        return new SampleDto(
            $this->from,
            $this->to,
            $this->cc,
            $this->subject,
            $this->body
        );
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    private function copy(string $key, $value): self
    {
        $new = clone $this;
        $new->{$key} = $value;

        return $new;
    }

    /**
     * @return void
     */
    private function assertAtLeastOneFromAddress(): void
    {
        if (empty($this->from)) {
            throw new LogicException(
                'At least one from-address must be provided'
            );
        }
    }

    /**
     * @return void
     */
    private function assertAtLeastOneRecipientAddress(): void
    {
        if (empty($this->to) && empty($this->cc)) {
            throw new LogicException(
                'At least one recipient address (To or CC) must be provided'
            );
        }
    }

    /**
     * @return void
     */
    private function assertSubjectIsProvided(): void
    {
        if ($this->subject === null) {
            throw new LogicException('Email subject must be provided');
        }
    }

    /**
     * @return void
     */
    private function assertThatBodyIsSpecified(): void
    {
        if ($this->body === null) {
            throw new LogicException('Email body must be provided');
        }
    }
}
