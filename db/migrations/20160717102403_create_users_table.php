<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
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
        $users = $this->table('users', ['id' => false,  'primary_key' => 'id']);
        $users->addColumn('id', 'string', array('limit' => 36))
            ->addColumn('email', 'string', array('limit' => 254))
            ->addColumn('username', 'string', array('limit' => 150))
            ->addColumn('password_hash', 'string', array('limit' => 255))
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime', array('null' => true))
            ->addIndex(array('email'), array('unique' => true))
            ->addIndex(array('username'), array('unique' => true))
            ->save();
    }
}
