<?php

use Phinx\Migration\AbstractMigration;

class CreateRestaurantsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $users = $this->table('restaurants');
        $users->addColumn('name', 'string', array('limit' => 255))
            ->addColumn('city', 'string', array('limit' => 255))
            ->addColumn('category_id', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addForeignKey('category_id', 'categories', ['id'], array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->addIndex(array('name'), array('unique' => true))
            ->save();
    }
}
