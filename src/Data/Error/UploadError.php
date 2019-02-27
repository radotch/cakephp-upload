<?php
namespace CakeUpload\Data\Error;

/**
 * Description of UploadError
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
class UploadError
{
    /**
     * Error messages
     * 
     * @var array 
     */
    private $_errorMessages = [
        UPLOAD_ERR_OK => 'The file %s has been uploaded with success.',
        UPLOAD_ERR_INI_SIZE => 'The uploaded file %s exceeds the upload_max_filesize directive.',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file %s exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        UPLOAD_ERR_PARTIAL => 'The uploaded file %s was only partially uploaded.',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file %s to disk.',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
    ];
    
    /**
     * 
     */
    public function __construct()
    {
        
    }
    
    /**
     * Get formatted error message
     * 
     * @param int $errCode Error code
     * @param string $fileName File name
     * @return string Formatted string 
     */
    public function getMessage(int $errCode, string $fileName)
    {
        $message = $this->_errorMessages[$errCode];
        
        return sprintf($message, $fileName);
    }
}
