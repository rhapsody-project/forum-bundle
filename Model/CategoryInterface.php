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
interface CategoryInterface
{
	/* The category is marked as a "private"" category. */
	const CATEGORY_PRIVACY_PRIVATE = 'forum.category.privacy.private';

	/* The category is marked as a "public" category. */
	const CATEGORY_PRIVACY_PUBLIC = 'forum.category.privacy.public';

	/**
	 * Generates a slug that is appropriate for this forum.
	 * @return string the slug.
	 */
	function generateSlug();


	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getCreated()
	 */
	function getCreated();


	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getDescription()
	 */
	function getDescription();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getId()
	 */
	function getId();

	/**
	 * Returns the last indexed date of the forum.
	 * @return \DateTime the last indexed date.
	 */
	function getLastIndexed();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getName()
	 */
	function getName();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getOrder()
	 */
	function getOrder();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getPrivacy()
	 */
	function getPrivacy();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getTags()
	 */
	function getTags();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumInterface::getTopics()
	 */
	function getTopics();

}
