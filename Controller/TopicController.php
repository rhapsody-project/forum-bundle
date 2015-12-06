<?php
/*
 * Copyright (c) 2013 Rhapsody Project
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
namespace Rhapsody\ForumBundle\Controller;

use Rhapsody\ForumBundle\RhapsodyForumEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Controller
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TopicController extends Controller
{

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function createAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\ForumDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.topic_delegate');

		/** @var $forumManager \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->get('rhapsody.forum.doctrine.forum_manager');

		$forum = $forumManager->findById($request->attributes->get('forum'));
		list($topic, $post, $response) = $delegate->createAction($request, $forum);
		return $response
			->setRoute('rhapsody_forum_topic_view')
			->mergeRouteParameters(array('forum' => $forum->id))
			->render();
	}

	/**
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @return \Symfony\Component\HttpFoundation\Response the Response.
	 */
	public function deleteAction(Request $request)
	{
		/** @var $topicManager \Rhapsody\SocialBundle\Doctrine\TopicManagerInterface	 */
		$topicManager = $this->get('rhapsody.forum.doctrine.topic_manager');

		/** @var $forumManager \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->get('rhapsody.forum.doctrine.forum_manager');

		/** @var $forum \Rhapsody\ForumBundle\Model\ForumInterface */
		$forum = $forumManager->findById($request->attributes->get('forum'));
		$response = $delegate->deleteAction($request, $forum, $request->attributes->get('topic'));
		return $response->render();
	}

	/**
	 * Handles a request for a list of topics, either all topics or those within
	 * a specific category.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request the request.
	 * @param string $category the category, or <tt>null</tt> for all topics.
	 * @param array $options the options.
	 */
	public function listAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\ForumDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.topic_delegate');

		/** @var $forumManager \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->get('rhapsody.forum.doctrine.forum_manager');

		/** @var $forum \Rhapsody\ForumBundle\Model\ForumInterface */
		$forum = $forumManager->findById($request->attributes->get('forum'));
		list($topics, $response) = $delegate->listAction($request, $forum);
		return $response
			->mergeData(array('forum' => $forum))
			->setTemplate('RhapsodyForumBundle:Topic:partials/list.html.twig')
			->render();
	}

	/**
	 * Handles a request for a list of topics, either all topics or those within
	 * a specific category.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request the request.
	 * @param string $category the category, or <tt>null</tt> for all topics.
	 * @param array $options the options.
	 */
	public function replyAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\ForumDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.topic_delegate');

		/** @var $forumManager \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->get('rhapsody.forum.doctrine.forum_manager');

		/** @var $topicManager \Rhapsody\SocialBundle\Doctrine\TopicManagerInterface */
		$topicManager = $this->container->get('rhapsody.forum.doctrine.topic_manager');

		$forum = $forumManager->findById($request->attributes->get('forum'));
		$topic = $topicManager->findByForumAndId($forum, $request->attributes->get('topic'));
		list($topic, $response) = $delegate->replyAction($request, $forum, $topic);
		return $response
			->mergeData(array('forum' => $forum))
			->setTemplate('RhapsodyForumBundle:Topic:reply.html.twig')
			->render();
	}

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function newAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\ForumDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.topic_delegate');

		/** @var $forumManager \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->get('rhapsody.forum.doctrine.forum_manager');

		/** @var $forum \Rhapsody\ForumBundle\Model\ForumInterface */
		$forum = $forumManager->findById($request->attributes->get('forum'));
		list($topic, $response) = $delegate->newAction($request, $forum);
		return $response
			->mergeData(array('forum' => $forum))
			->setTemplate('RhapsodyForumBundle:Topic:new.html.twig')
			->render();
	}

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function viewAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\ForumDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.topic_delegate');

		/** @var $forumManager \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->get('rhapsody.forum.doctrine.forum_manager');

		/** @var $topicManager \Rhapsody\SocialBundle\Doctrine\TopicManagerInterface */
		$topicManager = $this->container->get('rhapsody.forum.doctrine.topic_manager');

		$forum = $forumManager->findById($request->attributes->get('forum'));
		$topic = $topicManager->findByForumAndId($forum, $request->attributes->get('topic'));
		list($topic, $response) = $delegate->viewAction($request, $topic);

		$user = $this->getUser();
		$topicManager->viewTopic($topic, $user, RhapsodyForumEvents::VIEW_TOPIC);

		return $response
			->mergeData(array('forum' => $forum))
			->setTemplate('RhapsodyForumBundle:Topic:view.html.twig')
			->render();
	}
}
