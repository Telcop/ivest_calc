<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;

class Calculator extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
    * @var float
    */
    const NAME_PIF = 'Залоговая недвижимость';
    
    /**
    * @var float
    */
    const AMOUNT_MIN = 500000;

    /**
    * @var float
    */
    const COMISSION_PERCENTAGE = 0.30;

    /**
    * @var float
    */
    public $amount = 0;

    /**
    * @var float
    */
    public $cost_share;

    /**
    * @var float
    */
    public $quantity_share = 0 ;

    /**
    * @var float
    */
    public $amount_net = 0 ;

    /**
    * @var float
    */
    public $comission = 0 ;
    
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Layout::rows([
                Input::make('calc.amount_min')
                    ->title('Минимальная сумма инвестирования, руб.')
                    ->placeholder(number_format(self::AMOUNT_MIN, 2, '.', ' '))
                    ->horizontal()
                    ->mask([
                        'alias' => 'currency',
                        'prefix' => ' ',
                        'groupSeparator' => ' ',
                        'digitsOptional' => true,
                    ])
                    ->disabled(),

                Input::make('calc.amount')
                    ->title('Сумма инвестирования (не менее 500 рублей), руб.')
                    ->placeholder($this->amount)
                    ->horizontal()
                    ->required()
                    ->mask([
                        'alias' => 'currency',
                        'prefix' => ' ',
                        'groupSeparator' => ' ',
                        'digitsOptional' => true,
                    ])
                    ->help('вводит Агент/Клиент'),

                // Button::make('Вычислить')
                //     ->method('calculator')
                //     ->icon('bs.calculator')
                //     ->type(Color::SECONDARY),    
            ]),

            Layout::rows([
                Input::make('calc.cost_share')
                    ->title('Стоимость пая, руб./шт.')
                    ->placeholder(number_format($this->cost_share, 2, '.', ' '))
                    ->help('указать в поручении')
                    ->horizontal()
                    ->mask([
                        'alias' => 'currency',
                        'prefix' => ' ',
                        'groupSeparator' => ' ',
                        'digitsOptional' => true,
                    ])
                    // ->type(Color::DANGER)
                    ->disabled(),

                Input::make('calc.quantity_share')
                    ->title('Количество паев, шт.')
                    ->placeholder($this->quantity_share) // вычисляемое
                    ->help('указать в поручении')
                    ->horizontal()
                    ->mask([
                        'alias' => 'decimal',
                        'digits' => 2,
                        'prefix' => ' ',
                        'groupSeparator' => ' ',
                        'digitsOptional' => true,
                    ])
                    ->disabled(),

                Input::make('calc.amount_net')
                    ->title('Сумма инвестирования (за вычетом комиссии брокера, руб.')
                    ->placeholder($this->amount_net) // вычисляемое
                    ->horizontal()
                    ->mask([
                        'alias' => 'currency',
                        'prefix' => ' ',
                        'groupSeparator' => ' ',
                        'digitsOptional' => true,
                    ])
                    ->disabled(),
                    
                Input::make('calc.comission_percentage')
                    ->title('Комиссия брокера за сделку (в процентах), %')
                    ->placeholder(self::COMISSION_PERCENTAGE)
                    ->horizontal()
                    ->mask([
                        'alias' => 'percentage',
                        'digits' => 2,
                        'digitsOptional' => true,
                    ])
                    ->disabled(),

                Input::make('calc.comission')
                    ->title('Комиссия брокера за сделку (информативно), руб.')
                    ->placeholder($this->comission) //вычисляемое
                    ->horizontal()
                    ->mask([
                        'alias' => 'currency',
                        'prefix' => ' ',
                        'groupSeparator' => ' ',
                        'digitsOptional' => true,
                        'decimal' => 2,
                    ])
                    ->disabled(),
            ])
        ];
    }
}
