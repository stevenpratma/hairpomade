<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 3.0.0
 * @filesource
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Session Files Driver
 *
 * @package	CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author	Andrey Andreev
 * @link	https://codeigniter.com/user_guide/libraries/sessions.html
 */
class CI_Session_files_driver extends CI_Session_driver implements SessionHandlerInterface {

	/**
	 * Save path
	 *
	 * @var	string
	 */
	protected $_save_path;

	/**
	 * File handle
	 *
	 * @var	resource
	 */
	protected $_file_handle;

	/**
	 * File name
	 *
	 * @var	resource
	 */
	protected $_file_path;

	/**
	 * File new flag
	 *
	 * @var	bool
	 */
	protected $_file_new;

	/**
	 * Validate SID regular expression
	 *
	 * @var	string
	 */
	protected $_sid_regexp;

	/**
	 * mbstring.func_overload flag
	 *
	 * @var	bool
	 */
	protected static $func_overload;

	// ------------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 * @param	array	$params	Configuration parameters
	 * @return	void
	 */
	public function __construct(&$params)
	{
		parent::__construct($params);

		if (isset($this->_config['save_path']))
		{
			$this->_config['save_path'] = rtrim($this->_config['save_path'], '/\\');
			ini_set('session.save_path', $this->_config['save_path']);
		}
		else
		{
			log_message('debug', 'Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.');
			$this->_config['save_path'] = rtrim(ini_get('session.save_path'), '/\\');
		}

		$this->_sid_regexp = $this->_config['_sid_regexp'];

		isset(self::$func_overload) OR self::$func_overload = (extension_loaded('mbstring') && ini_get('mbstring.func_overload'));
	}

	// ------------------------------------------------------------------------

	/**
	 * Open
	 *
	 * Sanitizes the save_path directory.
	 *
	 * @param	string	$save_path	Path to session files' directory
	 * @param	string	$name		Session cookie name
	 * @return	bool
	 */
	public function open($save_path, $name): bool
{
    if (!is_dir($save_path)) {
        if (!mkdir($save_path, 0700, true)) {
            log_message('error', "Session: Configured save path '{$this->_config['save_path']}' is not a directory, doesn't exist, or cannot be created.");
            return false;
        }
    } elseif (!is_writable($save_path)) {
        log_message('error', "Session: Configured save path '{$this->_config['save_path']}' is not writable by the PHP process.");
        return false;
    }

    $this->_config['save_path'] = $save_path;
    $this->_file_path = $this->_config['save_path'] . DIRECTORY_SEPARATOR
        . $name // we'll use the session cookie name as a prefix to avoid collisions
        . ($this->_config['match_ip'] ? md5($_SERVER['REMOTE_ADDR']) : '');

    $this->php5_validate_id();

    return true;
}


	// ------------------------------------------------------------------------

	/**
	 * Read
	 *
	 * Reads session data and acquires a lock
	 *
	 * @param	string	$session_id	Session ID
	 * @return	string	Serialized session data
	 */
	public function read($session_id): string|false
{
    if ($this->_file_handle === null) {
        $this->_file_new = !file_exists($this->_file_path . $session_id);

        if (($this->_file_handle = fopen($this->_file_path . $session_id, 'c+b')) === false) {
            log_message('error', "Session: Unable to open file '{$this->_file_path}{$session_id}'.");
            return false;
        }

        if (flock($this->_file_handle, LOCK_EX) === false) {
            log_message('error', "Session: Unable to obtain lock for file '{$this->_file_path}{$session_id}'.");
            fclose($this->_file_handle);
            $this->_file_handle = null;
            return false;
        }

        $this->_session_id = $session_id;

        if ($this->_file_new) {
            chmod($this->_file_path . $session_id, 0600);
            $this->_fingerprint = md5('');
            return '';
        }
    } elseif ($this->_file_handle === false) {
        return false;
    } else {
        rewind($this->_file_handle);
    }

    $session_data = '';
    for ($read = 0, $length = filesize($this->_file_path . $session_id); $read < $length; $read += self::strlen($buffer)) {
        if (($buffer = fread($this->_file_handle, $length - $read)) === false) {
            break;
        }

        $session_data .= $buffer;
    }

    $this->_fingerprint = md5($session_data);
    return $session_data;
}


	// ------------------------------------------------------------------------

