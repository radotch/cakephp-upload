<?php
namespace CakeUpload\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\Database\Type;
use Cake\Event\Event;
use Cake\Utility\Hash;
use CakeUpload\Database\Type\UploadedFileType;
use CakeUpload\Data\Error\UploadChecker;
use ArrayObject;

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
    
    /**
     * Modifies data being marshaled to ensure empty upload data is not inserted.
     * 
     * @param Event $event
     * @param ArrayObject $data
     * @param ArrayObject $options
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        $dataCopy = $data->getArrayCopy();
        foreach (array_keys($this->getConfig(NULL, [])) as $field) {
            $path = $field . '.error';
            if ((Hash::get($dataCopy, $path) !== NULL) && (Hash::get($dataCopy, $path) === UPLOAD_ERR_NO_FILE)) {
                unset($data[$field]);
            }
        }
    }
    
    /**
     * 
     * @param Event $event
     * @param Entity $entity
     * @param ArrayObject $options
     */
    public function beforeSave(Event $event, Entity $entity, ArrayObject $options)
    {
        $uploadChecker = new UploadChecker($entity, array_keys($this->getConfig(NULL, [])));
        if ($uploadChecker->hasErrors()) {
            $errors = $uploadChecker->getErrors();
            $entity->setErrors($errors);
            return FALSE;
        }
    }
}
