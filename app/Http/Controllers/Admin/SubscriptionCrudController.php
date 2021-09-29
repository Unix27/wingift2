<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubscriptionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubscriptionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubscriptionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'title');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 1);
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CloudPaymentsSubscription::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subscription');
        CRUD::setEntityNameStrings('подписку', 'подписки');


        $this->crud->addFilter([
            'name'  => 'published',
            'type'  => 'select2_multiple',
            'label' => 'Сортировать по статусу'
        ], function() {

            $statuses = ['Active'=>'Active','Cancelled' => 'Cancelled','Failed' => 'Failed'];
            $from_to_register = '';
            $from_to = '';

            if(request('from_to_register')){
                $from_to_register = json_decode(request('from_to_register'));
            }

            if(request('from_to')){
                $from_to = json_decode(request('from_to'));
            }

            foreach($statuses as $key => $status){

                $query = \App\Models\CloudPaymentsSubscription::where('status', $status);

                if($from_to)
                    $query = $query->where([
                        [
                            'nextTransactionDate','>=',$from_to->from,
                        ],
                        [
                            'nextTransactionDate','<=',$from_to->to. ' 23:59:59'
                        ]
                    ]);

                if($from_to_register)
                    $query = $query->where([
                        [
                            'start_at','>=',$from_to_register->from,
                        ],
                        [
                            'start_at','<=',$from_to_register->to. ' 23:59:59'
                        ]
                    ]);

//                $statuses[$key] .= ' ('.$query->count().')';
            }



            return $statuses;
        }, function($value) { // if the filter is active
            $this->crud->addClause('whereIn', 'status', json_decode($value));
        });


        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Дата списания'
        ],
            true,
            function ($value) { // if the filter is active, apply these constraints
                 $dates = json_decode($value);
                 $this->crud->addClause('where', 'nextTransactionDate', '>=', $dates->from);
                 $this->crud->addClause('where', 'nextTransactionDate', '<=', $dates->to . ' 23:59:59');
            });

        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to_register',
            'label' => 'Дата регистрации'
        ],
            true,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'start_at', '>=', $dates->from);
                $this->crud->addClause('where', 'start_at', '<=', $dates->to . ' 23:59:59');
            });

        $this->crud->query = $this->crud->query->withoutGlobalScopes();

        $this->crud->model->clearGlobalScopes();

         $this->crud->addSaveAction([
            'name' => 'save_action_one',
            'redirect' => function($crud, $request, $itemId) {
//                dd($request);
                if($request->status == 'Cancelled'){
                   //  $payment = \App\Models\CloudPaymentsSubscription::find($request->id);
                   //  $traffic = \App\Models\Traffic::where('us_id',$payment->user->id)->first();

                   // $traffic = Traffic::first();
                   // $traffic->us_id = $payment->user->id;
                   // $traffic->status = 1;
                   // $traffic->save();
                   //  if($traffic->status) {
                   //      $curl = curl_init();

                   //      curl_setopt_array($curl, array(
                   //          CURLOPT_URL => 'https://your-free-prize.xyz/callback.php?clickid=' . $traffic->clickid . '&action=cancelled',
                   //          CURLOPT_RETURNTRANSFER => true,
                   //          CURLOPT_ENCODING => '',
                   //          CURLOPT_MAXREDIRS => 10,
                   //          CURLOPT_TIMEOUT => 0,
                   //          CURLOPT_FOLLOWLOCATION => true,
                   //          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   //          CURLOPT_CUSTOMREQUEST => 'GET',
                   //      ));

                   //      $info = curl_getinfo($curl);
                   //      $response = curl_exec($curl);
                   //      $error = curl_error($curl);

                   //      curl_close($curl);
                   //  }
                   //  $traffic->status = 0;
                   //  $traffic->save();

                }

                return $crud->route;
            }, // what's the redirect URL, where the user will be taken after saving?

            // OPTIONAL:
            'button_text' => 'Custom save message', // override text appearing on the button
            // You can also provide translatable texts, for example:
            // 'button_text' => trans('backpack::crud.save_action_one'),
            'visible' => function($crud) {
                return true;
            }, // customize when this save action is visible for the current operation
            'referrer_url' => function($crud, $request, $itemId) {
                return $crud->route;
            }, // override http_referrer_url
            'order' => 1, // change the order save actions are in
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

         CRUD::column('cloudpayments_id')->label('Токен');
         CRUD::column('user')->type('relationship')->label('Пользователь');
         CRUD::column('amount')->label('Сумма');
         CRUD::column('currency')->label('Валюта');
         CRUD::column('status')->label('Статус');
         CRUD::column('accountId')->label('E-mail');
         CRUD::column('start_at')->label('Регистрация');
         CRUD::column('nextTransactionDate')->label('След.оплата');
        // CRUD::column('is_new')->label('Импорт Пользователя');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SubscriptionRequest::class);

        //CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
        CRUD::field('user_id')->type('select2')->entry('user')->model('App\Models\User')->options(function($query) {
            return $query->withoutGlobalScopes()->get();
        })->attribute('name')->label('Пользователь');
         CRUD::field('cloudpayments_id')->type('text')->label('Токен');
         CRUD::field('amount')->type('number')->label('Сумма');
         CRUD::field('currency')->type('text')->label('Валюта');
         CRUD::field('status')->type('text')->label('Статус');
         CRUD::field('accountId')->type('text')->label('E-mail');
         CRUD::field('start_at')->type('date')->label('Регистрация');
         CRUD::field('nextTransactionDate')->type('date')->label('Следующая оплата');
        CRUD::addField([// CustomHTML
            'name'  => 'Table',
            'type'  => 'view',
            'view' => '/components/history-table']);

    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    function filterSubscribeChangeLabel(){

        $input = request()->all();

        $statuses = ['Active'=>'Active','Cancelled' => 'Cancelled','Failed' => 'Failed'];
        $from_to_register = '';
        $from_to = '';

        if(isset($input['from_to_register_js'])){
            $from_to_register = json_decode($input['from_to_register_js']);
        }



        if(isset($input['from_to_js'])){
            $from_to = json_decode($input['from_to_js']);
        }

        $html ='';
        foreach($statuses as $key => $status){

            $query = \App\Models\CloudPaymentsSubscription::where('status', $status);
            if($from_to) {
                $query = $query->where(
                    'nextTransactionDate', '>=', str_replace('+',' ', $from_to->from))
                    ->where('nextTransactionDate', '<=', str_replace('+',' ', $from_to->to) . ' 23:59:59');
            }
            if($from_to_register) {
                $query = $query->where('start_at', '>=', str_replace('+',' ', $from_to_register->from))
                    ->where('start_at', '<=', str_replace('+',' ', $from_to_register->to) . ' 23:59:59');
            }



            $html .= ' '.$key .'('.$query->get()->count(). ')';
//            $statuses[$key] .= ' ('.$query->get()->count().')';
        }
       exit(json_encode($html));
    }
}
