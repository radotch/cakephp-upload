<?php
namespace CakeUpload\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Database\Type;
use CakeUpload\Database\Type\UploadedFileType;

/**
 * Uploadable behavior
 */
class UploadableBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    /**
     * Rebuild configuration.
     * Change column type for fields in table schema.
     * 
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
        $configs = [];
        foreach ($this->getConfig(NULL, []) as $field => $settings) {
            if (is_int($field)) {
                $configs[$settings] = [];
                $this->_configDelete($field);
            } else {
                $configs[$field] = $settings;
            }
        }
        
        $this->setConfig($configs);
        
        // Set column type for configured fields (UploadedFileType)
        Type::map('uploadedFile', UploadedFileType::class);
        
        $schema = $this->_table->getSchema();
        foreach (array_keys($this->getConfig(NULL, [])) as $field) {
            $schema->setColumnType($field, 'uploadedFile');
        }
        
        $this->_table->setSchema($schema);
    }
}
