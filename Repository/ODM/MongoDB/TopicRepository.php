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
use Rhapsody\ForumBundle\Model\ForumInterface;
use Rhapsody\ForumBundle\Repository\TopicRepositoryInterface;

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
class TopicRepository extends DocumentRepository implements TopicRepositoryInterface
{
	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\TopicRepositoryInterface::findOneById()
	 */
	public function findById($id)
	{
		return $this->find($id);
	}

	public function findBySlug($slug)
	{
		return $this->find(array('slug' => $slug));
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\TopicRepositoryInterface::findOneByCategoryAndSlug()
	 */
	public function findOneByCategoryAndSlug($category, $slug)
	{
		return $this->findOneBy(array(
			'slug' => $slug,
			'category.$id' => new \MongoId($category->getId())
		));
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\TopicRepositoryInterface::findOneById()
	 */
	public function findOneById($id)
	{
		return $this->find($id);
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\TopicRepositoryInterface::findAll()
	 */
	public function findAllByForum(ForumInterface $forum)
	{
		$qb = $this->createQueryBuilder()
			->field('forum.$id')->equals(new \MongoId($forum->getId()))
			->sort('lastUpdated', 'DESC');
		$query = $qb->getQuery();

		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\TopicRepositoryInterface::findAllByCategory()
	 */
	public function findAllByForumAndCategory(ForumInterface $forum, $category)
	{
		$qb = $this->createQueryBuilder('t')
			->field('forum.$id')->equals(new \MongoId($forum->getId()))
			->field('category.$id')->equals(new \MongoId($category->getId()))
			->sort('lastUpdated', 'DESC');
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\TopicRepositoryInterface::findLatestPosted()
	 */
	public function findLatestPosted(ForumInterface $forum, $number)
	{
		$qb = $this->createQueryBuilder()
			->field('forum.$id')->equals(new \MongoId($forum->getId()))
			->sort('lastUpdated', 'DESC')
			->limit($number);
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\TopicRepositoryInterface::search()
	 */
	public function search($query)
	{
		$regexp = new \MongoRegex('/' . $query . '/i');
		$qb = $this->createQueryBuilder()
				->field('subject')->equals($regexp)
				->sort('lastUpdated', 'DESC');
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Repository\TopicRepositoryInterface::incrementTopicNumViews()
	 */
	public function incrementTopicNumViews($topic)
	{
		$this->getDocumentManager()
				->getDocumentCollection($this->getDocumentName())
				->getMongoCollection()
				->update(array('_id' => new \MongoId($topic->getId())), array('$inc' => array('numViews' => 1)));
	}
}
