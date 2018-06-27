<?php
namespace TYPO3SniffPool\Sniffs\Files;

/**
 * TYPO3SniffPool_Sniffs_Files_FileExtensionSniff.
 *
 * PHP version 5
 *
 * @category  Files
 * @package   TYPO3SniffPool
 * @author    Stefano Kowalke <blueduck@mailbox.org>
 * @copyright 2013 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Checks if a PHP files has the extension .inc instead of .php
 *
 * @category  Files
 * @package   TYPO3SniffPool
 * @author    Stefano Kowalke <blueduck@mailbox.org>
 * @copyright 2013 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */
class FileExtensionSniff implements Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array('PHP');


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_OPEN_TAG);

    }//end register()


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int $stackPtr The position of the current token in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        // Make sure this is the first PHP open tag so we don't process
        // the same file twice.
        $prevOpenTag = $phpcsFile->findPrevious(T_OPEN_TAG, ($stackPtr - 1));
        if ($prevOpenTag !== false) {
            return;
        }

        $fileName  = $phpcsFile->getFileName();
        $extension = substr($fileName, strrpos($fileName, '.'));

        if ($extension !== '.php') {
            $error = 'Extension for PHP files is always ".php". Found "'.$extension.'" file; use ".php" extension instead';
            $phpcsFile->addError($error, $stackPtr, 'WrongFileExtension');
        }

    }//end process()


}//end class
