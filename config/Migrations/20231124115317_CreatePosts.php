<?php
use Migrations\AbstractMigration;

class CreatePosts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('posts');
        $table->addColumn('tittle', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('content', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();

        $ref = $this->table('posts');
        $ref->addColumn('user_id', 'integer', [
                'signed' => 'disable',]
        )->addForeignKey('user_id', 'users', 'id',
            [
                'delete' => 'CASCADE', 'update' => 'NO_ACTION'
            ]
        )->update();
        $ref->addColumn('category_id', 'integer', [
            'signed' => 'disable',
        ])->addForeignKey('category_id', 'categories', 'id',
            [
                'delete' => 'CASCADE', 'update' => 'NO_ACTION'
            ]
        )->update();
    }
}
