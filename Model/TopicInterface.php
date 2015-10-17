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
interface TopicInterface
{

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getCreated()
	 */
	function getCreated();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getLastUpdated()
	 */
	function getLastUpdated();

	/**
	 * Returns the post that represents the start of this topic.
	 *
	 * @return PostInterface the post.
	 */
	function getPost();

	/**
	 * Returns the title of the topic thread.
	 * @return string the title of the topic thread.
	 */
	function getTitle();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getType()
	 */
	function getType();

	/**
	 * Returns the number of times the topic has been viewed.
	 *
	 * @return in the number of times the topic has been viewed.
	 */
	function getViewCount();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::isLocked()
	 */
	function isLocked();
}
