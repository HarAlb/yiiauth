<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m220203_082244_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(30),
            'lastname' => $this->string(50),
            'gender' => "ENUM('" . implode('\',\'',\app\models\RegistrationForm::GENDERS) . "')",
            'birthdate' => $this->date(),
            'email' => $this->string()->unique(),
            'phone_code' => $this->string(),
            'phone' => $this->string(),
			'email_confirm_token' => $this->string(),
			'password' => $this->string(),
			'password_reset_token' => $this->string(),
            'auth_key' => $this->string()->unique(),
			'created_at' => $this->date()->notNull(),
			'updated_at' => $this->date()->notNull()
        ], $tableOptions);
		$this->createIndex(
			'{{%idx-unique-user-phone}}',
			'{{%users}}',
			['phone_code', 'phone'],
			true
		);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
