<?php

class Library
{
    private int $libId;
    private string $address;
    private array $bookShelf;

    public function __construct($libId, $address, $bookShelf)
    {
        $this->libId = $libId;
        $this->address = $address;
        //$this->bookShelf = new Shelf($bookShelf->getShelfId(), $bookShelf->getLibId(), $bookShelf->getVolume(), $bookShelf->getBooksFromShelf());
        $this->bookShelf = $bookShelf;
    }

    public function getLibId(): int
    {
        return $this->libId;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    

    // Метод получения объекта полок в помещении
    public function getBookShelf():array
    {
        return $this->bookShelf;
    }

    public function addBookShelf(Shelf $shelf)
    {
        array_push($this->bookShelf, $shelf) ;
    }
    
    
    public function __toString()
    {
        return 'Библиотека №' . $this->libId . ' находится по адресу: ' . $this->address;
    }
}