<?php

declare(strict_types = 1);

namespace App\Post\Application\Command;

use App\Kernel\Application\Command\Command;

final class AddPostCommand implements Command
{
    private $date;
    private $title;
    private $text;

    public function __construct(\DateTime $date, string $title, ?string $text)
    {
        $this->date = $date;
        $this->title = $title;
        $this->text = $text;
    }

    public function date(): \DateTime
    {
        return $this->date;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function text(): string
    {
        return $this->text;
    }
}
