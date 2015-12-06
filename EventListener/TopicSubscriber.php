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
namespace Rhapsody\ForumBundle\EventListener;

use Rhapsody\ForumBundle\Doctrine\ForumManagerInterface;
use Rhapsody\ForumBundle\Model\ForumInterface;
use Rhapsody\ForumBundle\RhapsodyForumEvents;
use Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface;
use Rhapsody\SocialBundle\Doctrine\TopicManagerInterface;
use Rhapsody\SocialBundle\Event\TopicEventInterface;
use Rhapsody\SocialBundle\EventListener\AbstractTopicSubscriber;
use Rhapsody\SocialBundle\Factory\TemplateFactoryInterface;
use Rhapsody\SocialBundle\Mailer\MailerInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 *
 * @author    Sean.Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\EventListener
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TopicSubscriber extends AbstractTopicSubscriber
{

	protected $forumManager;

	/**
	 *
	 * @param MailerInterface $mailer
	 * @param UrlGeneratorInterface $router
	 * @param SessionInterface $session
	 */
	public function __construct(
			MailerInterface $mailer,
			UrlGeneratorInterface $router,
			SessionInterface $session,
			TemplateFactoryInterface $templateFactory,
			ActivityManagerInterface $activityManager,
			TopicManagerInterface $topicManager,
			ForumManagerInterface $forumManager)
	{
		parent::__construct($mailer, $router, $session, $templateFactory, $activityManager, $topicManager);
		$this->forumManager = $forumManager;
	}

	public static function getSubscribedEvents()
	{
		return array(
			RhapsodyForumEvents::NEW_TOPIC => array('onNewTopic', 0),
			RhapsodyForumEvents::REPLY_TO_TOPIC => array('onReplyToTopic', 0),
			RhapsodyForumEvents::VIEW_TOPIC => array('onViewTopic', 0),
		);
	}

	/**
	 * Returns the uniform resource location (URL) of the topic.
	 *
	 * @param ForumInterface $forum the forum.
	 * @param TopicInterface $topic the topic.
	 * @return the uniform resource location (URL) of the topic.
	 */
	protected function getTopicUrl(ForumInterface $forum, TopicInterface $topic)
	{
		$route = 'rhapsody_forum_topic_view';
		$url = $this->router->generate($route, array(
			'forum' => $forum->getId(),
			'topic' => $topic->getId()
		), UrlGeneratorInterface::ABSOLUTE_URL);
		return $url;
	}

	public function onNewTopic(TopicEventInterface $event)
	{
		$topic    = $event->getTopic();
		$post     = $event->getPost();
		$author   = $event->getUser();
		$forum    = $topic->getForum();
		$url      = $this->getTopicUrl($forum, $topic);
		$watchers = array(); //$this->forumManager->findFollowers($forum);
		$users    = $this->exclude($watchers, array($author));

		$template = 'RhapsodyForumBundle:Mail:topic_new_email.txt.twig';
		$data = array('author' => $author, 'forum' => $forum, 'topic' => $topic, 'post' => $post, 'url' => $url);
		$this->notify($template, $data, $users);
		$this->generateActivity($forum, $topic, $author);

		$this->forumManager->updateForumActivityStats($forum, $topic, $post);
	}

	/**
	 * Reacts to topic reply events. When a topic is replied to, we want to
	 * update the counts on the topic as well as send emails notifying the
	 * thread participants of a new post.
	 *
	 * @param TopicEventInterface $event
	 */
	public function onReplyToTopic(TopicEventInterface $event)
	{
		$topic    = $event->getTopic();
		$post     = $event->getPost();
		$author   = $event->getUser();
		$forum    = $topic->getForum();
		$url      = $this->getTopicUrl($forum, $topic);
		$watchers = $this->topicManager->findUsersByTopic($topic);
		$users    = $this->exclude($watchers, array($author));

		$template = 'RhapsodyForumBundle:Mail:topic_reply_email.txt.twig';
		$data = array('author' => $author, 'forum' => $forum, 'topic' => $topic, 'post' => $post, 'url' => $url);
		$this->notify($template, $data, $users);
		$this->generateActivity($forum, $post, $author);

		$this->topicManager->updateCounts($topic);
		$this->forumManager->updateForumActivityStats($forum, $topic, $post);
	}

	/**
	 * React to topic viewing by updating the view count.
	 *
	 * @param TopicEventInterface $event
	 */
	public function onViewTopic(TopicEventInterface $event)
	{
		$topic = $event->getTopic();
		$user  = $event->getUser();

		$this->topicManager->markTopicAsViewed($topic, $user);
	}
}
