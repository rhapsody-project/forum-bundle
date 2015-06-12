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
class Forum implements ForumInterface
{

	/**
	 * The identifier for the forum.
	 * @var mixed
	 * @access protected
	 */
	protected $id;

	/**
	 * The date that the forum was created.
	 * @var \DateTime
	 * @access protected
	 */
	protected $created;

	/**
	 * The description of the forum.
	 * @var string
	 * @access protected
	 */
	protected $description;

	/**
	 * Whether the forum is enabled or not.
	 * @var boolean
	 * @access protected
	 */
	protected $enabled;

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
	 * Constructor for the forum model.
	 */
	public function __construct()
	{
		$this->created = new \DateTime;
		$this->categories = array();
		$this->enabled = true;
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
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getCreated()
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getDescription()
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getId()
	 */
	public function getId()
	{
		return $this->id;
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

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::isEnabled()
	 */
	public function isEnabled()
	{
		return $this->enabled;
	}

	/**
	 * Sets the creation date of the forum.
	 * @param \DateTime $created the creation date.
	 */
	public function setCreated(\DateTime $created)
	{
		$this->created = $created;
	}

	/**
	 * Sets the description of the forum.
	 * @param string $description the description.
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * Sets the enabled status of the forum.
	 * @param boolean $enabled whether to enable or disable the forum.
	 */
	public function setEnabled($enabled)
	{
		$this->enabled = $enabled;
	}

	/**
	 * Sets the identifier of the forum.
	 * @param mixed $id the identifier.
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * Sets the last index date of the forum.
	 * @param \DateTime $lastIndexed the last indexed date.
	 */
	public function setLastIndexed(\DateTime $lastIndexed)
	{
		$this->lastIndexed = $lastIndexed;
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

	/**
	 * Sets the collection of topics on the forum.
	 * @param array $topics the collection of topics.
	 */
	public function setCategories($categories)
	{
		$this->categories = $categories;
	}
}
