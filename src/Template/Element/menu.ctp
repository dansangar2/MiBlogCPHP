<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Acciones') ?></li>
        <li><?= $this->Html->link(__('Cuenta'), ['controller' => 'Users', 'action' => 'view/' . $current_user['id']]) ?></li>
        <li><?= $this->Html->link(__('Categorias'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nueva Categoria'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Blog'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Tus posts'), ['controller' => 'Posts', 'action' => 'yourindex/' .$current_user['id']]) ?></li>
        <li><?= $this->Html->link(__('Nuevo Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link('Salir', ['controller' => 'Users', 'action' => 'logout']) ?></li>
    </ul>
</nav>
