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
namespace Rhapsody\ForumBundle\Model;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Model
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class PostRevision
{

	/**
	 * The author of the post.
	 * @var mixed
	 * @access protected
	 */
	protected $author;

	/**
	 * The comment explaining the revision.
	 * @var string
	 * @access protected
	 */
	protected $comment;

	/**
	 * The date and time that this revision was created.
	 * @var \DateTime
	 * @access protected
	 */
	protected $created;


	/**
	 * The text of this post.
	 * @var string
	 * @access protected
	 */
	protected $text;

	public function __construct()
	{
		$this->created = new \DateTime();
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\PostRevisionInterface::getAuthor()
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\PostRevisionInterface::getCreated()
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\PostRevisionInterface::getComment()
	 */
	public function getComment()
	{
		return $this->comment;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\PostRevisionInterface::getText()
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * @param mixed $author
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
	}

	/**
	 * @param \DateTime $created
	 */
	public function setCreated(\DateTime $created)
	{
		$this->created = $created;
	}

	/**
	 * @param string $comment
	*/
	public function setComment($comment)
	{
		$this->comment = $comment;
	}

	/**
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->text = $text;
	}
}
