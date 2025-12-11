<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Color;
use App\Models\CostShare;
use Illuminate\Http\Request;


class PlatformScreen extends Screen
{
    /**
    * @var float
    */
    const NAME_PIF = '5895ВыпЦБ';
    
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
    public $investment_volume = 0 ;

    /**
    * @var float
    */
    public $comission = 0 ;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'cost_share' => (float) CostShare::where('prod_code', self::NAME_PIF)->orderBy('id', 'desc')->first()->quotes,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Инвестиционный калькулятор для расчета суммы инвестирования';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return CostShare::where('prod_code', self::NAME_PIF)->orderBy('id', 'desc')->first()->prod_name;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            // Button::make('Вычислить')
            //     ->method('calculator')
            //     ->icon('bs.calculator'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
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
                        ->title('Сумма инвестирования (не менее 500 тысяч рублей), руб.')
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

                    Button::make('Вычислить')
                        ->method('calculator')
                        ->type(Color::SECONDARY)
                        ->icon('bs.calculator')
                        ->class('btn  btn-secondary btn_calculator')
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

                // Input::make('calc.amount_net')
                //     ->title('Сумма инвестирования (за вычетом комиссии брокера, руб.')
                //     ->placeholder($this->amount_net) // вычисляемое
                //     ->horizontal()
                //     ->mask([
                //         'alias' => 'currency',
                //         'prefix' => ' ',
                //         'groupSeparator' => ' ',
                //         'digitsOptional' => true,
                //     ])
                //     ->disabled(),
                    
                Input::make('calc.investment_volume')
                    ->title('Объем инвестирования (за вычтено комиссий, руб.)')
                    ->placeholder($this->investment_volume) // вычисляемое
                    ->horizontal()
                    ->mask([
                        'alias' => 'currency',
                        'prefix' => ' ',
                        'groupSeparator' => ' ',
                        'digitsOptional' => true,
                    ])
                    ->disabled(),

                Input::make('calc.comission_percentage')
                    ->title('Комиссия брокера за сделку (0.3% от суммы, но не менее 3 тыс. руб.), %')
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

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function calculator(Request $request)
    {
        $this->amount = (float) str_replace(' ', '', $request->input('calc.amount'));
        $this->cost_share = (float) CostShare::where('prod_code', self::NAME_PIF)->orderBy('id', 'desc')->first()->quotes;
        $this->comission = $this->amount == 0 
            ? 0 
            : (( $this->amount * (float)(self::COMISSION_PERCENTAGE/100) ) < (float)3000 
                ? (float) 3000  
                : round($this->amount * (float)(self::COMISSION_PERCENTAGE/100), 2)
            );
        $this->amount_net = $this->amount < self::AMOUNT_MIN 
            ? 0 
            : $this->amount - $this->comission;
        $this->quantity_share = number_format(floor($this->amount_net / $this->cost_share), 2, '.', ' ');
        $this->investment_volume = number_format((floor($this->amount_net / $this->cost_share) * $this->cost_share), 2, '.', ' ');

        $this->comission = number_format($this->comission, 2, '.', ' ');
        $this->cost_share = number_format($this->cost_share, 2, '.', ' ');
        $this->amount = number_format($this->amount, 2, '.', ' ');

        if (!($this->amount_net))
            Alert::error('Обратитесь к менеджеру');

        $this->amount_net = number_format($this->amount_net, 2, '.', ' ');

    }
}
