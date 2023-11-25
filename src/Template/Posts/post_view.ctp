<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $item
 */

use App\Controller\CategoriesController;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($item) ?>
    <fieldset>
        <legend><?= __($desc) ?></legend>
        <?php
        $categories = [];
        $categoriesOptions = [];
        $categoryField = 'category';
        if(!isset($readonly)) {
            foreach ((new CategoriesController())->Categories->find('all') as $c)
            {
                $categories[$c->id] = $c->name;
            }
            $readonly = false;
            $categoryField .= '_id';
            $categoriesOptions = ['options' => $categories, 'readonly' => 'readonly'];
        }
        else if($readonly)
        {
            $categories = (new CategoriesController())->Categories->get($item->category_id)->name;
            $categoriesOptions = ['value' => "$categories", 'readonly' => true];
            echo $categories;
        }
        echo $this->Form->control('tittle', ['readonly' => $readonly]);
        echo $this->Form->control($categoryField, $categoriesOptions);
        echo $this->Form->control('content', ['readonly' => $readonly]);
        ?>
    </fieldset>
    <?php if(!$readonly):?>
    <?= $this->Form->button(__('Guardar')) ?>
    <?php else: ?>
    <?= $this->Form->end() ?>
    <div class="comments form large-9 medium-8 columns content">
        <?= $this->element('../Comments/comment_view', ['post' => $item, 'comments' => $comments]) ?>
        <?= $this->element('../Comments/index', ['post' => $item, 'comments' => $comments]) ?>
    </div>
    <?php endif; ?>
</div>