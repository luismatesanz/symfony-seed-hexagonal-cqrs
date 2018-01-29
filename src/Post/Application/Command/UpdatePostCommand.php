<?php

namespace App\Post\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Post\Domain\Model\PostId;

class UpdatePostCommand implements Command
{
    private $id;
    private $date;
    private $title;
    private $text;

    public function __construct(PostId $id, ?\DateTime $date, ?string $title, ?string $text)
    {
        $this->id = $id;
        $this->date = $date;
        $this->title = $title;
        $this->text = $text;
    }

    public function id(): PostId
    {
        return $this->id;
    }

    public function date(): ?\DateTime
    {
        return $this->date;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function text(): ?string
    {
        return $this->text;
    }
}