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
use Rhapsody\ForumBundle\Model\ForumInterface;
use Rhapsody\ForumBundle\RhapsodyForumEvents;
use Rhapsody\RestBundle\HttpFoundation\Controller\Delegate;
use Rhapsody\SocialBundle\Controller\Delegate\PostDelegate as BasePostDelegate;
use Rhapsody\SocialBundle\Doctrine\PostManagerInterface;
use Rhapsody\SocialBundle\Doctrine\TopicManagerInterface;
use Rhapsody\SocialBundle\Event\TopicEventBuilder;
use Rhapsody\SocialBundle\Model\PostInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
class PostDelegate extends BasePostDelegate
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
	public function createAction(Request $request, TopicInterface $topic)
	{
		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		/** @var $postManager \Rhapsody\SocialBundle\Doctrine\TopicManagerInterface */
		$topicManager = $this->container->get('rhapsody.forum.doctrine.topic_manager');

		/** @var $formFactory \Rhapsody\SocialBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('rhapsody_forum.post.form.factory');

		/** @var $user \Symfony\Component\Security\Core\User\UserInterface */
		$user = $this->getUser();

		/** @var $topic \Rhapsody\SocialBundle\Model\TopicInterface */
		$post = $postManager->newPost($topic);
		$form = $formFactory->createForm();
		$form->setData($post);
		$form->handleRequest($request);
		$data = $form->getData();

		if (!$form->isValid()) {
			$view = View::create(array('forum' => $forum, 'topic' => $topic, 'post' => $data, 'form' => $form->createView()))
				->setFormat($request->getRequestFormat('html'))
				->setSerializationContext(SerializationContext::create()->setGroups('context'))
				->setTemplate('RhapsodyForumBundle:Topic:reply.html.twig');
			throw FormExceptionFactory::create('The form is invalid.')->setForm($form)->setView($view)->build();
		}

		$post = $postManager->createPost($data, $topic, $user);

		$topic->setLastUpdated($post->getCreated());
		$topic->setLastPost($data);
		$topicManager->update($topic);

		try {
			$topicEventBuilder = TopicEventBuilder::create()
				->setTopic($topic)
				->setPost($post)
				->setUser($post->author);
			$event = $topicEventBuilder->build();

			$eventDispatcher = $this->container->get('event_dispatcher');
			$eventDispatcher->dispatch(RhapsodyForumEvents::REPLY_TO_TOPIC, $event);
		}
		catch (\Exception $ex) {
			throw $ex;
		}

		$this->container->get('session')->getFlashBag()->add('success', 'rhapsody.forum.post.created');
		$view = RouteRedirectView::create('rhapsody_forum_topic_view', array('topic' => $topic->id, 'post' => $post->id))
			->setFormat($request->getRequestFormat('html'));
		return $this->createResponseBuilder($view);
	}

	public function deleteAction(Request $request, $postId)
	{
		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		$post = $postManager->findById($postId);
		if (!$topic) {
			throw new NotFoundHttpException(sprintf('No post found with id "%s"', $postId));
		}

		$postManager->remove($post);
		//event dispatcher for deleted post?

		$view = RouteRedirectView::create('rhapsody_forum_topic_view', array('topic' => $topic->id))
			->setFormat($request->getRequestFormat('html'));
		return $this->createResponseBuilder($view);
	}

	/**
	 * Delegate for rendering the page that allows the user to post a new topic to
	 * the forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param mixed $category Optional. The category for the topic.
	 */
	public function editAction(Request $request, TopicInterface $topic, PostInterface $post)
	{
		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		/** @var $formFactory \Rhapsody\SocialBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('rhapsody_forum.post.form.factory');
		$form = $formFactory->createForm();
		$form->setData($post);

		$view = View::create(array('topic' => $topic, 'post' => $post, 'form' => $form->createView()))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodyForumBundle:Post:edit.html.twig');
		return $this->createResponseBuilder($view);
	}

	/**
	 * Delegate for rendering the page that allows the user to post a new topic to
	 * the forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param mixed $category Optional. The category for the topic.
	 */
	public function saveAction(Request $request, TopicInterface $topic, PostInterface $post)
	{
		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		/** @var $formFactory \Rhapsody\SocialBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('rhapsody_forum.post.form.factory');

		/** @var $user \Symfony\Component\Security\Core\User\UserInterface */
		$user = $this->getUser();

		/** @var $topic \Rhapsody\SocialBundle\Model\TopicInterface */
		$form = $formFactory->createForm();
		$form->setData($post);
		$form->handleRequest($request);
		$data = $form->getData();

		if (!$form->isValid()) {
			$view = View::create(array('topic' => $topic, 'post' => $data, 'form' => $form->createView()))
				->setFormat($request->getRequestFormat('html'))
				->setSerializationContext(SerializationContext::create()->setGroups('context'))
				->setTemplate('RhapsodyForumBundle:Topic:reply.html.twig');
			throw FormExceptionFactory::create('The form is invalid.')->setForm($form)->setView($view)->build();
		}

		$data->editCount += 1;
		$data->lastUpdated = new \DateTime;
		$postManager->update($data);

		$this->container->get('session')->getFlashBag()->add('success', 'rhapsody.forum.post.created');
		$view = RouteRedirectView::create('rhapsody_forum_topic_view', array('topic' => $topic->id, 'post' => $data->id))
			->setFormat($request->getRequestFormat('html'));
		return $this->createResponseBuilder($view);
	}

	/**
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param mixed $category Optional. The category for the topic.
	 * @param mixed $topic
	 */
	public function viewAction($request, $forum, $topic, $category = null)
	{
		throw new \Exception('Not yet implemented');
	}
}
