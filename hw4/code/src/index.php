<?php

require_once 'DigitalBook.php';
require_once 'PaperBook.php';
require_once 'Shelf.php';
require_once 'Library.php';

$lib1 = new Library(1, 'Курская, 78', []); //библотека без шкафов
$lib2 = new Library(2, 'Комсомольская, 2', []);//библеотека без шкафов

$shelf1 = new Shelf(1,2,[]); //полки без книг
$shelf2 = new Shelf(2, 4, []);
$shelf3 = new Shelf(3, 3,[]);


$lib = [];
array_push($lib, $lib1);
array_push($lib, $lib2);

$pBook1 = new PaperBook('Сероглазый король', ['Ахматова А.А.'], 1911); // книги без полок
$pBook2 = new PaperBook('Обитаемый остров', ['Стругацкий А.Н','Стругацкий Б.Н'], 1974);
$pBook4 = new PaperBook('Реквием', ['Ахматова А.А.'], 1911);
$pBook3 = new PaperBook('Большие надежды', ['Чарльз Диккенс'], 1997);
$dBook1 = new DigitalBook('ОСНОВЫ АЛГОРИТМИЗАЦИИ И ПРОГРАММИРОВАНИЯ', ['Жданова Т.А.', 'Бузыкова Ю.С.'], 2011, 'https://pnu.edu.ru/media/filer_public/2013/02/25/book_basics.pdf');
$dBook2 = new DigitalBook('Алгоритмы на практике', ['Даниэль Зингаро'], 2023, 'https://publ.lib.ru/ARCHIVES/B/).pdf');

// теперь ставим книги на полки (в шкафы)
$shelf1->placeBookInShelf($pBook1);
$shelf2->placeBookInShelf($pBook2);
$shelf3->placeBookInShelf($pBook3);
$shelf1->placeBookInShelf($pBook4);

$lib1->addBookShelf($shelf1); // в библиотеку ставим шкафы
$lib1->addBookShelf($shelf3);
$lib2->addBookShelf($shelf2);




echo $lib1 . PHP_EOL;                                  // Получаем данные по помещению (номер, адрес)
echo $pBook2->takeBook('Маша') . PHP_EOL;    // Выдаем книгу на руки
echo 'Количество книг в шкафу №' . $shelf1->getShelfId() . ': '  . $shelf1->getCountBooks(). ' шт )' . PHP_EOL;
echo $pBook2->returnBook('Маша') . PHP_EOL;   // Возврат книги от читателя
echo $pBook2->takeBook('Петя.') . PHP_EOL;
echo $pBook3->takeBook('Вася') . PHP_EOL;
echo $dBook2->takeBook('Катя') . PHP_EOL;

echo $pBook1->infoBook(). PHP_EOL;// смотрим информацию о книге
echo $pBook2->infoBook(). PHP_EOL;
echo $pBook3->infoBook(). PHP_EOL;

echo 'Книга '. $pBook2->getName() . ' находится по адрессу ' . getBookAdress($pBook2, $lib). PHP_EOL;



function getBookAdress (PaperBook $book, array $lib): string //данный метод позволят определить, где можно получить данную книгу
{
    $adress = null;
    
    foreach ($lib as $item) {
        $list = $item->getBookShelf();
       
    
        foreach ($list as $i) {
    
            if ($i->getShelfId() == $book->getShelfId()){
                $adress = $item->getAddress();
            }
        }
    }
    if (isset($adress)){
        return $adress;
    }
    else{
        return 'Адресс не найден';
    }
    
}


// 6. Дан код:

// class A
// {
//     public function foo()
//     {
//         static $x = 0;
//         echo ++$x;
//     }
// }
// $a1 = new A();
// $a2 = new A();
// $a1->foo();      // 1
// $a2->foo();      // 2
// $a1->foo();      // 3
// $a2->foo();      // 4

// Что он выведет на каждом шаге? Почему?  
// Переменная $x объявлена как статическая, а статическая переменная сохраняет значение, которое было у нее при последнем вызове функции и изменяет в процессе работы функции 
// плюс в функции увеличиваем значение на 1


// Немного изменим п.5
// Что он выведет теперь?

// class A
// {
//     public function foo()
//     {
//         static $x = 0;
//         echo ++$x;
//     }
// }
// class B extends A
// {
// }
// $a1 = new A();
// $b1 = new B();
// $a1->foo();      //1
// $b1->foo();      //2
// $a1->foo();      //3
// $b1->foo();      //4     // Класс B наследует от класса А его метод foo(), но не переопределяет его, потому результат будет тот же