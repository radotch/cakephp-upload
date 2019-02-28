<?php
namespace CakeUpload\Storage;

use CakeUpload\Storage\StorageInterface;
use Psr\Http\Message\UploadedFileInterface;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Log\Log;
use Exception;

/**
 * Description of LocalStorage
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
class LocalStorage implements StorageInterface
{
    /**
     * Table instance 
     * 
     * @var Table 
     */
    protected $_table;
    
    /**
     * Entity instance 
     * 
     * @var Entity 
     */
    protected $_entity;

    /**
     * Folder instance
     * 
     * @var string 
     */
    protected $_folder;
    
    /**
     * Field name
     * 
     * @var string 
     */
    protected $_field;
    /**
     * Field settings
     * 
     * @var array 
     */
    protected $_settings;
    
    /**
     * Constructor 
     * 
     * @param string $table Table
     * @param string $entity Entity
     * @param string $path Path relative to CakePHP webroot directory
     * @param string $field Field name
     * @param array $settings Field settings
     */
    public function __construct(Table $table, Entity $entity, string $path, string $field, array $settings)
    {
        $this->_table = $table;
        $this->_entity = $entity;
        $this->_folder = new Folder(WWW_ROOT . $path, TRUE);
        $this->_field = $field;
        $this->_settings = $settings;
    }
    
    /**
     * Write/move set of uploaded files to path
     * 
     * @param UploadedFileInterface[] $files Array with uploaded files
     * @return void 
     */
    public function write(array $files)
    {
        foreach ($files as $file) {
            $this->writeFile($file);
        }
    }
    
    /**
     * Move single uploaded file to path passed to this instance.
     * 
     * @param string $file File name
     * @return void
     */
    public function writeFile(UploadedFileInterface $file)
    {
        $folder = $this->_folder;
        $targetPath = $folder->path . DS . $file->getClientFilename();
        
        try {
            $file->moveTo($targetPath);
        } catch (Exception $ex) {
            Log::write('error', [$targetPath => ['error' => $ex->getMessage()]]);
        }
    }
    
    /**
     * Delete set of files from path passed to this instance.
     * 
     * @param array $files Array with file names
     * @return void
     */
    public function delete(array $files)
    {
        foreach ($files as $fileName) {
            $this->deleteFile($fileName);
        }
    }
    
    /**
     * Delete single file from path passed to this instance
     * 
     * @param string $fileName File name
     * @return bool TRUE on success, otherwise FALE
     */
    public function deleteFile(string $fileName)
    {
        $folder = $this->_folder;
        $file = new File($folder->path . DS . $fileName);
        
        if (! $file->exists()) {
            Log::write('error', 'The file "' . $fileName . '" does not exists.');
            return false;
        }
        
        return $file->delete();
    }
    
    /**
     * Completely remove path's content from path passed to this instance. 
     * 
     * @param none
     * @return bool TRUE on success, otherwise FALSE
     */
    public function deletePath()
    {
        $folder = $this->_folder;
        
        if ($folder->path === null) {
            Log::write('error', 'Folder does not exists');
            return false;
        }
        
        return $folder->delete();
    }
}
