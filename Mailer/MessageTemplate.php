<?php
/* Copyright (c) 2013 Rhapsody Project
 *
 * Licensed under the MIT License (http://opensource.org/licenses/MIT)
 *
 * Permission is hereby granted, free of charge, to any
 * person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY
 * KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT
 * OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Rhapsody\ForumBundle\Mailer;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Mailer
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class MessageTemplate
{
	private $subject;
	private $senderEmail;
	private $senderName = null;
	private $to;
	private $body;
	private $template;

	public static function newInstance()
	{
		$class = get_called_class();
		return new $class;
	}

	/**
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @return array
	 */
	public function getFrom()
	{
		$from = trim($this->senderEmail);
		if (!empty($this->senderName)) {
			return array($from => $this->senderName);
		}
		return array($from);
	}

	public function getSenderEmail()
	{
		return $this->senderEmail;
	}

	public function getSenderName()
	{
		return $this->senderName;
	}

	/**
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	public function getTemplate()
	{
		return $this->template;
	}

	/**
	 * @return mixed
	 */
	public function getTo()
	{
		return $this->to;
	}

	/**
	 *
	 * @param string $body
	 */
	public function setBody($body)
	{
		$this->body = $body;
		return $this;
	}

	/**
	 *
	 * @param mixed $from
	 */
	public function setFrom($email, $name = null)
	{
		$this->senderEmail = trim($email);
		if (!empty($name)) {
			$this->senderName = trim($name);
		}
		return $this;
	}

	/**
	 *
	 * @param string $subject
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
		return $this;
	}

	public function setTemplate($template)
	{
		$this->template = $template;
		return $this;
	}

	/**
	 *
	 * @param mixed $to
	 */
	public function setTo($to)
	{
		$this->to = $to;
		return $this;
	}
}