	/**
	 * Write
	 *
	 * Writes (create / update) session data
	 *
	 * @param	string	$session_id	Session ID
	 * @param	string	$session_data	Serialized session data
	 * @return	bool
	 */
	public function write($session_id, $session_data): bool
{
    if ($session_id !== $this->_session_id && ($this->close() === false || $this->read($session_id) === false)) {
        return false;
    }

    if (!is_resource($this->_file_handle)) {
        return false;
    } elseif ($this->_fingerprint === md5($session_data)) {
        return (!$this->_file_new && !touch($this->_file_path . $session_id)) ? false : true;
    }

    if (!$this->_file_new) {
        ftruncate($this->_file_handle, 0);
        rewind($this->_file_handle);
    }

    if (($length = strlen($session_data)) > 0) {
        for ($written = 0; $written < $length; $written += $result) {
            if (($result = fwrite($this->_file_handle, substr($session_data, $written))) === false) {
                break;
            }
        }

        if (!is_int($result)) {
            $this->_fingerprint = md5(substr($session_data, 0, $written));
            log_message('error', 'Session: Unable to write data.');
            return false;
        }
    }

    $this->_fingerprint = md5($session_data);
    return true;
}


	// ------------------------------------------------------------------------

	/**
	 * Close
	 *
	 * Releases locks and closes file descriptor.
	 *
	 * @return	bool
	 */
	public function close(): bool
	{
		if (is_resource($this->_file_handle)) {
			flock($this->_file_handle, LOCK_UN);
			fclose($this->_file_handle);
	
			$this->_file_handle = $this->_file_new = $this->_session_id = null;
			return true;
		}
	
		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Destroy
	 *
	 * Destroys the current session.
	 *
	 * @param	string	$session_id	Session ID
	 * @return	bool
	 */
	public function destroy($session_id): bool
{
    if ($this->close() === $this->_success) {
        if (file_exists($this->_file_path . $session_id)) {
            $this->_cookie_destroy();
            return unlink($this->_file_path . $session_id) ? true : false;
        }

        return true; // Jika file tidak ada, sesi dianggap sudah dihapus
    } elseif ($this->_file_path !== null) {
        clearstatcache();
        if (file_exists($this->_file_path . $session_id)) {
            $this->_cookie_destroy();
            return unlink($this->_file_path . $session_id) ? true : false;
        }

        return true; // Jika file tidak ada, sesi dianggap sudah dihapus
    }

    return false; // Default, jika tidak ada kasus yang sesuai
}


	// ------------------------------------------------------------------------

	/**
	 * Garbage Collector
	 *
	 * Deletes expired sessions
	 *
	 * @param	int 	$maxlifetime	Maximum lifetime of sessions
	 * @return	bool
	 */
	public function gc($maxlifetime): int|false
{
    if (!is_dir($this->_config['save_path']) || ($directory = opendir($this->_config['save_path'])) === false) {
        log_message('debug', "Session: Garbage collector couldn't list files under directory '" . $this->_config['save_path'] . "'.");
        return false;
    }

    $ts = time() - $maxlifetime;
    $deleted_count = 0;

    $pattern = ($this->_config['match_ip'] === true) ? '[0-9a-f]{32}' : '';
    $pattern = sprintf('#\A%s' . $pattern . $this->_sid_regexp . '\z#', preg_quote($this->_config['cookie_name']));

    while (($file = readdir($directory)) !== false) {
        if (!preg_match($pattern, $file) || !is_file($this->_config['save_path'] . DIRECTORY_SEPARATOR . $file)) {
            continue;
        }

        $mtime = filemtime($this->_config['save_path'] . DIRECTORY_SEPARATOR . $file);
        if ($mtime === false || $mtime <= $ts || $this->validateSessionId($file) === false) {
            if (unlink($this->_config['save_path'] . DIRECTORY_SEPARATOR . $file)) {
                $deleted_count++;
            }
        }
    }

    closedir($directory);

    return $deleted_count;
}



	// --------------------------------------------------------------------

	/**
	 * Validate ID
	 *
	 * Checks whether a session ID record exists server-side,
	 * to enforce session.use_strict_mode.
	 *
	 * @param	string	$id
	 * @return	bool
	 */
	public function validateSessionId($id)
	{
		$result = is_file($this->_file_path.$id);
		clearstatcache(TRUE, $this->_file_path.$id);
		return $result;
	}

	// --------------------------------------------------------------------

	/**
	 * Byte-safe strlen()
	 *
	 * @param	string	$str
	 * @return	int
	 */
	protected static function strlen($str)
	{
		return (self::$func_overload)
			? mb_strlen($str, '8bit')
			: strlen($str);
	}
}
