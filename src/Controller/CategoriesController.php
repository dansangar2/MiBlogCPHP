<?php

namespace App\Controller;

use App\Controller\Component\GestionController;

class CategoriesController extends GestionController
{
    function item()
    {
        return $this->Categories;
    }

    function itemName()
    {
        return 'category';
    }

    function successRedirect()
    {
        return $this->redirect('/categories/index');
    }

    function headerDescriptions()
    {
        return['edit' => 'Modifica Categoría', 'add' => 'Añadir Categoría'];
    }

    function paramsToAddWindows()
    {
        return [];
    }

    function paramsToViewWindows()
    {
        return [];
    }

    function paramsToUpdateWindows()
    {
        return [];
    }
}