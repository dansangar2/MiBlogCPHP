<?php

namespace App\Controller\Component;

use App\Controller\AppController;

/**
 * Class GestionController
 *
 * Controlador general. Contiene todos los métodos necesarios de getión básica
 * de una entidad.
 *
 * @author  Daniel San José García <daniel.sanjose@x-netdigital.com>
 * @version 2023.1126
 *
 * @package App\Controller\Component
 */
abstract class GestionController extends AppController
{
    public static $ListingMethod = "index";
    public static $ViewMethod = "view";
    public static $AddMethod = "add";
    public static $EditMethod = "edit";
    public static $DeleteMethod = "delete";

    public function isAuthorized($user)
    {
        if(in_array($this->request->action, ['edit', 'delete'])) {
            $id = $this->request->getParam('pass', 0);
            $item = $this->item()->get($id);
            if(!isset($item->user_id) || $item->user_id == $user['id']) {
                return true;
            }
            return $this->redirect("/posts/index");
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->paginate = ['order' => ['modified' => 'desc']];
        $items = $this->paginate($this->item());
        $this->set($this->itemName(), $items);
    }

    public function view($id)
    {
        $item = $this->item()->get($id);
        $readonly = true;
        $desc = $item->name;
        $this->set(compact('item'));
        $this->set(compact('readonly'));
        $this->set(compact('desc'));
        foreach ($this->paramsToViewWindows() as $k => $v) {
            $item->$k = $v;
            $this->set(compact($k));
        }
        return $this->render($this->itemName() . "_view");
    }

    public function add()
    {
        $item = $this->item()->newEntity();
        if($this->request->is('post')) {
            $item = $this->item()->patchEntity($item, $this->request->getData());
            foreach ($this->paramsToAddWindows() as $k => $v) {
                $item->$k = $v;
            }
            if($this->item()->save($item)) {
                if($this->successRedirect()!=null) {
                    $this->Flash->success('Creado correctamente.');
                }
            } else {
                $this->Flash->error('No se ha podido crear.');
            }
        }
        $desc = isset($this->headerDescriptions()['add']) ? $this->headerDescriptions()['add'] : 'añadir';
        $this->set(compact('item'));
        $this->set(compact('desc'));
        return $this->render($this->itemName() . "_view");
    }

    public function edit($id)
    {
        $item = $this->item()->get($id);

        if($this->request->is(['post', 'patch', 'put'])) {
            $item = $this->item()->patchEntity($item, $this->request->getData());
            foreach ($this->paramsToUpdateWindows() as $k => $v) {
                $item->$k = $v;
            }
            if($this->item()->save($item)) {
                if($this->successRedirect()!=null) {
                    $this->Flash->success('Guardado correctamente.');
                }
            } else {
                $this->Flash->success('No se ha podido guardar.');
            }
        }
        $desc = isset($this->headerDescriptions()['edit']) ? $this->headerDescriptions()['edit'] : 'Editar';
        $this->set(compact('item'));
        $this->set(compact('desc'));
        return $this->render($this->itemName() . "_view");
    }

    public function delete($id)
    {
        $item = $this->item()->get($id);

        $redirect = ['action' => 'index'];
        $requests = ['post', 'delete'];

        //Debería redireccionar a index o a un mensaje de "acción prohíbida" si se intenta borrar por URL.
        if(!$this->request->is($requests)) {
            return $this->redirect($redirect);
        }

        //Si la primera comprobación no es eficaz, entonces lanzará el error como segunda medida de seguridad.
        $this->request->allowMethod($requests);

        if($this->item()->delete($item)) {
            $this->Flash->success('Borrado correctamente');
        } else {
            $this->Flash->success('No se ha podido borrar.');
        }

        return $this->redirect($redirect);
    }

    /**
     * Nombre que tendrá la base de datos.
     *
     * Por ejemplo:
     *
     * Si en el controlador de Users se retorna en este método:
     * item() => return 'Users';
     *
     * Entonces cada vez que se quiera llamar a la BD, se hará cómo:
     * $this->Users->[acción]
     *
     * @author  Daniel San José García <daniel.sanjose@x-netdigital.com>
     * @version 2023.1126
     *
     * @return mixed
     */
    abstract function item();

    /**
     * El nombre del objeto, usado para redirigir a la vistas.
     *
     * Recomendable usar la versión en singular y minúsculas de la entidad y de item().
     * Por ejemplo:
     * item() => 'Users'
     * itemName() => 'user'
     *
     * @author  Daniel San José García <daniel.sanjose@x-netdigital.com>
     * @version 2023.1126
     *
     * @return mixed
     */
    abstract function itemName();

    /**
     * Cuando se crea correctamente
     *
     * @author  Daniel San José García <daniel.sanjose@x-netdigital.com>
     * @version 2023.1126
     *
     * @return mixed
     */
    abstract function successRedirect();

    /**
     * Array de parámetros que se inicializarán al crear un objeto.
     *
     * Por ejemplo:
     * paramsToAddWindows() => ['name' => 'dummy']
     * Pondrá el atributo 'name' cómo dummy.
     *
     * @author  Daniel San José García <daniel.sanjose@x-netdigital.com>
     * @version 2023.1126
     *
     * @return array
     */
    abstract function paramsToAddWindows();

    /**
     * Array de parámetros que se mandará a la vista.
     *
     * Por ejemplo:
     * paramsToViewWindows() => ['name' => 'dummy']
     * Mandará a la vista el atributo 'name' con valor 'dummy'
     *
     * @author  Daniel San José García <daniel.sanjose@x-netdigital.com>
     * @version 2023.1126
     *
     * @return array
     */
    abstract function paramsToViewWindows();

    /**
     * Array de parámetros que se inicializarán al modificar un objeto.
     *
     * Por ejemplo:
     * paramsToAddWindows() => ['name' => 'dummy']
     * Pondrá el atributo 'name' cómo dummy.
     *
     * @author  Daniel San José García <daniel.sanjose@x-netdigital.com>
     * @version 2023.1126
     *
     * @return array
     */
    abstract function paramsToUpdateWindows();

    /**
     * Texto que se mostrarán en las cabeceras de las ventanas.
     *
     * Por ejemplo:
     * headerDescriptions() => ['edit' => 'Editar Usuario']
     * Mostrará "Editar Usuario" cuando vayas a editar un Usuario.
     *
     * Funciona para "add" y "edit".
     * ['add' => '', 'edit' => '']
     *
     * @author  Daniel San José García <daniel.sanjose@x-netdigital.com>
     * @version 2023.1126
     *
     * @return array
     */
    abstract function headerDescriptions();
}