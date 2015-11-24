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

use Rhapsody\ForumBundle\RhapsodyForumEvents;
use Rhapsody\SocialBundle\Doctrine\TopicManagerInterface;
use Rhapsody\SocialBundle\Event\TopicEventInterface;
use Rhapsody\SocialBundle\Factory\TemplateFactoryInterface;
use Rhapsody\SocialBundle\Mailer\EmailTemplate;
use Rhapsody\SocialBundle\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface;

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
class TopicSubscriber implements EventSubscriberInterface
{

	private $mailer;
	private $router;
	private $session;

	/**
	 * The {@link ActivityManager}
	 * @var \Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface
	 */
	private $activityManager;

	private $auditManager;

	/**
	 * The {@link TemplateFactory}.
	 * @var \Rhapsody\SocialBundle\Factory\TemplateFactoryInterface
	 */
	private $templateFactory;

	/**
	 * The {@link TopicManager}.
	 * @var \Rhapsody\SocialBundle\Doctrine\TopicManagerInterface
	 */
	private $topicManager;

	protected $senderEmail = 'noreply@lorecall.com';
	protected $senderName = 'Lorecall';

	/**
	 *
	 * @param MailerInterface $mailer
	 * @param UrlGeneratorInterface $router
	 * @param SessionInterface $session
	 */
	public function __construct(MailerInterface $mailer, UrlGeneratorInterface $router, SessionInterface $session, ActivityManagerInterface $activityManager, TopicManagerInterface $topicManager, TemplateFactoryInterface $templateFactory)
	{
		$this->mailer = $mailer;
		$this->router = $router;
		$this->session = $session;
		$this->activityManager = $activityManager;
		$this->topicManager = $topicManager;
		$this->templateFactory = $templateFactory;
	}

	public static function getSubscribedEvents()
	{
		return array(
			RhapsodyForumEvents::NEW_TOPIC => array('onNewTopic', 0),
			RhapsodyForumEvents::REPLY_TO_TOPIC => array('onReplyToTopic', 0),
			RhapsodyForumEvents::VIEW_TOPIC => array('onViewTopic', 0),
		);
	}

	public function onNewTopic(TopicEventInterface $event)
	{
		/** @var $topic \Rhapsody\SocialBundle\Model\TopicInterface */
		$topic  = $event->getTopic();

		/** @var $author \Symfony\Component\Security\Core\User\UserInterface */
		$author = $event->getUser();

		/** @var $forum \Rhapsody\SocialBundle\Model\ForumInterface */
		$forum  = $topic->getForum();

		// 1. Look up users "watching" the forum. (not yet implemented)
		// 2. Inform all of the watchers, sans author, that a new topic has been created.

		$activity= $this->activityManager->newActivity(array(
			'content' => $topic,
			'source' => $forum,
			'author' => $author,
			'user' => null,
		));
		$this->activityManager->updateActivity($activity);
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
		/** @var $topic \Rhapsody\SocialBundle\Model\TopicInterface */
		$topic  = $event->getTopic();

		/** @var $post \Rhapsody\SocialBundle\Model\PostInterface */
		$post   = $event->getPost();

		/** @var $author \Symfony\Component\Security\Core\User\UserInterface */
		$author = $event->getUser();

		// ** Count the number of posts and replies for a given topic.
		$this->topicManager->updateCounts($topic);

		// ** The URL for viewing the forum post.
		$url = $this->router->generate('rhapsody_forum_topic_view', array(
				'topic' => $topic->getId(),
		), UrlGeneratorInterface::ABSOLUTE_URL);

		$users  = $this->topicManager->findUsersByTopic($topic);
		foreach ($users as $user) {
			// **
			// Only send the comment email to people OTHER THAN the person who
			// actually posted the comment. Why do they need to know they posted
			// a comment? They already do! They just posted it! [SWQ]
			if ($user->getId() !== $author->getId()) {
				/** @var $user \Symfony\Component\Security\Core\User\UserInterface */
				$email = $user->email;
				if (!empty($email)) {
					$data = array(
							'author' => $author,
							'topic'  => $topic,
							'post'   => $post,
							'url'    => $url,
							'user'   => $user,
					);

					/** @var $message \Application\LorecallBundle\Model\Messaging\MessageTemplate */
					$message = EmailTemplate::newInstance()
						->setTemplate($this->templateFactory->getTopicReplyEmailTemplate())
						->setTo($email)
						->setFrom($this->senderEmail, $this->senderName);
					$this->mailer->sendMessage($message, $data);
				}
			}
		}
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
