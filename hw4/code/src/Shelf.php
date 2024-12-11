<?php

class Shelf
{

    private int $shelfId;
    //private int $libId;
    private int $volume;
    private array $books;

    public function __construct(int $shelfId, int $volume, array $books)
    {
        $this->shelfId = $shelfId;
        //$this->libId = $libId;
        $this->volume = $volume;
        $this->books = $books;
    }

    public function getShelfId(): int
    {
        return $this->shelfId;
    }

    // public function getLibId(): int
    // {
    //     return $this->libId;
    // }

    public function getVolume(): int
    {
        return $this->volume;
    }

    public function getBooksFromShelf(): array
    {
        return $this->books;
    }

    // Возвращает количество книг, находящихся в шкафу
    public function getCountBooks()
    {
        return count($this->books);
    }
    public function getListBooks()
    {
        return $this->books;
    }

    // Метод размещения книги в шкаф
    public function placeBookInShelf(PaperBook $book)
    {
        array_push($this->books, $book);
            $book->setShelfId($this->getShelfId());

        //$shelfIdForBook = $book->getShelfId();
        // if (count($this->books) < $$this->getVolume()) {
        //     array_push($this->books[], $book);
        //     $book->setShelfId($this->getShelfId());
        // } else {
        //     echo 'Шкаф № ' . $this->getShelfId() . ' переполнен. Положите книгу "' . $book->getName() . '" в другой шкаф' . PHP_EOL;
        // }
    }
}