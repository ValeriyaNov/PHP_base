<?php

require_once "Book.php";

class PaperBook extends Book
{
    private int $shelfId;
    private int $countRead = 0;  // Переменная для подсчета количества прочтений

    public function __construct(string $name, array $authors, int $year)
    {
        parent::__construct($name, $authors, $year);
        //$this->shelfId = $shelfId;
    }

    public function getShelfId()
    {
        return $this->shelfId;
    }

    public function setShelfId(int $shelfId)
    {
        $this->shelfId = $shelfId;
    }

    // Метод выдачи книги на руки
    public function takeBook(string $name): string
    {

        return 'Книга: ' . $this->getName() . ', автор: ' . $this->getAuthor() . ', год: ' . $this->getYear() . ', получена пользователем ' . $name . ' Количество прочтений: ' . ++$this->countRead;
    }

    // Метод возврата книги читателем
    public function returnBook(string $name): string
    {
        return 'Книга: ' . $this->getName() . ', автор: ' . $this->getAuthor() . ', год: ' . $this->getYear() . ',  шкаф №' . $this->getShelfId() . ', возвращена пользователем ' . $name;
    }
    public function infoBook(): string
    {
        return 'Книга: ' . $this->getName() . ', автор: ' . $this->getAuthor() . ', год: ' . $this->getYear() . ',  шкаф №' . $this->getShelfId();
    }

    
}