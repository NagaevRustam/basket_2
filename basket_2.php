<?php

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items=[];

function getOperationNumber(array $operations, $items): int
{
    $arr = $operations;
    if (count(value: $items) === 0) {
        array_splice($arr, offset: 2, length: 1);
    }
    echo implode(PHP_EOL, array: $arr) . PHP_EOL . '>';
    do{
        $result = trim(string: fgets(STDIN));
        if(!array_key_exists(key: $result, array: $operations)){
            echo '!!!Неизвестный номер операции. Повторите попытку.' . PHP_EOL;
        }
    } while (!array_key_exists(key: $result, array: $operations));
    return $result;
}

function addProduct (array &$items): void {
    echo "Введение название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    $items[] = $itemName;
}

function deleteProduct (array &$items): void {
    echo 'Текущий список покупок:' . PHP_EOL;
    displayShoppingList($items, false);
    echo 'Введение название товара для удаления из списка:' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));
    if (in_array($itemName, $items, true) !== false) {
        while (($key = array_search($itemName, $items, true)) !== false) {
            unset($items[$key]);
        }
    }
}

function displayShoppingList(array $arr, bool $isPrint): void {
    $counter = count(value: $arr);
    if ($counter) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode(separator: "\n", array: $arr) . "\n";
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
    echo "--------\n";
    if ($isPrint) {
        echo 'Всего ' . count(value: $arr) . ' позиций. ' . PHP_EOL;
        echo 'Нажми enter для продолжения';
        fgets(STDIN);
    }
}

do {
    $operationNumber = getOperationNumber(operations: $operations, items: $items);

    echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            addProduct ( $items);
            break;

        case OPERATION_DELETE:
            deleteProduct($items);
            echo $operationNumber;
            break;

        case OPERATION_PRINT:
            displayShoppingList ( $items, true );
            echo $operationNumber;
            break;
    }
    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;