<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Http\Response;

use Psr\Http\Message\StreamInterface;
use Windwalker\Http\Response\Response;
use Windwalker\Http\Stream\Stream;
use Windwalker\Http\Stream\StringStream;

/**
 * The HtmlResponse class.
 *
 * @since  {DEPLOY_VERSION}
 */
class JsonResponse extends TextResponse
{
	/**
	 * Content type.
	 *
	 * @var  string
	 */
	protected $type = 'application/json';

	/**
	 * Constructor.
	 *
	 * @param  string  $json     The JSON body data.
	 * @param  int     $status   The status code.
	 * @param  array   $headers  The custom headers.
	 */
	public function __construct($json = '', $status = 200, array $headers = array(), $options = 0)
	{
		parent::__construct(
			$this->encode($json, $options),
			$status,
			$headers
		);
	}

	/**
	 * Encode json.
	 *
	 * @param   mixed $data     The dat to convert.
	 * @param   int   $options  The json_encode() options flag.
	 *
	 * @return  string  Encoded json.
	 */
	protected function encode($data, $options = 0)
	{
		// Check is already json string.
		if (is_string($data) && strlen($data) >= 1)
		{
			$firstChar = $data[0];

			if (in_array($firstChar, array('[', '{', '"')))
			{
				return $data;
			}
		}

		// Clear json_last_error()
		json_encode(null);

		$json = json_encode($data, $options);

		if (json_last_error() !== JSON_ERROR_NONE)
		{
			throw new \UnexpectedValueException(sprintf('JSON encode failure: %s', json_last_error_msg()));
		}

		return $json;
	}
}
