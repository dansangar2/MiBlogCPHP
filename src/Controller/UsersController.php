<?php

namespace App\Controller;

use App\Controller\Component\GestionController;
use Cake\Event\Event;

class UsersController extends GestionController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add']);
    }

    public function isAuthorized($user)
    {
        if(!isset($user['role']) || $user['role'] === 'admin')
        {
            if(in_array($this->request->action, ['home', 'logout']))
            {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }
    public function login()
    {
        if($this->request->is('post'))
        {
            $user = $this->Auth->identify();
            if($user)
            {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            else
            {
                $this->Flash->error('Datos introducidos incorrectos', ['key' => 'auth']);
            }
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function home()
    {
        return $this->redirect("/posts/index");
    }

    function item()
    {
        return $this->Users;
    }

    function itemName()
    {
        return 'user';
    }

    function successRedirect()
    {
        return $this->redirect('/users/login');
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

    function headerDescriptions()
    {
        return['edit' => 'Modifica Usuario', 'add' => 'Agregar Usuario'];
    }
}