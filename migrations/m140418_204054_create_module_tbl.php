<?php

use vova07\users\helpers\Security;
use yii\db\Migration;
use yii\db\Schema;

/**
 * CLass m140418_204054_create_module_tbl
 * @package vova07\users\migrations
 *
 * Create module tables.
 *
 * Will be created 3 tables:
 * - {{%users}} - Users table.
 * - {{%profiles}} - User profiles table.
 * - {{%user_email}} - Users email table. This table is used to store temporary new user email address.
 *
 * By default will be added one super-administrator with login: admin and password: admin12345.
 */
class m140418_204054_create_module_tbl extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        // MySql table options
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        // Users table
        $this->createTable(
            '{{%users}}',
            [
                'id' => $this->primaryKey(),
                'username' => $this->string(30)->notNull(),
                'email' => $this->string(100)->notNull(),
                'password_hash' => $this->string(255)->notNull(),
                'auth_key' => $this->string(32)->notNull(),
                'token' => $this->string(53)->notNull(),
                'role' => $this->string(64)->notNull()->defaultValue('user'),
                'status_id' => $this->smallInteger()->notNull()->defaultValue(0),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        // Indexes
        $this->createIndex('users-username', '{{%users}}', 'username', true);
        $this->createIndex('users-email', '{{%users}}', 'email', true);
        $this->createIndex('users-role', '{{%users}}', 'role');
        $this->createIndex('users-status_id', '{{%users}}', 'status_id');
        $this->createIndex('users-created_at', '{{%users}}', 'created_at');

        // Users table
        $this->createTable(
            '{{%profiles}}',
            [
                'user_id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . '(50) NOT NULL',
                'surname' => Schema::TYPE_STRING . '(50) NOT NULL',
                'avatar_url' => Schema::TYPE_STRING . '(64) NOT NULL'
            ],
            $tableOptions
        );

        // Foreign Keys
        $this->addForeignKey('FK_profile_user', '{{%profiles}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');

        // Users emails table
        $this->createTable(
            '{{%user_email}}',
            [
                'user_id' => $this->integer()->notNull(),
                'email' => $this->string(100)->notNull(),
                'token' => $this->string(53)->notNull(),
            ],
            $tableOptions
        );
        $this->addPrimaryKey('user_email_pk', '{{%user_email}}', ['user_id', 'email']);

        // Foreign Keys
        $this->addForeignKey(
            'FK_user_email_user',
            '{{%user_email}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Add super-administrator
        $this->addFirstUser();
        $this->execute($this->getProfileSql());
    }

    /**
     * Insert first super-admin user
     */
    private function addFirstUser()
    {
        $time = time();
        $password_hash = Yii::$app->security->generatePasswordHash('admin12345');
        $auth_key = Yii::$app->security->generateRandomString();
        $token = Security::generateExpiringRandomString();

        $this->insert('{{%users}}', [
            'username' => 'admin',
            'email' => 'admin@demo.com',
            'password_hash' => $password_hash,
            'auth_key' => $auth_key,
            'token' => $token,
            'role' => 'superadmin',
            'status_id' => 1,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }

    /**
     * Insert first super-admin user profile
     */
    private function getProfileSql()
    {
        $this->insert('{{%profiles}}', [
            'user_id' => 1,
            'name' => 'Administration',
            'surname' => 'Site',
            'avatar_url' => '',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_email}}');
        $this->dropTable('{{%profiles}}');
        $this->dropTable('{{%users}}');
    }
}