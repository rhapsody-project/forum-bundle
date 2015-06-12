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
namespace Rhapsody\ForumBundle\Repository\ODM\MongoDB;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Rhapsody\ForumBundle\Repository\CategoryRepositoryInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Repository\ODM\MongoDB
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class CategoryRepository extends DocumentRepository implements CategoryRepositoryInterface
{
	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\CategoryRepositoryInterface::findById()
	 */
	public function findById($id)
	{
		return $this->findOneBy(array('id' => $id));
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\CategoryRepositoryInterface::findOneBySlug()
	 */
	public function findBySlug($slug)
	{
		return $this->findOneBy(array('slug' => $slug));
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\CategoryRepositoryInterface::findOneById()
	 */
	public function findAllByTopic($topic)
	{
		$qb = $this->createQueryBuilder()->sort('position', 'ASC');
		$query = $qb->getQuery();
		return $query->execute()->toArray();
	}

	public function findAll()
	{
		return $this->createQueryBuilder()->sort('position', 'ASC')->getQuery()->execute()->toArray();
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\CategoryRepositoryInterface::findOneById()
	 */
	public function findRecentByTopic($topic, $number)
	{

	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\CategoryRepositoryInterface::findOneById()
	 */
	public function search($query)
	{

	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\CategoryRepositoryInterface::findOneById()
	 */
	public function getPostBefore($post)
	{
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\CategoryRepositoryInterface::findOneById()
	 */
	public function createNewPost()
	{

	}
}
