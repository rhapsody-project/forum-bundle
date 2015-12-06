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

use Rhapsody\SocialBundle\Model\ActivitySourceInterface;
use Rhapsody\SocialBundle\Model\SocialContext;

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
class Forum extends SocialContext implements ForumInterface, ActivitySourceInterface
{

	/**
	 * The description of the forum.
	 * @var string
	 * @access protected
	 */
	protected $description;

	/**
	 * The last topic posted to the forum.
	 * @var TopicInterface $lastTopic
	 */
	protected $lastTopic;

	/**
	 * The name of the forum.
	 * @var string
	 * @access protected
	 */
	protected $name;

	/**
	 * The display order of the forum, with relation to its siblings. A
	 * forum with a lower order value will display before forums with higher
	 * order values.
	 * @var int
	 * @access protected
	 */
	protected $order;

	/**
	 * The collection of categories in this forum.
	 * @var array
	 * @access protected
	 */
	protected $categories = array();

	/**
	 * The number of topics in the forum.
	 * @var number $topicCount
	 */
	protected $topicCount;

	/**
	 * Constructor for the forum model.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->categories = array();
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getCategories()
	 */
	public function getCategories()
	{
		return $this->categories;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getDescription()
	 */
	public function getDescription()
	{
		return $this->description;
	}

	public function getLastTopic()
	{
		return $this->lastTopic;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getName()
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getOrder()
	 */
	public function getOrder()
	{
		return $this->order;
	}

	public function getTopicCount()
	{
		return $this->topicCount;
	}

	/**
	 * Sets the collection of topics on the forum.
	 * @param array $topics the collection of topics.
	 */
	public function setCategories($categories)
	{
		$this->categories = $categories;
	}

	/**
	 * Sets the description of the forum.
	 * @param string $description the description.
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function setLastTopic($topic)
	{
		$this->lastTopic = $topic;
	}

	/**
	 * Sets the creation date of the forum.
	 * @param \DateTime $created the creation date.
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Sets the numerical ordering of the forum for sort algorithms. A lower
	 * value gives higher priority to the forum, and therefore displays it
	 * higher in the list of categories.
	 *
	 * @param int $order the order to display the forum in.
	 */
	public function setOrder($order)
	{
		$this->order = $order;
	}

	public function setTopicCount($topicCount)
	{
		$this->topicCount = $topicCount;
	}
}
