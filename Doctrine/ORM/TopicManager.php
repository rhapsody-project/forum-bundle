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
namespace Rhapsody\ForumBundle\Doctrine\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Monolog\Logger;
use Rhapsody\ForumBundle\Doctrine\TopicManagerInterface;
use Rhapsody\ForumBundle\Factory\BuilderFactoryInterface;
use Rhapsody\ForumBundle\Model\TopicInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Doctrine\ODM\MongoDB
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TopicManager implements TopicManagerInterface
{
	/**
	 * Whether or not to automatically flush changes after a persistence
	 * operation is performed.
	 * @var boolean
	 * @access protected
	 */
	protected $autoFlush = true;

	/**
	 * The logging device.
	 * @var \Monolog\Logger
	 * @access protected
	 */
	protected $logger;

	/**
	 * The event dispatcher.
	 * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
	 * @access protected
	 */
	protected $eventDispatcher;

	/**
	 * The object manager.
	 * @var \Doctrine\Common\Persistence\ObjectManager
	 * @access protected
	 */
	protected $objectManager;

	/**
	 * The repository.
	 * @var \Doctrine\ODM\MongoDB\DocumentRepository
	 * @access protected
	 */
	protected $repository;

	/**
	 * The class builder factory.
	 * @var \Rhapsody\ForumBundle\Factory\BuilderFactoryInterface
	 * @access protected
	 */
	protected $builderFactory;

	/**
	 * The class.
	 * @var string
	 * @access protected
	 */
	protected $class;

	public function __construct(ObjectManager $objectManager, EventDispatcherInterface $eventDispatcher, BuilderFactoryInterface $builderFactory, $class)
	{
		$repository = $objectManager->getRepository($class);
		$metadata = $objectManager->getClassMetadata($class);

		$this->class = $metadata->getName();
		$this->repository = $repository;
		$this->eventDispatcher = $eventDispatcher;
		$this->objectManager = $objectManager;
		$this->builderFactory = $builderFactory;

		$this->logger = new Logger(get_class($this));
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\ForumBundle\Doctrine\TopicManagerInterface::createTopicBuilder()
	 */
	public function createTopicBuilder()
	{
		return $this->topicBuilderFactory->create();
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\ForumBundle\Doctrine\TopicManagerInterface::findBySlug()
	 */
	public function findBySlug($slug)
	{
			return $this->repository->findBySlug($slug);
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\ForumBundle\Doctrine\TopicManagerInterface::findAll()
	 */
	public function findAll()
	{
		return $this->repository->findAllTopics();
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\ForumBundle\Doctrine\TopicManagerInterface::findAll()
	 */
	public function findAllByCategory($category)
	{
		return $this->repository->findAllByCategory($category);
	}

	/**
	 *
	 */
	public function remove(TopicInterface $topic, $andFlush = true)
	{
		$category = $topic->getCategory();

		$this->logger->debug(sprintf('Removing all posts associated with topic: %s.', $topic->getId()));
		$posts = $this->TopicManager->findAllByTopic($topic);
		$this->TopicManager->removeAll($posts);

		$this->logger->debug(sprintf('Removing topic: %s.', $topic->getId()));
		$this->objectManager->remove($topic);
		if ($andFlush) {
			$this->objectManager->flush();
			//$this->categoryUpdater->update($category);
		}
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\ForumBundle\Doctrine\TopicManagerInterface::search()
	 */
	public function search($query, $paginate = true)
	{
		return $this->repository->search($query, $paginate);
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\ForumBundle\Doctrine\TopicManagerInterface::update()
	 */
	public function update(TopicInterface $topic, $andFlush = true)
	{
		$this->objectManager->persist($topic);
		if ($andFlush) {
			$this->objectManager->flush();
		}
	}

}
