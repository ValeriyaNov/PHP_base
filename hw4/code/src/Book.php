<?php

abstract class  Book
{
    private string $name;
    private array $authors;
    private int $year;

    public function __construct(string $name, array $authors, int $year)
    {
        $this->name = $name;
        $this->authors = $authors;
        $this->year = $year;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAuthor(): string
    {
        $arrAuthors = '';
        foreach ($this->authors as $author) {
            $arrAuthors .= $author . ' ';
        }
        return $arrAuthors;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }


    public function getYear(): int
    {
        return $this->year;
    }

    abstract public function takeBook(string $name): string;
}