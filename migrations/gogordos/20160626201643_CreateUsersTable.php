<?php

class CreateUsersTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $t = $this->create_table("users", array("id" => false));
        $t->column("id", "integer", ["primary_key" => true,
            "auto_increment" => true,
            "unsigned" => true,
            "null" => false]);
        $t->column("username", "string", ["null" => false]);
        $t->column("email", "string", ["limit" => 128, "null" => false]);
        $t->column("password_hash", "string", ["limit" => 255, "null" => false]);
        $t->finish();

        $this->add_index("users", "email", ["unique" => true]);
        $this->add_index("users", "username", ["unique" => true]);
    }

    public function down()
    {
        $this->drop_table("users");
    }
}
