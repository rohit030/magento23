<?php

namespace Rc\ProductOptions\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements  UpgradeSchemaInterface
{
    public function upgrade(
            SchemaSetupInterface $setup,
            ModuleContextInterface $context
        ){

        $setup->startSetup();
        $optionTable = $setup->getTable('catalog_product_option');
        $optionValueTable = $setup->getTable('catalog_product_option_type_value');
        if (version_compare($context->getVersion(), '1.0.1') < 0) {

            if ($setup->getConnection()->isTableExists($optionTable) == true) {

            $columns = [
                'custom_class' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Custom Option Class',
                ],
            ];
            $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($optionTable, $name, $definition);
                }          
            }
        }

        if (version_compare($context->getVersion(), '1.0.2') < 0) {

            if ($setup->getConnection()->isTableExists($optionTable) == true) {

            $columns = [
                'image' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'option image names by coma seperated',
                ],
            ];
            $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($optionTable, $name, $definition);
                }          
            }
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {

            if ($setup->getConnection()->isTableExists($optionValueTable) == true) {

            $columns = [
                'image' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'option image name',
                ],
            ];
            $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($optionValueTable, $name, $definition);
                }          
            }
        }

        if (version_compare($context->getVersion(), '1.0.4') < 0) {

            if ($setup->getConnection()->isTableExists($optionTable) == true) {

            $columns = [
                'description' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'option Description',
                ],
            ];
            $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($optionTable, $name, $definition);
                }          
            }
        }

        if (version_compare($context->getVersion(), '1.0.5') < 0) {

            if ($setup->getConnection()->isTableExists($optionTable) == true) {

                $columns = [
                    'depends_id' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Option Id',
                    ],
                ];
                $connection = $setup->getConnection();
                    foreach ($columns as $name => $definition) {
                        $connection->addColumn($optionTable, $name, $definition);
                    }          
            }
        }
        
        $setup->endSetup();

    }

}