<?php
namespace Bitrix\MyBooksCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class BookTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'my_book';
    }
    
    public static function getUfId()
    {
        return 'MY_BOOK';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('ISBN', array(
                'required' => true,
                'column_name' => 'ISBNCODE',
                'validation' => function() {
                    return array(
                        new Entity\Validator\Unique(),
                        new Entity\Validator\RegExp('/\d{13}/'),
                        function ($value, $primary, $row, $field) {
                            // value - значение поля
                            // primary - массив с первичным ключом, в данном случае [ID => 1]
                            // row - весь массив данных, переданный в ::add или ::update
                            // field - объект валидируемого поля - Entity\StringField('ISBN', ...)

                            // проверяем последнюю цифру
                            if ($value[12] > 1) {
                                return true;
                            } else {
                                // если цифра неправильная - возвращаем особую ошибку
                                return new Entity\FieldError(
                                    $field, 'Контрольная цифра ISBN не сошлась', 'MY_ISBN_CHECKSUM'
                                );
                            }
                        }
                    );
                }
            )),

            //модификация данных перед сохранением и перед выдачей
            new Entity\StringField('TITLE', array(
                'save_data_modification' => function () {
                    return array(
                        function ($value) {
                            return "Книга ". $value;
                        }
                    );
                },
                'fetch_data_modification' => function () {
                    return array(
                        function ($value) {
                            return str_replace("Книга ", "кн", $value);
                        }
                    );
                }
            )),

            new Entity\DateField('PUBLISH_DATE', array(
                'default_value' => function () {
                    // figure out last friday date
                    $lastFriday = date('Y-m-d', strtotime('last friday'));
                    return new Type\Date($lastFriday, 'Y-m-d');
                }
            )),

            // виртуальное поле
            new Entity\ExpressionField('AGE_DAYS',
                'DATEDIFF(NOW(), %s)', array('PUBLISH_DATE')
            ),

            new Entity\TextField('EDITIONS_ISBN', array(
                'serialized' => true
            )),
            new Entity\IntegerField('READERS_COUNT')
        );
    }

    // до добавления записи вырезаем все дефисы
    public static function onBeforeAdd(Entity\Event $event)
    {
        $result = new Entity\EventResult;
        $data = $event->getParameter("fields");

        if (isset($data['ISBN']))
        {
            $cleanIsbn = str_replace('-', '', $data['ISBN']);
            $result->modifyFields(array('ISBN' => $cleanIsbn));
        }

        return $result;
    }

    // запрещает обновлять ISBN выбросом пустого поля
    // public static function onBeforeUpdate(Entity\Event $event)
    // {
    //     $result = new Entity\EventResult;
    //     $data = $event->getParameter("fields");

    //     if (isset($data['ISBN']))
    //     {
    //         $result->unsetFields(array('ISBN'));
    //     }

    //     return $result;
    // }

    // еще можно сгенерировать ошибку
    // public static function onBeforeUpdate(Entity\Event $event)
    // {
    //     $result = new Entity\EventResult;
    //     $data = $event->getParameter("fields");

    //     if (isset($data['ISBN']))
    //     {
    //         $result->addError(new Entity\FieldError(
    //             $event->getEntity()->getField('ISBN'),
    //             'Запрещено менять ISBN код у существующих книг'
    //         ));
    //     }

    //     return $result;
    // }

    // еще можно обработать ошибку целиком для всей записи а не для поля
    // public static function onBeforeUpdate(Entity\Event $event)
    // {
    //     $result = new Entity\EventResult;
    //     $data = $event->getParameter("fields");

    //     if (isset($data['ISBN'])) // комплексная проверка данных
    //     {
    //         $result->addError(new Entity\EntityError(
    //             'Невозможно обновить запись'
    //         ));
    //     }

    //     return $result;
    // }

    //все возможные события
    // OnBeforeAdd (параметры: fields)
    // OnAdd (параметры: fields)
    // OnAfterAdd (параметры: fields, primary)

    // OnBeforeUpdate (параметры: primary, fields)
    // OnUpdate (параметры: primary, fields)
    // OnAfterUpdate (параметры: primary, fields)

    // OnBeforeDelete (параметры: primary)
    // OnDelete (параметры: primary)
    // OnAfterDelete (параметры: primary)
}