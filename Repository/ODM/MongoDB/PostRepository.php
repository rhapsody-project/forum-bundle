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
use Rhapsody\ForumBundle\Repository\PostRepositoryInterface;
use Rhapsody\ForumBundle\Model\TopicInterface;
use Rhapsody\ForumBundle\Model\PostInterface;

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
class PostRepository extends DocumentRepository implements PostRepositoryInterface
{

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\PostRepositoryInterface::findAllByTopic()
	 */
	public function findAllByTopic($topic)
	{
		$qb = $this->createQueryBuilder()
			->field('topic.$id')->equals(new \MongoId($topic->getId()))
			->sort('created', 'ASC');
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\PostRepositoryInterface::findById()
	 */
	public function findById($id)
	{
		return $this->findOneBy(array('id' => $id));
	}

	public function findPositionByTopicAndPost(TopicInterface $topic, PostInterface $post)
	{
		$qb = $this->createQueryBuilder()
			->field('_id')->lt(new \MongoId($post->getId()))
			->field('topic.$id')->equals(new \MongoId($topic->getId()))
			->sort('created', 'ASC')
			->count();
		$query = $qb->getQuery();
		return $query->execute();
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\PostRepositoryInterface::findOneById()
	 */
	public function findRecentByTopic($topic, $number)
	{
		$qb = $this->createQueryBuilder()
			->field('topic.$id')->equals(new \MongoId($topic->getId()))
			->sort('created', 'DESC')
			->limit((int) $number);
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\PostRepositoryInterface::findAllByTopic()
	 */
	public function getPostCountByTopic($topic)
	{
		$qb = $this->createQueryBuilder()
			->field('topic.$id')->equals(new \MongoId($topic->getId()));
		$query = $qb->getQuery();
		return $query->count();
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\PostRepositoryInterface::search()
	 */
	public function search($query)
	{
		$regexp = new \MongoRegex('/' . $query . '/i');
		$qb = $this->createQueryBuilder()
				->field('message')->equals($regexp)
				->sort('created', 'ASC');
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\PostRepositoryInterface::findOneById()
	 */
	public function getPostBefore($post)
	{
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\PostRepositoryInterface::findOneById()
	 */
	public function createNewPost()
	{

	}
}
