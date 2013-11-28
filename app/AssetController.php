<?php
namespace CTV;


use \Exception;

//Vendor Libraries
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * An Asset is a file that is served by the web app, such as an image, a CSS file, a JS file, or other.
 */
class AssetController {

	private $template;

	private $app;
	private $path;
	private $filename;
	private $content_type;

	/**
	 *
	 *
	 * @return mixed
	 */
	protected function retrieve() {
		$this->filename = trim($this->filename, '/');

		try {
			$qualifiedFilename = $this->templatize($this->filename, $this->path);
			$stream = $this->getStream($qualifiedFilename);

			//TODO: Try to figure out if a 304 is possible.
			//	header('HTTP/1.1 304 Not Modified', true, 304);
			//Need to use 304 here, to tell browser to cache.
			return $this->app->stream($stream, 200, array('Content-Type' => $this->content_type,
			                                        'Cache-Control' => 's-maxage=3600, public'));

		} catch (Exception $e) {
			if (!IN_PRODUCTION) {
				$url = FALLBACK_URL . $this->path . '/' . $this->filename;
				logger('File not found... falling back to ' . $url, 'warning');
				$stream = $this->getStream($url);
				return $this->app->stream($stream, 200, array('Content-type' => $this->content_type));
			} else {
				return $this->app->abort(404, 'File not be found.');
			}
		}


	}

	public function serveCSS(Application $app, $path = '', $filename = '') {
		logger('serveCSS(path = ' . $path . ', filename = ' . $filename .')', 'debug');

		$this->app = $app;
		$this->path = $path;
		$this->filename = $filename;
		$this->content_type = 'text/css';
		return $this->retrieve();
	}

	public function serveJavascript(Application $app, $path = '', $filename = '') {
		logger('serveJavascript(path = ' . $path . ', filename = ' . $filename .')', 'debug');

		$this->app = $app;
		$this->path = $path;
		$this->filename = $filename;
		$this->content_type = 'text/javascript';
		return $this->retrieve();
	}

	public function serveImage(Request $request, Application $app, $path = '', $filename = '') {
		logger('serveImage(path = ' . $path . ', filename = ' . $filename .')', 'debug');

		$this->app = $app;
		$this->path = $path;
		$this->filename = $filename;

		if (preg_match('/.png/i', $filename)) {
			$this->content_type = 'image/png';
		} else if (preg_match('/.gif/i', $filename)) {
			$this->content_type = 'image/gif';
		} else if (preg_match('/.jp[e]g/i', $filename)) {
			$this->content_type = 'image/jpeg';
		} else {
			$this->content_type = null;
		}

		return $this->retrieve();
	}

	/**
	 * Serves the 'favicon.ico' file.
	 */
	public function serveFavicon(Application $app) {
		$stream = function() {
			readfile(PUBLIC_DIRECTORY.'favicon.ico');
		};
		return $app->stream($stream, 200, array('Content-Type' => 'image/x-icon'));
	}

	/**
	 * Returns a callback function which will stream data from a URL.
	 * @param $url
	 *
	 * @return callable
	 */
	function getStream($url) {
		$stream = function () use ($url) {
			logger('Attempting to stream from location: ' . $url, 'info');
			try {
			$fh = fopen($url, 'rb');
			while (!feof($fh)) {
				echo fread($fh, 1024);
				ob_flush();
				flush();
			}
			fclose($fh);
			} catch (Exception $e) {
				logger('Unable to locate file to stream from: ' . $url, 'error');
			}
		};
		return $stream;
	}



}

