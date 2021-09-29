<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DrawRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DrawCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DrawCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Draw::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/draw');
        CRUD::setEntityNameStrings('конкурс', 'конкурсы');

        $this->crud->query = $this->crud->query->withoutGlobalScopes();

        $this->crud->model->clearGlobalScopes();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('title')->label('Название');
        CRUD::column('slug');
        CRUD::column('is_active')->type('check')->label('Активный');
        CRUD::column('is_free')->type('check')->label('Бесплатный');
        CRUD::column('is_person')->type('check')->label('Персона');
        CRUD::column('is_land')->type('check')->label('Лендинг');
        CRUD::column('land_sub')->label('Поддомен');
        CRUD::column('land_theme')->label('Тема');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DrawRequest::class);

        CRUD::field('title')->type('text')->label('Название');
        CRUD::field('slug')->type('text')->hint('По умолчанию будет сгенерирован из названия');
        CRUD::field('prize')->type('text')->label('Приз');
        CRUD::field('image')->type('browse')->label('Изображение');
        CRUD::field('is_active')->type('boolean')->default(1)->label('Активный');
        CRUD::field('is_free')->type('boolean')->default(0)->label('Бесплатный');
        CRUD::field('is_person')->type('boolean')->default(0)->label('Персона');
        CRUD::field('link')->type('text')->label('Ссылка');
        CRUD::field('end_date')->type('datetime_picker')->label('Дата окончания');
        CRUD::field('extras')->type('ckeditor')->label('Описание');

        CRUD::field('is_land')->type('boolean')->default(0)->label('Лендинг');
        CRUD::field('land_sub')->type('text')->label('Поддомен');
        CRUD::field('land_theme')->type('text')->label('Тема');
        CRUD::field('land_insta')->type('text')->label('Истаграмм');
        CRUD::field('land_count')->type('text')->label('Победителей');
        CRUD::field('land_image')->type('browse')->label('Лендинг Изображение Desktop');
        CRUD::field('land_image2')->type('browse')->label('Лендинг Изображение Tablet');
        CRUD::field('land_image3')->type('browse')->label('Лендинг Изображение Mobile');
        CRUD::field('land_text')->type('ckeditor')->label('Лендинг Описание');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
}
