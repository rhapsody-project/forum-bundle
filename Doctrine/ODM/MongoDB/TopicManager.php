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
namespace Rhapsody\ForumBundle\Doctrine\ODM\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Monolog\Logger;
use Rhapsody\ForumBundle\Model\ForumInterface;
use Rhapsody\SocialBundle\Doctrine\ODM\MongoDB\TopicManager as BaseTopicManager;
use Rhapsody\SocialBundle\Doctrine\PostManagerInterface;
use Rhapsody\SocialBundle\Event\TopicEventBuilder;
use Rhapsody\SocialBundle\Factory\BuilderFactoryInterface;
use Rhapsody\SocialBundle\Form\Factory\FactoryInterface;
use Rhapsody\SocialBundle\Model\PostInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Rhapsody\ForumBundle\RhapsodyForumEvents;

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
class TopicManager extends BaseTopicManager
{

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\TopicManager::__construct()
	 */
	public function __construct(
			ObjectManager $objectManager,
			EventDispatcherInterface $eventDispatcher,
			BuilderFactoryInterface $builderFactory,
			FactoryInterface $formFactory,
			PostManagerInterface $postManager,
			$class)
	{
		parent::__construct($objectManager, $eventDispatcher, $builderFactory, $formFactory, $postManager, $class);
		$this->logger = new Logger(get_class($this));
	}

	public function createTopic(TopicInterface $topic, PostInterface $post, $user)
	{
		$topic = parent::createTopic($topic, $post, $user);
		try {
			$topicEventBuilder = TopicEventBuilder::create()
				->setTopic($topic)
				->setPost($post)
				->setUser($user);
			$event = $topicEventBuilder->build();
			$this->eventDispatcher->dispatch(RhapsodyForumEvents::NEW_TOPIC, $event);
		}
		catch (\Exception $ex) {
			//$this->logger->error("An error occurred while trying ")
			throw $ex;
		}
		return $topic;
	}

	public function findByForumAndId(ForumInterface $forum, $id)
	{
		return $this->repository->findOneByForumAndId($forum, $id);
	}

	public function getTopicCountByForum(ForumInterface $forum)
	{
		return $this->repository->getTopicCountByForum($forum);
	}
}
