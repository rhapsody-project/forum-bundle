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

use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Rhapsody\ForumBundle\Model\Topic;
use Rhapsody\ForumBundle\Model\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 *
 * @author Sean W. Quinn
 * @category Rhapsody ForumBundle
 * @package Rhapsody\ForumBundle\Controller
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license http://opensource.org/licenses/MIT
 * @version $Id$
 * @since 1.0
 */
class PostController extends Controller
{

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function createAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\PostDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.post_delegate');

		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$topicManager = $this->container->get('rhapsody.forum.doctrine.topic_manager');

		$topic = $topicManager->findById($request->query->get('topic'));
		$response = $delegate->createAction($request, $topic);
		return $response->render();
	}

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function deleteAction($id)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\PostDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.post_delegate');

		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		/** @var $post \Rhapsody\ForumBundle\Model\PostInterface */
		$post = $postManager->findById($request->attributes->get('post'));

		$response = $delegate->saveAction($request, $post->getForum(), $post->getTopic(), $post);
		return $response->render();
	}

	/**
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @return \Symfony\Component\HttpFoundation\Response the response.
	 */
	public function editAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\PostDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.post_delegate');

		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		/** @var $post \Rhapsody\ForumBundle\Model\PostInterface */
		$post = $postManager->findById($request->attributes->get('post'));

		$response = $delegate->editAction($request, $post->getTopic(), $post);
		return $response->render();
	}

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function saveAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\PostDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.post_delegate');

		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		/** @var $post \Rhapsody\ForumBundle\Model\PostInterface */
		$post = $postManager->findById($request->attributes->get('post'));

		$response = $delegate->saveAction($request, $post->getTopic(), $post);
		return $response->render();
	}
}
