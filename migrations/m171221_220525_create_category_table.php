<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 * Has foreign keys to the tables:
 *
 * - `category`
 */
class m171221_220525_create_category_table extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45)->notNull(),
            'link' => $this->string(100)->notNull(),
            'parent_id' => $this->integer()->defaultValue(0),
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
                'idx-category-parent_id', 'category', 'parent_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
                'fk-category-parent_id', 'category', 'parent_id', 'category', 'id', 'CASCADE', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `category`
        $this->dropForeignKey(
                'fk-category-parent_id', 'category'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
                'idx-category-parent_id', 'category'
        );

        $this->dropTable('category');
    }

}
