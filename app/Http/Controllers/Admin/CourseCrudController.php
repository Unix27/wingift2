<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CourseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CourseCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Course::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/course');
        CRUD::setEntityNameStrings('курс', 'курсы');

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
        //CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

         CRUD::column('title')->label('Название');
         CRUD::column('slug');
         CRUD::column('is_active')->type('check')->label('Активный');
         CRUD::column('is_free')->type('check')->label('Бесплатный');
         CRUD::column('category')->type('relationship')->label('Категория');
         CRUD::column('rating')->label('Рейтинг');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CourseRequest::class);

        // dd($this->crud->getCurrentEntry()->files);

        CRUD::field('category_id')->type('select2')->entry('category')->model('App\Models\Category')->options(function($query) {
            return $query->withoutGlobalScopes()->get();
        })->attribute('title')->label('Категория');
        CRUD::field('title')->type('text')->label('Название');
        CRUD::field('slug')->type('text')->hint('По умолчанию будет сгенерирован из названия');
        CRUD::field('excerpt')->type('textarea')->label('Короткое описание');
        CRUD::field('is_active')->type('boolean')->default(1)->label('Активный');
        CRUD::field('is_free')->type('boolean')->default(0)->label('Бесплатный');
        CRUD::field('rating')->type('number')->default(1)->label('Рейтинг');
        CRUD::field('content')->type('ckeditor')->label('Описание');
        CRUD::field('files')->type('repeatable')->label('Файлы')->init_rows(0)->fields([
	       [
               'name' => 'title',
               'label' => 'Название'
	       ],[
		       'name' => 'description',
		       'type' => 'textarea',
               'label' => 'Описание'
	       ],[
		       'name' => 'path',
		       'type' => 'browse',
               'label' => 'Файл'
	       ]
        ]);
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
