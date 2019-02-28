<?php
namespace CakeUpload\Storage;

use Cake\ORM\Table;
use Cake\ORM\Entity;

/**
 * Define common interface about files storage
 * 
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
interface StorageInterface
{
    /**
     * Constructor
     * 
     * @param Table $table Table
     * @param Entity $entity Entity
     * @param string $path Path relative to CakePHP webroot directory
     * @param string $field Field name
     * @param array $settings Field settings
     */
    public function __construct(Table $table, Entity $entity, string $path, string $field, array $settings);
    
    /**
     * Move/write set of Uploaded Files to path
     * 
     * @param array $files Array of Uploaded files
     */
    public function write(array $files);
    
    /**
     * Delete set of files from path
     * 
     * @param array $files Array of files or file names
     */
    public function delete(array $files);
    
    /**
     * Completely delete content in path
     * 
     * @param none
     */
    public function deletePath();
}
