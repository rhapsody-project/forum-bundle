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

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\RouteRedirectView;
use JMS\Serializer\SerializationContext;
use Rhapsody\ComponentExtensionBundle\Exception\FormExceptionFactory;
use Rhapsody\ForumBundle\Event\TopicEvent;
use Rhapsody\ForumBundle\Form\Type\TopicForm;
use Rhapsody\ForumBundle\Model\CategoryInterface;
use Rhapsody\ForumBundle\Model\ForumInterface;
use Rhapsody\ForumBundle\Model\TopicInterface;
use Rhapsody\ForumBundle\RhapsodyForumEvents;
use Rhapsody\RestBundle\HttpFoundation\Controller\Delegate;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

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
class TopicDelegate extends Delegate
{

	/**
	 * Delegate for rendering the page that allows the user to post a new topic to
	 * the forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param mixed $category Optional. The category for the topic.
	 */
	public function createAction($request, $forum, $category = null)
	{
		/** @var $topicManager \Rhapsody\ForumBundle\Doctrine\TopicManagerInterface */
		$topicManager = $this->container->get('rhapsody.forum.doctrine.topic_manager');

		/** @var $formFactory \Rhapsody\ForumBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('rhapsody_forum.topic.form.factory');

		/** @var $user \Symfony\Component\Security\Core\User\UserInterface */
		$user = $this->getUser();

		/** @var $topic \Rhapsody\ForumBundle\Model\TopicInterface */
		$topic = $topicManager->newTopic($forum, $category);
		$form = $formFactory->createForm();
		$form->setData($topic);
		$form->handleRequest($request);
		$data = $form->getData();

		if (!$form->isValid()) {
			$view = View::create(array('forum' => $forum, 'category' => $category,'topic' => $data, 'form' => $form->createView()))
				->setFormat($request->getRequestFormat('html'))
				->setSerializationContext(SerializationContext::create()->setGroups('context'))
				->setTemplate('RhapsodyForumBundle:Topic:new.html.twig');
			throw FormExceptionFactory::create('The form is invalid.')->setForm($form)->setView($view)->build();
		}

		$post = $form->get('post')->getData();

		$topicManager->createTopic($data, $post, $user);

		$this->container->get('session')->getFlashBag()->add('success', 'rhapsody.forum.topic.created');
		$view = RouteRedirectView::create('rhapsody_forum_topic_view', array('forum' => $forum->getId(), 'category' => $category, 'topic' => $data->getId()))
			->setFormat($request->getRequestFormat('html'));
		return $this->createResponseBuilder($view);
	}

	/**
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param string $id The topic identifier.
	 * @throws NotFoundHttpException
	 */
	public function deleteAction(Request $request, ForumInterface $forum, $topicId)
	{
		/** @var $topicManager \Rhapsody\ForumBundle\Doctrine\TopicManagerInterface */
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
	public function listAction(Request $request, ForumInterface $forum)
	{
		/** @var $paginator \Knp\Components\Pager\Paginator */
		$paginator = $this->container->get('knp_paginator');

		/** @var $topicManager \Rhapsody\ForumBundle\Doctrine\TopicManagerInterface */
		$topicManager = $this->container->get('rhapsody.forum.doctrine.topic_manager');

		$page = $request->query->get('page', 1);
		$topics = $topicManager->findAll();

		$pagination = $paginator->paginate($topics, $page, $this->container->getParameter('rhapsody_forum.pagination.topics_per_page'));

		$view = View::create(array('topics' => $pagination, 'page' => $page))
			->setFormat($request->getRequestFormat('html'))
			->setTemplate('RhapsodyForumBundle:Topic:list.html.twig');
		return $this->createResponseBuilder($view);
	}

	/**
	 * Delegate for posting a new topic to the forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param mixed $category Optional. The category for the topic.
	 */
	public function newAction(Request $request, $forum, $category = null)
	{
		/** @var $topicManager \Rhapsody\ForumBundle\Doctrine\TopicManagerInterface */
		$topicManager = $this->container->get('rhapsody.forum.doctrine.topic_manager');

		/** @var $formFactory \Rhapsody\ForumBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('rhapsody_forum.topic.form.factory');

		/** @var $topic \Rhapsody\ForumBundle\Model\TopicInterface */
		$topic = $topicManager->newTopic($forum, $category);
		$form = $formFactory->createForm();
		$form->setData($topic);

		$view = View::create(array('forum' => $forum,'category' => $category, 'topic' => $topic,'form' => $form->createView()))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodyForumBundle:Topic:new.html.twig');
		return $this->createResponseBuilder($view);
	}

	/**
	 * Delegate for posting a reply to a topic in a forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\ForumBundle\Model\ForumInterface $forum The forum.
	 * @param \Rhapsody\ForumBundle\Model\TopicInterface $topic The topic.
	 */
	public function replyAction(Request $request, ForumInterface $forum, TopicInterface $topic)
	{
		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		/** @var $formFactory \Rhapsody\ForumBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('rhapsody_forum.post.form.factory');

		/** @var $post \Rhapsody\ForumBundle\Model\PostInterface */
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
	 * @param \Rhapsody\ForumBundle\Model\TopicInterface $topic The topic.
	 */
	public function viewAction(Request $request, ForumInterface $forum, $topicId)
	{
		/** @var $eventDispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
		$eventDispatcher = $this->container->get('event_dispatcher');

		/** @var $topicManager \Rhapsody\ForumBundle\Doctrine\TopicManagerInterface */
		$topicManager = $this->container->get('rhapsody.forum.doctrine.topic_manager');

		/** @var $topicManager \Rhapsody\ForumBundle\Doctrine\TopicManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		/** @var $paginator \Knp\Components\Pager\Paginator */
		$paginator = $this->get('knp_paginator');

		try {
			$page = $request->query->get('page', 1);
			$_topic = $topicManager->findById($topicId);
			$_posts = $postManager->findAllByTopic($_topic);

			// ** Trigger the view of the topic, to update statistics, etc.
			$eventDispatcher->dispatch(RhapsodyForumEvents::VIEW_TOPIC, new TopicEvent($_topic));

			// ** Paginate the posts, we don't want to return too many.
			$paginatedPosts = $paginator->paginate($_posts, $page, $this->container->getParameter('rhapsody_forum.pagination.posts_per_page'));

			$view = View::create(array('topic' => $_topic,'page' => $page,'posts' => $paginatedPosts))
				->setFormat($request->getRequestFormat('html'))
				->setSerializationContext(SerializationContext::create()->setGroups('context'))
				->setTemplate('LorecallChronicleBundle:Topic:view.html.twig');
			return $this->createResponseBuilder($view);
		}
		catch ( \Exception $ex ) {
			throw $ex;
		}
	}
}
