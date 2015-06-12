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

use Rhapsody\Commons\Web\SlugInflector;

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
class Category implements CategoryInterface
{

	/**
	 * The identifier for the category.
	 * @var mixed
	 * @access protected
	 */
	protected $id;

	/**
	 * The date that the category was created.
	 * @var \DateTime
	 * @access protected
	 */
	protected $created;

	/**
	 * The description of the category.
	 * @var string
	 * @access protected
	 */
	protected $description;

	/**
	 * When the category was last indexed; when a forum is indexed statistical
	 * data such as number of posts and number of topics is updated.
	 * @var \DateTime
	 * @access protected
	 */
	protected $lastIndexed;

	/**
	 * The name of the forum.
	 * @var string
	 * @access protected
	 */
	protected $name;

	/**
	 * The display order of the category, with relation to its siblings. A
	 * category with a lower order value will display before categories with
	 * higher order values.
	 * @var int
	 * @access protected
	 */
	protected $order;

	/**
	 * The privacy flag for the category.
	 * @var string
	 * @access protected
	 */
	protected $privacy = CategoryInterface::CATEGORY_PRIVACY_PUBLIC;

	/**
	 * The collection of tags that define this category.
	 * @var array
	 * @access protected
	 */
	protected $tags = array();

	/**
	 * The collection of topics in this category.
	 * @var array
	 * @access protected
	 */
	protected $topics = array();

	/**
	 * Constructor for the forum model.
	 */
	public function __construct()
	{
		$this->created = new \DateTime;
		$this->lastIndexed = new \DateTime;
		$this->tags = array();
		$this->topics = array();
	}

	/**
	 * Generates the slug whether it is empty
	 */
	public function generateSlug()
	{
		if (empty($this->slug)) {
			$inflector = SlugInflector::getInstance();
			$this->slug = $inflector->inflect($this->getName());
		}
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\CategoryInterface::getCreated()
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\CategoryInterface::getDescription()
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\CategoryInterface::getId()
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\CategoryInterface::getLastIndexed()
	 */
	public function getLastIndexed()
	{
		return $this->lastIndexed;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\CategoryInterface::getName()
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\CategoryInterface::getOrder()
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\CategoryInterface::getPrivacy()
	 */
	public function getPrivacy()
	{
		return $this->privacy;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\CategoryInterface::getTags()
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\CategoryInterface::getTopics()
	 */
	public function getTopics()
	{
		return $this->topics;
	}

	/**
	 * Sets the creation date of the category.
	 * @param \DateTime $created the creation date.
	 */
	public function setCreated(\DateTime $created)
	{
		$this->created = $created;
	}

	/**
	 * Sets the description of the category.
	 * @param string $description the description.
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * Sets the identifier of the category.
	 * @param mixed $id the identifier.
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * Sets the last index date of the category.
	 * @param \DateTime $lastIndexed the last indexed date.
	 */
	public function setLastIndexed(\DateTime $lastIndexed)
	{
		$this->lastIndexed = $lastIndexed;
	}

	/**
	 * Sets the creation date of the category.
	 * @param \DateTime $created the creation date.
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Sets the numerical ordering of the category for sort algorithms. A lower
	 * value gives higher priority to the category, and therefore displays it
	 * higher in the list of categories.
	 *
	 * @param int $order the order to display the category in.
	 */
	public function setOrder($order)
	{
		$this->order = $order;
	}

	/**
	 * Sets the privacy of the category.
	 * @param string $privacy the privacy.
	 */
	public function setPrivacy($privacy)
	{
		$this->privacy = $privacy;
	}

	/**
	 * Sets the tags of the category.
	 * @param array $tags the forum's tags.
	 */
	public function setTags($tags)
	{
		$this->tags = $tags;
	}

	/**
	 * Sets the collection of topics on the category.
	 * @param array $topics the collection of topics.
	 */
	public function setTopics($topics)
	{
		$this->topics = $topics;
	}
}
