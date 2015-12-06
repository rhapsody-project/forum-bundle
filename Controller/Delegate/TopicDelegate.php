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
namespace Rhapsody\ForumBundle\Controller\Delegate;

use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Rhapsody\ComponentExtensionBundle\Exception\FormExceptionFactory;
use Rhapsody\ForumBundle\Model\ForumInterface;
use Rhapsody\ForumBundle\RhapsodyForumEvents;
use Rhapsody\RestBundle\HttpFoundation\Controller\Delegate;
use Rhapsody\SocialBundle\Controller\Delegate\TopicDelegate as BaseTopicDelegate;
use Rhapsody\SocialBundle\Doctrine\PostManagerInterface;
use Rhapsody\SocialBundle\Doctrine\TopicManagerInterface;
use Rhapsody\SocialBundle\Event\TopicEventBuilder;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Rhapsody\SocialBundle\Model\SocialContextInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Controller\Delegate
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TopicDelegate extends BaseTopicDelegate
{

	public function __construct(TopicManagerInterface $topicManager, PostManagerInterface $postManager)
	{
		parent::__construct($topicManager, $postManager);
	}

	/**
	 * Delegate for rendering the page that allows the user to post a new topic to
	 * the forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param mixed $category Optional. The category for the topic.
	 */
	public function createAction($request, SocialContextInterface $socialContext, $category = null)
	{
		return parent::createAction($request, $socialContext);
	}

	/**
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param string $id The topic identifier.
	 * @throws NotFoundHttpException
	 */
	public function deleteAction(Request $request, ForumInterface $forum, $topicId)
	{
		/** @var $topicManager \Rhapsody\SocialBundle\Doctrine\TopicManagerInterface */
		$topicManager = $this->container->get('rhapsody.forum.doctrine.topic_manager');

		$topic = $topicManager->findById($topicId);
		if (! $topic) {
			throw new NotFoundHttpException(sprintf('No topic found with id "%s"', $topicId));
		}

		$topicManager->remove($topic);
		return $this->createResponseBuilder($view);
	}

	/**
	 * Handles a request for a list of topics, either all topics or those within
	 * a specific category.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *     the request.
	 * @param \RhapsodyForumBundle\Model\ForumInterface $forum
	 *     the forum.
	 * @param string $category
	 *     the category, or <tt>null</tt> for all topics.
	 * @param array $options
	 *     the options.
	 */
	public function listAction(Request $request, SocialContextInterface $socialContext)
	{
		return parent::listAction($request, $socialContext);
	}

	/**
	 * Delegate for posting a new topic to the forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param mixed $category Optional. The category for the topic.
	 */
	public function newAction(Request $request, SocialContextInterface $socialContext)
	{
		return parent::newAction($request, $socialContext);
	}

	/**
	 * Delegate for posting a reply to a topic in a forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param \Rhapsody\SocialBundle\Model\TopicInterface $topic The topic.
	 */
	public function replyAction(Request $request, ForumInterface $forum, TopicInterface $topic)
	{
		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		/** @var $formFactory \Rhapsody\SocialBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('rhapsody_forum.post.form.factory');

		/** @var $post \Rhapsody\SocialBundle\Model\PostInterface */
		$post = $postManager->newPost($topic);
		$form = $formFactory->createForm();
		$form->setData($post);

		$posts = $postManager->findRecentByTopic($topic);

		$view = View::create(array('forum' => $forum,'category' => $topic->getCategory(), 'topic' => $topic, 'post' => $post, 'posts' => $posts, 'form' => $form->createView()))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodyForumBundle:Topic:reply.html.twig');
		return $this->createResponseBuilder($view);
	}

	/**
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param \Rhapsody\SocialBundle\Model\TopicInterface $topic The topic.
	 */
	public function viewAction(Request $request, TopicInterface $topic, $pageSize = 10)
	{
		return parent::viewAction($request, $topic, $pageSize);
	}
}
