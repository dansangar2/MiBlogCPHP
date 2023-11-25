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

    function successMessage()
    {
        return 'Categoría guardada correctamente';
    }

    function errorMessage()
    {
        return 'La Categoría no se ha podido guardar';
    }

    function successRedirect()
    {
        return null;
    }

    function paramsToAddWindows()
    {
        return [];
    }

    function paramsToViewWindows()
    {
        return [];
    }
}